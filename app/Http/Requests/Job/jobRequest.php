<?php

namespace App\Http\Requests\Job;

use Illuminate\Foundation\Http\FormRequest;

class jobRequest extends FormRequest
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
//            `title`, `description`, `education`, `type`, `level`, `location`
            'title'=>'required',
            'description'=>'required',
            'education'=>'required',
            'type'=>'required',
            'level'=>'required',
            'location'=>'required',
            'skill_name'=>'required',
        ];
    }
}
