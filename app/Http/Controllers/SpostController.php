<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Carbon\Carbon;

use App\Http\Requests\StoreSpost;
use App\Traits\PublishPost;
use App\Spost;


class SpostController extends Controller
{
    use PublishPost;

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
     * Create a scheduled post (spost).
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
            $media = [];
            if( !is_null($spost->media_1) ) { array_push($media, $spost->media_1); }
            if( !is_null($spost->media_2) ) { array_push($media, $spost->media_2); }
            if( !is_null($spost->media_3) ) { array_push($media, $spost->media_3); }
            if( !is_null($spost->media_4) ) { array_push($media, $spost->media_4); }
            $spost->media   =   $media;
        }
        
        $now = Carbon::now()->timezone($user->timezone)->toDateTimeLocalString();
        $currentDate = Str::of($now)->limit(16,'');
        
        return view('sposts.schedule', compact('user', 'sposts', 'currentDate'));
    }

    /**
     * Store the incoming spost.
     *
     * @param  StoreSpost $request
     * @return Response
     */

    public function store(StoreSpost $request)
    {   
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

}
