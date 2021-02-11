<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\StoreSubscriber;

use Newsletter;


class SubscriberController extends Controller
{
    /**
     * Subscribe a new person to the list 
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreSubscriber $request)
    {
        $interestId = $request->category_id
                    ? \App\Category::where('id',$request->category_id)->first()->mailchimp_interest_id
                    : "84a0520c2e"; 

        if ( ! Newsletter::isSubscribed($request->email) ) 
        {
            Newsletter::subscribePending(
                $request->email, 
                ['FNAME'=>$request->name],
                'subscribers', 
                ['interests'=>[$interestId=>true] ] );

            $title = 'Information';
            $message = 'Thanks for you subscription. Please check your email inbox and confirm.';
            //return redirect('newsletter')->with('success', 'Thanks For Subscribe');
        } else{
            $title = 'Information';
            $message = 'Oops! You have already subscribed.';
        }
        
        return view( 'information', compact( 'title', 'message' ) );
        //return redirect('newsletter')->with('failure', 'Sorry! You have already subscribed ');

        return back()->with('flash', 'Added subscriber: ' . $request->email );
    }

    public function pingChimp(){
        $api = Newsletter::getApi();

        // Get lists
        $lists = $api->get('lists');

        $structure = array();

        foreach($lists['lists'] as $list){
            // Get categories
            $this_list_id = $list['id'];
			$this_list_name = $list['name'];
			$structure[$this_list_id]['id'] = $this_list_id;
			$structure[$this_list_id]['name'] = $this_list_name;
			$structure[$this_list_id]['categories'] = array();

			$categories = $api->get('lists/' . $this_list_id . '/interest-categories/');
			//dd($categories);

            foreach($categories['categories'] as $category){
                // Get interests
                $this_category_id = $category['id'];
				$this_category_name = $category['title'];
                $structure[$this_list_id]['categories'][$this_category_id]['id'] = $this_category_id;
				$structure[$this_list_id]['categories'][$this_category_id]['name'] = $this_category_name;
				$structure[$this_list_id]['categories'][$this_category_id]['interests'] = array();

                $interests = $api->get('lists/' . $this_list_id . '/interest-categories/' . $this_category_id . '/interests');
                //dd($interests);

                foreach($interests['interests'] as $interest){
					$this_interest_id = $interest['id'];
					$this_interest_name = $interest['name'];
					$structure[$this_list_id]['categories'][$this_category_id]['interests'][$this_interest_id]['id'] = $this_interest_id;
					$structure[$this_list_id]['categories'][$this_category_id]['interests'][$this_interest_id]['name'] = $this_interest_name;
				}
            }
        }
        dd( $structure );

    }

    public function mcSegments(){
        $api = Newsletter::getApi();

        // Get segments
        $segments = $api->get('lists/f52a8f2e25/segments');
        dd( $segments );

    }

    public function mcGetCampaigns(){
        $api = Newsletter::getApi();

        // Get campaigns
        $campaigns = $api->get('campaigns');
        dd( $campaigns );

    }

    public function showCampaign( $campaignId ){
        $api = Newsletter::getApi();

        // Get campaign
        $campaign = $api->get('campaigns/' . $campaignId);
        dd( $campaign );

    }

    public function mcCreateCampaign(){

        dd('Create a mc campaign ');

        $subject = 'Your daily remote jobs';
        $fromName = 'Remote Jobs';
        $replyTo = 'info@remjob.io';
        $listName = 'subscribers';

        $options = [
            'recipients' => [
                'segment_opts' => [
                    'saved_segment_id' => '3533471'
                ]
            ],
        ];

        $defaultOptions = [
            'type' => 'regular',
            'recipients' => [
                'list_id' => 'f52a8f2e25',
            ],
            'settings' => [
                'subject_line' => $subject,
                'from_name' => $fromName,
                'reply_to' => $replyTo,
            ],
        ];

        $options = array_merge($defaultOptions, $options);

        dd( $options );

        $api = Newsletter::getApi();

        // Get segments
        $segments = $api->get('lists/f52a8f2e25/segments');
        dd( $segments );

    }

}
