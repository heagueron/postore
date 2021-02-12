<?php

namespace App\Http\Controllers\Admin;

use App\TextOption;
use App\Option;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

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
        $options = \App\Option::all();
        $textOptions = TextOption::all();
        // $adminPlans = \App\Plan::all();

        //return view( 'admin.edit-options', compact( 'adminOptions', 'adminTextOptions', 'adminPlans') );
        return view( 'admin.options.index', compact( 'options', 'textOptions') );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function storeTextOption(Request $request)
    {
        //dd($request);
        $data = request()->validate([
            'name'          => 'required',
            'value'         => 'required',
        ]);

        TextOption::create($data);

        return redirect()->route('admin.edit-options');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\TextOption  $textOption
     * @return \Illuminate\Http\Response
     */
    public function editTextOption(TextOption $textOption)
    {
        // dd('will edit text option: ', $textOption->name);
        return view('admin.options.editTextOption', compact('textOption') );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\TextOption  $textOption
     * @return \Illuminate\Http\Response
     */
    public function updateTextOption(Request $request, TextOption $textOption)
    {
        //dd('upddate ', $textOption->name, $request);
        $data = request()->validate([
            'name'          => 'required',
            'value'         => 'required',
        ]);

        $textOption->update($data);

        return redirect()->route('admin.edit-options');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Option  $option
     * @return \Illuminate\Http\Response
     */
    public function editOption(Option $option)
    {
        //dd('will edit option: ', $option->name);
        return view('admin.options.editOption', compact('option') );
    }

     /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Option  $option
     * @return \Illuminate\Http\Response
     */
    public function updateOption(Request $request, Option $option)
    {
        //dd('upddate ', $option->name, $request);
        $data = request()->validate([
            'name'          => 'required',
            'value'         => 'required',
        ]);

        $option->update($data);

        return redirect()->route('admin.edit-options');
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
