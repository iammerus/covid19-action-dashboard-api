<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDailyStatisticsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('daily_statistics', function (Blueprint $table) {
            $table->id();
            $table->integer('country_id');
            $table->date('date');
            $table->integer('confirmed');
            $table->integer('recovered');
            $table->integer('deaths');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('daily_statistics');
    }
}
