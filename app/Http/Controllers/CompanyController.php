<?php

namespace App\Http\Controllers;

use App\Company;
use Illuminate\Http\Request;

class CompanyController extends Controller
{
    /**
     * Display the specified resource.
     *
     * @param  string  $email
     * @return \Illuminate\Http\Response
     */
    public function search_company_by_email( $email )
    {
        if( Company::where( 'email', 'like', $email )->exists() ){
            $company = Company::where( 'email', 'like', $email )->first();
        } else { $company = NULL; }
        
        return response()->json([
            'company'        => $company
        ],200);
        
    }

}
