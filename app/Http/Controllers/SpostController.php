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

        $sposts = $user->sposts()->get();
      
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

        $sposts = $user->sposts()->get();

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
    {    dd( "store",request() );  
        $date=Carbon::createFromDate( request()->input('post_date') );
        $minDate = Carbon::now()->timezone(auth()->user()->timezone);

        // Check that date is greater than current date
        if ( ! $date->gte( $minDate ) ) {
            return back()->withInput()->with('date_error', 'Please select a date after current date');
        }

        $this->completeStore($date);

        return redirect('/sposts')->with('flash', 'New post scheduled!');

    }

    public function sendNow ()
    {   dd( "sendNow",request() );
        $date = Carbon::now()->timezone(auth()->user()->timezone);

        $spost = $this->completeStore($date);
        
        //dd('post and profiles',$spost,request()->input('twitter_accounts'));
        // Trait to publish a post to a set of social profiles
        $this->publishTwitter($spost, request()->input('twitter_accounts') );

        return redirect('/sposts')->with('flash', 'New post sent!');

    }

    private function completeStore($date){
        // Check social profiles
        $tpIds = request()->input('twitter_accounts');
        if ( is_null($tpIds) ){
            return back()->withInput()->with('profile_error', 'Please select at least one social profile.');
        }

        // Create the scheduled post
        $spost = Spost::create([
            'text'                  => request()->input('text'),
            'user_id'               => request()->input('user_id'),
            'post_date'             => $date->toDateTimeString(),
            'posted'                => false,
        ]);

        // Attach social profiles
        $spost->twitter_profiles()->attach( array_values($tpIds) );

        return $spost;
    }

    public function imageUpload()
    {
        dd('ok, lets load that marvelous image');
    }

}
