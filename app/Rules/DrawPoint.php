<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use App\Models\Point;
class DrawPoint implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    private $point;
    private $sumPoint;
    public function __construct()
    {
        //
        $this->point=new Point();
        $this->sumPoint = 0;
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
       $user = auth()->guard('web')->user();
       $this->sumPoint = $this->point->sumPointDiemCoTheRutCurrent($user->id);
       //dd($this->sumPoint - moneyToPoint(config('point.typePoint.minMoney')));
       return ($this->sumPoint) >=(int)$value&&(int)$value>0;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        $user = auth()->guard('web')->user();
        return 'Số tiền rút phải nhỏ  hơn. Số tiền tối đa có thể rút ' .number_format($this->sumPoint) . 'đ';
    }
}
