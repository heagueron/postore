<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;


class StoreSubscriber extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $categoryIds = DB::table('categories')->pluck('id')->toArray();

        return [         
            'name'                  => 'nullable|min:3',
            'email'                 => 'required|email',
            'category_id'           => [ Rule::in( array_values($categoryIds) ) ],
        ];
        // TODO: validate twitter_accounts array input.
    }

    public function messages()
    {
        return [
            'name.min'        => 'Enter a name with at least 3 characters.',
            'email.email'     => 'Please enter a valid email.',
            'email.required'  => 'Email is required.',
            'category_id.*'   => 'Please select a category from the provided list.',
        ];
    }
}