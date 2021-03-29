<?php

namespace App\Http\Controllers\Admin;

use App\Category;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class CategoryController extends Controller
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
        if( Category::count() > 0 ){
            $categories = Category::oldest()->get();
        } else { $categories = []; }
        
        return view( 'admin.categories.index',compact('categories') );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = request()->validate([
            'name'          => 'required|min:3',
            'tag'           => 'required|min:2',
            'language_id'   => [ Rule::in(['1','2']) ],
            'mailchimp_audience_id' => 'nullable',
            'mailchimp_category_id' => 'nullable',
            'mailchimp_interest_id' => 'nullable',
        ]);

        Category::create($data);

        return back()->with('flash', 'Added category: ' . $request->name );
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function edit(Category $category)
    {
        return view('admin.categories.edit', compact('category') );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Category $category)
    {
        $data = request()->validate([
            'name'          => 'required|min:3',
            'tag'           => 'required|min:2',
            'language_id'   => [ Rule::in(['1','2']) ],
            'mailchimp_audience_id' => 'nullable',
            'mailchimp_category_id' => 'nullable',
            'mailchimp_interest_id' => 'nullable',
            'mailchimp_base_campaign_id' => 'nullable',
            'created_at' => 'nullable',
            'updated_at' => 'nullable',
        ]);

        $category->update($data);

        return redirect()->route('admin.categories.index');
    }

}
