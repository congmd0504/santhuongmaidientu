<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class ValidateBanDiem extends FormRequest
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
            "pay"=>[
                "required",
                'integer',
                'min:1',
            ],
        ];
    }
    public function messages()
    {
        return [
            "pay.required"=>"Số xu là trường bắt buộc",
            "pay.integer"=>"Số xu phải là số nguyên",
        ];
    }
}
