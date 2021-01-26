<?php

namespace App\Http\Controllers\Admin;

use App\Tag;
use App\Remjob;
use App\Company;
use App\Category;
use Illuminate\Support\Str;

use Illuminate\Http\Request;
use App\Traits\PublishRemjob;
use App\Mail\RemjobUpdatedMail;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;

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

        // if( Remjob::where('active',1)->exists() ){
        //     $remjobs = Remjob::where('active',1)->orderBy('created_at', 'desc')->get();
        // } else { $remjobs = []; }
        
        return view( 'admin.remjobs.index',compact('remjobs') );

    }

    /**
     * Load jobs from API remoteok.io
     *
     * @return \Illuminate\Http\Response
     */

    public function rok()
    {
        // try {
        //     $response = Http::retry(3, 100)->get('https://remoteok.io/api');
        //     dd($response->json());
        // } catch (\Throwable $e) {
        //     report($e); // this is a Laravel helper, not from Sentry
        //     dd('an exception has been thrown and reported!',$e);
        // }

        $response = Http::retry(3, 100)->get('https://remoteok.io/api');
   
        $jobsArray = $response->json();
        array_shift( $jobsArray );

        foreach ( array_slice($jobsArray, 0, 8) as $remApiJob ) {

            if( DB::table('remjobs')->where([
                ['external_api', '=', 'https://remoteok.io'],
                ['position', '=', STR::before( $remApiJob["position"], '(')],
            ])->exists() ){ break; }

            // Create the remote job post
            $remjob = Remjob::create([
                'position'          => STR::before( $remApiJob["position"], '('),
                'description'       => $remApiJob["description"],
                'category_id'       => null,
                'locations'         => $remApiJob["location"],
                'apply_link'        => $remApiJob["url"],
                'apply_mode'        => 'link',
            ]);

            $companyName = STR::before( $remApiJob["company"], 'ÃÂ');

            // Company
            if( !Company::where('name', $companyName)->exists() ) {
                // Create company
                $company = Company::create([
                    'name'  => $companyName,
                    'slug'  => Str::slug( $companyName, '-' ),
                    'email' => 'heagueron@gmail.com',
                    'logo'  => $remApiJob["company_logo"],
                ]);
            } else {
                $company = Company::where('name', $companyName)->first();
            }

            $remjob->update([ 
                'company_id'    => $company->id,
                'external_api'  => 'https://remoteok.io',
                'slug'          => Str::slug( ($remjob->position.' '.$remjob->id), '_'),
                'active'        => 1,
            ]);

            // tags for the remjob-tag pivot table
            $tagsIdToLink = [];

            // Add every tag, if it does not exist, create it in the database.
            array_pop($remApiJob["tags"]);  // last element is no a tag
            
            // take first 3 tags
            foreach ( array_slice($remApiJob["tags"], 0, 2) as $inputTag ) {
                if( Tag::where('name',trim($inputTag) )-> exists() ) {
                    $foundTag = Tag::where('name',trim($inputTag) )->first();
                    array_push( $tagsIdToLink, $foundTag->id );
                } else {
                    $newTag = Tag::create([ 'name' => trim($inputTag) ]);
                    array_push( $tagsIdToLink, $newTag->id );
                }
            }

            $remjob->tags()->attach( array_unique( $tagsIdToLink ) );

            
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
        //dd($jobsArray['jobs']);
        foreach ( array_slice($jobsArray['jobs'], 0, 8) as $remApiJob ) {

            if( DB::table('remjobs')->where([
                ['external_api', '=', 'https://remotive.io/'],
                ['position', '=', $remApiJob["title"]],
            ])->exists() ){ break; }

            // Create the remote job post
            $remjob = Remjob::create([
                'position'          => $remApiJob["title"],
                'description'       => $remApiJob["description"],
                'category_id'       => null,
                'locations'         => $remApiJob["candidate_required_location"],
                'apply_link'        => $remApiJob["url"],
                'apply_mode'        => 'link',
            ]);

            $companyName = $remApiJob["company_name"];

            // Company
            if( !Company::where('name', $companyName)->exists() ) {
                // Create company
                $company = Company::create([
                    'name'  => $companyName,
                    'slug'  => Str::slug( $companyName, '-' ),
                    'email' => 'heagueron@gmail.com',
                    'logo'  => array_key_exists('company_logo_url', $remApiJob) ? $remApiJob["company_logo_url"] : null,
                ]);
            } else {
                $company = Company::where('name', $companyName)->first();
            }

            $remjob->update([ 
                'company_id'    => $company->id,
                'external_api'  => 'https://remotive.io/',
                'slug'          => Str::slug( ($remjob->position.' '.$remjob->id), '_'),
                'active'        => 1,
            ]);

            // tags for the remjob-tag pivot table
            $tagsIdToLink = [];

            // Add every tag, if it does not exist, create it in the database.
            $inputTags = array_values( $remApiJob["tags"] );

            // take 3 tags
            foreach ( array_slice($inputTags, 0, 2) as $inputTag ) {
                if( Tag::where('name',trim($inputTag) )-> exists() ) {
                    $foundTag = Tag::where('name',trim($inputTag) )->first();
                    array_push( $tagsIdToLink, $foundTag->id );
                } else {
                    $newTag = Tag::create([ 'name' => trim($inputTag) ]);
                    array_push( $tagsIdToLink, $newTag->id );
                }
            }

            $remjob->tags()->attach( array_unique( $tagsIdToLink ) );

            
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


        foreach ( array_slice($jobsArray, 0, 21) as $remApiJob ) {

            if( DB::table('remjobs')->where([
                ['external_api', '=', 'https://www.workingnomads.co/'],
                ['position', '=', $remApiJob["title"]],
            ])->exists() ){ break; }

            // Create the remote job post
            $remjob = Remjob::create([
                'position'          => $remApiJob["title"],
                'description'       => $remApiJob["description"],
                'category_id'       => null,
                'locations'         => $remApiJob["location"],
                'apply_link'        => $remApiJob["url"],
                'apply_mode'        => 'link',
            ]);

            $companyName = $remApiJob["company_name"];

            // Company
            if( !Company::where('name', $companyName)->exists() ) {
                // Create company
                $company = Company::create([
                    'name'  => $companyName,
                    'slug'  => Str::slug( $companyName, '-' ),
                    'email' => 'heagueron@gmail.com',
                    'logo'  => null,
                ]);
            } else {
                $company = Company::where('name', $companyName)->first();
            }

            $remjob->update([ 
                'company_id'    => $company->id,
                'external_api'  => 'https://www.workingnomads.co/',
                'slug'          => Str::slug( ($remjob->position.' '.$remjob->id), '_'),
                'active'        => 1,
            ]);

            // tags for the remjob-tag pivot table
            $tagsIdToLink = [];

            // Add every tag, if it does not exist, create it in the database.
            $inputTags = explode("," , $remApiJob["tags"]);

            // take 3 tags
            foreach ( array_slice($inputTags, 0, 2) as $inputTag ) {
                if( Tag::where('name',trim($inputTag) )-> exists() ) {
                    $foundTag = Tag::where('name',trim($inputTag) )->first();
                    array_push( $tagsIdToLink, $foundTag->id );
                } else {
                    $newTag = Tag::create([ 'name' => trim($inputTag) ]);
                    array_push( $tagsIdToLink, $newTag->id );
                }
            }

            $remjob->tags()->attach( array_unique( $tagsIdToLink ) );

            
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

        foreach ( array_slice($jobsArray, 0, 21) as $remApiJob ) {

            if( DB::table('remjobs')->where([
                ['external_api', '=', 'https://jobs.github.com/positions'],
                ['position', '=', $remApiJob["title"]],
            ])->exists() ){ 
                break; 
            }

            // Create the remote job post
            $remjob = Remjob::create([
                'position'          => $remApiJob["title"],
                'description'       => $remApiJob["description"],
                'category_id'       => null,
                'locations'         => $remApiJob["location"],
                'apply_link'        => $remApiJob["url"],
                'apply_mode'        => 'link',
            ]);

            $companyName = $remApiJob["company"];

            // Company
            if( !Company::where('name', $companyName)->exists() ) {
                // Create company
                $company = Company::create([
                    'name'  => $companyName,
                    'slug'  => Str::slug( $companyName, '-' ),
                    'email' => 'heagueron@gmail.com',
                    'logo'  => array_key_exists('company_logo', $remApiJob) ? $remApiJob["company_logo"] : null,
                ]);
            } else {
                $company = Company::where('name', $companyName)->first();
            }

            $remjob->update([ 
                'company_id'    => $company->id,
                'external_api'  => 'https://jobs.github.com/positions',
                'slug'          => Str::slug( ($remjob->position.' '.$remjob->id), '_'),
                'active'        => 1,
            ]);

            
        }
        return redirect()->back();
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
        // dd('edit remjob position: ', $remjob->position);
        if ( $remjob->language == 'es' ) {
            $categories = \App\Category::whereIn( 'id', [7, 8, 9, 10, 11, 12] )->get();
        } else {
            $categories = \App\Category::whereIn( 'id', [1, 2, 3, 4, 5, 6] )->get();
        }

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

            'position'      => request()->position,
            //'tags'          => ['required', 'max:100'], 
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

        // Send Mail to Client and cc Administrator
        try{ 
            Mail::to( $remjob->company->user->email )
                ->cc('info@remjob.io')
                ->bcc('heagueron@gmail.com')
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
        // Delete media files
        if(\Storage::exists( 'public/' . $remjob->company->logo )){
            \Storage::delete( 'public/' . $remjob->company->logo );           
        }

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


        // $link = $remjob->apply_link != null ? $remjob->apply_link : $remjob->apply_email;

        // // Select ramdom template:
        // $template = mt_rand(1,3);

        // if( $template == 1 ){
        //     $text = trim( $remjob->company->name );
        //     $text .= ' is looking for a '.trim( $remjob->position );
        //     //$text .= '. Find more through '.$link; 
        // } elseif( $template == 2 ){
        //     $text = 'Want to work as '.trim( $remjob->position );
        //     $text .= ' at '.trim( $remjob->company->name ).'?';
        //     //$text .= 'Apply through '.$link;
        // } else {
        //     $text = trim( $remjob->company->name );
        //     $text .= ' is hiring: '.trim( $remjob->position );
        //     //$text .= '. Apply here: '.$link; 
        // }

        // if( $remjob->locations ){
        //    $text .= ' ['.$remjob->locations.']'; 
        // }
        

        // $text .= ' ☛ '.$link;
        // $text .= ' Source: '.$remjob->external_api;   

        // if( $remjob->has('tags') ){
        //     foreach( $remjob->tags as $tag ){
        //         $text .= ' #'.str_replace(' ', '' , $tag->name); 
        //     }
        // }
        
        // //dd($text);
        
        // $twitterProfile = \App\TwitterProfile::where('handler','JMServca')->first();
        // $twitter = new TwitterGateway( $twitterProfile->id, false );
        
        // try {
        //     // Post with TwitterOAuth library
        //     $response = $twitter->connection->post( "statuses/update", [ "status"    => $text,] );

        //     if ( $twitter->connection->getLastHttpCode() == 200 ) {          
        //         // register the social share
        //         $tweetPost = new \App\TwitterPost();
        //         $tweetPost->remjob_id = $remjob->id;
        //         $tweetPost->save();
        //         return back()->with('flash', 'Remjob shared on Twitter!');
        //     } else {
        //         return back()->with('fail', 'Remjob could not be shared on Twitter!');
        //     } 

        // } catch (TwitterOAuthException $exception) {
        //     return back()->with('fail','Remjob could not be shared on Twitter! (exc.) ' . $exception->getMessage() );
        // }

        
    }

    private function validateRemjob() 
    {

        $validatedData = request()->validate([
            'position'      => ['required', 'max:100'],
            'tags'          => ['required', 'max:100'],      
            'description'   => ['required'],
            'category_id'   => [ Rule::in(['1','2','3','4','5','6','7','8','9','10','11','12']) ],
            'apply_link'    => ['exclude_if:apply_mode,==,email', 'url'],
            'apply_email'   => ['exclude_if:apply_mode,==,link', 'email'],
            'min_salary'    => ['nullable', 'max:7', 'lte:max_salary'], 
            'max_salary'    => ['nullable', 'max:7', 'gte:min_salary'],
            'locations'     => ['max:100'],
        ]);

        return $validatedData;

    }


}
