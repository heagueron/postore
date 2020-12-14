<?php

namespace App\Http\Controllers;

use App\Remjob;
use Illuminate\Http\Request;
use App\Rules\GumroadLicense;
use App\ApiConnectors\Gumroad;
use Illuminate\Support\Facades\Auth;

class PaymentController extends Controller
{
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

                $sale = Gumroad::getSale( $request->query('sale_id') )['sale'];
                $gumroadLicense = $sale['license_key'];

                return view( 'payments.publish', compact( 'remjob', 'gumroadLicense' ) );

            } else { 
                $message = 'Sorry. We could not find your payment license for this job post. Contact support: heagueron@gmail.com';
            }

        } else {
            $message = 'Sorry. We could not find your remote job. Contact support: heagueron@gmail.com';
        }
         
        return view( 'information', compact( 'message' ) );

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
        return redirect()->route( 'landing')->with('flash', 'New remote job posted!');
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
            return redirect()->route( 'landing' )->with('flash', 'New remote job posted!'); 
        }

        return redirect()->route( 'landing' )->with('fail', 'Attemp to publish a paid plan as "free" ... '); 
        
    }

}
