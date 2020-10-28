<?php

namespace App\Http\Controllers;

use App\Remjob;
use App\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class RemjobController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $remjobs = Remjob::all();
        //dd( $remjobs );
        session([ 'selectedTag' => '' ]);

        return view( 'landing', compact('remjobs') );

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view( 'remjobs.create' );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        dd($request);
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
     * Display the specified resource.
     *
     * @param  \App\Remjob  $remjob
     * @return \Illuminate\Http\Response
     */
    public function searchByTags( $tags, Request $request )
    {
        $tagsLength = ( Str::length( $tags ) ) - 12;
        $tagsText = Str::substr($tags, 7, $tagsLength);

        $tag = Tag::where( 'name', 'like', $tagsText )->first();
        if ($tag === null) {
            return view('404');
        }

        if( $tag->remjobs()->count() > 0 ) {
            $remjobs = $tag->remjobs()->get();
            return view( 'landing', compact('remjobs') );
        }

        dd($tag->name.' has no remjobs posted');
        
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

    /**
     * Returns a list of job_tags
     * @param  null
     * @return \Illuminate\Http\Response
     */
    public function job_tags()
    {
        $job_tags = array(
            array('tag' => 'javascript'),
            array('tag' => 'node'),
            array('tag' => 'php'),
            array('tag' => 'java'),
            array('tag' => 'python'),
            array('tag' => 'angular'),
            array('tag' => 'react'),
            array('tag' => 'vue'),
            array('tag' => 'devops'),
            array('tag' => 'docker'),
            array('tag' => 'engineer'),
        );

        return response()->json([
            'job_tags' => $job_tags
        ],200);
    }

    /**
     * Returns a list of job_tags, filtered by a search_term
     * @param  string $search_term
     * @return \Illuminate\Http\Response
     */
    public function search_job_tags_by_term($search_term)
    {
        $job_tags = Tag::all();

        $filtered_job_tags = array();

        foreach ($job_tags as $key => $job_tag) {
            if( Str::startsWith( strtolower( $job_tag->name ), strtolower( $search_term ) ) ) {
                array_push( $filtered_job_tags, $job_tag);
            };
        }
            
        $job_tags = "Hello there. I will send the Job tags list by term.";
        return response()->json([
            'search_term'       => $search_term,
            'filtered_job_tags' => $filtered_job_tags
        ],200);
        // return response()->json([
        //     'array1'       => $$job_tags1,
        //     'array2' => $job_tags
        // ],200);
    }


}
