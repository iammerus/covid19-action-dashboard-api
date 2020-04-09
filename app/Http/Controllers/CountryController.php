<?php

namespace App\Http\Controllers;

use App\Country;
use Illuminate\Http\Request;

class CountryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Country[]|\Illuminate\Database\Eloquent\Collection
     */
    public function index()
    {
        return Country::all();
    }
}
