<?php

namespace App\Http\Controllers\Admin;

use App\Company;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;

class CompanyController extends Controller
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
        // dd('will return companies');
        if( Company::count() > 0 ){
            $companies = Company::latest()->get();
        } else { $companies = []; }
        
        return view( 'admin.companies.index',compact('companies') );

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validateCompany();

        $company = Company::create([
            'name'      => request()->company_name,
            'slug'      => Str::slug( request()->company_name, '-' ),
            'email'     => request()->company_email,
            'user_id'   => request()->user_id,
        ]);

        if ( request()->has('company_logo') ){
            $this->storeMedia($company);
        }

        return back()->with('flash', 'Added company: ' . $request->company_name );

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit( Company $company )
    {
        return view('admin.companies.edit', compact('company') );

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
        $this->validateCompany();

        $company = Company::findOrFail( $id ); 

        $company->update([
            'name'      => request()->company_name,
            'slug'      => Str::slug( request()->company_name, '-' ),
            'email'     => request()->company_email,
            //'user_id'   => request()->user_id,
        ]);
        
        if ( request()->has('company_logo') ){
            $this->storeMedia($company);
        }

        return redirect()->route('admin.companies.index');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Company  $Company
     * @return \Illuminate\Http\Response
     */
    public function destroy(Company $company)
    {
        // Check if $company has remjobs and destroy them
        if( $company->remjobs()->count() > 0 ){

            $remjobs = $company->remjobs()->get();

            foreach ($remjobs as $key => $remjob) {
                // Delete media files
                if(\Storage::exists( 'public/' . $remjob->company->logo )){
                    \Storage::delete( 'public/' . $remjob->company->logo );           
                }

                // Delete from pivot table Sposts-Twitter profiles
                DB::table('remjob_tag')->where('remjob_id',$remjob->id)->delete();

                // Delete the remote job
                $remjob->delete();
            }

        } 

        $company->delete();
        
        return back()->with('flash', 'Removed company ' . $company->name );
        
    }

    private function validateCompany() 
    {

        $validatedData = request()->validate([
            //'user_id'               => 'required',
            'company_name'          => 'required|min:3',
            'company_email'         => 'required|email',
            'company_logo'  => '',
            'company_twitter'   => '',
        ]);

        if ( request()->hasFile('company_logo')){
            request()->validate([
                'company_logo'        => 'file|image|max:5000'  // under 5 mb
            ]);
        }

        return $validatedData;

    }

    /**
     * Store the incoming company_logo.
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

}
