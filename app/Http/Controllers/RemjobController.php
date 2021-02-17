<?php

namespace App\Http\Controllers;

use DB;
use App\Tag;
use App\Visit;
use App\Remjob;
use App\Company;
use App\Category;
use Carbon\Carbon;

use Illuminate\Support\Str;

use Illuminate\Http\Request;
use App\Mail\RemjobCreatedMail;
use App\Http\Requests\StoreRemjob;
use App\Http\Requests\UpdateRemjob;
use App\Mail\RemjobUpdatedMail;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Builder;

class RemjobController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index( Request $request )
    {
        // App::setLocale('es');

        // Register a visit
        $ip = \request()->ip();
        if( !Visit::where('visitor_ip', $ip)->exists() ){
            $this->registerVisit( $ip, 'landing' );
        } else {
            $latestVisit = Visit::where('visitor_ip', $ip)->orderBy('created_at', 'desc')->first();
            if ( !$latestVisit->created_at->isToday() ){
                $this->registerVisit( $ip, 'landing' );
            } 
        }
        
        Log::info( 'Will show all active remote jobs' );

        if( Remjob::where( [['language', '=', App::getLocale()],['active', '=', '1']] )->exists() ){

            $remjobs = Remjob::where( [['language', '=', App::getLocale()],['active', '=', '1']] )
                ->orderBy('plan_id', 'desc')->orderBy('created_at', 'desc')->get();

        } else { $remjobs = []; } 

        $lenguageId = \App\Language::where('short_name', App::getLocale())->first()->id;

        $categories = Category::where('language_id', '=',  $lenguageId )->get();
        $selectedCategory = $categories[0];
        //dd($selectedCategory);
        return view( 'landing', compact('remjobs', 'request', 'categories', 'selectedCategory') );

    }

    /**
     * Display a listing of the worlwide jobs
     *
     * @return \Illuminate\Http\Response
     */
    public function worldwide( Request $request )
    {
        if( Remjob::where( [['language', '=', App::getLocale()],['active', '=', '1']] )
            ->whereIn(strtoupper('locations'), ['WORLDWIDE', 'GLOBAL', 'ANYWHERE', 'REMOTE'])
            ->exists() ){

            $remjobs = Remjob::where( [['language', '=', App::getLocale()],['active', '=', '1']] )
            ->whereIn(strtoupper('locations'), ['WORLDWIDE', 'GLOBAL', 'ANYWHERE', 'REMOTE'])
            ->orderBy('plan_id', 'desc')->orderBy('created_at', 'desc')->get();
        } else { $remjobs = []; } 

        $lenguageId = \App\Language::where('short_name', App::getLocale())->first()->id;

        $categories = Category::where('language_id', '=',  $lenguageId )->get();
        $selectedCategory = $categories[0];
        //dd($selectedCategory);
        return view( 'landing', compact('remjobs', 'request', 'categories', 'selectedCategory') );
    }

    private function registerVisit( $ip, $route ){

        Log::info( 'Will register a visitor' );

        Visit::create([
            'visitor_ip'    => $ip,
            'entry_route'   => $route,
            'user_id'       => Auth::check() ? Auth::user()->id : null,
        ]);
        return;
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // Retrieve the currently authenticated user...
        $user = Auth::user();
        
        if (App::isLocale('es')) {
            $categories = \App\Category::whereIn( 'id', [7, 8, 9, 10, 11, 12] )->get();
        } else {
            $categories = \App\Category::whereIn( 'id', [1, 2, 3, 4, 5, 6] )->get();
        }

        return view( 'remjobs.create', compact('categories', 'user') );

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreRemjob $request)
    {
        //Log::info('Will create remote job: '.request()->position);

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
            'plan_id'               => request()->plan_id,

        ]);

        // Company
        if( !Company::where('id', request()->company_id)->exists() ){
            // Create company
            $company = Company::create([
                'name'      => request()->company_name,
                'slug'      => Str::slug( request()->company_name, '-' ),
                'email'     => request()->company_email,
                'user_id'   => \Auth::user()->id,
                'twitter'   => request()->company_twitter
            ]);
            //Log::info('Created company: '.$company->name.' while creating job: '.$remjob->position);
        } else {

            $company = Company::find(request()->company_id);

            if( $company->user_id == 1 ){
                // this company has api captured jobs. Now could be switching to real client.
                $company->update([
                    'email'     => request()->company_email,
                    'user_id'   => \Auth::user()->id,
                    'twitter'   => request()->company_twitter
                ]);
            }

        }

        // Add or update media to the company model
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
        $jobPostTotal = \App\Plan::find( request()->plan_id )->value;

        $remjob->update([ 
            'total'                 => $jobPostTotal,
            'language'              => App::getLocale(),
            'company_id'            => $company->id,
            'slug'                  => Str::slug( ($remjob->position.' '.$remjob->id), '_'),
        ]);

        // Store the new Remjob id...
        session([ 'newRemjobId' => $remjob->id ]);

        // Head to preview and checkout page

        // Send Mail to Client and cc Administrator
        try{ 
            Mail::to( $remjob->company->user->email )
                ->cc('info@remjob.io')
                ->bcc('heagueron@gmail.com')
                ->send( new RemjobCreatedMail( $remjob ) );
        } catch (\Exception $exception){ 
            Log::info( 'Failed to send email to notify client or admin creation of remjob: ' . $remjob->id );
        }

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
        // Register a visit
        $ip = \request()->ip();

        if( $ip != "127.0.0.1" AND $ip != "45.186.209.3" ) {
            $this->registerVisit( $ip, 'remjobs.show' );
        }
        
        return view( 'remjobs.show', compact('remjob') );

    }

    /**
     * Display the specified resource.
     *
     * @param  string $tags
     * @return \Illuminate\Http\Response
     */
    public function searchByTags( $tags, Request $request )
    {
        // App::setLocale('es');

        $lenguageId = \App\Language::where('short_name', App::getLocale())->first()->id;
        $categories = Category::where('language_id', '=',  $lenguageId )->get();


        $tagsLength = ( Str::length( $tags ) ) - 12;
        $tagsText = Str::substr($tags, 7, $tagsLength);

        //Log::info('Searching jobs for tag: '.$tagsText);

        $catTags = [
            'dev', 'customer_support', 'marketing', 'design', 'non_tech',
            'desarrollo', 'servicios_al_cliente', 'mercadotecnia', 'diseño', 'otros'
        ];

        if( in_array( $tagsText, $catTags ) ){
            // Search for a CATEGORY TAG
            $category = Category::where( 'tag', 'like', $tagsText )->first();

            if( $category->whereHas('remjobs', function (Builder $query) {
                //$query->where('active', 1);
                $query->where( [['language', '=', App::getLocale()],['active', '=', '1']] );
            }) ){
                //$remjobs = $category->remjobs()->where('active', 1)
                $remjobs = $category->remjobs()->where( [['language', '=', App::getLocale()],['active', '=', '1']] )
                    ->orderBy('plan_id', 'desc')
                    ->orderBy('created_at', 'desc')->get();
            } else { $remjobs = []; }

            $selectedCategory = $category;
            
        } else {
            // Search for a normal TAG
            if( !Tag::where( 'name', 'like', $tagsText )->exists() ) {
                return view('404');
            }
            $tag = Tag::where( 'name', 'like', $tagsText )->first();

            if( $tag->whereHas('remjobs', function (Builder $query) {
                // $query->where('active', 1);
                $query->where( [['language', '=', App::getLocale()],['active', '=', '1']] );
            }) ){
                //$remjobs = $tag->remjobs()->where('active', 1)
                $remjobs = $tag->remjobs()->where( [['language', '=', App::getLocale()],['active', '=', '1']] )
                    ->orderBy('plan_id', 'desc')
                    ->orderBy('created_at', 'desc')->get();
            } else { $remjobs = []; }

            $selectedCategory = $categories[0];

        }

        return view( 'landing', compact('remjobs', 'request', 'categories', 'selectedCategory') );
        
    }

    /**
     * Display the specified resource.
     *
     * @param  string $company_name
     * @return \Illuminate\Http\Response
     */
    public function searchByCompany( Company $company, Request $request )
    {
        //Log::info('Searching jobs for company slug: '.$company->slug);
        
        // $company = Company::where( 'slug', 'like', $company_slug )->first();
        $remjobs = Remjob::where( 'company_id', $company->id )
            ->orderBy('plan_id', 'desc')
            ->orderBy('created_at', 'desc')->get();
        
        return view( 'landing', compact('remjobs', 'request') );
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Remjob  $remjob
     * @return \Illuminate\Http\Response
     */
    public function edit(Remjob $remjob)
    { 

        if( Auth::user()->id != $remjob->company->user_id ) {
            $title = 'Information';
            $message = 'Ooops!. It seems the link is not working. Please check or contact support (in your message, 
                        include the link you are trying to access. Thanks!';
            return view( 'information', compact( 'title', 'message' ) );
        }

        $tagsText = '';
        foreach( $remjob->tags()->take(5)->get() as $tag ){
            $tagsText .= $tag->name.', ';
        }
        $tagsText = rtrim($tagsText, ", ");

        if ( $remjob->language == 'es' ) {
            $categories = \App\Category::whereIn( 'id', [7, 8, 9, 10, 11, 12] )->get();
        } else {
            $categories = \App\Category::whereIn( 'id', [1, 2, 3, 4, 5, 6] )->get();
        }

        $user = Auth::user();
        
        return view( 'remjobs.edit', compact('remjob', 'tagsText', 'categories', 'user') );

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Remjob  $remjob
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRemjob $request, Remjob $remjob)
    {
        //dd('update: ', $remjob->position, $request );
        $remjob->update([

            'position'              => request()->position,
            'description'           => request()->description,
            'category_id'           => request()->category_id,
            'min_salary'            => request()->min_salary,
            'max_salary'            => request()->max_salary,
            'locations'             => request()->locations,
            'apply_link'            => request()->apply_link,
            'apply_email'           => request()->apply_email,
            'apply_mode'            => request()->apply_mode,
            
            
        ]);

        // tags for the remjob-tag pivot table
        $tagsIdToLink = [];  

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

        $remjob->tags()->sync( array_unique( $tagsIdToLink ) );

        // Store the new Remjob id...
        session([ 'newRemjobId' => $remjob->id ]);

        // Send Mail to Client and cc Administrator
        try{ 
            Mail::to( $remjob->company->user->email )
                ->cc('info@remjob.io')
                ->bcc('heagueron@gmail.com')
                ->send( new RemjobUpdatedMail( $remjob ) );
        } catch (\Exception $exception){ 
            Log::info( 'Failed to send email to notify client or admin update of remjob: ' . $remjob->id );
        }

        return redirect()->route('landing');
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
    public function search_job_tags_by_term( $search_term )
    {
        $job_tags = Tag::all();

        $filtered_job_tags = array();

        foreach ($job_tags as $key => $job_tag) {
            if( Str::startsWith( strtolower( $job_tag->name ), strtolower( $search_term ) ) ) {
                array_push( $filtered_job_tags, $job_tag);
            };
        }
            
        return response()->json([
            'search_term'       => $search_term,
            'filtered_job_tags' => $filtered_job_tags
        ],200);

    }

    /**
     * Store the incoming $remjob company_logo.
     *
     * @param Company $company
     * @return void
     */
    private function storeMedia( $company )
    {
        // Get file from form
        $path= request()->company_logo;
        //$path= $request->file('webinarphoto');

        // Resize and encode to required type
        $img = Image::make($path)->resize(60, null, function ($constraint) 
                {
                    $constraint->aspectRatio();
                })->encode();

        // Build a file name with extension 
        $filename = time(). '.' .$path->getClientOriginalExtension();

        // Put uploaded image content on file with own name
        Storage::put($filename, $img, 'public');

        // Move file to final location in storage 
        Storage::move($filename, 'public/logos/' . $filename);

        // Update company model in database 
        $company->update([
            'logo' => 'logos/' . $filename
        ]);
        
        return;

    }

    /***********************
     * 
     * Test Admin Only Route
     */
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index_hean( Request $request )
    {
        $remjobs = Remjob::where( [['language', '=', App::getLocale()],['active', '=', '1']] )
            ->orderBy('plan_id', 'desc')->orderBy('created_at', 'desc')->get();

        $lenguageId = \App\Language::where('short_name', App::getLocale())->first()->id;

        $categories = Category::where('language_id', '=',  $lenguageId )->get();
        $selectedCategory = $categories[0];

        return view( 'admin.landing_hean', compact('remjobs', 'request', 'categories', 'selectedCategory') );

    }


}
