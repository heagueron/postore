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
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function rok()
    {
        $response = HTTP::get('https://remoteok.io/api');

        $jobsArray = $response->json();

        array_shift( $jobsArray );

        // // foreach ( array_slice($jobsArray, 0, 11) as $remApiJob ){
        // //     if(strpos($remApiJob["company"], 'Ã‚Â ') !== false){
        // //         $remApiJob["company"] = 'found';
        // //     }
        // // }
        

        // dd( array_slice($jobsArray, 0, 11) );

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

            $remjob->update([ 
                'company_id'    => $company->id, 
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
        // dd( $remjob );
        $link = $remjob->apply_link != null ? $remjob->apply_link : $remjob->apply_email;

        $text = $remjob->company->name;
        $text .= ' is looking for a '.$remjob->position;
        $text .= '. Find more through '.$link;

        $twitterProfile = \App\TwitterProfile::where('handler','JMServca')->first();
        //dd( $twitterProfile );
        $twitter = new TwitterGateway( $twitterProfile->id, false );

        // Post with TwitterOAuth library
        $response = $twitter->connection->post(
            "statuses/update",
            [
                "status"    => $text,
            ]
        );
        //dd('$response: ',$response);

        if ( $twitter->connection->getLastHttpCode() == 200 ) {
            return back()->with('flash', 'Remjob shared on Twitter!');
        } else {
            return back()->with('fail', 'Remjob could not be shared on Twitter!');
        }    
        
        // $spost->update( [ 'posted' => true ] );
        
    }


}
