<?php

namespace App\Http\Controllers\Admin;

use App\Daily;
use App\Visit;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DailyController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if( Daily::all()->count() > 0 ){
            $dailies = Daily::latest()->get();
        } else { $dailies = []; }
        
        return view( 'admin.dailies.index',compact('dailies') );
    }

    /**
     * Update all dailies
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function updateAll(Request $request)
    {
        // From a date string
        $startDT = new Carbon('2021-01-28');
        $endDT = Carbon::yesterday();

        //$all_dates = array();
        while ( $endDT->gte($startDT) ){

            if( Daily::where('track_day', $endDT->toDateString())->exists() ){
                break;
            }

            if( Visit::where('created_at', '==', $endDT)->exists() ){
                $landingVisits = 0;
                $detailVisits = 0;
                foreach ( Visit::whereDate('created_at', '==', $endDT)  as $visit ) {
                    if ( $visit->entry_route == 'landing'  ) { $landingVisits +=1; }
                    if ( $visit->entry_route == 'remjobs.show'  ) { $detailVisits +=1; }
                }
                Daily::create([
                    'track_day'     => $endDT->toDateString(),
                    'hits_landing'  => $landingVisits,
                    'hits_details'  => $$detailVisits,
                ]);
            }

            $endDT->subDay();

        }

        return back()->with('flash', 'All dailies updated. ');

    }

}
