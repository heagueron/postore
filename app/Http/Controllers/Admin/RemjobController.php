<?php

namespace App\Http\Controllers\Admin;

use App\Remjob;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class RemjobController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        //dd("admin remjob controller index ");
        $remjobs = Remjob::orderBy('created_at', 'desc')->get();
        return view( 'admin.remjobs.index',compact('remjobs') );

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Remjob  $remjob
     * @return \Illuminate\Http\Response
     */
    public function show(Remjob $remjob)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Remjob  $remjob
     * @return \Illuminate\Http\Response
     */
    public function edit(Remjob $remjob)
    {
        dd('edit remjob position: ', $remjob->position);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Remjob  $remjob
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Remjob $remjob)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Remjob  $remjob
     * @return \Illuminate\Http\Response
     */
    public function destroy(Remjob $remjob)
    {
        // Delete media files
        if(\Storage::exists( 'public/' . $remjob->company_logo )){
            \Storage::delete( 'public/' . $remjob->company_logo );           
        }

        // Delete from pivot table Sposts-Twitter profiles
        DB::table('remjob_tag')->where('remjob_id',$remjob->id)->delete();

        // Delete the scheduled post
        $remjob->delete();

        return back()->with('message', 'Removed Remote Job Post from ' . $remjob->company_name );
        
    }
}
