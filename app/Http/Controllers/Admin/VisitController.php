<?php

namespace App\Http\Controllers\Admin;

use App\Daily;
use App\Visit;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class VisitController extends Controller
{

    /**
     * Remove consolidated visit data from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function cleanAll()
    {
        $endDT = Carbon::yesterday();

        //Make sure data has been consolidated
        if( Daily::where('track_day', $endDT->toDateString() )->exists() ){
            // Clean DB
            Visit::whereDate('created_at', '!=', Carbon::today())->delete();
            return back()->with('flash', 'Old visit registers removed from DB. ');  
        }
        else{
            return back()->with('fail', 'Warning: data has not been consolidated!');
        }
    }

}
