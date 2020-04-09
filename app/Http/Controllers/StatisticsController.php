<?php

namespace App\Http\Controllers;

use App\Country;
use App\DailyStatistic;

class StatisticsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $results = [];
        $countries = Country::all();

        foreach ($countries as $country) {
            // Get the latest data for the country
            $latest = DailyStatistic::whereCountryId($country->id)->orderByDesc('date')->first();

            if (!$latest) continue;

            $results[] = [
                'country' => $country->name,
                'code' => $country->code,
                'region' => $country->region,
                'data' => [
                    'recovered' => $latest->recovered,
                    'deaths' => $latest->deaths,
                    'confirmed' => $latest->confirmed
                ]
            ];
        }

        return response($results);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function history()
    {
        $results = [];
        $countries = Country::all();

        foreach ($countries as $country) {
            // Get the latest data for the country
            $latest = DailyStatistic::whereCountryId($country->id)->orderByDesc('date')->limit(20)->get();

            if (!$latest) continue;

            $results[] = [
                'country' => $country->name,
                'code' => $country->code,
                'region' => $country->region,
                'data' => $latest
            ];
        }

        return response($results);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function single($code)
    {
        $results = [];
        $country = Country::whereCode($code)->single;

        if (!$country) return [];

        // Get the latest data for the country
        $history = DailyStatistic::whereCountryId($country->id)->orderByDesc('date')->get();

        if (!$history) return [];

        $results = [
            'country' => $country->name,
            'code' => $country->code,
            'region' => $country->region,
            'data' => $history
        ];

        return response($results);
    }

}
