<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use App\Models\Period;

use Carbon\Carbon;

class SyncPeriod extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sync:period';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sinkronisasi Periode';

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
     * @return int
     */
    public function handle()
    {
        $now = Carbon::now();
        $year = $now->year;

        if(!Period::where('period', $year)->first()){
            Period::insert([
                'period' => $year
            ]);
        }

        \Log::info("Sync Period success");
    }
}
