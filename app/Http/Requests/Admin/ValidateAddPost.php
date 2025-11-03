<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
class ValidateAddPost extends FormRequest
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
            "name"=>"required|min:3|max:250",
            "slug"=>[
                "required",
                Rule::unique("App\Models\Post", 'slug')->where(function ($query) {
                    return $query->where('deleted_at', null);
                })
            ],
            "view"=>"nullable|integer",
            "hot"=>"nullable|integer",
            "avatar"=>"mimes:jpeg,jpg,png,svg|nullable",
            "category_id"=>'exists:App\Models\CategoryPost,id',
            "active"=>"required",
            //"checkrobot"=>"accepted"
        ];
    }
    public function messages()
    {
        return [
            "name.required"=>"Name post is required",
            "name.min"=>"Name post > 3",
            "name.max"=>"Name post < 250",
            "slug.required"=>"slug post is required",
            "slug.unique"=>"slug post is exits",
            "hot.integer"=>"hot is integer",
            "view.integer"=>"view is integer",
            "avatar.mimes"=>"avatar  in jpeg,jpg,png,svg",
            "active.required"=>"active  is required",
            "category_id"=>"category_id k tồn tại",
            //"checkrobot.accepted"=>"checkrobot product is accepted",
        ];
    }
}
