<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class CleanNoCompanyRemjobs extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'postore:clean-no-company';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Deletes from the Database any remote job somehow created without a company.';

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
        if( \App\Remjob::whereIn('company_id', [null, ''])->exists() ){

            // Get no-company remote jobs
            $remjobs = \App\Remjob::whereIn('company_id', [null, ''])->get();

            $deletedRemjobsCount = 0;

            foreach ( $remjobs as $remjob ) {

                // Delete from pivot table remjob_tag
                DB::table('remjob_tag')->where('remjob_id',$remjob->id)->delete();

                // Delete the remote job
                $remjob->delete();
                
                $deletedRemjobsCount += 1;
            }

            $this->info( ' Total remote jobs deleted: '.$deletedRemjobsCount );

        } else {
            $this->info( ' No remote jobs deleted ' );
        }
        
    }
}
