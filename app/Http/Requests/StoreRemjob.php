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
            'tags'          => ['required', 'max:100'],      
            'description'   => ['required'],
            'category_id'   => [ Rule::in(['1','2','3','4','5','6','7','8','9','10','11','12','13','14']) ],
            'apply_link'    => ['exclude_if:apply_mode,==,email', 'url'],
            'apply_email'   => ['exclude_if:apply_mode,==,link', 'email'],
            'min_salary'    => ['nullable', 'max:7', 'lte:max_salary'], 
            'max_salary'    => ['nullable', 'max:7', 'gte:min_salary'],
            'locations'     => ['max:100'],
            'company_logo'  => ['nullable','file','image','max:5000'],
            'company_email' => ['required', 'email:rfc,dns'],
            'company_twitter' => ['nullable', 'max:15'],
        ];
            
    }

    public function messages()
    {
        return [
            'category_id.*'         => 'Please select a category from the provided list.',

            'company_name.required' => 'Please enter the name of the company.',
            'company_name.max'      => 'Please enter a company name with less than 50 characters.',

            'position.required'     => 'Please enter a name for the position.',
            'position.max'          => 'Please enter a position name with less than 100 characters.',

            'tags.required'         => 'Please enter some tags separated by comma (example: dev, java, php).',
            'tags.max'              => 'The tags list must have less than 100 characters.',

            'description.required'  => 'Please enter a description for the position.',
            
            'apply_link.required'   => 'A url link to apply is required.',
            'apply_link.url'        => 'Please enter a valid url link so candidates can apply for the position.',

            'apply_email.required'  => 'A email to apply is required.',
            'apply_email.email'     => 'Please enter a valid email so candidates can apply for the position.',

            'min_salary.max'        => 'Enter a minimun salary less than 999,999.',
            'min_salary.lte'        => 'Minimun salary must be less than or equal to Maximun Salary.',

            'max_salary.max'        => 'Enter a maximun salary less than 999,999.',
            'max_salary.gte'        => 'Maximun salary must be more than or equal to Minimun Salary.',

            'locations.max'         => 'Allowed locations must have less than 100 characters.',

            'company_logo.file'     => 'Please select a image file for your company logo. Max 5000 bytes.',
            'company_logo.image'    => 'Please select a image file for your company logo. Max 5000 bytes.',
            'company_logo.max'      => 'Please select a image file for your company logo. Max 5000 bytes.',
            
            'company_twitter.max'   => 'The Twitter handle has a maximum length of 15 characters.',
        ];
    }

}
