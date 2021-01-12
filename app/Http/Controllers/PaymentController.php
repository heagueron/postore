<?php

namespace App\Http\Controllers;

use App\Remjob;
use Illuminate\Http\Request;
use App\Rules\GumroadLicense;
use App\ApiConnectors\Gumroad;
use Illuminate\Support\Facades\Auth;

use App\Traits\PublishRemjob;
use Illuminate\Support\Facades\Log;

class PaymentController extends Controller
{
    use PublishRemjob;

    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display the specified resource checkout page.
     *
     * @param  \App\Remjob  $remjob
     * @return \Illuminate\Http\Response
     */
    public function checkout(Remjob $remjob)
    {
        //dd( Auth::user()->id, $remjob->company->user->id )
        if( $remjob->external_api ){
            return redirect()->route('landing');
        } else if ( Auth::user()->id != $remjob->company->user->id ) {
                return redirect()->route('landing');
        } 

        if( $remjob->paid == 1) {
            return redirect()->route('landing');
        }

        return view( 'payments.checkout', compact('remjob') );

    }

    

    /**
     * Show the form for activating a remjob after payment
     *
     * @return \Illuminate\Http\Response
     */
    public function activate( Request $request )
    {   
        
        if( ( null !== session('newRemjobId') ) and Remjob::where('id', session('newRemjobId') )->exists() ) {

            $remjob = Remjob::find( session('newRemjobId') );

            // Retrieve the license from gumroad:
            if ( request()->query('sale_id') ) {

                $grConnection = new Gumroad();

                $sale = $grConnection->getSale( request()->query('sale_id') )['sale'];
                
                $gumroadLicense = $sale['license_key'];

                return view( 'payments.publish', compact( 'remjob', 'gumroadLicense' ) );

            } else { 
                $title = 'Information';
                $message = 'Ooops!. We could not find your payment license for this job post.';
            }

        } else {
            $title = 'Information';
            $message = 'Ooops!. We could not find your remote job.';
        }
         
        return view( 'information', compact( 'title', 'message' ) );

    }

    /**
     * Publish a newly created remote job in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function publish( Request $request, Remjob $remjob )
    {
        $request->validate([
            'license' => [ 'required', 'string', new GumroadLicense ],
        ]);

        // Activate the remote job post active and paid attribute to publish:
        $remjob->update([
            'active'                => 1,
            'paid'                  => 1,
            'gumroad_license'       => request()->license,
        ]);

        Log::info( 'Remote Job id: ' .$remjob->id.' activated.' );

        // Share new posted remote job on Twitter
        $publish = $this->shareRemjobOnTwitter( $remjob );

        if( $publish ){
            Log::info( 'New Remote Job id: ' .$remjob->id.' shared on Twitter.' );
            return redirect()->route( 'landing' )->with('flash', 'New Remote Job activated | Shared on Twitter!');
        } else {
            Log::info( 'New Remote Job id: ' .$remjob->id.' failed to share on Twitter.' );
            return redirect()->route( 'landing' )->with('flash', 'New Remote Job activated | Failed to share on Twitter!');
        } 
        //return redirect()->route('landing')->with('flash', 'New remote job posted!');
    }

    /**
     * Publish a newly created remote job in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function freePublish( Request $request, Remjob $remjob )
    {
        // Make sure job post has free plan
        if( $remjob->plan->id == 1 ){

            // Activate the remote job post active and to publish:
            $remjob->update([
                'active'                => 1,
            ]);

            Log::info( 'Remote Job id: ' .$remjob->id.' activated.' );
            
            // Share new posted remote job on Twitter
            $publish = $this->shareRemjobOnTwitter( $remjob );
            
            if( $publish ){
                Log::info( 'New Remote Job id: ' .$remjob->id.' shared on Twitter.' );
                return redirect()->route( 'landing' )->with('flash', 'New Remote Job activated | Shared on Twitter!');
            } else {
                Log::info( 'New Remote Job id: ' .$remjob->id.' failed to share on Twitter.' );
                return redirect()->route( 'landing' )->with('flash', 'New Remote Job activated | Failed to share on Twitter!');
            } 
 
        }

        return redirect()->route( 'landing' )->with('fail', 'Attemp to publish a paid plan as "free" ... '); 
        
    }

}
