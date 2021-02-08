<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Newsletter;


class SubscriberController extends Controller
{
    /**
     * Subscribe a new person to the list 
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        dd('subscribe this friend: ', $request);

        $data = request()->validate([
            'name'          => 'nullable|min:3',
            'email'         => 'required|email',
            'category_id'   => [ 'nullable', Rule::in(['1','2','3','4','5','6','7','8','9','10','11','12']) ],
            //'frecuency'     => [ 'nullable', Rule::in(['daily','weekly','monthly']) ],
        ]);


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

        // $api = Newsletter::getApi();
        // $allAudiences = $api->get('lists');
        // //$response = $api->get( 'lists/f52a8f2e25/interest-categories/');
        // $audienceId = $allAudiences['lists'][0]['id'];
        // $categories = $api->get( 'lists/f52a8f2e25/interest-categories/');
        
        // foreach( $categories['categories'] as $category){
        //     dd($category['id']);
        // }
        
        // dd($categories['categories']);
    }
}
