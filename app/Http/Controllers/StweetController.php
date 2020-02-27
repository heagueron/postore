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
        $content = $twitter->connection->get("account/verify_credentials");
        $statuses  = $twitter->connection->get("statuses/user_timeline", ["count" => 5, "exclude_replies" => true]);
        return view('stweets.index', compact('content', 'statuses'));
    }
    
    public function create()
    {
        // twitter_profile_id forced. TODO: make it selectable.
        $user = \Auth::user();
        dd($user, $user->twitter_profiles->first()->id);
        return view('stweets.create', compact('user'));
    }

    public function store(TwitterGateway $twitter)
    {
        $stweet = Stweet::create( $this->validatedData() );
        // dd($stweet);
        $twitter->connection->post("statuses/update", ["status" => $stweet->text]);
        return redirect('/stweets');
    }

    protected function validatedData()
    {
        return request()->validate([
            'text' => 'required|min:1|max:240',
            'twitter_profile_id' => 'required'
        ]);
    }
}
