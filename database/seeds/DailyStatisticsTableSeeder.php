<?php

use App\Country;
use App\DailyStatistic;
use Illuminate\Database\Seeder;

class DailyStatisticsTableSeeder extends Seeder
{
    public function __construct() {
        $json = file_get_contents(__DIR__ . '/data/timeseries.json');

        $this->data = json_decode($json, true);
    }
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $countries = Country::all();

        DailyStatistic::unguard();

        foreach ($countries as $country) {

            if(!array_key_exists($country->name, $this->data)) continue;
            foreach ($this->data[$country->name] as $data) {
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

    private $data = [];
}
