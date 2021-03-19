<?php

namespace App\Http\Controllers\Api;

use App\Visit;
use App\Remjob;
use Carbon\Carbon;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Resources\RemjobResource;
use App\Http\Resources\RemjobCollection;
use App\Http\Resources\RemjobCollectionPro;


class RemjobController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Register a visit
        $ip = \request()->ip();
        $this->registerVisit($ip, 'apiV1Remjobs');

        $remjobs = Remjob::where('active',1)
            ->whereDate('created_at', '<', Carbon::yesterday()->toDateString())
            ->orderBy('created_at', 'desc')
            ->take(150)
            ->get();

        return new RemjobCollection( $remjobs );
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function indexPro()
    {
        // Register a visit
        $ip = \request()->ip();
        $this->registerVisit($ip, 'apiV1Remjobs');

        $remjobs = Remjob::where('active',1)
            ->orderBy('created_at', 'desc')
            ->get();

        return new RemjobCollectionPro( $remjobs );  
    }

    private function registerVisit( $ip, $route, $firstOnDate = false ){
        
        if( !Visit::where('visitor_ip', $ip)->exists() ){
            // First time ever!
            $firstOnDate = true;

        } else {
            $latestVisit = Visit::where('visitor_ip', $ip)->orderBy('created_at', 'desc')->first();
            if ( !$latestVisit->created_at->isToday() ){
                $firstOnDate = true;
            } 
        }

        Visit::create([
            'visitor_ip'    => $ip,
            'entry_route'   => $route,
            'user_id'       => null,
            'first_on_date' => $firstOnDate
        ]);

        return;
        
    }

}
