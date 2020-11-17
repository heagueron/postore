<?php

namespace App\Http\Controllers\Admin;

use App\Tag;
use App\Remjob;
use App\Company;
use Illuminate\Support\Str;
Use Illuminate\Support\Facades\HTTP;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Traits\PublishRemjob;

use App\ApiConnectors\TwitterGateway;

class RemjobController extends Controller
{

        
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
        //dd("admin remjob controller index ");
        $remjobs = Remjob::orderBy('created_at', 'desc')->get();
        return view( 'admin.remjobs.index',compact('remjobs') );

    }

    /**
     * Load jobs from API remoteok.io
     *
     * @return \Illuminate\Http\Response
     */

    public function rok()
    {
        $response = HTTP::get('https://remoteok.io/api');
        $jobsArray = $response->json();
        array_shift( $jobsArray );

        foreach ( array_slice($jobsArray, 0, 11) as $remApiJob ) {

            // Create the remote job post
            $remjob = Remjob::create([
                'position'          => STR::before( $remApiJob["position"], '('),
                'description'       => $remApiJob["description"],
                'category_id'       => null,
                'locations'         => $remApiJob["location"],
                'apply_link'        => $remApiJob["url"],
                'apply_mode'        => 'link',
                'show_logo'         => 'on',
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
            ]);

            // tags for the remjob-tag pivot table
            $tagsIdToLink = [];

            // Add every tag, if it does not exist, create it in the database.
            array_pop($remApiJob["tags"]);

            foreach ( $remApiJob["tags"] as $inputTag ) {
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
        $response = HTTP::get('https://remotive.io/api/remote-jobs');
        $jobsArray = $response->json();

        if( !$jobsArray['job-count'] ) {
            return back()->with('fail', 'No job found on remotive api');
        }

        //dd( array_slice($jobsArray['jobs'], 0, 11) );

        foreach ( array_slice($jobsArray['jobs'], 0, 11) as $remApiJob ) {

            // Create the remote job post
            $remjob = Remjob::create([
                'position'          => $remApiJob["title"],
                'description'       => $remApiJob["description"],
                'category_id'       => null,
                'locations'         => $remApiJob["candidate_required_location"],
                'apply_link'        => $remApiJob["url"],
                'apply_mode'        => 'link',
                'show_logo'         => 'on',
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
            ]);

            // tags for the remjob-tag pivot table
            $tagsIdToLink = [];

            // Add every tag, if it does not exist, create it in the database.
            $inputTags = array_values( $remApiJob["tags"] );

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
        $response = HTTP::get('https://www.workingnomads.co/api/exposed_jobs/');
        $jobsArray = $response->json();

        if( !count( $jobsArray ) > 0) {
            return back()->with('fail', 'No job found on working-nomads api');
        }
        //dd( explode( "," , $jobsArray[0]["tags"] ) ) ;

        //dd( array_slice($jobsArray, 0, 11) );

        foreach ( array_slice($jobsArray, 0, 11) as $remApiJob ) {

            // Create the remote job post
            $remjob = Remjob::create([
                'position'          => $remApiJob["title"],
                'description'       => $remApiJob["description"],
                'category_id'       => null,
                'locations'         => $remApiJob["location"],
                'apply_link'        => $remApiJob["url"],
                'apply_mode'        => 'link',
                'show_logo'         => null,
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
            ]);

            // tags for the remjob-tag pivot table
            $tagsIdToLink = [];

            // Add every tag, if it does not exist, create it in the database.
            $inputTags = explode("," , $remApiJob["tags"]);

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
        dd('edit remjob position: ', $remjob->position);
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
        // Delete media files
        if(\Storage::exists( 'public/' . $remjob->company_logo )){
            \Storage::delete( 'public/' . $remjob->company_logo );           
        }

        // Delete from pivot table Sposts-Twitter profiles
        DB::table('remjob_tag')->where('remjob_id',$remjob->id)->delete();

        // Delete the scheduled post
        $remjob->delete();

        return back()->with('message', 'Removed Remote Job Post from ' . $remjob->company_name );
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Remjob  $remjob
     * @return \Illuminate\Http\Response
     */
    public function tweet(Remjob $remjob)
    {
        // $publish = $this->shareRemjobOnTwitter( $remjob );
        // if( $publish ){
        //     return back()->with('flash', 'Remjob shared on Twitter!');
        // } else {
        //     return back()->with('fail', 'Remjob could not be shared on Twitter!');
        // }
        $link = $remjob->apply_link != null ? $remjob->apply_link : $remjob->apply_email;

        $text = trim( $remjob->company->name );
        $text .= ' is looking for a '.trim( $remjob->position );
        $text .= '. Find more through '.$link;
        
        if( $remjob->total == null ) {
            $text .= '. Source: '.$remjob->external_api;
        }
        
        foreach( $remjob->tags as $tag ){
           $text .= ' #'.str_replace(' ', '' , $tag->name); 
        }
        //dd($text);
        
        $twitterProfile = \App\TwitterProfile::where('handler','JMServca')->first();
        $twitter = new TwitterGateway( $twitterProfile->id, false );

        // Post with TwitterOAuth library
        $response = $twitter->connection->post(
            "statuses/update",
            [
                "status"    => $text,
            ]
        );

        if ( $twitter->connection->getLastHttpCode() == 200 ) {
            return back()->with('flash', 'Remjob shared on Twitter!');
        } else {
            return back()->with('fail', 'Remjob could not be shared on Twitter!');
        }    
        
        // $spost->update( [ 'posted' => true ] );
        
    }


}
