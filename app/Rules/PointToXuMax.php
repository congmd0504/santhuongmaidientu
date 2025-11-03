<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use App\Models\Point;
class PointToXuMax implements Rule
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
       $this->sumPoint = $this->point->sumPointDiemThuongCurrent($user->id);
       return ($this->sumPoint - moneyToPoint(config('point.typePoint.minMoney')) ) >=(int)$value&&(int)$value>0;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        $user = auth()->guard('web')->user();
        return ':attribute phải nhỏ  hơn số điểm tối đa ' .$this->sumPoint . ' và > 0 và số điểm tối thiểu còn lại phải >='. moneyToPoint(config('point.typePoint.minMoney'));
    }
}
