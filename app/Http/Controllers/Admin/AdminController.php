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
        //dd($adminOptions[0]->value);
        return view( 'admin.edit-options', compact('adminOptions') );
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
            'base_price' => [ 'required', 'string'],
            'show_logo' => [ 'required', 'string'],
            'yellow_background' => [ 'required', 'string'],
            'main_front_page' => [ 'required', 'string'],
            'category_front_page' => [ 'required', 'string'],
            'remjob_active_duration' => [ 'required', 'string'],
        ]);
        \App\Option::find(1)->update( ['value'=>$request->base_price]);
        \App\Option::find(2)->update( ['value'=>$request->show_logo]);
        \App\Option::find(3)->update( ['value'=>$request->yellow_background]);
        \App\Option::find(4)->update( ['value'=>$request->main_front_page]);
        \App\Option::find(5)->update( ['value'=>$request->category_front_page]);
        \App\Option::find(6)->update( ['value'=>$request->remjob_active_duration]);

        return redirect()->back()->with('flash','Admin options values updated');
    }



}
