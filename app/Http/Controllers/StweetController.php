<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\ApiConnectors\TwitterGateway;
use App\Stweet;


class StweetController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function index(TwitterGateway $twitter)
    {
        $user = \Auth::user();

        $stweets = Stweet::all();
        // dd($stweets);
        return view( 'stweets.index', compact('user', 'stweets') );

    }
    
    public function create()
    {
        $user = \Auth::user();
        if ( !empty($user->twitter_profiles->all() )){
            // In the create, twitter_profile_id is forced to first. TODO: make it selectable.
            return view('stweets.create', compact('user'));
        }
        // Go ahead and create a twitter profile in postore app (not just a Twitter user).
        return redirect('/twitter_profiles/create');
    }

    public function store(TwitterGateway $twitter)
    {
        // dd( request() );
        $stweet = Stweet::create( $this->validatedData() );
        // dd($stweet);
        return redirect('/stweets')->with('flash', 'New tweet scheduled!');

        // $twitter->connection->post("statuses/update", ["status" => $stweet->text]);

        // if ($twitter->connection->getLastHttpCode() == 200) {
        //     // Tweet posted succesfully
        //     return redirect('/stweets')->with('flash', 'New tweet sent!');
        // } else {
        //     return redirect('/stweets')->with('flash', 'Error: New tweet not sent!');
        // }
    }

    public function twitterStatuses(TwitterGateway $twitter)
    {
        $user = \Auth::user();
        if ( !empty($user->twitter_profiles->all() )){
            $content = $twitter->connection->get("account/verify_credentials");
            $statuses  = $twitter->connection->get("statuses/user_timeline", ["count" => 5, "exclude_replies" => true]);
            return view('stweets.statuses', compact('content', 'statuses'));
        }
        // Go ahead and create a twitter profile in postore app (not just a Twitter user).
        return redirect('/twitter_profiles/create');
    }

    protected function validatedData()
    {
        return request()->validate([
            'text'                  => 'required|min:1|max:240',
            'twitter_profile_id'    => 'required',
            'post_date'             => 'required'
        ]);
    }
}
