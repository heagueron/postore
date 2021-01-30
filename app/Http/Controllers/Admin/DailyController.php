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
                //dd('breaking on: ', $endDT->toDateString() );
                break;
            }

            $landingVisits = 0;
            foreach (Visit::all() as $visit) {
                if ( Str::limit( $visit->created_at, 10, '') == $endDT->toDateString()  ) {
                    $landingVisits +=1;
                }
            }

            // Got Landing Visits?
            if( $landingVisits > 0 ){
                Daily::create([
                    'track_day'    => $endDT->toDateString(),
                    'hits_landing' => $landingVisits,
                ]);
            }
            
            //array_push( $all_dates, $endDT->toDateString() );
            $endDT->subDay();
        }
        //dd($all_dates);
        return back()->with('flash', 'All dailies updated. ');

    }

}
