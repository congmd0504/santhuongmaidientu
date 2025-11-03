<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
class ValidateAddCategoryProduct extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        if(auth()->guard('admin')->check()){
            return true;
        }else{
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
                "name" => "required|min:3|max:100",
                "slug" => [
                    "required",
                   // 'unique:App\Models\CategoryProduct,slug',
                     Rule::unique("App\Models\CategoryProduct",'slug')->where(function ($query) {
                        return $query->where('deleted_at', null);
                    })
                ],
                "icon" => "mimes:jpeg,jpg,png,svg|nullable|max:3000",
                "avatar" => "mimes:jpeg,jpg,png,svg|nullable|max:3000",
                "active" => "required",
                //"checkrobot" => "accepted"
        ];
    }
    public function messages()
    {
        return     [
            "name.required" => "Name category is required",
            "name.min" => "Name category > 3",
            "name.max" => "Name category < 100",
            "slug.required" => "slug category is required",
            "slug.unique" => "slug đã tồn tại",
            "icon.mimes" => "icon category in jpeg,jpg,png,svg",
            "icon_path.max" => "icon category size < 3mb",
            "avatar.mimes" => "avatar category in jpeg,jpg,png,svg",
            "avatar_path.max" => "avatar category size < 3mb",
            "active.required" => "active category is required",
            //"checkrobot.accepted" => "checkrobot category is accepted",
        ];
    }
}
