<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreRemjob extends FormRequest
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
            'company_name'  => ['required', 'max:50'],
            'position'      => ['required', 'max:100'],       
            'text'          => ['required', 'max:300'],
            'category_id'   => ['required', Rule::in(['1','2','3','4','5','6'])],
            'apply_link'    => ['required', 'url'],
            'min_salary'    => ['nullable', 'max:7'], 
            'max_salary'    => ['nullable', 'max:7'],
            'locations'     => ['required', 'max:100'],
            'company_logo'  => ['nullable','file','image','max:5000'],

        ];
            
    }

    public function messages()
    {
        return [
            'company_name.required'  => 'Please enter the name of your company.',
            'company_name.max'       => 'Please enter a company name with less than 50 characters.',

            'position.required'  => 'Please enter a name for the position.',
            'position.max'       => 'Please enter a position name with less than 100 characters.',

            'text.required'  => 'Please enter a description for the position.',
            'text.max'       => 'Please enter a position description with less than 300 characters.',

            'category_id.required'  => 'Please select a category.',
            
            'apply_link.required'  => 'Please enter a url link to apply for the position.',
            'apply_link.url'       => 'Please enter a valid url link to apply for the position.',

            'min_salary.max'       => 'Enter a minimun salary less than 999,999.',

            'max_salary.max'       => 'Enter a maximun salary less than 999,999.',

            'locations.required'  => 'Please enter a description for the position.',
            'locations.max'       => 'Allowed locations must have less than 100 characters.',

        ];
    }

}
