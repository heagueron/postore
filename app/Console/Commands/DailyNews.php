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

        // TESTING: MARKETING Remote Jobs
        $category = \App\Category::where('tag', 'marketing')->first();

        if ( \App\Remjob::whereDate( 'created_at', '=', Carbon::yesterday()->toDateString() )
                            ->where('category_id', $category->id)
                            ->exists() ){
            $this->info( 'got ' .$category->tag. ' jobs.' );
            
            // Replicate the campaigne
            $clonCampaign = $api->post('campaigns/' .$category->mailchimp_base_campaign_id. '/actions/replicate');

            if( $clonCampaign ) {

                $this->info('Campaign replication succeded. Category: '.$category->tag);

                $campaignId = $clonCampaign["id"];

                $remjobs = \App\Remjob::whereDate( 'created_at', '=', Carbon::yesterday()->toDateString() )
                            ->where('category_id', $category->id)->get();
                
                // Create the content
                $html  = '<div style"background-color:#c9c9c9; padding:20px:">';
                $html .= '<div style"background-color:#ffffff; padding:10px:">';

                $html .= '<p>Hello</p>'; 
                $html .= '<p>Here are your selected remote jobs for ' .Carbon::yesterday()->toDateString(). '</p><br/>';

                $html .= '<hr style="display: block; margin-block-start: 0.5em; margin-block-end: 0.5em;"><br/>';

                foreach ( $remjobs as $remjob ) {
                    $html .= '<div style="line-height: 1.4;">';
                    $html .= '<a style="text-decoration: none;" href="https://remjob.io/remote_job/' .$remjob->slug. '">';
                    $html .= '<p style="color:#38c172;">' .$remjob->position. '</p></a>';
                    $html .= '<p>At ' .$remjob->company->name. '</p>';
                    $html .= '<p>[ ' .$remjob->locations. ' ]</p><br/>';
                    $html .= '</div>';
                }

                $html .= 'Find more jobs at: <a style="text-decoration: none;" href="https://remjob.io">https://remjob.io</a><br/>';
                $html .= '</div></div>';

                //Update the clon campaigne
                $options = [];
                $updateResponse = Newsletter::updateContent( $campaignId, $html, $options);
                if ( !$updateResponse  ) {

                    $this->info('Campaign update failed for: '.$category->tag);

                } else {

                    // Send the campaign
                    $response = $api->post('campaigns/' .$campaignId. '/actions/send');
                    if( $response ) {
                        $this->info('Campaign send initiated  for: '.$category->tag);
                    } else {
                        $this->info('Campaign send failed for: '.$category->tag);
                    }

                }

            } else {
                $this->info('Campaign replication failed. Category: '.$category->tag);
            }
        } else {
            $this->info( 'There are no ' .$category->tag. ' jobs.' );
        }
      

    }


}
