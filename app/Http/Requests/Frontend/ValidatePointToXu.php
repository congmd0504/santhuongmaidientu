<?php

namespace App\Http\Requests\Frontend;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use App\Rules\DrawPoint;
use App\Rules\PointToXuMax;

class ValidatePointToXu extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        if(auth()->guard('web')->check()){
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
            "pay"=>[
                "required",
                'integer',
                new PointToXuMax(),
            ],

            "checkrobot"=>"accepted"
        ];
    }
    public function messages()
    {
        return [
            "pay.required"=>"Số điểm là trường bắt buộc",
            "pay.integer"=>"Số điểm phải là số nguyên",
        ];
    }
}
