<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class ValidateAddSlider extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        if (auth()->guard('admin')->check()) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            "name" => "required|min:3|max:250",
            "slug" => "required",
            //"description"=>"required",
            "image_path" => "mimes:jpeg,jpg,png,svg|nullable",
            "active" => "required",
            //"checkrobot" => "accepted"
        ];
    }
    public function messages()
    {
        return [
            "name.required" => "Name  is required",
            "name.min" => "Name  > 3",
            "name.max" => "Name  < 250",
            "slug.required" => "slug slider is required",
            "image_path.mimes" => "image  in jpeg,jpg,png,svg",
            "active.required" => "active  is required",
            //"checkrobot.accepted" => "checkrobot slider is accepted",
        ];
    }
}
