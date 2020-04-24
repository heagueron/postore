<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\ApiConnectors\TwitterGateway;


class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }
    

    /**
     * Show the user social profiles dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function socialProfilesIndex()
    {
        return view('social-profiles.index');
    }

    /**
     * Check if user has new avatars loaded on the linked social network
     * and update DB
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */

    public function checkAvatars()
    {
        //dd('ok, chek avatars');
        if( ! auth()->user()->twitter_profiles->count() > 0 ){
            return redirect()->route('social_profiles.index');
        }
        //dd('oh this users has profiles');
        $twitter_profiles = auth()->user()->twitter_profiles->all();
        foreach($twitter_profiles as $tp){

            $currentAvatar = null;
            
            // Build the twitter connection class for new profile
            $twitter = new TwitterGateway( $tp->id, false);

            // Grab the avatar
            $response = $twitter->connection
                ->get("account/verify_credentials", ["skip_status" => "true"]);

            // Check response
            if ( $twitter->connection->getLastHttpCode() == 200 ) {
                    $currentAvatar    = $response->profile_image_url_https;
            } else {
                session( ['info' => 'One or more of your Twitter avatars could not be checked'] );
            }
            if( !is_null($currentAvatar) && ($currentAvatar != $tp->avatar) ){
                $tp->update(['avatar'   => $currentAvatar]);
            }
        }
   
        return redirect()->route('sposts.schedule')->with('flash', 'All Twitter avatars updated');

    }

}
