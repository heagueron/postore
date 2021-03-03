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

            $landingVisits = Visit::whereDate( 'created_at', '=', $endDT->toDateString())->where('entry_route', 'landing')->exists()
                            ? Visit::whereDate( 'created_at', '=', $endDT->toDateString())->where('entry_route', 'landing')->count()
                            : 0;

            $detailVisits = Visit::whereDate( 'created_at', '=', $endDT->toDateString())->where('entry_route', 'remjobs.show')->exists()
                            ? Visit::whereDate( 'created_at', '=', $endDT->toDateString())->where('entry_route', 'remjobs.show')->count()
                            : 0;
                            
            $categoryOrTagVisits = Visit::whereDate( 'created_at', '=', $endDT->toDateString())->where('entry_route', 'remjobs.searchByTags')->exists()
                            ? Visit::whereDate( 'created_at', '=', $endDT->toDateString())->where('entry_route', 'remjobs.searchByTags')->count()
                            : 0;

            $uniqueVisitors = Visit::whereDate( 'created_at', '=', $endDT->toDateString())->where('first_on_date', 1)->exists()
                            ? Visit::whereDate( 'created_at', '=', $endDT->toDateString())->where('first_on_date', 1)->count()
                            : 0;
            try{ 

                Daily::create([
                    'track_day'         => $endDT->toDateString(),
                    'hits_landing'      => $landingVisits,
                    'hits_details'      => $detailVisits,
                    'hits_category'     => $categoryOrTagVisits,
                    'visitors_count'    => $uniqueVisitors,
                ]);

            } catch (\Exception $exception){ 
                Log::info( 'Failed to create daily on: ' . $endDT->toDateString() );
                dd( 'Failed to create daily on: ' . $endDT->toDateString(), $exception );
            }
            

            $endDT->subDay();           

        }

        return back()->with('flash', 'All dailies updated. ');

    }

}
