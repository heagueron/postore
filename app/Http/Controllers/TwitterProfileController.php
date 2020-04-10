<?php

namespace App\Http\Controllers;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use DB;

use App\ApiConnectors\TwitterGateway;
use App\TwitterProfile;
use App\Spost;


class TwitterProfileController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Steps 1,2 in the authorization process.
     *
     * @param  null
     * @return void
     */
    public function create()
    {
        // STEP 1: POST oauth/request_token
        // Create a request for a consumer application to obtain a request token.
        $twitter1 = new TwitterGateway(null,true);
        $url = 'https://api.twitter.com/oauth/request_token';
        $requestMethod = 'POST';

        $postfields = array(
            "oauth_callback" => "http%3A%2F%2F127.0.0.1%3A8000%2Ftwitter_profiles%2FconvertToken"
        );

        $response1 = $twitter1->connection
            ->buildOauth($url, $requestMethod)
            ->setPostfields($postfields)
            ->performRequest();
        //dd(json_decode($response1,true));
        // Callback confirmation:
        if ( !Str::of($response1)->after('oauth_callback_confirmed=')->exactly('true')  ){
            dd('Callback function not confirmed in Step 1');
        }

        $oauth_token = Str::of($response1)
            ->after('oauth_token=')
            ->before('&oauth_token_secret');
        $oauth_token_secret = Str::of($response1)
            ->after('oauth_token_secret=')
            ->before('&oauth_callback_confirmed');

        // Store them in session:
        session([
            'oauth_token' => $oauth_token, 
            'oauth_token_secret' => $oauth_token_secret
        ]);


        // Step 2: GET oauth/authorize
        // Have the user authenticate, and send the consumer application a request token.
        $twitter2 = new TwitterGateway(null,true);
        $url = 'https://api.twitter.com/oauth/authorize';
        $getfield = Str::of('?oauth_token=')->append($oauth_token);
        $requestMethod = 'GET';

        echo $twitter2->connection
            ->setGetfield($getfield)
            ->buildOauth($url, $requestMethod)
            ->performRequest();


    }

    /**
     * Last step in the authorization process.
     * This is the callback to get the access token.
     *
     * @param  null
     * @return view
     */
    public function convertToken()
    {
        // Check token
        $tokenFromStep2 = request()->oauth_token;
        $oauth_verifier = request()->oauth_verifier;
        //dd(session()->get('oauth_token'), $tokenFromStep2);
        if( !Str::of( session()->get('oauth_token') ) == $tokenFromStep2 ){
            dd("Token mismatch. Please log out, log in and try again.");
        }
        
        // Step 3: POST oauth/access_token
        // Convert the request token into a usable access token.
        $twitter3 = new TwitterGateway(1,false);
        $response3 = $twitter3->connection->oauth(
            "oauth/access_token", 
            ["oauth_verifier" => $oauth_verifier, "oauth_token" => $tokenFromStep2]);

        if ( $twitter3->connection->getLastHttpCode() != 200 ) {
            return view('info', [
                'infoMessage'   => 'Authorization failed. Please try again or contact support.'
            ]);
        } 

        // Check if that twitter handler (screen_name) already exists
        if( TwitterProfile::where('handler',$response3['screen_name'])->exists() ){
            return view('info', [
                'infoMessage'   => 'You already has your twitter profile @' .$response3['screen_name']. ' linked in this application'
            ]);
        }
        
        // Create the Twiter Profile
        $twitterProfile = \App\TwitterProfile::create(
            [
                'handler'               => $response3['screen_name'],
                'access_token'          => $response3['oauth_token'],
                'access_token_secret'   => $response3['oauth_token_secret'],
                'user_id'               => auth()->user()->id,
                'twitter_user_id'       => $response3['user_id']
            ]
        );

        // Build the twitter connection class for new profile
        $twitter = new TwitterGateway( $twitterProfile->id, false);

        // Grab the avatar
        $response4 = $twitter->connection
            ->get("account/verify_credentials", ["skip_status" => "true"]);

        if ( $twitter->connection->getLastHttpCode() == 200 ) {
            $twitterProfile->update([
                'avatar'    => $response4->profile_image_url_https
            ]); 
        } else {
            return view('info', [
                'infoMessage'   => 'We did not get the avatar but you can schedule tweets for your profile: @' .  $response3['screen_name'],
            ]);
        }
           
        return view('thanks', [
            'message'   => 'Now you can schedule tweets for your profile: @' .  $response3['screen_name'],
        ]);
    }

    /**
     * Delete a twitter profile (the link to the social network)
     *
     * @param  Spost $spost
     * @return void
     */
    public function destroy(TwitterProfile $twitter_profile)
    {
        // Remove scheduled posts owned solely by this profile and their media files
        if( Spost::where('user_id', auth()->user()->id)->exists() ){
            $sposts = Spost::where('user_id', auth()->user()->id)->get();

            foreach($sposts as $spost){

                // Select sposts not shared with other profiles
                if( !DB::table('spost_twitter_profile')->where('spost_id', $spost->id)->
                    where('twitter_profile_id','!=',$twitter_profile->id)->exists() ){

                        // Remove media files:
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

                        // Remove spost
                        $spost->delete();

                }
            }
        }

        // Remove this profile entries in pivot table 'spost_twitter_profile'
        DB::table('spost_twitter_profile')->where('twitter_profile_id', '=', $twitter_profile->id)->delete();

        // Remove this profile
        $twitter_profile->delete();

        return back()->with('flash', 'Twitter profile @' .$twitter_profile->handler. ' unlinked.');

    }

}
