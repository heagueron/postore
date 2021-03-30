<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Str;

use Newsletter;

class RemoveMCCampaigns extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'postore:delMCC';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Delete MailChimp Campaigns older than 3 days';

    /**
     * The reference date to delete MailChimp Campaigns
     *
     * @var string
     */
    protected $refDate;

    /**
     * The base MailChimp Campaign Ids array
     *
     * @var string
     */
    protected $baseMCCIds = [];

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();

        $this->refDate = \Carbon\Carbon::now()->subDays(3);

        $this->baseMCCIds = \App\Category::where('mailchimp_base_campaign_id','!=', null)->pluck('mailchimp_base_campaign_id')->toArray();

    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $api = Newsletter::getApi();

        // Get campaigns
        $data = $api->get('campaigns?offset=0&count=37');

        $campaignsToDelete = array_filter( 
            $data['campaigns'], 
            function( $campaign ) {
                return ( 
                    $campaign['create_time'] < $this->refDate       and 
                    !in_array($campaign['id'], $this->baseMCCIds)   and
                    str_contains($campaign['settings']['title'], 'copy')
                );
            } 
        );

        if( count($campaignsToDelete) > 0 ){

            $this->info(' ');
            $this->info( 'WILL DELETE THIS ' .count($campaignsToDelete). ' MAILCHIMP CAMPAIGNS: ' );
            $this->info(' ');
            foreach ( $campaignsToDelete as $ctd) {
                $this->info( $ctd['id'] . ' | '.$ctd['settings']['title'] . ' | '.Str::limit($ctd['create_time'],10,'') );
                try {
                    $response = $api->delete( 'campaigns/' .$ctd['id'] );
                } catch (\Throwable $th) {
                    $this->info( 'Error deleting this campaign ' . $ctd['id']);
                }
            }
        } else {
            $this->info( 'No MailChimp Campaigns to delete at this time');
        }

        return 0;
    }


}
