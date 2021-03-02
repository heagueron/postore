<?php

namespace App\Http\Controllers\Admin;

use App\Tag;
use App\Remjob;
use App\Company;
use App\Category;
use App\Language;
use Illuminate\Support\Str;

use Illuminate\Http\Request;
use App\Traits\PublishRemjob;
use App\Mail\RemjobUpdatedMail;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;

use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;
use App\ApiConnectors\TwitterGateway;


class RemjobController extends Controller
{
    use PublishRemjob;
        
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
        if( Remjob::all()->count() > 0 ){
            $remjobs = Remjob::latest()->get();
        } else { $remjobs = []; }
        
        return view( 'admin.remjobs.index',compact('remjobs') );

    }

    /**
     * Load jobs from API remoteok.io
     *
     * @return \Illuminate\Http\Response
     */

    public function rok()
    {
        $response = Http::retry(3, 100)->get('https://remoteok.io/api');
        $jobsArray = $response->json();

        array_shift( $jobsArray );

        foreach ( array_slice($jobsArray, 0, 8) as $remApiJob ) {


            if( DB::table('remjobs')->where([
                ['external_api', '=', 'https://remoteok.io'],
                ['position', '=', STR::before( $remApiJob["position"], '(')],
            ])->exists() ){
                Log::info( 'ROK api job: ' .STR::before( $remApiJob["position"], '('). 'already exists' );
                 
            }

            if( strlen( $remApiJob["company_logo"] ) > 190 or strlen( $remApiJob["position"] > 75 ) ) {
                Log::info( 'ROK api job: ' .STR::before( $remApiJob["position"], '('). 'position or company_logo link too long' );
                continue;
            }

            $jobData = [
                'position'          => STR::before( $remApiJob["position"], '('),
                'description'       => $remApiJob["description"],
                'category_id'       => null,
                'locations'         => $remApiJob["location"],
                'apply_link'        => $remApiJob["url"],
                'apply_mode'        => 'link',
                'company_name'      => STR::before( $remApiJob["company"], 'ÃÂ'),
                'tags'              => array_values( $remApiJob["tags"] ),
                'logo'              => array_key_exists('company_logo', $remApiJob) ? $remApiJob["company_logo"] : null,
                'external_api'      => 'https://remoteok.io',
            ];

            try{ 
                $this->createApiJob( $jobData );
            } catch (\Exception $exception){ 
                Log::info( 'Failed to create ROK api job: ' . $jobData['position'] );
            }

        }
        return redirect()->back();
    }
    
    /**
     * Load jobs from API remotive
     *
     * @return \Illuminate\Http\Response
     */

    public function remotive()
    {
        $response = Http::get('https://remotive.io/api/remote-jobs');
        $jobsArray = $response->json();
        
        if( !$jobsArray['job-count'] ) {
            return back()->with('fail', 'No job found on remotive api');
        }

        foreach ( array_slice($jobsArray['jobs'], 0, 8) as $remApiJob ) {

            if( DB::table('remjobs')->where([
                ['external_api', '=', 'https://remotive.io/'],
                ['position', '=', $remApiJob["title"]],
            ])->exists() ){ continue; }

            if( strlen( $remApiJob["title"] > 75 ) ) {
                continue;
            }
            
            $jobData = [
                'position'          => $remApiJob["title"],
                'description'       => $remApiJob["description"],
                'category_id'       => null,
                'locations'         => $remApiJob["candidate_required_location"],
                'apply_link'        => $remApiJob["url"],
                'apply_mode'        => 'link',
                'company_name'      => $remApiJob["company_name"],
                'tags'              => array_values( $remApiJob["tags"] ),
                'logo'              => array_key_exists('company_logo_url', $remApiJob) ? $remApiJob["company_logo_url"] : null,
                'external_api'      => 'https://remotive.io/',
            ];

            try{ 
                $this->createApiJob( $jobData );
            } catch (\Exception $exception){ 
                Log::info( 'Failed to create REMOTIVE api job: ' . $jobData['position'] );
            }

        }
        return redirect()->back();
    }

    /**
     * Load jobs from API working-nomads
     *
     * @return \Illuminate\Http\Response
     */

    public function workingNomads()
    {
        $response = Http::get('https://www.workingnomads.co/api/exposed_jobs/');
        $jobsArray = $response->json();

        if( !count( $jobsArray ) > 0) {
            return back()->with('fail', 'No job found on working-nomads api');
        }

        foreach ( array_slice($jobsArray, 0, 11) as $remApiJob ) {

            if( DB::table('remjobs')->where([
                ['external_api', '=', 'https://www.workingnomads.co/'],
                ['position', '=', $remApiJob["title"]],
            ])->exists() ){ continue; }
            
            if( strlen( $remApiJob["title"] > 75 ) ) {
                continue;
            }
            
            $jobData = [
                'position'          => $remApiJob["title"],
                'description'       => $remApiJob["description"],
                'category_id'       => null,
                'locations'         => $remApiJob["location"],
                'apply_link'        => $remApiJob["url"],
                'apply_mode'        => 'link',
                'company_name'      => $remApiJob["company_name"],
                'tags'              => explode(",",$remApiJob["tags"]),
                'logo'              => null,
                'external_api'      => 'https://www.workingnomads.co/',
            ];

            try{ 
                $this->createApiJob( $jobData );
            } catch (\Exception $exception){ 
                Log::info( 'Failed to create WORKING NOMADS api job: ' . $jobData['position'] );
            }
            
        }
        return redirect()->back();
    }

    /**
     * Load jobs from API remotive
     *
     * @return \Illuminate\Http\Response
     */

    public function github()
    {
        $response = Http::get('https://jobs.github.com/positions.json');
        
        $jobsArray = $response->json();

        if( !$jobsArray ) {
            return back()->with('fail', 'No job found on github jobs');
        }

        foreach ( array_slice($jobsArray, 0, 11) as $remApiJob ) {

            if( DB::table('remjobs')->where([
                ['external_api', '=', 'https://jobs.github.com/positions'],
                ['position', '=', $remApiJob["title"]],
            ])->exists() ){ 
                continue; 
            }

            if( strlen( $remApiJob["company_logo"] ) > 190 or strlen( $remApiJob["title"] > 75 ) ) {
                continue;
            }

            $jobData = [
                'position'          => $remApiJob["title"],
                'description'       => $remApiJob["description"],
                'category_id'       => null,
                'locations'         => $remApiJob["location"],
                'apply_link'        => $remApiJob["url"],
                'apply_mode'        => 'link',
                'company_name'      => $remApiJob["company"],
                'tags'              => null,
                'logo'              => array_key_exists('company_logo', $remApiJob) ? $remApiJob["company_logo"] : null,
                'external_api'      => 'https://jobs.github.com/positions',
            ];

            try{ 
                $this->createApiJob( $jobData );
            } catch (\Exception $exception){ 
                Log::info( 'Failed to create GITHUB api job: ' . $jobData['position'] );
            }

        }
        return redirect()->back();
    }

    /**
     * Load jobs from API remotive
     *
     * @return \Illuminate\Http\Response
     */

    public function stack()
    {
        //Feed URLs
        $feeds = array(
            "http://stackoverflow.com/jobs/feed?r=true",
        );
        
        //Read each feed's items
        $entries = array();
        foreach($feeds as $feed) {
            $xml = simplexml_load_file($feed);
            $entries = array_merge($entries, $xml->xpath("//item"));
        }

        //Sort feed entries by pubDate
        usort($entries, function ($feed1, $feed2) {
            return strtotime($feed2->pubDate) - strtotime($feed1->pubDate);
        });

        

        // $response = Http::get('https://jobs.github.com/positions.json');
        
        // $jobsArray = $response->json();

        if( count( $entries ) == 0 ) {
            return back()->with('fail', 'No job found on github jobs');
        }

        foreach ( array_slice($entries, 0, 11) as $remApiJob ) {

            if( DB::table('remjobs')->where([
                ['external_api', '=', 'http://stackoverflow.com/jobs/feed'],
                ['apply_link', '=', $remApiJob->link],
            ])->exists() ){ 
                continue; 
            }

            // if( strlen( $remApiJob["company_logo"] ) > 190 or strlen( $remApiJob["title"] > 75 ) ) {
            //     continue;
            // }

            $jobData = [
                'position'          => (string)Str::of($remApiJob->title)->before(' at '),
                'description'       => (string)$remApiJob->description,
                'category_id'       => null,
                'locations'         => (string)$remApiJob->location,
                'apply_link'        => (string)$remApiJob->link,
                'apply_mode'        => 'link',
                'company_name'      => (string)Str::of($remApiJob->title)->after(' at ')->before(' ('),
                'tags'              => (array)$remApiJob->category,
                'logo'              => null,
                'external_api'      => 'http://stackoverflow.com/jobs/feed',
            ];

            try{ 
                $this->createApiJob( $jobData );
            } catch (\Exception $exception){ 
                Log::info( 'Failed to create STACK api job: ' . $jobData['position'] );
            }

        }
        return redirect()->back();
    }


    private function createApiJob( $jobData ){

        $companyName = $jobData['company_name'];

        // Company
        if( !Company::where('name', $companyName)->exists() ) {
            // Create company
            $company = Company::create([
                'name'  => $companyName,
                'slug'  => Str::slug( $companyName, '-' ),
                'email' => 'heagueron@gmail.com',
                'logo'  => $jobData["logo"] != null ? $jobData["logo"]: null,
                'user_id'   => 1,
            ]);
        } else {
            $company = Company::where('name', $companyName)->first();
            if( !$company->user_id == 1 ){
                // this company belongs to a registered client
                return;
            }
        }

        // Create the remote job post
        $remjob = Remjob::create([
            'position'          => $jobData["position"],
            'description'       => $jobData["description"],
            'category_id'       => 2, // This is category id for dev by default. It should be edited in admin.
            'locations'         => $jobData["locations"],
            'apply_link'        => $jobData["apply_link"],
            'apply_mode'        => 'link',
            'company_id'        => $company->id,
            'external_api'      => $jobData['external_api'],
            //'slug'              => Str::slug( ($remjob->position.' '.$remjob->id), '_'),
            'active'            => 0, // will be active after edition.
        ]);

        $remjob->update([
            'slug'              => Str::slug( ($remjob->position.' '.$remjob->id), '_'),
        ]);



        if( $jobData['tags'] != null ){

            // tags for the remjob-tag pivot table
            $tagsIdToLink = [];

            // Add every tag, if it does not exist, create it in the database.
            
            // take first 3 tags
            foreach ( array_slice($jobData["tags"], 0, 2) as $inputTag ) {

                if( Tag::where('name',trim($inputTag) )-> exists() ) {
                    $foundTag = Tag::where('name',trim($inputTag) )->first();
                    array_push( $tagsIdToLink, $foundTag->id );

                } else {
                    $newTag = Tag::create([ 'name' => trim($inputTag) ]);
                    array_push( $tagsIdToLink, $newTag->id );
                }

            }

            $remjob->tags()->attach( array_values( array_unique( $tagsIdToLink ) ) );
        } 
        
        return;

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
        $lenguageId = Language::where('short_name', \App::getLocale())->first()->id;

        $categories = Category::where('language_id', '=',  $lenguageId )->whereNotIn('id', [1, 7])->get();

        $tagsText = '';
        foreach( $remjob->tags()->take(5)->get() as $tag ){
            $tagsText .= $tag->name.', ';
        }
        $tagsText = rtrim($tagsText, ", ");

        // Retrieve the currently authenticated user...
        $user = \App\User::find(1);
        return view( 'admin.remjobs.edit', compact('remjob', 'categories', 'user', 'tagsText') );

        // return view('admin.remjobs.edit', compact('remjob', 'categories', 'tagsText') );

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validateRemjob();

        $remjob = Remjob::findOrFail( $id );

        // Delete previous links from pivot table remjob_tag
        DB::table('remjob_tag')->where('remjob_id',$remjob->id)->delete();


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
            'slug'                  => Str::slug( (request()->position.' '.$remjob->id), '_'),
            'plan_id'               => request()->plan_id,
            
        ]);

        // Add or update media to the company model
        if( !is_null( request()->logo ) ){
            $remjob->company->update([ 'logo'    => request()->logo]);
        }

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

        // Send Mail to Client and cc Administrator
        try{ 
            Mail::to( $remjob->company->user->email )
                ->cc('info@remjob.io')
                ->send( new RemjobUpdatedMail( $remjob ) );
        } catch (\Exception $exception){ 
            Log::info( 'Failed to send email to notify client or admin update of remjob: ' . $remjob->id );
        }

        return redirect()->route('admin.remjobs.index');
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Remjob  $remjob
     * @return \Illuminate\Http\Response
     */
    public function destroy(Remjob $remjob)
    {
        // Delete from pivot table remjob_tag
        DB::table('remjob_tag')->where('remjob_id',$remjob->id)->delete();

        // Delete the remote job
        $remjob->delete();

        return back()->with('message', 'Removed Remote Job Post from ' . $remjob->company_name );
        
    }

    /**
     * Inactivate the specified remote job
     *
     * @param  \App\Remjob  $remjob
     * @return \Illuminate\Http\Response
     */
    public function toggleActive(Remjob $remjob)
    {
        if($remjob->active){
            // Inactivate the scheduled post
            $remjob->update( ['active'    => 0, ]);
        } else {
            // Activate the scheduled post
            $remjob->update( ['active'    => 1, ]);
        }

        return back()->with('message', 'Inactivated Remote Job Post from ' . $remjob->company_name );
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Remjob  $remjob
     * @return \Illuminate\Http\Response
     */
    public function tweet(Remjob $remjob)
    {
        $publish = $this->shareRemjobOnTwitter( $remjob );

        if( $publish ){
            return back()->with('flash', 'Remjob shared on Twitter!');
        } else {
            return back()->with('fail', 'Remjob could not be shared on Twitter!');
        }

        
    }

    private function validateRemjob() 
    {
        $categoryIds = DB::table('categories')->pluck('id')->toArray();

        $validatedData = request()->validate([
            'position'      => ['required', 'max:100'],
            'tags'          => ['required', 'max:100'],      
            'description'   => ['required'],
            //'category_id'   => [ Rule::in(['1','2','3','4','5','6','7','8','9','10','11','12','13','14', '15']) ],
            'category_id'   => [ Rule::in( array_values($categoryIds) ) ],
            'apply_link'    => ['exclude_if:apply_mode,==,email', 'url'],
            'apply_email'   => ['exclude_if:apply_mode,==,link', 'email'],
            'min_salary'    => ['nullable', 'max:7', 'lte:max_salary'], 
            'max_salary'    => ['nullable', 'max:7', 'gte:min_salary'],
            'locations'     => ['max:100'],
            'plan_id'       => [ Rule::in(['1','2','3']) ],
        ]);

        return $validatedData;

    }

    /**
     * Returns a json list of jobs, filtered by company
     * @param  string $search_term
     * @return \Illuminate\Http\Response
     */
    public function searchJobsByCompanyJson( $id )
    {
        $company = Company::findOrFail($id);

        $remjobs = $company->remjobs()->get();
            
        return response()->json([
            'remjobs'       => $remjobs,
        ],200);

    }


}
