<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use App\Models\Point;
use App\Helper\CartHelper;
class PointLessTotalValueProduct implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    private $point;
    private $totalPrice;
    private $totalPoint;
    private $sumPointCurrent;
    public function __construct()
    {
        //
        $this->point=new Point();
        $cart = new CartHelper();
        $user = auth()->guard('web')->user();
        $this->sumPointCurrent = $this->point->sumPointMuaHangCurrent($user->id) ?? 0;
        $this->totalPrice =  $cart->getTotalPrice() ?? 0;
        $this->totalPoint =  $cart->getTotalPointAccessUse() ?? 0;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        //
       return ($value?? 0) >=0 && $value <= $this->totalPoint && $value <= $this->sumPointCurrent;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        $user = auth()->guard('web')->user();
        return 'Số điểm sử dụng phải nhỏ  hơn số điểm hiện có là ' . number_format($this->sumPointCurrent) . ' và số điểm tối đa được phép dùng để mua sản phẩm ' .number_format($this->totalPoint) . ' và >= 0';
    }
}
