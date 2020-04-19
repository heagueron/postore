<?php

namespace App\Http\Controllers;

use DB;
use App\Spost;
use Carbon\Carbon;


use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Requests\StoreSpost;
use Illuminate\Support\Facades\Storage;
use App\Traits\PublishPost;
use App\Traits\TwitterEngagement;


class SpostController extends Controller
{
    use PublishPost;
    use TwitterEngagement;

    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * List the scheduled posts (sposts).
     *
     * @param  null
     * @return view
     */
    public function index()
    {
        $user = \Auth::user();

        $sposts = $user->sposts()->orderBy('created_at', 'desc')->get();

        return view( 'sposts.index', compact('user', 'sposts') );

    }

    /**
     * Show scheduled posts and create new(spost).
     *
     * @param  null
     * @return view
     */
    public function schedule()
    {
        $user = \Auth::user();

        // Check if user has at least one social network profile
        if ( empty($user->twitter_profiles->all() )){
            // TODO: add check for other social network profiles (Linkedin, Instagram, Facebook)
            // Go ahead and create a twitter profile in postore app (not just a Twitter user).
            return redirect('/social_profiles'); 
        }

        $sposts = $user->sposts()
            ->where('posted', false)
            ->orderBy('created_at', 'desc')
            ->get();
        
        // Set media array
        foreach ($sposts as $spost) {
            $this->setSpostMedia($spost);
        }
        
        $now = Carbon::now()->timezone($user->timezone)->toDateTimeLocalString();
        $currentDate = Str::of($now)->limit(16,'');
        //dd($sposts);
        return view('sposts.schedule', compact('user', 'sposts', 'currentDate'));
    }

    /**
     * Store the incoming spost.
     *
     * @param  StoreSpost $request
     * @return Response
     */

    public function store(StoreSpost $request)
    {   //dd(request());
        $date       = Carbon::createFromDate( request()->post_date );
        $now        = Carbon::now()->timezone(auth()->user()->timezone)->toDateTimeLocalString();
        $minDate    = Carbon::createFromDate( $now );

        // Check date
        if ( ! $date->gte( $minDate ) && request()->input('send-now') == "false" ) {
            return back()->withInput()
                ->with('date_error', 'Please select a date after current date');
        }

        // Create the scheduled post
        $spost = Spost::create([
            'text'                  => request()->text,
            'user_id'               => request()->user_id,
            'post_date'             => $date->toDateTimeString(),
            'posted'                => false,
            'media_1'               => request()->media_1,
            'media_2'               => request()->media_2,
            'media_3'               => request()->media_3,
            'media_4'               => request()->media_4,
            'media_files_count'     => request()->media_files_count,
        ]);
   
        // Add media to the model
        if( request()->media_files_count > 0 ){
            $this->storeMedia($spost);
        } 
        
        // Attach social profiles
        $spost->twitter_profiles()->attach( array_values( request()->twitter_accounts ) );

        // Check inmediate posting
        if( request()->input('send-now') == "true" ) {
            // Trait to publish a post to a set of social profiles
            $publish = $this->publishTwitter( $spost, request()->twitter_accounts );
            if($publish != 'success'){
                return view('sposts.publish_failure', compact('publish') );
            }
            // TODO: Also publish on other social networks.
        }

        return redirect('/sposts/schedule')->with('flash', 'New post scheduled!');

    }

    /**
     * Edit a spost.
     *
     * @param  Spost $spost
     * @return Response
     */
    public function edit(Spost $spost)
    {   
        $user = \Auth::user();

        // Use current local date as minDate
        $now = Carbon::now()->timezone($user->timezone)->toDateTimeLocalString();
        $minDate = Str::of($now)->limit(16,'');

        // Use current post_date field as date to show
        $date2 = Carbon::createFromDate( $spost->post_date )->toDateTimeLocalString();
        $currentDate= Str::of($date2)->limit(16,'');
        
        $this->setSpostMedia($spost);

        //dd("ok, edit spost: ", $spost);
        return view( 'sposts.edit', compact('user', 'spost', 'minDate', 'currentDate') );
    }

    /**
     * Detail of a spost.
     *
     * @param  Spost $spost
     * @return Response
     */
    public function detail(Spost $spost)
    {
        // Get twitter profiles for the scheduled post
        $tpIds = [];
        foreach ($spost->twitter_profiles as $tp) {
            array_push($tpIds,$tp->id);
        }

        // Get media files for the scheduled post
        if(\Storage::exists( 'public/' . $spost->media_1 )){
            $strMedia1 = Storage::get(  'public/' . $spost->media_1  ); 
        }
        if(\Storage::exists( 'public/' . $spost->media_2 )){
            $strMedia2 = Storage::get(  'public/' . $spost->media_2  );
        }
        if(\Storage::exists( 'public/' . $spost->media_3 )){
            $strMedia3 = Storage::get(  'public/' . $spost->media_3  );   
        }
        if(\Storage::exists( 'public/' . $spost->media_4 )){
            $strMedia4 = Storage::get(  'public/' . $spost->media_4  );
        }

        return response()->json([
            'controller'            => 'SpostController@detail',
            'activeTwitterProfiles' => $tpIds,
            'strMedia1'             => utf8_encode($strMedia1),
            'strMedia2'             => utf8_encode($strMedia2),
            'strMedia3'             => utf8_encode($strMedia3),
            'strMedia4'             => utf8_encode($strMedia4)

        ],200);
    }

    /**
     * Update a spost.
     *
     * @param  Spost $spost
     * @return Response
     */
    public function update(Spost $spost, StoreSpost $request)
    {   //dd(request());
        $date       = Carbon::createFromDate( request()->post_date );
        $now        = Carbon::now()->timezone(auth()->user()->timezone)->toDateTimeLocalString();
        $minDate    = Carbon::createFromDate( $now );

        // Check date
        if ( ! $date->gte( $minDate ) ) {
            return back()->withInput()
                ->with('date_error', 'Please select a date after current date');
        }

        // Update the scheduled post
        $spost->update([
            'text'                  => request()->text,
            'post_date'             => $date->toDateTimeString(),
            'media_files_count'     => request()->media_files_count,
        ]);

        // Update media 
        if( request()->input('ck-media_1') ){
            // Clean storage file, if present
            if(\Storage::exists( 'public/' . $spost->media_1 )){
                \Storage::delete( 'public/' . $spost->media_1 );           
            }
            // Update 
            $spost->update([ 'media_1' => request()->media_1]); // creates uploadedFile
            $spost->update([
                'media_1' => is_null( request()->media_1 ) ? null : request()->media_1->store('uploads', 'public')
            ]);
        }

        if( request()->input('ck-media_2') ){
            // Clean storage file, if present
            if(\Storage::exists( 'public/' . $spost->media_2 )){
                \Storage::delete( 'public/' . $spost->media_2 );           
            }
            // Update
            $spost->update([ 'media_2' => request()->media_2]); // creates uploadedFile
            $spost->update([
                'media_2' => is_null( request()->media_2 ) ? null : request()->media_2->store('uploads', 'public')
            ]);
        }

        if( request()->input('ck-media_3') ){
            // Clean storage file, if present
            if(\Storage::exists( 'public/' . $spost->media_3 )){
                \Storage::delete( 'public/' . $spost->media_3 );           
            }
            // Update
            $spost->update([ 'media_3' => request()->media_3]); // creates uploadedFile
            $spost->update([
                'media_3' => is_null( request()->media_3 ) ? null : request()->media_3->store('uploads', 'public')
            ]);
        }

        if( request()->input('ck-media_4') ){
            // Clean storage file, if present
            if(\Storage::exists( 'public/' . $spost->media_4 )){
                \Storage::delete( 'public/' . $spost->media_4 );           
            }
            // Update
            $spost->update([ 'media_4' => request()->media_4]); // creates uploadedFile
            $spost->update([
                'media_4' => is_null( request()->media_4 ) ? null : request()->media_4->store('uploads', 'public')
            ]);
        }
        
        // Update social profiles
        $spost->twitter_profiles()->sync( array_values( request()->twitter_accounts ) );

        return redirect('/sposts/schedule')->with('flash', 'Post updated.');
    }

    
    /**
     * Delete a spost.
     *
     * @param  Spost $spost
     * @return Response
     */
    public function destroy(Spost $spost)
    {   
        // Delete media files
        if(\Storage::exists( 'public/' . $spost->media_1 )){
            \Storage::delete( 'public/' . $spost->media_1 );           
        }
        if(\Storage::exists( 'public/' . $spost->media_2 )){
            \Storage::delete( 'public/' . $spost->media_2 );           
        }
        if(\Storage::exists( 'public/' . $spost->media_3 )){
            \Storage::delete( 'public/' . $spost->media_3 );           
        }
        if(\Storage::exists( 'public/' . $spost->media_4 )){
            \Storage::delete( 'public/' . $spost->media_4 );           
        }

        // Delete from pivot table Sposts-Twitter profiles
        DB::table('spost_twitter_profile')->where('spost_id',$spost->id)->delete();

        // Delete the scheduled post
        $spost->delete();

        return back()->with('info', 'Schedule post successfully removed.');
    }



    /**
     * Send a spost.
     *
     * @param  Spost $spost
     * @return Response
     */
    public function sendNow(Spost $spost)
    {   
        $tpIds = [];
        foreach ($spost->twitter_profiles as $tp) {
            array_push($tpIds,$tp->id);
        }

        // Trait to publish a post to a set of social profiles
        $publish = $this->publishTwitter( $spost, $tpIds );
        if($publish != 'success'){
            return view('sposts.publish_failure', compact('publish') );
        }
        // TODO: Also publish on other social networks.

        return back()->with('info', 'The post was successfully published.');
    }

    /**
     * Show archived posts with engagement statistics.
     *
     * @param  null
     * @return view
     */
    public function archive()
    {
        $user = \Auth::user();

        // Check if user has at least one social network profile
        if ( empty($user->twitter_profiles->all() )){
            // TODO: add check for other social network profiles (Linkedin, Instagram, Facebook)
            // Go ahead and create a twitter profile in postore app (not just a Twitter user).
            return redirect('/social_profiles'); 
        }

        $sposts = $user->sposts()
            ->where('posted', true)
            ->orderBy('created_at', 'desc')
            ->simplePaginate(5);
        
        // Set media array
        foreach ($sposts as $spost) {
            $this->setSpostMedia($spost);
            // Trait to publish a post to a set of social profiles
            $spost->engagement = $this->getEngagement($spost) != null 
                ? $this->getEngagement($spost) 
                : null;
        }
        //dd($sposts);

        return view('sposts.archive', compact('user', 'sposts'));

    }

    /**
     * Store the incoming spost media files.
     *
     * @param  Spost $spost
     * @return void
     */
    private function storeMedia($spost)
    {
        $spost->update([
                'media_1' => is_null( request()->media_1 ) ? null : request()->media_1->store('uploads', 'public'),
                'media_2' => is_null( request()->media_2 ) ? null : request()->media_2->store('uploads', 'public'),
                'media_3' => is_null( request()->media_3 ) ? null : request()->media_3->store('uploads', 'public'),
                'media_4' => is_null( request()->media_4 ) ? null : request()->media_4->store('uploads', 'public'),
            ]);
    }


    /**
     * Prepare spost media data
     *
     * @param  Spost $spost
     * @return void
     */
    private function setSpostMedia($spost)
    {
        $media = [];
        $names = [];
        $inputs = [];

        if( !is_null($spost->media_1) ) { 
            array_push($media, $spost->media_1);
            array_push($names, 'media_1');
            array_push($inputs, 0);
            }

        if( !is_null($spost->media_2) ) {
            array_push($media, $spost->media_2);
            array_push($names, 'media_2');
            array_push($inputs, 1);
            }

        if( !is_null($spost->media_3) ) {
            array_push($media, $spost->media_3);
            array_push($names, 'media_3');
            array_push($inputs, 2);
            }

        if( !is_null($spost->media_4) ) {
            array_push($media, $spost->media_4);
            array_push($names, 'media_4');
            array_push($inputs, 3);
            }
        $spost->media   =   $media;
        $spost->names   =   $names;
        $spost->inputs  =   $inputs;

    }




}
