<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
class ValidateEditSetting extends FormRequest
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
            "name" => [
                "required",
                "min:3",
                "max:250",
                // Rule::unique("App\Models\Setting", 'name')->where(function ($query) {

                //     $id=request()->route()->parameter('id');
                //     return $query->where([
                //         ['deleted_at', null],
                //         ['id','<>',$id]
                //     ]);
                // })
            ],
            "value" => "nullable",
            "slug" => [
                "nullable",
                // Rule::unique("App\Models\Setting", 'slug')->where(function ($query) {
                //     $id=request()->route()->parameter('id');
                //     return $query->where([
                //         ['deleted_at', null],
                //         ['id','<>',$id]
                //     ]);
                // })
            ],
            //"description"=>"required",
            "active" => "required",
            //"checkrobot" => "accepted"
        ];
    }
    public function messages()
    {
        return [
            "name.required" => "name  is required",
            "name.unique" => "name setting is exits",
            "name.min" => "name  > 3",
            "name.max" => "name  < 250",
            "slug.unique" => "slug setting is exits",
            "active.required" => "active  is required",
            //"checkrobot.accepted" => "checkrobot  is accepted",
        ];
    }
}
