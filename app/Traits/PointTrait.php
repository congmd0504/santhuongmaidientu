<?php

namespace App\Traits;

use App\Models\Hoahong;
use App\Models\Point;
use App\Models\User;
use FontLib\TrueType\Collection;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Concerns\ToArray;

/**
 *
 */
trait PointTrait
{

    private $data = [];
    /*
     store image upload and return null || array
     @param
     $request type Request, data input
     $fieldName type string, name of field input file
     $folderName type string; name of folder store
     return array
     [
         "file_name","file_path"
     ]
    */
    // lấy tổng số điểm mỗi kiểu
    // lấy danh sách hoa hồng được hưởng từ các thành viên

    public function getSumEachType($user)
    {
        $point = new Point();
        return  $point->where([
            'user_id' => $user->id,
        ])->select('type', Point::raw('SUM(point) as total'))->groupBy('type')->get();
    }
    // lấy số điểm hiện có
    public function getSumPointCurrent($user)
    {
        $point = new Point();
        return $point->where([
            'user_id' => $user->id,
        ])->select(Point::raw('SUM(point) as total'))->first()->total;
    }
    // lấy số điểm hiện có
    public function getListUser20()
    {
        $user = auth()->guard('web')->user();
        $i = 1;
        $this->data = [];
        $data = [];
        $userLoop = [$user];
        // dd($userLoop->childs()->first()->childs()->first()->childs()->first()->childs()->first());
        $data =  $this->getListUser20Recusive($userLoop, 1);
        //  $data=collect($data);
        // dd($data->orderby('created_at'));
        return $data;
    }
    public function getListUser20Recusive($userLoop, $i = 1, $imax = 20)
    {

        if ($i <= $imax) {
            if ($userLoop) {
                foreach ($userLoop as $loopItem) {
                    if ($loopItem->childs->count() > 0) {
                        $list = $loopItem->childs()->get()->toArray();
                        foreach ($list as $item) {
                            $item['level'] = $i;
                            array_push($this->data, $item);
                        }
                    }
                }
                foreach ($userLoop as $loopItem) {
                    if ($loopItem->childs->count() > 0) {
                        $this->getListUser20Recusive($loopItem->childs, $i + 1);
                    }
                }
            }
        }
        return $this->data;
    }

    public function getListUser20Recusive2($userLoop, $i = 1, $imax = 20)
    {

        if ($i <= $imax) {
            if ($userLoop) {
                foreach ($userLoop as $loopItem) {
                    if ($loopItem->childs->count() > 0) {
                        $list = $loopItem->childs()->get();
                        foreach ($list as $item) {
                            $item->level = $i;
                            array_push($this->data, $item);
                        }
                    }
                }
                foreach ($userLoop as $loopItem) {
                    if ($loopItem->childs->count() > 0) {
                        $this->getListUser20Recusive($loopItem->childs, $i + 1);
                    }
                }
            }
        }
        return $this->data;
    }

    public function addPointTo7($user)
    {
        $j = 1;
        $userLoop = $user;
        while ($j <= 7) {
            if ($userLoop->parent_id2 != 0) {
                // dd($userLoop->parent2()->first());
                if ($userLoop->parent2()->first()->active == 1) {
                    $userLoop->parent2()->first()->points()->create([
                        'type' => $this->typePoint[3]['type'],
                        'point' => getConfigBB(),
                        'active' => 1,
                        'userorigin_id' => $user->id,
                    ]);
                }
                $userLoop = $userLoop->parent2()->first();
            } else {
                break;
            }
            $j++;
        }
    }
    public function addPointTo20($user, $total)
    {
        // thêm số điểm cây 20 lớp
        $total = (float)$total;
        $totalPoint = moneyToPoint($total);

        $i = 1;
        $userLoop = $user;
        $typePoint = config('point.typePoint');
        $rose = config('point.rose');
        while ($i <= 20) {
            if ($userLoop->parent_id != 0) {
                if ($userLoop->parent()->first()->active == 1) {
                    $userLoop->parent()->first()->points()->create([
                        'type' => $typePoint[2]['type'],
                        'point' => $rose[$i]['percent'] * $totalPoint / 100,
                        'active' => 1,
                        'userorigin_id' => $user->id,
                    ]);
                }
                $userLoop = $userLoop->parent()->first();
            } else {
                break;
            }
            $i++;
        }
    }
    public function addPointParentAndUpdateMoney($user, $transaction)
    {
        // nếu sử dụng điểm k tính j hết
        // if ($transaction->point > 0) {
        //     return;
        // }
        // cấp a-b-c-d
        $configLenDaiLy = getValueConfigLenDaiLy();
        $levelCurrent = $user->level;
        $total = $transaction->money;
        $total = (float)$total;
        $totalPoint = moneyToPoint($total);

        $typePoint = config('point.typePoint');

        $listParentKeyString = trim($user->parent_all_key, "|");
        //dd($listParentKeyString);
        if ($listParentKeyString) {
            $listParentKeyArray = explode('|', $listParentKeyString);
            $userModel = new User();
            $pointModel = new Point();
            $allUserParent = $userModel->whereIn("id", $listParentKeyArray)->get();

            $this->resultArrayParentRecusive = [];
            $this->recusiveParentUser($allUserParent, $user);
            $listHoahong = [];

            $this->resultArrayParentRecusiveLevelMax = [];
            $this->recusiveParentToMaxUser($allUserParent, $user, $user->level);
            $this->resultArrayParentAllRecusive = [];
            $allUserParentSortChildToParent = $this->recusiveParentAllUser($allUserParent, $user);
            // dd($this->resultArrayParentRecusive, $this->resultArrayParentRecusiveLevelMax, $this->resultArrayParentAllRecusive);
            foreach ($this->resultArrayParentRecusiveLevelMax as $key => $itemParent) {
                $isAllThanhVien = $this->isAllLevelThanhVienTo($allUserParentSortChildToParent, $itemParent);
                $dataPoint = collect();
                if ($key == 0) {
                    // thuong nhom cho cap dai ly tro len
                    $getThuongNhom = getThuongNhom($itemParent->level, $itemParent->total_money_group, $total);
                    $dataCreatePoint = [];
                    foreach ($getThuongNhom as $keyPoint => $item) {
                        $itemPoint = [
                            'type' => $typePoint[2]['type'],
                            'point' => $item["value"] * $item["phantram"] / 100,
                            'active' => 1,
                            'userorigin_id' => $user->id,
                            'transaction_id' => $transaction->id,
                            'phantram' => $item["phantram"],
                        ];
                        $dataCreatePoint[] = $itemPoint;
                        $dataPoint->push($itemPoint);
                    }
                    // dd(collect($dataCreatePoint)->toJson());
                    $itemParent->points()->createMany($dataCreatePoint);
                } else if ($isAllThanhVien) {
                    // thuong 2 phan tram cho cap tren nếu tất cả tổ tiên thằng mua là thành viên
                    $itemPoint = [
                        'type' => $typePoint[2]['type'],
                        'point' => $totalPoint * 2 / 100,
                        'active' => 1,
                        'userorigin_id' => $user->id,
                        'transaction_id' => $transaction->id,
                        'phantram' => 2,
                    ];
                    $dataPoint->push($itemPoint);
                    $itemParent->points()->create($itemPoint);
                }

                // thêm thưởng thu nhập cho f1 f2 f3 6, 8, 10
                $userParentLC2 = collect($allUserParent)->firstWhere('id', $itemParent->parent_id);
                if ($userParentLC2) {
                    $dataPointInsertAll = collect();
                    if ($userParentLC2->level >= 2) {
                        $pointInsertC2 = $dataPoint->map(function ($item, $key) use ($typePoint, $itemParent, $transaction, $totalPoint) {
                            return [
                                'type' => $typePoint[3]['type'],
                                'point' => $item["point"] * 10 / 100,
                                'active' => 1,
                                'userorigin_id' => $itemParent->id,
                                'transaction_id' => $transaction->id,
                                'phantram' => 10,
                            ];
                        })->toArray();
                        $userParentLC2->points()->createMany($pointInsertC2);
                    }
                    $userParentLC3 = collect($allUserParent)->firstWhere('id', $userParentLC2->parent_id);
                    if ($userParentLC3) {
                        if ($userParentLC3->level >= 2) {
                            $userParentLC3->points()->createMany($dataPoint->map(function ($item, $key) use ($typePoint, $itemParent, $transaction, $totalPoint) {
                                return [
                                    'type' => $typePoint[3]['type'],
                                    'point' => $item["point"] * 8 / 100,
                                    'active' => 1,
                                    'userorigin_id' => $itemParent->id,
                                    'transaction_id' => $transaction->id,
                                    'phantram' => 8,
                                ];
                            })->toArray());
                        }
                        $userParentLC4 = collect($allUserParent)->firstWhere('id', $userParentLC3->parent_id);
                        if ($userParentLC4) {
                            if ($userParentLC4->level >= 2) {
                                $userParentLC4->points()->createMany($dataPoint->map(function ($item, $key) use ($typePoint, $itemParent, $transaction, $totalPoint) {
                                    return [
                                        'type' => $typePoint[3]['type'],
                                        'point' => $item["point"] * 6 / 100,
                                        'active' => 1,
                                        'userorigin_id' => $itemParent->id,
                                        'transaction_id' => $transaction->id,
                                        'phantram' => 6,
                                    ];
                                })->toArray());
                            }
                        }
                    }
                }
            }
            // them ds nhom và update ds nhóm và thêm hoa hồng
            foreach ($this->resultArrayParentRecusive as $key => $itemParent) {
                $itemParent->update([
                    'total_money_group' => $itemParent->total_money_group + $total,
                    'total_money_current' => $itemParent->total_money_current + $total,
                    'level' => getLevel($itemParent, $total, $configLenDaiLy),
                ]);
                $listHoahong[] = [
                    // "transaction_id" => $transaction->id,
                    "user_id" => $itemParent->id,
                    "money" => $total
                ];
            }
            $transaction->hoahongs()->createMany($listHoahong);


            $userParent = collect($allUserParent)->firstWhere('id', $user->parent_id);
            if ($userParent) {
                // 10 % f1
                $point = $userParent->points()->create([
                    'type' => $typePoint[1]['type'],
                    'point' => $totalPoint * 10 / 100,
                    'active' => 1,
                    'userorigin_id' => $user->id,
                    'transaction_id' => $transaction->id,
                    'phantram' => 10,
                ]);
                // thêm thưởng thu nhập cho f1 f2 f3 6, 8, 10
                $userParentC2 = collect($allUserParent)->firstWhere('id', $userParent->parent_id);
                if ($userParentC2) {
                    if ($userParentC2->level >= 2) {
                        $userParentC2->points()->create([
                            'type' => $typePoint[3]['type'],
                            'point' => ($totalPoint * 10 / 100) * 10 / 100,
                            'active' => 1,
                            'userorigin_id' => $userParent->id,
                            'transaction_id' => $transaction->id,
                            'phantram' => 10,
                            'point_id' => $point->id,
                        ]);
                    }
                    $userParentC3 = collect($allUserParent)->firstWhere('id', $userParentC2->parent_id);
                    if ($userParentC3) {
                        if ($userParentC3->level >= 2) {
                            $userParentC3->points()->create([
                                'type' => $typePoint[3]['type'],
                                'point' => ($totalPoint * 10 / 100) * 8 / 100,
                                'active' => 1,
                                'userorigin_id' => $userParent->id,
                                'transaction_id' => $transaction->id,
                                'phantram' => 8,
                                'point_id' => $point->id,
                            ]);
                        }
                        $userParentC4 = collect($allUserParent)->firstWhere('id', $userParentC3->parent_id);
                        if ($userParentC4) {
                            if ($userParentC4->level >= 2) {
                                $userParentC4->points()->create([
                                    'type' => $typePoint[3]['type'],
                                    'point' => ($totalPoint * 10 / 100) * 6 / 100,
                                    'active' => 1,
                                    'userorigin_id' => $userParent->id,
                                    'transaction_id' => $transaction->id,
                                    'phantram' => 6,
                                    'point_id' => $point->id,
                                ]);
                            }
                        }
                    }
                }
            }
        }
        $newLevel = getLevel($user, $total, $configLenDaiLy);
        $dataUpdate = [];
        // thuong vao vi mua sp 100% diem khi thanh vien mua
        if ($newLevel > 0) {
            $user->points()->create([
                'type' => $typePoint[6]['type'],
                'point' => $totalPoint,
                'active' => 1,
                'userorigin_id' => $user->id,
                'transaction_id' => $transaction->id
            ]);
            // $dataUpdate['is_first_buy'] = false;
        }

        // thuong 5% don hang cua mik
        // $user->points()->create([
        //     'type' => $typePoint[1]['type'],
        //     'point' => $totalPoint * $hoaHongKhiTuMua/100,
        //     'active' => 1,
        //     'userorigin_id' => null,
        //     'transaction_id' => $transaction->id
        // ]);

        $dataUpdate['level'] = $newLevel;
        $dataUpdate['total_money'] = $user->total_money + $total;

        // if ($user->level < $dataUpdate['level']) {
        //     $dataUpdate['total_money'] = $user->total_money + $total;
        // }
        // if ($user->parent_id != 0) {
        //     $userParent =$user->parent()->first();
        //        // thuong cha phan tram trực tiếp
        //     if($userParent && $userParent->active==1 && $userParent->level > 0){

        //         $userParent->points()->create([
        //             'type' => $typePoint[2]['type'],
        //             'point' => $hoaHongKhiConMua * $totalPoint / 100, // getThuongNhom($userParent->level, $userParent->total_money_group, $totalPoint)
        //             'active' => 1,
        //             'userorigin_id' => $user->id,
        //             'transaction_id' => $transaction->id
        //         ]);
        // 		// $dataUserParentUpdate = [
        //         //     'total_money_group' => $userParent->total_money_group + $total,
        //         //     'total_money_current' => $userParent->total_money_current + $total,
        //         // ];
        //         // $levelUserParent = getLevel($userParent, $total);
        //         // if ($userParent->level < $levelUserParent) {
        //         //     $dataUserParentUpdate['level'] = $levelUserParent;
        //         // }
        //         // $userParent->update($dataUserParentUpdate);

        //         // if ($userParent->parent_id != 0) {
        //         //     $userParentC2 =$userParent->parent()->first();

        //         //     if($userParentC2 && $userParentC2->active==1){
        //         //         // thuong cha phan tram theo cap do
        //         //         // check nếu a, c là đại lý
        //         //         if ($userParentC2->level >0 && $user->level > 0) {

        //         //             $userParentC2->points()->create([
        //         //                 'type' => $typePoint[2]['type'],
        //         //                 'point' => $hoaHongKhiConMuaC2 * $totalPoint / 100,
        //         //                 'active' => 1,
        //         //                 'userorigin_id' => $user->id,
        //         //                 'transaction_id' => $transaction->id
        //         //             ]);
        //         //             if ($userParentC2->parent_id != 0) {
        //         //                 // d
        //         //                 $userParentC3 =$userParentC2->parent()->first();
        //         //                 // dd($userParentC3);
        //         //                 if($userParentC3 && $userParentC3->active == 1){
        //         //                     if ($userParentC3->level > 0) {
        //         //                         $userParentC3->points()->create([
        //         //                             'type' => $typePoint[2]['type'],
        //         //                             'point' => $hoaHongKhiConMuaC3 * $totalPoint / 100,
        //         //                             'active' => 1,
        //         //                             'userorigin_id' => $user->id,
        //         //                             'transaction_id' => $transaction->id
        //         //                         ]);
        //         //                     }
        //         //                 }
        //         //             }
        //         //         }


        //         //     }
        //         // }
        //     }
        // }
        $user->update($dataUpdate);
    }

    public function addPointKYC($user)
    {
        // add điểm thưởng kyc
        $a = $user->points()->create([
            'type' => config("point.typePoint.2")['type'],
            'point' => getKYCNhanThuong() * getConfigBB(),
            'active' => 1,
            'userorigin_id' => $user->id,
        ]);

    }
    public function addPointWhenNapTien($user, $totalMoney)
    {
        $configLenDaiLy = getValueConfigLenDaiLy();
        $levelCurrent = $user->level;
        $total = (float)$totalMoney;
        $totalPoint = moneyToPoint($total);
        $levelNewUser = getLevel($user, $totalMoney);

        $typePoint = config('point.typePoint');
        // them diem nap
        $pointNap = $user->points()->create([
            'type' => $typePoint[14]['type'],
            'point' => $totalPoint * getConfigBB(),
            'active' => 1,
            'userorigin_id' => $user->id,
            'point_id' => null,
            'phantram' => null,
        ]);
        // thuong khi nap
        $phanTramThuongMuaHang = getPhanTramTangDiemMuaHang($totalMoney);
        if ($phanTramThuongMuaHang > 0) {
            $user->points()->create([
                'type' => $typePoint[3]['type'],
                'point' => $totalPoint * $phanTramThuongMuaHang / 100 * getConfigBB(),
                'active' => 1,
                'userorigin_id' => $user->id,
                'point_id' => $pointNap->id,
                'phantram' => $phanTramThuongMuaHang,
            ]);
        }

        // handler f0

//Bengin:  //Nạp tiền không thêm vào doanh số ==>> lên phần này ẩn
//        // update doanh so và level user
//        if ($user->status == 2) {
//            handlerAddPointDoanhSoNhom($user, $user, $totalPoint);
//            $user->update([
//                'level' => $levelNewUser,
//                'total_money' => $user->total_money + $totalMoney,
//            ]);
//        }
//
//        // update doanh so cho 3 level ben tren f1, f2, f3
//        // f1
//        $parentC1 = $user->parent;
//        if ($parentC1) {
//            // handler f1
//            if($parentC1->status == 2) {
//                handlerAddPointByLevel($user, $parentC1, $totalPoint);
//                $levelNewC1 = getLevel($parentC1, $totalMoney);
//                if ($parentC1->level >=1) {
//                    $parentC1->update([
//                        'level' => $levelNewC1,
//                        'total_money_group' => $parentC1->total_money_group + $totalMoney,
//                    ]);
//                }
//
//            }
//
//            // f2
//            $parentC2 = $parentC1->parent;
//            if ($parentC2) {
//                // handler f2
//                if($parentC2->status == 2) {
//                    handlerAddPointDoanhSoNhom($user, $parentC2, $totalPoint);
//                    $levelNewC2 = getLevel($parentC2, $totalMoney);
//                    if($parentC2->level >=1) {
//                        $parentC2->update([
//                            'level' => $levelNewC2,
//                            'total_money_group' => $parentC2->total_money_group + $totalMoney,
//                        ]);
//                    }
//                }
//                // f3
//                $parentC3 = $parentC2->parent;
//                if ($parentC3) {
//                    // handler f3
//                    if($parentC3->status == 2) {
//                        handlerAddPointDoanhSoNhom($user, $parentC3, $totalPoint);
//                        $levelNewC3 = getLevel($parentC3, $totalMoney);
//                        if ($parentC3->level >= 1) {
//                            $parentC3->update([
//                                'level' => $levelNewC3,
//                                'total_money_group' => $parentC3->total_money_group + $totalMoney,
//                            ]);
//                        }
//                    }
//                }
//            }
//end    }
    }
    public function addPointWhenMuaHang($user, $totalMoney)
    {
        $configLenDaiLy = getValueConfigLenDaiLy();
        $levelCurrent = $user->level;
        $total = (float)$totalMoney;
        //Quy đổi tiền sang điểm
        $totalPoint = moneyToPoint($total);

        $levelNewUser = getLevel($user, $totalMoney);
        $typePoint = config('point.typePoint');
        // handler f0
        // them diem nap
        $pointNap = $user->points()->create([
            'type' => $typePoint[1]['type'],
            'point' => $totalPoint * getConfigBB(),
            'active' => 1,
            'userorigin_id' => $user->id,
            'point_id' => null,
            'phantram' => null,
        ]);
        // Trừ điểm mua hàng
        $pointUse = $user->points()->create([
            'userorigin_id' => $user->id,
            'type' => $this->typePoint[9]['type'],
            'point' => (0 - $totalPoint) * getConfigBB(),
            'active' => 1,
        ]);
        // update doanh so và level user
        //Nếu (TÀI KHOẢN ĐÃ ĐƯỢC KIC THÌ) mới cộng doanh số: if ($user->status == 2) {
            handlerAddPointDoanhSoNhom($user, $user, $totalPoint);
            $user->update([
                'level' => $levelNewUser,
                'total_money' => $user->total_money + $totalMoney,
            ]);
        //}
        // update doanh so cho 3 level ben tren f1, f2, f3
        // f1
        $parentC1 = $user->parent;
        if ($parentC1) {
            // handler f1
//            kiểm tra đã được KIC chưa
//            if($parentC1->status == 2) {
            handlerAddPointByLevel($user, $parentC1, $totalPoint);
                $levelNewC1 = getLevel($parentC1, $totalMoney);
//                Kiểm tra phải lớp hơn l 0
//                if ($parentC1->level >=1) {
                    $parentC1->update([
                        'level' => $parentC1->level,
                        'total_money_group' => $parentC1->total_money_group + $totalMoney,
                    ]);
//                }

//            }

            // f2
            $parentC2 = $parentC1->parent;
            if ($parentC2) {
                // handler f2
//                if($parentC2->status == 2) {
                    handlerAddPointDoanhSoNhom($user, $parentC2, $totalPoint);
                    $levelNewC2 = getLevel($parentC2, $totalMoney);
//                    if($parentC2->level >=1) {
                        $parentC2->update([
                            'level' => $parentC2->level,
                            'total_money_group' => $parentC2->total_money_group + $totalMoney,
                        ]);
//                    }
//                }
                // f3
                $parentC3 = $parentC2->parent;
                if ($parentC3) {
                    // handler f3
//                    if($parentC3->status == 2) {
                        handlerAddPointDoanhSoNhom($user, $parentC3, $totalPoint);
                        $levelNewC3 = getLevel($parentC3, $totalMoney);
//                        if ($parentC3->level >= 1) {
                            $parentC3->update([
                                'level' => $parentC3->level,
                                'total_money_group' => $parentC3->total_money_group + $totalMoney,
                            ]);
//                        }
//                    }
                }
            }
        }
    }

 public function addBonusBB($user, $product,$quantity)
{
    $bonusRate  = configPersentLoiNhuan() / 100; 
    $minBonus   = 1000; 
    $baseAmount = $product->loi_nhuan*$quantity;
    $typePoint  = config('point.typePoint');

    $currentBonus = $baseAmount ;
    
    $currentUser   = $user->parent;
    $currentTotal  = $baseAmount;
    $visitedIds    = [$user->id]; 
    $currentLevel  = 1;

    while ($currentUser && $currentBonus >= $minBonus) {

        // Kiểm tra vòng lặp trong cây
        if (in_array($currentUser->id, $visitedIds)) {
            Log::warning("Phát hiện vòng lặp trong cây thưởng BB: user_id={$currentUser->id}");
            break;
        }

        $visitedIds[] = $currentUser->id;

        $currentBonus *= $bonusRate;
        $currentTotal *= $bonusRate;

        if ($currentBonus < $minBonus) break;

        $currentUser->points()->create([
            'type'          => $typePoint[27]['type'] ?? 27, // Loại thưởng cho cha
            'point'         => $currentBonus,
            'active'        => 1,
            'userorigin_id' => $user->id,
            'phantram'      => $bonusRate * 100,
        ]);

        // Chuyển lên cấp cha tiếp theo
        $currentUser = $currentUser->parent;
        $currentLevel++;
    }
}

public function addSales($user, $product,$quantity)
{
    $baseAmount = $product->price / 100 * configPersentDoanhThu();

    handlerAddPointDoanhSoNhom($user, $user, $baseAmount*$quantity);

    $levelNewUser = getLevel($user, $baseAmount*$quantity);
    $user->update([
        'level'             => $levelNewUser,
        'total_money' => $user->total_money + $baseAmount*$quantity,
    ]);

    $currentUser = $user->parent;
    $visitedIds  = [$user->id]; 

    while ($currentUser) {
        if (in_array($currentUser->id, $visitedIds)) {
            break;
        }

        $visitedIds[] = $currentUser->id;

        handlerAddPointDoanhSoNhom($user, $currentUser, $baseAmount*$quantity);

        // $levelNew = getLevel($currentUser, $baseAmount*$quantity);
        $currentUser->update([
            // 'level'             => $levelNew,
            'total_money_group' => $currentUser->total_money_group + $baseAmount*$quantity,
        ]);

        $currentUser = $currentUser->parent;
    }
}

public function addKTG($user, $total)
{
    $baseAmount = $total / 100 * configPersentKTG();
    $point = moneyToPoint($baseAmount);

    $user->points()->create([
        'type'          => config("point.typePoint")[31]['type'],
        'point'         => $point * getConfigBB(),
        'active'        => 1,
        'userorigin_id' => $user->id,
        'phantram'      => configPersentKTG(),
    ]);
}





    public $resultArrayParentRecusive;
    public function recusiveParentUser($data, $user)
    {
        $parent = $data->firstWhere('id', $user->parent_id);
        if ($parent && $parent->level > $user->level) {
            array_push($this->resultArrayParentRecusive, $parent);
            $this->recusiveParentUser($data, $parent);
        }
    }
    public $resultArrayParentRecusiveLevelMax;
    // lấy từ đại lý trở lên có level >=2
    public function recusiveParentToMaxUser($data, $user, $level)
    {
        $parent = $data->firstWhere('id', $user->parent_id);
        $levelCheck = $level;
        if ($parent && $parent->level > $level && $parent->level >= 2) { // từ đại lý trở lên
            array_push($this->resultArrayParentRecusiveLevelMax, $parent);
            $levelCheck = $parent->level;
        }
        if ($parent) {
            $this->recusiveParentToMaxUser($data, $parent, $levelCheck);
        }
    }
    public $resultArrayParentAllRecusive;
    public function recusiveParentAllUser($data, $user)
    {
        $parent = $data->firstWhere('id', $user->parent_id);
        if ($parent) {
            array_push($this->resultArrayParentAllRecusive, $parent);
            $this->recusiveParentAllUser($data, $parent);
        }
    }
    public function isAllLevelThanhVienTo($data, $itemParent)
    {
        $index = collect($data)->search(4);
        if ($index >= 0) {
            $dataCheck = collect($data)->take($index + 1)->all();
            return collect($dataCheck)->where("level", "<", 1)->count() <= 0;
        } else return false;
    }

}
