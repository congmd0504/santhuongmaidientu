<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
class ValidateAddProduct extends FormRequest
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
            "masp"=>[
                "required",
                "min:3",
                "max:250",
                Rule::unique("App\Models\Product", 'masp')->where(function ($query) {
                    return $query->where([
                        ['deleted_at', null],
                    ]);
                })
            ],
            "name"=>"required|min:3|max:250",
            "slug"=>[
                "required",
                Rule::unique("App\Models\Product", 'slug')->where(function ($query) {
                    return $query->where([
                        ['deleted_at', null],
                    ]);
                })
            ],
            "icon"=>"mimes:jpeg,jpg,png,svg|nullable",
            "price"=>"nullable",
            "sale"=>"nullable",
           // "hot"=>"required",
             // "pay"=>"required",
             // "number"=>"required",
            "warranty"=>"nullable",
            // "view"=>"required",

            "avatar"=>"mimes:jpeg,jpg,png,svg|nullable",
            "category_id"=>'exists:App\Models\CategoryProduct,id',
            "active"=>"required",
            //"checkrobot"=>"accepted"
        ];
    }
    public function messages()
    {
        return [
            "masp.required"=>"Mã sản phẩm là trường bắt buộc",
            "masp.min"=>"Mã sản phẩm  > 3",
            "masp.max"=>"Mã sản phẩm  < 250",
            "masp.unique"=>"Mã sản phẩm  đã tồn tại",
            "name.required"=>"Name product is required",
            "name.min"=>"Name product > 3",
            "name.max"=>"Name product < 250",
            "slug.required"=>"slug product is required",
            "slug.unique"=>"Mã sản phẩm  đã tồn tại",
            "price"=>"price is required",
           // "sale"=>"sale is required",
            //"hot"=>"hot is required",
            // "pay"=>"pay is required",
            // "number"=>"number is required",
            // "warranty"=>"hot is required",
            // "view"=>"hot is required",
            "avatar.mimes"=>"avatar  in jpeg,jpg,png,svg",
            "active.required"=>"active  is required",
            "category_id"=>"category_id k tồn tại",
            //"checkrobot.accepted"=>"checkrobot product is accepted",
        ];
    }
}
