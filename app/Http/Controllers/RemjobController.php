<?php

namespace App\Http\Controllers;

use App\Tag;
use App\Remjob;
use App\Category;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Requests\StoreRemjob;

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
        $remjobs = Remjob::orderBy('created_at', 'desc')->get();
        //dd( $remjobs );
        //session([ 'selectedTag' => '' ]);

        return view( 'landing', compact('remjobs') );

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = \App\Category::where('id', '>', '1')->get();
        // dd($categories);
        return view( 'remjobs.create', compact('categories') );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreRemjob $request)
    {
        dd($request);
        // Create the remote job post
        $remjob = Remjob::create([

            'position'      => request()->position,
            'description'   => request()->description,
            'category_id'   => request()->category_id,
            'min_salary'    => request()->min_salary,
            'max_salary'    => request()->max_salary,
            'locations'     => request()->locations,
            'apply_link'    => request()->apply_link,
            'company_name'  => request()->company_name,
            'company_slug'  => Str::slug( request()->company_name, '-' ),
            'company_email' => request()->company_email,
      
        ]);

        $tagsIdToLink = []; // tags for the remjob-tag pivot table

        $inputTags = explode(',', request()->tags );
        $category = Category::find( request()->category_id );
        array_unshift( $inputTags, $category->tag);

        foreach ( $inputTags as $inputTag ) {
            if( Tag::where('name',trim($inputTag) )-> exists() ) {
                $foundTag = Tag::where('name',trim($inputTag) )->first();
                array_push( $tagsIdToLink, $foundTag->id );
            } else {
                $newTag = Tag::create([ 'name' => trim($inputTag) ]);
                array_push( $tagsIdToLink, $newTag->id );
            }
        }
        // dd($tagsIdToLink);

        $remjob->tags()->attach( array_unique( $tagsIdToLink ) );

        return redirect('/')->with('flash', 'New Remote Job posted!');
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
     * @param  string $tags
     * @return \Illuminate\Http\Response
     */
    public function searchByTags( $tags )
    {
        $tagsLength = ( Str::length( $tags ) ) - 12;
        $tagsText = Str::substr($tags, 7, $tagsLength);

        $tag = Tag::where( 'name', 'like', $tagsText )->first();
        if ($tag === null) {
            return view('404');
        }

        $remjobs = $tag->remjobs()->get();
        
        return view( 'landing', compact('remjobs') );
        
    }

    /**
     * Display the specified resource.
     *
     * @param  string $company_name
     * @return \Illuminate\Http\Response
     */
    public function searchByCompany( $company_slug )
    {
        $remjobs = Remjob::where( 'company_slug', 'like', $company_slug )->get();
        
        return view( 'landing', compact('remjobs') );
        
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
