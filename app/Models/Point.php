<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Point extends Model
{
    //
    protected $table = "points";
    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
    public function userOriginPoint()
    {
        return $this->belongsTo(User::class, 'userorigin_id', 'id');
    }
    public function admin()
    {
        return $this->belongsTo(Admin::class, 'userorigin_id', 'id');
    }
    // lấy tổng số điểm mỗi kiểu
    // lấy danh sách hoa hồng được hưởng từ các thành viên
    public function sumEachType($userId)
    {
        return  $this->where([
            'user_id' => $userId,
        ])->select('type', Point::raw('SUM(point) as total'))->groupBy('type')->get();
    }

    // lấy tổng số điểm mỗi kiểu
    // lấy danh sách hoa hồng được hưởng từ các thành viên kiểu hoa hồng 8 gộp với 3
    public function sumEachTypeFrontend($userId)
    {
        $data =  $this->where([
            ['user_id', $userId],
            ['active', 1],
        ])->select('type', Point::raw('SUM(point) as total'))->groupBy('type')->get();
        return  $data;
    }
    // lấy số điểm hiện có
    public function sumPointCurrent($userId)
    {
        return $this->where([
            ['user_id', $userId],
            ['active', 1],
        ])->whereIn('type', config("point.listTypePointRut"))->select(Point::raw('SUM(point) as total'))->first()->total ?? 0;
    }

    // lấy tổng điểm thưởng
    public function sumPointDiemThuongCurrent($userId)
    {
        // return $this->where([
        //    ['user_id', $userId],
        //    ['active', 1],
        // ])->whereIn('type', config("point.listTypePointDiemThuong"))->select(Point::raw('SUM(point) as total'))->first()->total ?? 0;

        return $this->where([
               ['user_id', $userId],
               ['active', 1],
            ])->whereIn('type', config("point.tonghoahongnhanduoc"))->select(Point::raw('SUM(point) as total'))->first()->total ?? 0;
    }
    // lấy tổng điểm thưởng đã rút hoặc chuyển sang xu
    public function sumPointDiemDaRutCurrent($userId)
    {
        return $this->where([
            ['user_id', $userId],
            ['active', 1],
        ])->whereIn('type', config("point.listTypePointDiemDaRut"))->select(Point::raw('SUM(point) as total'))->first()->total ?? 0;
    }

    // lấy tổng điểm có thể rút 0.8 điểm thưởng - điểm đã rút
    public function sumPointDiemCoTheRutCurrent($userId) 
    {
         return $this->where([
            ['user_id', $userId],
            ['active', 1],
        ])->whereIn('type', config("point.listTypePointDiemThuong"))->select(Point::raw('SUM(point) as total'))->first()->total ?? 0;
    }

    // điểm mua hàng hiện có
    public function sumPointMuaHangCurrent($userId)
    {
        return $this->where([
            ['user_id', $userId],
            ['active', 1],
        ])->whereIn('type', config("point.listTypePointMH"))->select(Point::raw('SUM(point) as total'))->first()->total ?? 0;
    }
    public function sumPointCurrentPM($userId){
        return $this->where([
            'user_id' => $userId,
        ])->whereIn('type', [1])->select(Point::raw('SUM(point) as total'))->first()->total;
    }
}
