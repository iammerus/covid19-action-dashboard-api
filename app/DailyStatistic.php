<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DailyStatistic extends Model
{
    /**
     * Gets the country which owns the daily statistic
     */
    public function country()
    {
        return $this->belongsTo(Country::class);
    }
}
