<?php

namespace App\Http\Controllers;

use App\Tag;
use App\Remjob;
use App\Category;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Requests\StoreRemjob;

use Intervention\Image\Facades\Image;

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
        $remjobs = Remjob::orderBy('front_page_2w', 'desc')->orderBy('created_at', 'desc')->get();

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
        //dd($request()->show_logo);

        // Create the remote job post
        $remjob = Remjob::create([

            'position'          => request()->position,
            'description'       => request()->description,
            'category_id'       => request()->category_id,
            'min_salary'        => request()->min_salary,
            'max_salary'        => request()->max_salary,
            'locations'         => request()->locations,
            'apply_link'        => request()->apply_link,
            'apply_email'       => request()->apply_email,
            'apply_mode'        => request()->apply_mode,
            'company_name'      => request()->company_name,
            'company_slug'      => Str::slug( request()->company_name, '-' ),
            'company_email'     => request()->company_email,
            'company_twitter'   => request()->company_twitter,
            'show_logo'         => request()->show_logo,
            'highlight_yellow'  => request()->highlight_yellow,
            'front_page_2w'     => request()->front_page_2w,
            'front_category_2w' => request()->front_category_2w,
      
        ]);

        //dd( request(),  $remjob->show_logo, $remjob->highlight_yellow, $remjob->front_page_2w, $remjob->front_category_2w);

        // Add media to the remote job model
        if( !is_null( request()->company_logo ) ){
            $this->storeMedia ($remjob );
        }

        // tags for the remjob-tag pivot table
        $tagsIdToLink = []; // 

        $inputTags = explode(',', request()->tags );

        // Insert the Category tag in the first position of the array
        $category = Category::find( request()->category_id );
        array_unshift( $inputTags, $category->tag);

        // Add every tag, if it does not exist, create it in the database.
        foreach ( $inputTags as $inputTag ) {
            if( Tag::where('name',trim($inputTag) )-> exists() ) {
                $foundTag = Tag::where('name',trim($inputTag) )->first();
                array_push( $tagsIdToLink, $foundTag->id );
            } else {
                $newTag = Tag::create([ 'name' => trim($inputTag) ]);
                array_push( $tagsIdToLink, $newTag->id );
            }
        }

        $remjob->tags()->attach( array_unique( $tagsIdToLink ) );

        // Calculate job post total
        $jobPostTotal = 15
            + ($remjob->show_logo * 15)
            + ($remjob->highlight_yellow * 15)
            + ($remjob->front_page_2w * 30)
            + ($remjob->front_category_2w * 15);

        $remjob->update([ 
            'total'        => $jobPostTotal,
            'gumroad_link' => $this->determineGumroadLink( $remjob ), 
        ]);

        //dd($remjob->total);
        // Store the new Remjob id...
        session([ 'newRemjobId' => $remjob->id ]);

        return redirect()->route( 'checkout', [$remjob] );

        // Back to remote job list
        //return redirect('/')->with('flash', 'New Remote Job posted!');

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

        if( in_array( $tagsText, ['dev', 'customer-support', 'marketing', 'design', 'non-tech'] ) ){
            // Search for a CATEGORY TAG
            $category = Category::where( 'tag', 'like', $tagsText )->first();
            //dd($category);
            if( $category->has('remjobs') ){
                $remjobs = $category->remjobs()->orderBy('front_category_2w', 'desc')->orderBy('created_at', 'desc')->get();
            } else { $remjobs = null; }
            
        } else {
            // Search for a normal TAG
            $tag = Tag::where( 'name', 'like', $tagsText )->first();
            if ($tag === null) {
                return view('404');
            }
            if( $tag->has('remjobs') ){
                $remjobs = $remjobs = $tag->remjobs()->orderBy('created_at', 'desc')->get();
            } else { $remjobs = null; }

        }
        
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
        $remjobs = Remjob::where( 'company_slug', 'like', $company_slug )->orderBy('created_at', 'desc')->get();
        
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

    }

    /**
     * Store the incoming $remjob company_logo.
     *
     * @param Remjob $remjob
     * @return void
     */
    private function storeMedia($remjob)
    {
        $remjob->update([
            'company_logo' => request()->company_logo->store('logos', 'public')
        ]);

        $fixedLogo = Image::make( public_path('storage/' . $remjob->company_logo) )->fit(60, 60);
        $fixedLogo->save();    

    }

    private function determineGumroadLink( $remjob ) {
        $l = $remjob->show_logo;
        $h = $remjob->highlight_yellow;
        $fp = $remjob->front_page_2w;
        $fc = $remjob->front_category_2w;

        if ( !$l and !$h and !$fp and !$fc ) {
            $gumroadLink = 'link-0000';
        } elseif ( !$l and !$h and !$fp and $fc ) {
            $gumroadLink = 'link-0001';
        } elseif ( !$l and !$h and $fp and !$fc ) {
            $gumroadLink = 'link-0010';
        } elseif ( !$l and !$h and $fp and $fc ) {
            $gumroadLink = 'link-0011';
        } elseif ( !$l and $h and !$fp and !$fc ) {
            $gumroadLink = 'link-0100';
        } elseif ( !$l and $h and !$fp and $fc ) {
            $gumroadLink = 'link-0101';
        } elseif ( !$l and $h and $fp and !$fc ) {
            $gumroadLink = 'link-0110';
        } elseif ( !$l and $h and $fp and $fc ) {
            $gumroadLink = 'link-0111';
        } elseif ( $l and !$h and !$fp and !$fc ) {
            $gumroadLink = 'link-1000';
        } elseif ( $l and !$h and !$fp and $fc ) {
            $gumroadLink = 'link-1001';
        } elseif ( $l and !$h and $fp and !$fc ) {
            $gumroadLink = 'link-1010';
        } elseif ( $l and !$h and $fp and $fc ) {
            $gumroadLink = 'link-1011';
        } elseif ( $l and $h and !$fp and !$fc ) {
            $gumroadLink = 'link-1100';
        } elseif ( $l and $h and !$fp and $fc ) {
            $gumroadLink = 'link-1101';
        } elseif ( $l and $h and $fp and !$fc ) {
            $gumroadLink = 'link-1110';
        } elseif ( $l and $h and $fp and $fc ) {
            $gumroadLink = 'link-1111';
        }

        return $gumroadLink;
    }


}
