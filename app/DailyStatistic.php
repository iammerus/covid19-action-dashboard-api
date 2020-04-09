<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DailyStatistic extends Model
{
    protected $hidden = ['created_at', 'updated_at', 'country_id'];
    /**
     * Gets the country which owns the daily statistic
     */
    public function country()
    {
        return $this->belongsTo(Country::class);
    }
}
