<?php

namespace App\Console\Commands;

use App\Country;
use App\DailyStatistic;
use DateTime;
use Illuminate\Console\Command;

class FetchDataCommand extends Command
{
    protected $path = '';

    protected $url = 'http://localhost:9000/timeseries.json';

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'statistics:fetch';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();

        $timestamp = date('dmY');
        $this->path = storage_path("app/times/timeseries-{$timestamp}.json");
    }

    /**
     * Execute the console command.
     *
     * @return void
     * @throws \Exception
     */
    public function handle()
    {
        $this->alert("Fetching latest statistics data");
        $this->line('');

        // Fetch the latest JSON file with the data
        $latest = $this->fetchLatestFile();

        // Get the date of the last entry
        $lastDate = DailyStatistic::query()->orderByDesc('date')->first();

        // If we got a record, then set last date to that record's date, else set thee last date to a date in the past
       $lastDate = $lastDate ? new DateTime($lastDate->date) : (new DateTime('2000-01-01'));

       // Print some information out to the screen
        $this->info("Inserting records after {$lastDate->format('Y-m-d')}");
        $this->line('');

        // Unguard the daily statistic model
        DailyStatistic::unguard();
        foreach (Country::all() as $country) {
            // If there's no entries for the country, ignore it
            if(!array_key_exists($country->name, $latest)) continue;

            // Create a new laravel collection from the data array, then reverse it
            // Since the entries are in ascending order, well reverse the array, so the latest dates come early
            // That way, we get to the last entry we inserted quicker
            $countryData = collect($latest[$country->name])->reverse();

            // Counter variable.
            $total = 0;

            // Loop over the country's records
            foreach ($countryData as $data) {
                // If the date we are on is the last date, that means we've inserted all the records we needed to
                // insert for this country, break out of the loop
                if(!(new DateTime($data['date']))->diff($lastDate)->d) break;

                // Insert the statistic record
                DailyStatistic::create([
                    'country_id' => $country->id,
                    'date' => $data['date'],
                    'confirmed' => $data['confirmed'],
                    'deaths' => $data['deaths'],
                    'recovered' => $data['recovered']
                ]);

                $total++;
            }

            $this->comment("Finished inserting records for {$country->name}. Total records: {$total}");
        }
    }

    /**
     * Fetches the latest records
     *
     * @return array
     */
    private function fetchLatestFile()
    {
        $this->comment("Downloading file from '{$this->url}'...");

        // Download the latest json file from the URL
        $json = file_get_contents($this->url);

        if (file_exists($this->path)) unlink($this->path);

        // Store the file, use a little trick to minify the output
        file_put_contents($this->path, json_encode(json_decode($json)));

        // Print out a pretty message
        $this->comment("Download complete.");
        $this->line('');

        return json_decode($json, true);
    }
}
