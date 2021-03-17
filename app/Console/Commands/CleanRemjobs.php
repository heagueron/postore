<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class CleanRemjobs extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'postore:clean-remjobs';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Checks remote jobs date. Sets field active to 0 after the stablished duration period.';

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
        if( \App\Remjob::where('active', 1)->exists() ){

            // Get active remote jobs
            $remjobs = \App\Remjob::where('active', 1)->get();

            $inactivatedRemjobsCount = 0;
            $datetime2 = date_create();

            foreach ( $remjobs as $remjob ) {

                $dt1 = Carbon::parse( $remjob->created_at );
                $datetime1 = date_create($remjob->created_at);

                $interval = date_diff($datetime1, $datetime2)->format('%a');

                if( $interval > \App\Option::find(1)->value ){
                    $this->info( $remjob->position.', posted on: '.$dt1.' will be set inactive' );
                    $remjob->update([ 'active'  => 0 ]);

                    $inactivatedRemjobsCount += 1;
                }

            }

            $this->info( ' Total remote jobs inactivated: '.$inactivatedRemjobsCount );

            // Decrement active remjobs count
            \App\Option::where('name','active_remjobs')->first()->decrement('value', $inactivatedRemjobsCount);

        } else {
            $this->info( ' No remote jobs on active state ' );
        }
        
    }
}
