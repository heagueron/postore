<?php

namespace App\Http\Controllers;

use DB;

use App\Spost;

use Illuminate\Http\Request;
use App\Http\Requests\StoreSpost;

class SpostController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $user = \Auth::user();
        //dd($user);

        $sposts = $user->sposts()->get();
      
        return view( 'sposts.index', compact('user', 'sposts') );

    }

    public function create()
    {
        $user = \Auth::user();

        // Check if user has at least one social network profile
        if ( empty($user->twitter_profiles->all() )){
            // TODO: add check for other social network profiles
            // Go ahead and create a twitter profile in postore app (not just a Twitter user).
            return redirect('/twitter_profiles/create'); 
        }
        
        return view('sposts.create', compact('user'));
    }

    /**
     * Store the incoming spost.
     *
     * @param  StoreSpost  $request
     * @return Response
     */

    public function store(StoreSpost $request)
    {
        $spost = Spost::create( $request->validated() );
        
        $tpIds = request()->input('twitter_accounts');
        $spost->twitter_profiles()->attach( array_values($tpIds) );
        
        return redirect('/sposts')->with('flash', 'New post scheduled!');

    }

    // protected function validatedData()
    // {
    //     //Todo: build custom validator to pass with at least one social profile (no only twitter)
    //     return request()->validate([
    //         'text'                  => 'required|min:1|max:240',
    //         'user_id'               => 'required',
    //         'post_date'             => 'required',
    //         "twitter_accounts"      => "required|array|min:1",
    //         "twitter_accounts.*"    => "required|string",
    //     ]);
    // }

}
