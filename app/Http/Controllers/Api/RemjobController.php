<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Remjob;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;
use Carbon\Carbon;


class RemjobController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $remjobs = Remjob::where('active',1)->whereDate('created_at', '<', Carbon::yesterday()->toDateString())->get();
        
        $apiRemjobs = [];
        foreach ($remjobs as $remjob) {
            $apiRemjob = [
                'id'            => $remjob->id,
                'position'      => $remjob->position,
                'description'   => $remjob->description,
                'category'      => $remjob->category->name,
                'tags'          => $remjob->tags()->take(5)->pluck('name'),
                'locations'     => $remjob->locations,
                'url'           => 'https://remjob.io/' . $remjob->slug,
                'company'       => $remjob->company->name,
                'created_at'    => date_format($remjob->created_at,"Y-m-d H:i:s"),
            ];

            array_push($apiRemjobs, $apiRemjob);
        }
        return $apiRemjobs;
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
        //
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
        //
    }
}
