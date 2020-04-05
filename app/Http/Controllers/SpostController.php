<?php

namespace App\Http\Controllers;

use DB;

use App\Spost;

use Illuminate\Http\Request;
use App\Http\Requests\StoreSpost;
use Illuminate\Support\Str;
use Carbon\Carbon;
use App\Traits\PublishPost;

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
     * @return Response
     */
    public function index()
    {
        $user = \Auth::user();

        $sposts = $user->sposts()->orderBy('created_at', 'desc')->get();
        //dd($sposts);
        return view( 'sposts.index', compact('user', 'sposts') );

    }
    /**
     * Create a scheduled post (spost).
     *
     * @param  null
     * @return Response
     */

    public function schedule()
    {
        $user = \Auth::user();

        // Check if user has at least one social network profile
        if ( empty($user->twitter_profiles->all() )){
            // TODO: add check for other social network profiles (Linkedin, Instagram, Facebook)
            // Go ahead and create a twitter profile in postore app (not just a Twitter user).
            return redirect('/twitter_profiles/create'); 
        }

        $sposts = $user->sposts()->orderBy('created_at', 'desc')->get();

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
        //dd(request());
        $date       = Carbon::createFromDate( request()->input('post_date') );
        $minDate    = Carbon::now()->timezone(auth()->user()->timezone);

        // Check date
        if ( ! $date->gte( $minDate ) && request()->input('send-now') == "false" ) {
            return back()
                ->withInput()
                ->with('date_error', 'Please select a date after current date');
        }

        // Check social profiles
        $tpIds = request()->input('twitter_accounts');
        if ( is_null($tpIds) ){
            return back()
                ->withInput()
                ->with('profile_error', 'Please select at least one social profile.');
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
        $spost->twitter_profiles()->attach( array_values($tpIds) );

        // Check inmediate posting
        if( request()->input('send-now') == "true" ) {
            // Trait to publish a post to a set of social profiles
            $this->publishTwitter( $spost, request()->input('twitter_accounts') );

            // TODO: Also publish on other social networks.
        }

        return redirect('/sposts/schedule')->with('flash', 'New post scheduled!');

    }

    private function storeMedia($spost)
    {
        
        $spost->update([
                'media_1' => is_null( request()->media_1 ) ? null : request()->media_1->store('uploads', 'public'),
                'media_2' => is_null( request()->media_2 ) ? null : request()->media_2->store('uploads', 'public'),
                'media_3' => is_null( request()->media_3 ) ? null : request()->media_3->store('uploads', 'public'),
                'media_4' => is_null( request()->media_4 ) ? null : request()->media_4->store('uploads', 'public'),
            ]);
    }

    public function imageUpload()
    {
        dd('ok, lets load that marvelous image');
    }

}
