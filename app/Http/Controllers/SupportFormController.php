<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Mail\SupportFormMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;

class SupportFormController extends Controller
{
    public function create() 
    {
        $user = Auth::user();

        return view( 'support.create', compact('user') );

    }

    public function store() 
    {
        // dd( request()->all() );

        $data = request()->validate([
            'name' => 'required',
            'email' => 'required|email',
            'support-request' => 'required'
        ]);

        try{

            Mail::to('heagueron@gmail.com')->send( new SupportFormMail($data) );
            // return redirect()->route( 'landing' );

            $title = 'Thank You!';
            $message = 'Thanks for your contact. We will respond as soon as we can.';
            
            return view( 'information', compact( 'title', 'message' ) );

        } catch (\Exception $exception){

            $title = 'Oops!';
            $message = 'We were unable to send your contact. Please try again later.';

        }

        

        

    }

}
