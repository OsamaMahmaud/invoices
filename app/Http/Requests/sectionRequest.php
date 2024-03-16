<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class sectionRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [

            'section_name'=>'required|unique:sections,section_name|max:255',
            'description'=>'required',
        ];
    }

    public function messages()
    {

        return[
            'section_name.required' =>'* offer name required',
            'description.required' =>'* offer name required',
         ];
    }
}
