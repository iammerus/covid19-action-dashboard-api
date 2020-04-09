<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class ComputeTotalsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'statistics:compute';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Computes the current totals for all the countries in the application';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->info('Calculating totals...  Please wait');

        $this->info('Calculations complete. :)');
    }
}
