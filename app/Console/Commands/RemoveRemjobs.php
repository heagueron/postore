<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class RemoveRemjobs extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'postore:rmJobs';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Remove jobs older than 45 days';

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
        $refDate = \Carbon\Carbon::now()->subDays(45);

        $this->info( ' Will delete remote jobs created before: '.$refDate->toDateString() );

        if( \App\Remjob::where( 'created_at', '<', $refDate )->exists() ){
            
            $deletedJobCount = 0;
            $activeJobCount = 0;

            $remjobs = \App\Remjob::where( 'created_at', '<', $refDate )->get();
            foreach ( $remjobs as $remjob ) {

                // Decrement Active Jobs if needed
                if( $remjob->active == 1) { $activeJobCount += 1; }

                // Delete from pivot table remjob_tag
                DB::table('remjob_tag')->where('remjob_id',$remjob->id)->delete();

                // Delete the remote job
                $remjob->delete();

                $deletedJobCount += 1;
            }
            \App\Option::where('name','active_remjobs')->first()->decrement( 'value', $activeJobCount);

            $this->info( ' Remjobs deleted from DB: '.$deletedJobCount );

        } else {
            $this->info( ' No Remjobs to delete. ' );
        }
        
    }
}
