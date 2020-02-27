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
        //dd($twitter);
        $content = $twitter->connection->get("account/verify_credentials");
        $status  = $twitter->connection->get("statuses/home_timeline", ["count" => 1, "exclude_replies" => true]);
        dd($content, $status);
    }
    
    public function create()
    {
        // twitter_profile_id forced. TODO: make it selectable.
        $user = \Auth::user();
        return view('stweets.create', compact('user'));
    }

    public function store(TwitterGateway $twitter)
    {
        //dd(request());
        $stweet = Stweet::create($this->validatedData());
        // dd( $stweet,  $twitter->connection );

        $twitter->connection->post("statuses/update", ["status" => $stweet->text]);
        return redirect('/stweets/create');
    }

    protected function validatedData()
    {
        return request()->validate([
            'text' => 'required|min:1|max:240',
            'twitter_profile_id' => 'required'
        ]);
    }
}
