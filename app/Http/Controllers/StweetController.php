<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\ApiConnectors\TwitterGateway;
use App\Stweet;

use DB;


class StweetController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function index(TwitterGateway $twitter)
    {
        $user = \Auth::user();

        $stweets = [];

        if ( $user->twitter_profiles()->exists() ){
            // TODO: Get stweets from all twitter profiles for the user.
            $stweets = $user->twitter_profiles()->first()->stweets;
        }

        return view( 'stweets.index', compact('user', 'stweets') );

    }
    
    public function create()
    {
        $user = \Auth::user();
        if ( !empty($user->twitter_profiles->all() )){
            // TODO: In the create, twitter_profile_id is forced to first. TODO: make it selectable.
            return view('stweets.create', compact('user'));
        }
        // Go ahead and create a twitter profile in postore app (not just a Twitter user).
        return redirect('/twitter_profiles/create');
    }

    public function store(TwitterGateway $twitter)
    {

        $stweet = Stweet::create( $this->validatedData() );

        return redirect('/stweets')->with('flash', 'New tweet scheduled!');

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
