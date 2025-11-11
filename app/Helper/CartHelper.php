<?php

namespace App\Helper;

use Illuminate\Support\Facades\Auth;

use App\Models\CodeSale;
use DateTime;
use Illuminate\Http\Request;
//use Illuminate\Support\Facades\Session;
class CartHelper
{
    public $cartItems = [];
    public $cartSale = [];
    public $totalQuantity = 0;
    public $totalPrice = 0;
    public $totalOldPrice = 0;
    public $totalPointAccessUse = 0;

    public function __construct()
    {
        // session()->flush();

        $this->cartItems = session()->has('cart') ? session('cart') : [];
        $this->reRenderCartSale();
        //   $this->cartItems = Session::has('cart') ? Session::session('cart') : [];
        $this->totalQuantity = $this->getTotalQuantity();
        $this->totalPrice = $this->getTotalPrice();
        $this->totalOldPrice = $this->getTotalOldPrice();
        $this->totalPointAccessUse = $this->getTotalPointAccessUse();
    }
    public function add($product, $user, $quantity = 1)
    {
        // Kiểm tra sản phẩm thêm vào có `khong_tich_luy_ds`
        if ($product->khong_tich_luy_ds == 1) {
            // Kiểm tra giỏ hàng xem có sản phẩm `khong_tich_luy_ds == 1` chưa
            $hasKhongTichLuy = false;

            foreach ($this->cartItems as $item) {
                if (isset($item['khong_tich_luy_ds']) && $item['khong_tich_luy_ds'] == 1) {
                    $hasKhongTichLuy = true;
                    break;
                }
            }

            if (!$hasKhongTichLuy) {
                // Xóa hết sản phẩm có `khong_tich_luy_ds != 1`
                $this->cartItems = array_filter($this->cartItems, function ($item) {
                    return isset($item['khong_tich_luy_ds']) && $item['khong_tich_luy_ds'] == 1;
                });
            }
        } else {
            // Nếu sản phẩm `khong_tich_luy_ds != 1`, xóa hết sản phẩm có `khong_tich_luy_ds == 1`
            $this->cartItems = array_filter($this->cartItems, function ($item) {
                return !isset($item['khong_tich_luy_ds']) || $item['khong_tich_luy_ds'] != 1;
            });
        }

        if (isset($this->cartItems[$product->id])) {
            $this->cartItems[$product->id]['quantity'] +=  1;
            $this->cartItems[$product->id]['totalPriceOneItem'] = $this->getTotalPriceOneItem($this->cartItems[$product->id]);
            $this->cartItems[$product->id]['totalOldPriceOneItem'] = $this->getTotalOldPriceOneItem($this->cartItems[$product->id]);
        } else {

            $cartItem = [
                'id' => $product->id,
                'price' => $product->price,
                'sale' => $product->sale,
                'name' => $product->name,
                'avatar_path' => $product->avatar_path,
                'sp_khoi_nghiep' => $product->sp_khoi_nghiep ?? 0,
                'quantity' => $quantity,
                'phantramdiem' => $product->phantramdiem ?? 0,
                'is_tinh_diem' => $product->is_tinh_diem ?? 0,
                'is_gia_si' => $product->hot ?? 0,
                'khong_tich_luy_ds' => $product->khong_tich_luy_ds ?? 0,
            ];
            if (is_null($user->parent_all_key)) {
                $cartItem['parent_all_key_user'] = 0;
            } else {
                $cartItem['parent_all_key_user'] = 1;
            }

            $cartItem['totalPriceOneItem'] = $this->getTotalPriceOneItem($cartItem);
            $cartItem['totalOldPriceOneItem'] = $this->getTotalOldPriceOneItem($cartItem);
            $this->cartItems[$product->id] = $cartItem;
        }
        session(['cart' => $this->cartItems]);
        $this->reRenderCartSale();
    }
    public function reRenderCartSale()
    {
        $this->cartSale = session()->has('cartSale') ? session('cartSale') : [
            'product_id' => null,
            'codeSale' => null,
            'value' => 0,
            'valueTinhDiem' => 0,
            'mes' => '',
            'countSale' => 0,
        ];

        if ($this->cartSale['codeSale']) {
            $this->setCartSale($this->cartSale['codeSale']);
        }
    }
    public function setCartSale($code)
    {
        if ($code) {
            $codeSale = new CodeSale();
            $itemMa = $codeSale->where([
                "code" => $code,
                "active" => 1,
            ])->where(function ($query) {
                return $query->whereNull('date_start')->orWhere('date_start', '<=', new DateTime());
            })->where(function ($query) {
                return $query->whereNull('date_end')->orWhere('date_end', '>', new DateTime());
            })->whereColumn('count_use', '<', 'count_sale')->first();
            if ($itemMa) {
                $maxCount = $itemMa->count_sale - $itemMa->count_use;
                $isProduct = false;
                $count = 0;
                $isProductTinhDiem = false;
                if ($this->cartItems) {
                    foreach ($this->cartItems as $cartItem) {
                        if(!isset($itemMa->product_id)){
                                if ($cartItem['is_tinh_diem'] == 1) {
                                    $isProductTinhDiem = true;
                                }
                                $isProduct = true;
                                $count = $cartItem['quantity'];
                        }elseif($cartItem['id'] == $itemMa->product_id) {
                            if ($cartItem['is_tinh_diem'] == 1) {
                                $isProductTinhDiem = true;
                            }
                            $isProduct = true;
                            $count = $cartItem['quantity'];
                        }
                    }
                }
                if ($isProduct || (!$itemMa->product_id && count($this->cartItems) > 0)) {
                    $this->cartSale = [
                        'product_id' => $itemMa->product_id,
                        'codeSale' => $code,
                        'valueTinhDiem' => $isProductTinhDiem ? ($count > $maxCount ? $maxCount : $count) * $itemMa->money : 0,
                        'value' => ($count > $maxCount ? $maxCount : $count) * $itemMa->money,
                        'countSale' => ($count > $maxCount ? $maxCount : $count),
                        'mes' => 'Mã giảm giá ' . number_format(($count > $maxCount ? $maxCount : $count) * $itemMa->money) . 'd',
                    ];
                } else {
                    $this->cartSale = [
                        'product_id' => null,
                        'codeSale' => null,
                        'value' => 0,
                        'valueTinhDiem' => 0,
                        'mes' => '',
                        'countSale' => 0,
                    ];
                }
            } else {
                $this->cartSale = [
                    'product_id' => null,
                    'codeSale' => null,
                    'value' => 0,
                    'valueTinhDiem' => 0,
                    'mes' => '',
                    'countSale' => 0,
                ];
            }
        } else {
            $this->cartSale = [
                'product_id' => null,
                'codeSale' => null,
                'value' => 0,
                'valueTinhDiem' => 0,
                'mes' => '',
                'countSale' => 0,
            ];
        }
        session(['cartSale' => $this->cartSale]);
        // dd($this->cartSale);
    }
    public function remove($id)
    {
        if (isset($this->cartItems[$id])) {
            unset($this->cartItems[$id]);
        }
        // Session::put('cart' , $this->cartItems);
        session(['cart' => $this->cartItems]);
        $this->reRenderCartSale();
    }
    public function update($id, $quantity)
    {
        if (isset($this->cartItems[$id])) {
            $this->cartItems[$id]['quantity'] = $quantity;
            $this->cartItems[$id]['totalPriceOneItem'] = $this->getTotalPriceOneItem($this->cartItems[$id]);
            $this->cartItems[$id]['totalOldPriceOneItem'] = $this->getTotalOldPriceOneItem($this->cartItems[$id]);
        }
        //  Session::put('cart' , $this->cartItems);
        session(['cart' => $this->cartItems]);
        $this->reRenderCartSale();
    }
    public function clear()
    {
        $this->cartItems = [];
        session()->forget('cart');
        session()->forget('cartSale');
    }
    public function getTotalPriceOneItem($item)
    {
        $t = 0;
        $t +=  $item['price'] * (100 - $item['sale']) / 100 * $item['quantity'];
        return $t;
    }
    public function getTotalOldPriceOneItem($item)
    {
        $t = 0;
        $t +=  $item['price']  * $item['quantity'];
        return $t;
    }
    public function getTotalPrice()
    {
        $tP = 0;
        $tP2 = 0;
        if ($this->cartItems) {
            foreach ($this->cartItems as $cartItem) {
                if ($cartItem['sale'] > 0) {

                    $price = $cartItem['price'] * ((100 - $cartItem['sale']) / 100) * $cartItem['quantity'];

                    $totalPrice = $price;
                    $tP2 = $cartItem['is_tinh_diem'];

                    if ($tP2 == 0) {

//                        $tP += $price - ($totalPrice * $cartItem['phantramdiem']/ 100);
                        $tP += $price;

                    } else {

//                        $tP += $price - ($totalPrice * getPhanTramGiamGiaLevel(optional(auth()->user())->level) / 100);
                        $tP += $price;
                    }


                } else {

                    $price = $cartItem['price'] * $cartItem['quantity'];
                    $totalPrice = $price;
                    $tP2 = $cartItem['is_tinh_diem'];

                    if ($tP2 == 0) {

//                        $tP += $price - ($totalPrice * $cartItem['phantramdiem']/ 100);
                        $tP += $price;

                    } else {

//                        $tP += $price - ($totalPrice * getPhanTramGiamGiaLevel(optional(auth()->user())->level) / 100);
                        $tP += $price;
                    }

                }
            }
        }
        if ($this->cartSale["value"] > 0) {
            $tP = $tP - $this->cartSale["value"];
        }


        return $tP;
    }
    public function getTotalPriceTinhDiem()
    {
        $tP = 0;
        $tP2 = 0;

        if ($this->cartItems) {
            foreach ($this->cartItems as $cartItem) {
                if ($cartItem['is_tinh_diem'] == 1) {
                    $tP +=  $cartItem['price'] * (100 - $cartItem['sale']) / 100 * $cartItem['quantity'];
                }
            }
        }
        if ($this->cartSale["valueTinhDiem"] > 0) {
            $tP = $tP - $this->cartSale["valueTinhDiem"];
        }
        $tP = $tP > 0 ? $tP : 0;
        // if (getPhanTramGiamGiaLevel(optional(auth()->user())->level) > 0) {
        //     $tP = (100 - getPhanTramGiamGiaLevel(optional(auth()->user())->level)) * $tP / 100;
        // }
        //dd(getPhanTramGiamGiaLevel(optional(auth()->user())->level, $tP2) > 0);
        if (getPhanTramGiamGiaLevel(optional(auth()->user())->level, $tP2) > 0) {
            $tP = (100 - getPhanTramGiamGiaLevel(optional(auth()->user())->level, $tP2)) * $tP / 100;
        }
        // if ($this->cartItems) {
        //     foreach ($this->cartItems as $cartItem) {
        //         if($cartItem['parent_all_key_user'] == 0){
        //             $tP = 0;
        //         }
        //     }
        // }
        
        return $tP;
    }

    public function getTotalOldPrice()
    {
        $tP = 0;
        if ($this->cartItems) {
            foreach ($this->cartItems as $cartItem) {
                $tP +=  $cartItem['price']  * $cartItem['quantity'];
            }
        }
        return $tP;
    }

    public function getTotalQuantity()
    {
        $tQ = 0;
        foreach ($this->cartItems as $cartItem) {
            $tQ += $cartItem['quantity'];
        }
        return $tQ;
    }

//     public function getTotalPointAccessUse()
//     {
//         $tP = 0;
//         $tP2 = 0;
//         $totalPrice = 0;

//         $totalTP = 0; // Initialize totalTP to accumulate the total points
//         $totalPrice = 0; // Initialize totalPrice

//         if (Auth::check()) {
// //            if (Auth::user()->level > 0) {
//                 if ($this->cartItems) {
//                     foreach ($this->cartItems as $cartItem) {
//                         // Nếu sp_khoi_nghiep tồn tại và = 1 thì BỎ QUA (không tính điểm)
//                         if ( $cartItem['sp_khoi_nghiep'] == 1) {
//                             continue;
//                         }
//                         if ($cartItem['sale'] > 0) {

//                             $price = $cartItem['price'] * ((100 - $cartItem['sale']) / 100) * $cartItem['quantity'];
//                             $totalPrice = $price;
//                             $tP2 = $cartItem['is_tinh_diem'];


//                             if ($tP2 == 0) {

//                                 $tP += $totalPrice * (($cartItem['phantramdiem']) / 100);

//                             } else {

//                                 $tP += $totalPrice * getPhanTramGiamGiaLevel(optional(auth()->user())->level) / 100;
//                             }


//                         } else {

//                             $price = $cartItem['price'] * $cartItem['quantity'];
//                             $totalPrice = $price;
//                             $tP2 = $cartItem['is_tinh_diem'];

//                             if ($tP2 == 0) {

//                                 $tP += $totalPrice * $cartItem['phantramdiem']/ 100;

//                             } else {

//                                 $tP += $totalPrice * getPhanTramGiamGiaLevel(optional(auth()->user())->level) / 100;
//                             }

//                         }

//                     }

//                 }


//                 if ($this->cartSale["value"] > 0) {
//                     $tP = $tP - $this->cartSale["value"];
//                 }
//                 $tP = $tP > 0 ? $tP : 0;
// //            }
//         }
//         $tP = $tP / getConfigBB();
//         return $tP;
//     }


public function getTotalPointAccessUse()
{
    $totalPoint = 0;

    if (Auth::check()) {
        $user = Auth::user();

        // Chỉ cho phép tính điểm khi level > 0
        if ($user->level > 0 && $this->cartItems) {

            foreach ($this->cartItems as $cartItem) {

                // Nếu là sản phẩm khởi nghiệp thì bỏ qua
                if (!empty($cartItem['sp_khoi_nghiep']) && $cartItem['sp_khoi_nghiep'] == 1) {
                    continue;
                }

                // Tính giá sau giảm (nếu có)
                $price = $cartItem['price'];
                if (!empty($cartItem['sale']) && $cartItem['sale'] > 0) {
                    $price *= (100 - $cartItem['sale']) / 100;
                }

                // Nhân số lượng
                $totalPrice = $price * $cartItem['quantity'];

                // Tính điểm theo phần trăm riêng của sản phẩm
                $phanTramDiem = !empty($cartItem['phantramdiem']) ? $cartItem['phantramdiem'] : 0;
                $totalPoint += $totalPrice * ($phanTramDiem / 100);
            }

            // Nếu có giảm giá toàn giỏ hàng thì trừ đi
            if (!empty($this->cartSale["value"]) && $this->cartSale["value"] > 0) {
                $totalPoint -= $this->cartSale["value"];
            }

            // Không để âm
            $totalPoint = max(0, $totalPoint);
        }
    }

    // Chia theo hệ số quy đổi điểm
    return $totalPoint / getConfigBB();
}

}
