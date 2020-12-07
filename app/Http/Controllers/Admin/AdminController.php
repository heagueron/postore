<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    /**
     * Edit admin options
     *
     * @param  Spost $spost
     * @return Response
     */
    public function editAdminOptions()
    {
        $adminOptions = \App\Option::all();
        $adminTextOptions = \App\TextOption::all();
        $adminPlans = \App\Plan::all();

        return view( 'admin.edit-options', compact( 'adminOptions', 'adminTextOptions', 'adminPlans') );
    }

    /**
     * Update admin options
     *
     * @param  Spost $spost
     * @return Response
     */
    public function updateAdminOptions(Request $request)
    {
        $request->validate([
            'base_price' => [ 'required', 'string' ],
            'pro_price' => [ 'required', 'string' ],
            'premium_price' => [ 'required', 'string' ],

            'remjob_active_duration' => [ 'required', 'string' ],
            'support_email' => [ 'required', 'email' ],
        ]);
        \App\Plan::find(1)->update( ['value'=>$request->base_price] );

        \App\Plan::find(2)->update( ['value'=>$request->pro_price] );
        \App\Plan::find(3)->update( ['value'=>$request->premium_price] );

        \App\Option::find(1)->update( ['value'=>$request->remjob_active_duration] );
        \App\TextOption::find(1)->update( ['value'=>$request->support_email] );

        return redirect()->back()->with( 'flash','Admin options values updated' );
    }



}
