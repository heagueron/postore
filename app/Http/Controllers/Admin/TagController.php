<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Tag;
use Illuminate\Http\Request;
use DataTables;

class TagController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $tags = Tag::all();

        return view( 'admin.tags.index', compact('tags') );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Tag  $tag
     * @return \Illuminate\Http\Response
     */
    public function destroy(Tag $tag)
    {
        if( $tag->remjobs->count()==0 ){
            // Delete the tag
            $tag->delete();

        return back()->with('message', ' Removed TAG ');
        }

        return back()->with('message', ' Tag NOT Removed ' );

    }
}
