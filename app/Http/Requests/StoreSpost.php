<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreSpost extends FormRequest
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
        return [         
            'text'                  => 'required|min:1|max:240',
            'user_id'               => 'required',
            'post_date'             => 'required',
            //'twitter_accounts'      => 'required',
            //"twitter_accounts.*"    => "required|string",
        ];
        // TODO: validate twitter_accounts array input.
    }

    public function messages()
    {
        return [
            'text.required'             => 'Please enter a text for your post.',
            'post_date.required'        => 'Please select a date and time to schedule your post.',
            'twitter_accounts.required' => 'Please select at least one social profile.',
        ];
    }
}
