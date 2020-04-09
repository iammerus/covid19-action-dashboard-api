<?php

use App\Country;
use Illuminate\Database\Seeder;

class CountriesTableSeeder extends Seeder
{
    public function __construct() {
        $json = file_get_contents(__DIR__ . '/data/countries.json');

        $this->data = json_decode($json);
    }


    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach ($this->data as $country) {
            Country::create([
                'code' => $country->code,
                'name' => $country->name,
                'region' => $country->region
            ]);
        }
    }


    private $data = [];
}
