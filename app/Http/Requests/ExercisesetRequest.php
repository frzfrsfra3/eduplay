<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Lang;


class ExercisesetRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * return array
     */
    public function rules()
    {
        $maxAge = request('minimum_age') + 1;

        return [
            'title' => 'required|string|min:1|max:250',
            'description' => 'nullable',
            'topic_id' => 'required',
            'grade_id' => 'nullable',
            'skill_category_id' => 'nullable',
            'language_id' => 'required|numeric|min:0|max:4294967295',
            'description' => 'required',
            'publish_status' => 'required',
            'minimum_age' => 'required|numeric|min:1|max:50',
            'maximum_age' => 'required|numeric|min:'.$maxAge.'|max:50',
        ];
    }


    /**
     * Get the error messages for the defined validation rules.
     *
     * return array
     */
    public function messages()
    {
        return [
            'title.required' =>  Lang::get('controller.title_required'),
            'title.string' =>  Lang::get('controller.title_required'),
            'description.required' =>  Lang::get('controller.description_required'),
            'topic_id.required' =>  Lang::get('controller.topic_id_required'),
            'grade_id.required' =>  Lang::get('controller.grade_id_required'),
            'skill_category_id.required' =>  Lang::get('controller.skill_category_id_required'),
            'language_id.required' =>  Lang::get('controller.language_id_required'),
            'publish_status.required' =>  Lang::get('controller.publish_status_required'),
            'minimum_age.required' =>  Lang::get('controller.minimum_age_required'),
            'maximum_age.required' =>  Lang::get('controller.maximum_age_required'),
        ];
    }
}
