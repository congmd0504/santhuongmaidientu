<?php
// tạo link
use App\Models\Setting;
use App\Helper\CartHelper;

function makeLink($type, $id = null, $slug = null, $request = [])
{
    $route = "";
    switch ($type) {
        case 'category_products':
            $route = route("product.productByCategory", ["id" => $id, "slug" => $slug]);
            break;
        case 'category_posts':
            $route = route("post.postByCategory", ["id" => $id, "slug" => $slug]);
            break;
        case 'post':
            $route = route("post.detail", ["id" => $id, "slug" => $slug]);
            break;
        case 'post_all':
            $route = route("post.index");
            break;
        case 'product':
            $route = route("product.detail", ["id" => $id, "slug" => $slug]);
            break;
        case 'product_all':
            $route = route("product.index");
            break;
        case 'home':
            $route = route("home.index");
            break;
        case 'about-us':
            $route = route("about-us");
            break;
        case 'contact':
            $route = route("contact.index");
            break;
        case 'search':
            $route = route("home.search", $request);
            break;
        default:
            $route = route("home.index");
            break;
    }
    return $route;
}


function menuRecusive($model, $id, $result = array(), $i = 0)
{
    //  global $result;
    $i++;
    $data = $model->select(['id', 'name', 'slug'])->where('active', 1)->find($id)->setAppends(['slug_full']);
    $item = $data->toArray();
    // dd($item);
    $childs =  $data->childs()->where('active', 1)->select(['id', 'name', 'slug'])->get();
    foreach ($childs as $child) {
        //  $res  = $child->setAppends(['slug'])->toArray();

        $res =  menuRecusive($model, $child->id, []);
        // dd( $res );
        $item['childs'][] = $res;
        //   dd($item);
    }
    //  dd($result);
    // array_push($result, $item);
    return $item;
}

// quy đổi tiền sang điểm
function moneyToPoint($money)
{
    $money = (int)$money;
    return $money / getConfigBB();
}
function getValueConfigLenDaiLy()
{
    $setting = new Setting();
    return $setting->find(87)->value;
}
function getLevel($user, $money)
{
     $setting = new Setting();
    $listSetting = $setting->where('parent_id', 115)->get();

    $setLv1 = optional($listSetting->find(118))->value ?? 0;
    $setLv2 = optional($listSetting->find(135))->value ?? 0;
    $setLv3 = optional($listSetting->find(136))->value ?? 0;
    $setLv4 = optional($listSetting->find(137))->value ?? 0;
    // $setLv4 = optional($listSetting->find(119))->value ?? 0;
    // $setLv5 = optional($listSetting->find(120))->value ?? 0;

    // Cập nhật cơ chế: chỉ tính doanh số cá nhân để lên cấp (8/2/2024)
    $currentMoney = $user->total_money + $money;
    $level = 0;

    // Xác định cấp độ theo mốc doanh số
    if ($currentMoney >= $setLv4) {
        $level = 4;
    } elseif ($currentMoney >= $setLv3) {
        $level = 3;
    } elseif ($currentMoney >= $setLv2) {
        $level = 2;
    } elseif ($currentMoney >= $setLv1) {
        $level = 1;
    }

    // Giữ nguyên cấp nếu cấp hiện tại cao hơn
    if ($user->level > $level) {
        $level = $user->level;
    }

    //Thưởng cấp BB
    // $thuongCap = $user->thuong_cap;

    // if($level > $thuongCap){
    //     $typePoint = config('point.typePoint');
    //     $thanhTien = getConfigBB();//1BB = 1000
    //     if ($level == 5) {

    //         $user->points()->create([
    //             'type' => $typePoint[20]['type'],
    //             'point' => 200000 * $thanhTien,
    //             'active' => 1,
    //             'userorigin_id' => $user->id,
    //         ]);
    //         $dataUserUpdateCap = [
    //             "thuong_cap" => $level,
    //         ];
    //         $user->update($dataUserUpdateCap);

    //     } else if ($level == 4) {

    //         $user->points()->create([
    //             'type' => $typePoint[20]['type'],
    //             'point' => 75000 * $thanhTien,
    //             'active' => 1,
    //             'userorigin_id' => $user->id,
    //         ]);
    //         $dataUserUpdateCap = [
    //             "thuong_cap" => $level,
    //         ];
    //         $user->update($dataUserUpdateCap);

    //     } else if ($level == 3) {

    //         $user->points()->create([
    //             'type' => $typePoint[20]['type'],
    //             'point' => 22000 * $thanhTien,
    //             'active' => 1,
    //             'userorigin_id' => $user->id,
    //         ]);
    //         $dataUserUpdateCap = [
    //             "thuong_cap" => $level,
    //         ];
    //         $user->update($dataUserUpdateCap);

    //     } else if ($level == 2) {

    //         $user->points()->create([
    //             'type' => $typePoint[20]['type'],
    //             'point' => 10000 * $thanhTien,
    //             'active' => 1,
    //             'userorigin_id' => $user->id,
    //         ]);
    //         $dataUserUpdateCap = [
    //             "thuong_cap" => $level,
    //         ];
    //         $user->update($dataUserUpdateCap);

    //     } else  if ($level == 1) {

    //         $user->points()->create([
    //             'type' => $typePoint[20]['type'],
    //             'point' => 2000 * $thanhTien,
    //             'active' => 1,
    //             'userorigin_id' => $user->id,
    //         ]);
    //         $dataUserUpdateCap = [
    //             "thuong_cap" => $level,
    //         ];
    //         $user->update($dataUserUpdateCap);
    //     }
    // }

    return $level;
}
function getTenLevel($level)
{
    switch ($level) {
        case 0:
            return "Khách hàng mới";
            break;
        case 1:
            return "Người tiêu dùng thông minh"; // Thành viên
            break;
        case 2:
            return "Khởi nghiệp";
            break;
        case 3:
            return "Quản lý"; // Giám đốc TT
            break;
        case 4:
            return "Giám đốc vùng";
            break;
        default:
            return "";
            break;
    }
}
function getMotaLevel($level)
{
    switch ($level) {
        case 0:
            return "Doanh số cá nhân đạt 5 triệu để lên thành viên Khởi Nghiệp";
            break;
        default:
            return "";
            break;
    }
}

function getPhanTramGiamGiaLevel($level)
{
    $setting = new Setting();
    $listSetting = $setting->where('parent_id', 103)->get();
    $setLv0 = optional($listSetting->find(104))->value ?? 0;
    $setLv1 = optional($listSetting->find(105))->value ?? 0;
    $setLv2 = optional($listSetting->find(106))->value ?? 0;
    $setLv3 = optional($listSetting->find(107))->value ?? 0;
    $setLv4 = optional($listSetting->find(108))->value ?? 0;

    switch ($level) {
        case 0:
            return $setLv0;
            break;
        case 1:
            return $setLv1;
            break;
        case 2:
            return $setLv2;
            break;
        case 3:
            return $setLv3;
            break;
        case 4:
            return $setLv4;
            break;
        default:
            return 0;
            break;
    }
}

function getPhanTramMotaGiamGiaLevel($level)
{
    $setting = new Setting();
    $listSetting = $setting->where('parent_id', 103)->get();
    $setLv0 = optional($listSetting->find(104))->value ?? 0;
    $setLv1 = optional($listSetting->find(105))->value ?? 0;
    $setLv2 = optional($listSetting->find(106))->value ?? 0;
    $setLv3 = optional($listSetting->find(107))->value ?? 0;
    $setLv4 = optional($listSetting->find(108))->value ?? 0;

    switch ($level) {
        case 0:
           return "Bạn được chi trả " . $setLv0 . "% bằng ví KTG các sản phẩm tích lũy Vì đang ở là khách hàng mới";
            break;
        case 1:
            return "Bạn được chi trả " . $setLv1 . "% bằng ví KTG các sản phẩm tích lũy vì đang là Người tiêu dùng thông minh";
            break;
        case 2:
            return "Bạn được chi trả " . $setLv2 . "% bằng ví KTG các sản phẩm tích lũy vì đang là Khởi Nghiệp";
            break;
        case 3:
            return "Bạn được chi trả " . $setLv3 . "% bằng ví KTG các sản phẩm tích lũy vì đang là Quản lý";
            break;
        case 4:
            return "Bạn được chi trả " . $setLv4 . "% bằng ví KTG các sản phẩm tích lũy vì đang là Giám đốc vùng";
            break;
           
        default:
            return "";
            break;
    }
}

function getThuongNhom($level, $ds, $money)
{
    if ($level <= 0) {
        return [];
    }
    $phantram = 0;
    $result = [];
    $totalDSNAndMoney = $ds + $money;
    switch (true) {
        case $level >= 4:
            if ($totalDSNAndMoney >= 2500 * 1000000) {
                if ($ds >= 2500 * 1000000) {
                    array_push($result, ["value" => $money, "phantram" => 14]);
                } else {
                    array_push($result, ["value" => $totalDSNAndMoney - 2500 * 1000000, "phantram" => 14]);
                    array_push($result, ["value" => 2500 * 1000000 - $ds, "phantram" => 12]);
                }
            } else {
                array_push($result, ["value" => $money, "phantram" => 12]);
            }
            break;
        case $level >= 3:
            if ($totalDSNAndMoney >= 2500 * 1000000) {
                if ($ds >= 2500 * 1000000) {
                    array_push($result, ["value" => $money, "phantram" => 14]);
                } else if ($ds >= 500 * 1000000) {
                    array_push($result, ["value" => $totalDSNAndMoney - 2500 * 1000000, "phantram" => 14]);
                    array_push($result, ["value" => 2500 * 1000000 - $ds, "phantram" => 12]);
                } else {
                    array_push($result, ["value" => $totalDSNAndMoney - 2500 * 1000000, "phantram" => 14]);
                    array_push($result, ["value" => 2500 * 1000000 - 500 * 1000000, "phantram" => 12]);
                    array_push($result, ["value" => 500 * 1000000 - $ds, "phantram" => 10]);
                }
            } else if ($totalDSNAndMoney >= 500 * 1000000) {
                if ($ds >= 500 * 1000000) {
                    array_push($result, ["value" => $money, "phantram" => 12]);
                } else {
                    array_push($result, ["value" => $totalDSNAndMoney - 500 * 1000000, "phantram" => 12]);
                    array_push($result, ["value" => 500 * 1000000 - $ds, "phantram" => 10]);
                }
            } else {
                array_push($result, ["value" => $money, "phantram" => 10]);
            }
            break;
        case $level >= 2:
            if ($totalDSNAndMoney >= 2500 * 1000000) {
                if ($ds >= 2500 * 1000000) {
                    array_push($result, ["value" => $money, "phantram" => 14]);
                } else if ($ds >= 500 * 1000000) {
                    array_push($result, ["value" => $totalDSNAndMoney - 2500 * 1000000, "phantram" => 14]);
                    array_push($result, ["value" => 2500 * 1000000 - $ds, "phantram" => 12]);
                } else if ($ds >= 50 * 1000000) {
                    array_push($result, ["value" => $totalDSNAndMoney - 2500 * 1000000, "phantram" => 14]);
                    array_push($result, ["value" => 2500 * 1000000 - 500 * 1000000, "phantram" => 12]);
                    array_push($result, ["value" => 500 * 1000000 - $ds, "phantram" => 10]);
                } else {
                    array_push($result, ["value" => $totalDSNAndMoney - 2500 * 1000000, "phantram" => 14]);
                    array_push($result, ["value" => 2500 * 1000000 - 500 * 1000000, "phantram" => 12]);
                    array_push($result, ["value" => 500 * 1000000 - 50 * 1000000, "phantram" => 10]);
                    array_push($result, ["value" => 50 * 1000000 - $ds, "phantram" => 8]);
                }
            } else if ($totalDSNAndMoney >= 500 * 1000000) {
                if ($ds >= 500 * 1000000) {
                    array_push($result, ["value" => $money, "phantram" => 12]);
                } else if ($ds >= 50 * 1000000) {
                    array_push($result, ["value" => $totalDSNAndMoney - 500 * 1000000, "phantram" => 12]);
                    array_push($result, ["value" => 500 * 1000000 - $ds, "phantram" => 10]);
                } else {
                    array_push($result, ["value" => $totalDSNAndMoney - 500 * 1000000, "phantram" => 12]);
                    array_push($result, ["value" => 500 * 1000000 - 50 * 1000000, "phantram" => 10]);
                    array_push($result, ["value" => 50 * 1000000 - $ds, "phantram" => 8]);
                }
            } else if ($totalDSNAndMoney >= 50 * 1000000) {
                if ($ds >= 50 * 1000000) {
                    array_push($result, ["value" => $money, "phantram" => 10]);
                } else {
                    array_push($result, ["value" => $totalDSNAndMoney - 50 * 1000000, "phantram" => 10]);
                    array_push($result, ["value" => 50 * 1000000 - $ds, "phantram" => 8]);
                }
            } else {
                array_push($result, ["value" => $money, "phantram" => 8]);
            }
            break;
        default:
            # code...
            break;
    }
    // if ($totalDSNAndMoney >= 2500 * 1000000) {
    //     if ($ds >= 2500 * 1000000) {
    //         array_push($result, ["value" => $money, "phantram" => 14]);
    //     } else if ($ds >= 500 * 1000000) {
    //         array_push($result, ["value" => $totalDSNAndMoney - 2500 * 1000000, "phantram" => 14]);
    //         array_push($result, ["value" => 2500 * 1000000 - $ds, "phantram" => 12]);
    //     } else if ($ds >= 50 * 1000000) {
    //         array_push($result, ["value" => $totalDSNAndMoney - 2500 * 1000000, "phantram" => 14]);
    //         array_push($result, ["value" => 2500 * 1000000 - 500 * 1000000, "phantram" => 12]);
    //         array_push($result, ["value" => 500 * 1000000 - $ds, "phantram" => 10]);
    //     } else {
    //         array_push($result, ["value" => $totalDSNAndMoney - 2500 * 1000000, "phantram" => 14]);
    //         array_push($result, ["value" => 2500 * 1000000 - 500 * 1000000, "phantram" => 12]);
    //         array_push($result, ["value" => 500 * 1000000 - 50 * 1000000, "phantram" => 10]);
    //         array_push($result, ["value" => 50 * 1000000 - $ds, "phantram" => 8]);
    //     }
    // } else if ($totalDSNAndMoney >= 500 * 1000000) {
    //     if ($ds >= 500 * 1000000) {
    //         array_push($result, ["value" => $money, "phantram" => 12]);
    //     } else if ($ds >= 50 * 1000000) {
    //         array_push($result, ["value" => $totalDSNAndMoney - 500 * 1000000, "phantram" => 12]);
    //         array_push($result, ["value" => 500 * 1000000 - $ds, "phantram" => 10]);
    //     } else {
    //         array_push($result, ["value" => $totalDSNAndMoney - 500 * 1000000, "phantram" => 12]);
    //         array_push($result, ["value" => 500 * 1000000 - 50 * 1000000, "phantram" => 10]);
    //         array_push($result, ["value" => 50 * 1000000 - $ds, "phantram" => 8]);
    //     }
    // } else if ($totalDSNAndMoney >= 50 * 1000000) {
    //     if ($ds >= 50 * 1000000) {
    //         array_push($result, ["value" => $money, "phantram" => 10]);
    //     } else {
    //         array_push($result, ["value" => $totalDSNAndMoney - 50 * 1000000, "phantram" => 10]);
    //         array_push($result, ["value" => 50 * 1000000 - $ds, "phantram" => 8]);
    //     }
    // } else {
    //     array_push($result, ["value" => $money, "phantram" => 8]);
    // }

    // if ($level == 1) {
    //     if ($ds < 50 * 1000000) {
    //         $phantram = 8;
    //     } else {
    //         $phantram = 10;
    //     }
    // } else if ($level == 2) {
    //     if ($ds < 500 * 1000000) {
    //         $phantram = 10;
    //     } else {
    //         $phantram = 12;
    //     }
    // } else if ($level == 3) {
    //     if ($ds < 2.5 * 1000000) {
    //         $phantram = 12;
    //     } else {
    //         $phantram = 14;
    //     }
    // }
    // dd($phantram, $level, $ds, $money);
    // return $phantram * $money / 100;
    return $result;
}
function pointToMoney($point)
{
    return (float)$point * getConfigBB();
}
function makeCodeTransaction($transaction)
{
    $code = 'mgd-' . date('Y-m-d-h-s-m');
    //  dd($code);
    while ($transaction->where([
        'code' => $code,
    ])->exists()) {
        $code = 'mgd-' . date('Y-m-d-h-s-m') . rand(1, 1000);
    }
    return $code;
}
function makeCodeUser($user)
{

    $code =   bin2hex(random_bytes(10));
    // dd($code);
    while ($user->where([
        'code' => $code,
    ])->exists()) {
        $code =  bin2hex(random_bytes(10));
    }
    return $code;
}

function getKYCNhanThuong()
{
    $setting = new Setting();
    return $setting->find(88)->value ?? 0;
}

function getPhanTramTangDiemMuaHang($money)
{
    $setting = new Setting();
    $listConfig = $setting->where("parent_id", 89)->get();
    if ($money < 1000000) {
        $item = $listConfig->first(function ($value, $key) {
            return $value->id == 90;
        });
        return $item->value ?? 0;
    } else if ($money < 5000000) {
        $item = $listConfig->first(function ($value, $key) {
            return $value->id == 91;
        });
        return $item->value ?? 0;
    } else if ($money < 20000000) {
        $item = $listConfig->first(function ($value, $key) {
            return $value->id == 92;
        });
        return $item->value ?? 0;
    } else if ($money < 50000000) {
        $item = $listConfig->first(function ($value, $key) {
            return $value->id == 93;
        });
        return $item->value ?? 0;
    } else {
        $item = $listConfig->first(function ($value, $key) {
            return $value->id == 94;
        });
        return $item->value ?? 0;
    }
}
//Hoa hồng tái tiêu dùng
function handlerAddPointByLevel($userNap, $userPoint, $totalPoint)
{
    $setting = new Setting();
    $listSetting = $setting->where('parent_id', 103)->get();
    $setLv1 = optional($listSetting->find(104))->value ?? 0;
    $setLv2 = optional($listSetting->find(105))->value ?? 0;
    $setLv3 = optional($listSetting->find(106))->value ?? 0;
    $setLv4 = optional($listSetting->find(107))->value ?? 0;
    $setLv5 = optional($listSetting->find(108))->value ?? 0;

    $level = $userPoint->level;
    $phantram = 0;
    if ($level == 1) {
        // thuong hang đồng
        $phantram = $setLv1;
    } else if ($level == 2) {
        // thuong hang bac
        $phantram = $setLv2;
    } else if ($level == 3) {
        // thuong hang vang
        $phantram = $setLv3;
    } else if ($level == 4) {
        // thuong hang kim cuong
        $phantram = $setLv4;
    } else if ($level == 5) {
        // thuong hang vip
        $phantram = $setLv5;
    } else {
        return;
    }
    $userPoint->points()->createMany([
        [
            'type' => config("point.typePoint")[17]['type'],
            'point' => $phantram * $totalPoint / 100 * getConfigBB(),
            'active' => 1,
            'userorigin_id' => $userNap->id,
            'point_id' => null,
            'phantram' => null,
        ]
    ]);
    handlerAddPointDoanhSoNhom($userNap, $userPoint, $totalPoint);
}
function handlerAddPointDoanhSoNhom($userNap, $userPoint, $totalPoint)
{
    $level = $userPoint->level;
//    if ($level < 1) {
//        return;
//    }
    $userPoint->points()->createMany([
        // doanh số nhóm cuối tháng
        [
            'type' => config("point.typePoint")[18]['type'],
            'point' => 5 * $totalPoint / 100 * getConfigBB(),
            'active' => 0,
            'userorigin_id' => $userNap->id,
            'point_id' => null,
            'phantram' => null,
        ],
        // doanh số nhóm cuối năm
        [
            'type' => config("point.typePoint")[19]['type'],
            'point' => 1 * $totalPoint / 100 * getConfigBB(),
            'active' => 0,
            'userorigin_id' => $userNap->id,
            'point_id' => null,
            'phantram' => null,
        ],
    ]);
}
function getNameLevel($level)
{
    try {
        return config("point.level")[$level];
    } catch (\Exception $ex) {
        return "Chưa có hạng";
    }
}
function getDs($user)
{
    //return $user->total_money_group + $user->total_money;
    //Chỉ lấy ds cá nhân
    return $user->total_money;
}

function getConfigBB()
{
    $setting = new Setting();
    return $setting->find(121)->value ?? 0;
}
function getConfigWallet()
{
    $setting = new Setting();
    return $setting->find(133)->value ?? 0;
}
function getConfigGift()
{
    $setting = new Setting();
    return $setting->find(134)->value ?? 0;
}

function configTotalOrder()
{
    $setting = new Setting();
    return $setting->find(140)->value ?? 0;
}
function configPersentKTG()
{
    $setting = new Setting();
    return $setting->find( 139)->value ?? 0;
}
function configPersentLoiNhuan()
{
    $setting = new Setting();
    return $setting->find( 138)->value ?? 0;
}
function configPersentDoanhThu()
{
    $setting = new Setting();
    return $setting->find( 141)->value ?? 0;
}
function configPersentRutVi()
{
    $setting = new Setting();
    return $setting->find( 144)->value ?? 0;
}
function configMinRutVi()
{
    $setting = new Setting();
    return $setting->find( 145)->value ?? 0;
}


