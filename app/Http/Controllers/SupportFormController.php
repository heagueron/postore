<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Mail\SupportFormMail;
use Illuminate\Support\Facades\Mail;

class SupportFormController extends Controller
{
    public function create() 
    {
        return view('support.create');
    }

    public function store() 
    {
        // dd( request()->all() );

        $data = request()->validate([
            'name' => 'required',
            'email' => 'required|email',
            'support-request' => 'required'
        ]);

        Mail::to('heagueron@gmail.com')->send( new SupportFormMail($data) );

        return redirect()->route( 'landing' );

    }

}
