<?php

namespace App\Http\Controllers;

use App\Remjob;
use Illuminate\Http\Request;
use App\Rules\GumroadLicense;
use App\ApiConnectors\Gumroad;

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
            } else { $sale['license_key'] = '';}

            return view( 'payments.publish', compact( 'remjob', 'gumroadLicense' ) );
        }
        else {
            $message = 'Sorry. We could not find your remote job. Contact support: heagueron@gmail.com';
            return view( 'information', compact( 'message' ) );
        }
    }

    /**
     * Store a newly created resource in storage.
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

}
