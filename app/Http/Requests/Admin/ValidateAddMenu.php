<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ValidateAddMenu extends FormRequest
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
        return  [
            "name" => "required|min:3|max:100|unique:App\Models\Menu,name",
            "slug" =>            [
                "required",
                Rule::unique("App\Models\Menu", 'slug')->where(function ($query) {
                    return $query->where('deleted_at', null);
                })
            ],
            "active" => "required",
            //"checkrobot" => "accepted",
        ];
    }
    public function messages()
    {
        return     [
            "name.required" => "Name  is required",
            "name.min" => "Name  > 3",
            "name.max" => "Name  < 100",
            "name.unique" => "Name đã tồn tại",
            "slug.unique" => "Slug đã tồn tại",
            "active.required" => "active  is required",
            //"checkrobot.accepted" => "checkrobot  is accepted",
        ];
    }
}
