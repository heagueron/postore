<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Carbon\Carbon;
use Newsletter;

use Illuminate\Support\Facades\Log;

class TestMCC extends Command
{

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'postore:testMCC';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send mailchimp campaigns as test to professor.hean@gmail.com';

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
            $clonCampaign = $api->post('campaigns/1f89d556fa/actions/replicate');

            if( $clonCampaign ) {

                $this->info('Campaign replication succeded. Category: '.$category->tag);

                $campaignId = $clonCampaign["id"];

                $remjobs = \App\Remjob::whereDate( 'created_at', '=', Carbon::yesterday()->toDateString() )
                            ->where('category_id', $category->id)->get();
                
                // Container
                $html  = '<div style="margin-top:1rem;padding:25px;background-color:#f2f5f3;">';

                // Content
                $html .= '<div style="background-color:#ffffff; padding:10px;">';

                $html .= '<p>Hello *|FNAME|*,</p>'; 
                $html .= '<p>Here are your selected remote jobs. Click on any job title to get more details.</p><br/>';

                $html .= '<hr style="display: block; margin-block-start: 0.5em; margin-block-end: 0.5em;"><br/>';

                foreach ( $remjobs as $remjob ) {
                    $html .= '<div style="line-height: 1.3;">';
                    $html .= '<a style="text-decoration: none;" href="https://remjob.io/remote_job/' .$remjob->slug. '">';
                    $html .= '<p style="color:#38c172;">' .$remjob->position. '</p></a>';
                    $html .= '<p>At ' .$remjob->company->name. '</p>';
                    if( $remjob->locations ){
                        $html .= '<p>[ ' .$remjob->locations. ' ]</p>';
                    }
                    $html .= '</div><br/>';
                }

                $html .= '<hr style="display: block; margin-block-start: 0.5em; margin-block-end: 0.5em;"><br/>';

                $html .= 'Find more jobs at: <a style="text-decoration: none;" href="https://remjob.io">https://remjob.io</a><br/>';

                $html .= '<p>Have a nice day!</p><br/>';
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