<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    protected $fillable = ['region', 'name', 'code'];

    protected $hidden = ['id', 'created_at', 'updated_at'];

    public function statistics()
    {
        return $this->hasMany(DailyStatistic::class);
    }
}
