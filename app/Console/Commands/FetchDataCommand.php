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
     * @return mixed
     * @throws \Exception
     */
    public function handle()
    {
        $this->alert("Fetching latest statistics data");
        $this->line('');


        $latest = $this->fetchLatestFile();
        $this->line('');

        $lastDate = DailyStatistic::query()->orderByDesc('date')->first();

        if($lastDate) $lastDate = $lastDate->date;
        else $lastDate = date('Y-m-d');

        $this->info("Inserting records after {$lastDate}");

        $countries = Country::all();

        DailyStatistic::unguard();

        $lastDate = new DateTime($lastDate);

        foreach ($countries as $country) {

            if(!array_key_exists($country->name, $latest)) continue;

            $collection = collect($latest[$country->name])->reverse();

            foreach ($collection as $data) {
                if(!(new DateTime($data['date']))->diff($lastDate)->d) break;

                DailyStatistic::create([
                    'country_id' => $country->id,
                    'date' => $data['date'],
                    'confirmed' => $data['confirmed'],
                    'deaths' => $data['deaths'],
                    'recovered' => $data['recovered']
                ]);
            }
        }
    }

    private function fetchLatestFile()
    {
        $this->comment("Downloading file from '{$this->url}'...");

        // Download the latest json file from the URL
        $json = file_get_contents($this->url);

        if (file_exists($this->path)) unlink($this->path);

        // Store the file, use a little trick to minify the output
        file_put_contents($this->path, json_encode(json_decode($json)));

        $this->comment("Download complete.");

        return json_decode($json, true);
    }
}
