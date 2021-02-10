<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Carbon\Carbon;
use Newsletter;

use Illuminate\Support\Facades\Log;

class DailyNews extends Command
{

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'postore:dailyNews';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Updates and send mailchimp campaigns as newsletter';

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
        $api = Newsletter::getApi();

        // // Get campaigns
        // $nontechCampaign = $api->get('campaigns/bb3d041905');

        // MARKETING Remote Jobs
        $campaigneName = "Marketing";
        $baseCampaignId = '75a16833a6';

        // Replicate the campaigne
        $clonCampaign = $api->post('campaigns/' .$baseCampaignId. '/actions/replicate');

        if( $clonCampaign ) { 
            $this->info('Replication Success');
            $campaignId = $clonCampaign["id"];

            //Update the clon campaigne
            $html = '<br/><br/><h1> Marketing Remote Jobs Report ... (modified cloned campaign!) </h1>';
            $options = [];

            $updateResponse = Newsletter::updateContent( $campaignId, $html, $options);
            if ( !$updateResponse  ) {
                
                $this->info('Campaign update failed for: '.$campaignId);

            } else {
                
                // Send the campaign
                $response = $api->post('campaigns/' .$campaignId. '/actions/send');
                if( $response ) {
                    $this->info('Campaign send initiated  for: '.$campaignId);
                } else {
                    $this->info('Campaign send failed for: '.$campaignId);
                }
                
            }

        } else {
            $this->info('Replication Fail');
        }

    }


}
