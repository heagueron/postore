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
        $category = \App\Category::where('tag', 'dev')->first();

        if ( \App\Remjob::whereDate( 'created_at', '=', Carbon::yesterday()->toDateString() )
                        ->where([['category_id', $category->id],['active',1]])
                        ->exists() ){
            $this->info( 'got ' .$category->tag. ' jobs.' );
        
            // Replicate the campaigne
            $clonCampaign = $api->post('campaigns/1f89d556fa/actions/replicate'); // Test MCC Campaign

            if( $clonCampaign ) {

                $this->info('Campaign replication succeded. Category: '.$category->tag);

                $campaignId = $clonCampaign["id"];

                $remjobs = \App\Remjob::whereDate( 'created_at', '=', Carbon::yesterday()->toDateString() )
                            ->where([['category_id', $category->id],['active',1]])->get();
                
                // Container
                $html  = '<div style="margin-top:1rem;padding:35px 55px 35px 55px;background-color:#f2f5f3;">';

                // Content
                $html .= '<div style="background-color:#ffffff; padding:15px 30px 15px 30px">';

                // Advertising
                // $html .= '<div style="border:1px solid #fbfbfb; margin-bottom:25px; line-height:1.3;">';
                // $html .= '<img src="https://remjob.io/images/cintaRJ2.png" alt="newsAd" style="width:100%;height:auto;">';
                // $html .= '<br><small style="text-align:right;float:right;">Advertising</small>';
                // $html .= '<div style="margin:10px;">';
                // $html .= '<h3>Ad title</h3>';
                // $html .= '<p>Ad description. It will have a maximum of 50 words. Can be anything that explains your product or service.</p>';
                // $html .= '<a href="#">Ad link</a>';
                // $html .= '</div></div>';

                // Without Advertising
                $html .= '<div style="margin-bottom:25px;">';
                $html .= '<img src="https://remjob.io/images/cintaRJ2.png" alt="newsAd" style="width:100%;height:auto;">';
                $html .= '</div>';

                // Greet
                $html .= '<h2>Hello *|FNAME|*,</h2>'; 
                $html .= '<p class="plainText">Here are the latest <strong>'.$category->name.'</strong> remote jobs. Click on any job title to get more details.</p><br/>';

                //$html .= '<hr style="display: block; margin-block-start: 0.5em; margin-block-end: 0.5em;"><br/>';

                // Jobs
                foreach ( $remjobs as $remjob ) {
                    $html .= '<div style="line-height: 1.3;">';
                    $html .= '<a style="text-decoration: none;" href="https://remjob.io/remote_job/' .$remjob->slug. '">';
                    $html .= '<p class="titleText">' .$remjob->position. '</p></a>';
                    $html .= '<p class="plainText">At ' .$remjob->company->name. '</p>';
                    if( $remjob->locations ){
                        $html .= '<p class="plainText">[ ' .$remjob->locations. ' ]</p>';
                    }
                    $html .= '</div><br/>';
                }

                $html .= '<hr style="display: block; margin-block-start: 0.5em; margin-block-end: 0.5em;"><br/>';

                $html .= '<p class="plainText">If you have any questions or want to learn more about Remjob, feel free to reach out to us at <strong style="text-decoration: none;">info@remjob.io</strong></p><br/>';

                $html .= '<p class="plainText">Find more jobs at: <a style="text-decoration: none;" href="https://remjob.io">https://remjob.io</a></p><br/>';

                $html .= '<p class="plainText">Cheers,</p>';
                $html .= '<p class="plainText">Your friends at Remjob</p><br/>';
                $html .= '</div></div><br/>';

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
