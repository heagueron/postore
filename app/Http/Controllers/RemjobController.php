<?php

namespace App\Http\Controllers;

use DB;
use App\Tag;
use App\Remjob;
use App\Company;
use App\Category;
use Carbon\Carbon;
use Illuminate\Support\Str;

use Illuminate\Http\Request;

use App\Http\Requests\StoreRemjob;
use Illuminate\Support\Facades\App;
use Intervention\Image\Facades\Image;
use Illuminate\Database\Eloquent\Builder;

class RemjobController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // App::setLocale('es');
        if( Remjob::where( [['language', '=', App::getLocale()],['active', '=', '1']] )->exists() ){

            $remjobs = Remjob::where( [['language', '=', App::getLocale()],['active', '=', '1']] )
                ->orderBy('main_front_page', 'desc')->orderBy('created_at', 'desc')->get();

        } else { $remjobs = []; } 

        return view( 'landing', compact('remjobs') );

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //App::setlocale('es');
        if (App::isLocale('es')) {
            $categories = \App\Category::whereIn( 'id', [7, 8, 9, 10, 11, 12] )->get();
        } else {
            $categories = \App\Category::whereIn( 'id', [1, 2, 3, 4, 5, 6] )->get();
        }

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
        //dd( request() );

        // Create the remote job post
        $remjob = Remjob::create([

            'position'              => request()->position,
            'description'           => request()->description,
            'category_id'           => request()->category_id,
            'min_salary'            => request()->min_salary,
            'max_salary'            => request()->max_salary,
            'locations'             => request()->locations,
            'apply_link'            => request()->apply_link,
            'apply_email'           => request()->apply_email,
            'apply_mode'            => request()->apply_mode,
            'show_logo'             => request()->show_logo,
            'yellow_background'     => request()->yellow_background,
            'main_front_page'       => request()->main_front_page,
            'category_front_page'   => request()->category_front_page,       
        ]);

        // Company
        if( is_null( request()->company_id ) ){
            // Create company
            $company = Company::create([
                'name'      => request()->company_name,
                'slug'      => Str::slug( request()->company_name, '-' ),
                'email'     => request()->company_email,
                'user_id'   => \Auth::user()->id,
            ]);
        } else {
            $company = Company::findOrFail( request()->company_id );
        }

        // Add media to the company model
        if( !is_null( request()->company_logo ) ){
            $this->storeMedia( $company );
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
        $jobPostTotal = \App\Option::find(1)->value
            + ( $remjob->show_logo * \App\Option::find(2)->value )
            + ( $remjob->yellow_background * \App\Option::find(3)->value )
            + ( $remjob->main_front_page * \App\Option::find(4)->value )
            + ( $remjob->category_front_page * \App\Option::find(5)->value );

        $remjob->update([ 
            'total'                 => $jobPostTotal,
            'language'              => App::getLocale(),
            'gumroad_link'          => $this->determineGumroadLink( $remjob )['gumroadLink'],
            'gumroad_product_id'    => $this->determineGumroadLink( $remjob )['gumroadId'],
            'company_id'            => $company->id,
            'slug'                  => Str::slug( ($remjob->position.' '.$remjob->id), '-'),
        ]);

        // Store the new Remjob id...
        session([ 'newRemjobId' => $remjob->id ]);

        // Head to preview and checkout page

        // return redirect()->route( 'checkout', [ $company->slug.'-'.Str::slug( request()->position, '-' ).'-'.$remjob->id ] );
        return redirect()->route( 'checkout', $remjob->slug );


    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Remjob  $remjob
     * @return \Illuminate\Http\Response
     */
    public function show(Remjob $remjob)
    {
        return view( 'remjobs.show', compact('remjob') );
    }

    /**
     * Display the specified resource checkout page.
     *
     * @param  \App\Remjob  $remjob
     * @return \Illuminate\Http\Response
     */
    // public function checkout(Remjob $remjob)
    // {
    //     return view( 'remjobs.checkout', compact('remjob') );
    // }

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

            if( $category->whereHas('remjobs', function (Builder $query) {
                $query->where('active', 1);
            }) ){
                $remjobs = $category->remjobs()->where('active', 1)
                    ->orderBy('category_front_page', 'desc')
                    ->orderBy('created_at', 'desc')->get();
            } else { $remjobs = null; }
            
        } else {
            // Search for a normal TAG
            $tag = Tag::where( 'name', 'like', $tagsText )->first();
            if ($tag === null) {
                return view('404');
            }

            if( $tag->whereHas('remjobs', function (Builder $query) {
                $query->where('active', 1);
            }) ){
                $remjobs = $tag->remjobs()->where('active', 1)
                    ->orderBy('category_front_page', 'desc')
                    ->orderBy('created_at', 'desc')->get();
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
        $company = Company::where( 'slug', 'like', $company_slug )->first();
        $remjobs = Remjob::where( 'company_id', $company->id )->orderBy('created_at', 'desc')->get();
        
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
    private function storeMedia( $company )
    {
        $company->update([
            'logo' => request()->company_logo->store('logos', 'public')
        ]);

        $fixedLogo = Image::make( public_path('storage/' . $company->logo) )->resize(60, 60);
        $fixedLogo->save();    
        return;
    }

    private function determineGumroadLink( $remjob ) {
        $l = $remjob->show_logo;
        $h = $remjob->yellow_background;
        $fp = $remjob->main_front_page;
        $fc = $remjob->category_front_page;

        if ( !$l and !$h and !$fp and !$fc ) {
            $gumroadLink = 'link-0000';
            $gumroadId = '0000';   
        } elseif ( !$l and !$h and !$fp and $fc ) {
            $gumroadLink = 'link-0001';
            $gumroadId = '0001';   
        } elseif ( !$l and !$h and $fp and !$fc ) {
            $gumroadLink = 'link-0010';
            $gumroadId = '0010';   
        } elseif ( !$l and !$h and $fp and $fc ) {
            $gumroadLink = 'link-0011';
            $gumroadId = '0011';   
        } elseif ( !$l and $h and !$fp and !$fc ) {
            $gumroadLink = 'link-0100';
            $gumroadId = '0100';   
        } elseif ( !$l and $h and !$fp and $fc ) {
            $gumroadLink = 'link-0101';
            $gumroadId = '0101';   
        } elseif ( !$l and $h and $fp and !$fc ) {
            $gumroadLink = 'link-0110';
            $gumroadId = '0110';   
        } elseif ( !$l and $h and $fp and $fc ) {
            $gumroadLink = 'link-0111';
            $gumroadId = '0111';   
        } elseif ( $l and !$h and !$fp and !$fc ) {
            $gumroadLink = 'link-1000';
            $gumroadId = '1000';   
        } elseif ( $l and !$h and !$fp and $fc ) {
            $gumroadLink = 'link-1001';
            $gumroadId = '1001';   
        } elseif ( $l and !$h and $fp and !$fc ) {
            $gumroadLink = 'link-1010';
            $gumroadId = '1010';   
        } elseif ( $l and !$h and $fp and $fc ) {
            $gumroadLink = 'link-1011';
            $gumroadId = '1011';   
        } elseif ( $l and $h and !$fp and !$fc ) {
            $gumroadLink = 'link-1100';
            $gumroadId = '1100';   
        } elseif ( $l and $h and !$fp and $fc ) {
            $gumroadLink = 'link-1101';
            $gumroadId = '1101';   
        } elseif ( $l and $h and $fp and !$fc ) {
            $gumroadLink = 'link-1110';
            $gumroadId = '1110';   
        } elseif ( $l and $h and $fp and $fc ) {
            $gumroadLink = 'link-1111';
            $gumroadId = '1111';   
        }

        return compact('gumroadLink', 'gumroadId');

    }


}
