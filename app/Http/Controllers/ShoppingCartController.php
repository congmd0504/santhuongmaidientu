<?php

namespace App\Http\Controllers;

use App\Helper\CartHelper;
use App\Models\Order;
use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Point;
use App\Models\City;
use App\Models\District;
use App\Models\Commune;

use App\Helper\AddressHelper;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Requests\Frontend\ValidateAddOrder;
use App\Http\Requests\Frontend\ValidateUpdateOrder;
use App\Models\CodeSale;
use App\Models\Setting;

class ShoppingCartController extends Controller
{
    //

    private $product;
    private $point;
    private $order;
    private $cart;
    private $city;
    private $district;
    private $commune;
    private $transaction;
    private $unit;
    private $pointUnit;
    private $setting;
    private $typePoint;
    private $codeSale;
    public function __construct(
        Product $product,
        City $city,
        District $district,
        Commune $commune,
        Order $order,
        Transaction $transaction,
        Setting $setting,
        Point $point,
        CodeSale $codeSale
    ) {
        $this->product = $product;
        $this->point = $point;
        $this->order = $order;
        $this->city = $city;
        $this->district = $district;
        $this->commune = $commune;
        $this->transaction = $transaction;
        $this->setting = $setting;
        $this->codeSale = $codeSale;
        $this->unit = "đ";
        $this->pointUnit = config('point.pointUnit');
        $this->typePoint = config('point.typePoint');
    }
    public function list(Request $request)
    {
        $numberPoint = 0;
        $address = new AddressHelper();
        $data = $this->city->orderby('name')->get();
        $cities = $address->cities($data);
        $this->cart = new CartHelper();
        $data = $this->cart->cartItems;
        //  dd($data);
        $totalPrice =  $this->cart->getTotalPrice();
        $totalQuantity =  $this->cart->getTotalQuantity();
        $totalOldPrice = $this->cart->getTotalOldPrice();
        $totalPointAccessUse = $this->cart->getTotalPointAccessUse();

        $totalPriceMoney = $totalPrice;

        $totalPricePoint = 0;
        $infoCart = $this->setting->find(83);

        $numberPoint = old('usePoint') ?? 0;
        if ($numberPoint <= 0) {
            $numberPoint = $totalPrice;
            $pointaccess = $this->cart->getTotalPointAccessUse() ?? 0;
            $sumpointMhCurrent = $this->point->sumPointMuaHangCurrent(auth()->user()->id) ?? 0;

            if ($numberPoint > $pointaccess) {
                $numberPoint = $pointaccess;
            }
            if ($numberPoint > $sumpointMhCurrent) {
                $numberPoint = $sumpointMhCurrent;
            }
        }


        //Nếu giá trị bb mua đơn hàng > 0
        if ($numberPoint > 0) {
            $user = auth()->guard('web')->user();

            //TỔNG SỐ D TRONG VÍ BB
            $sumPointCurrent = $this->point->sumPointMuaHangCurrent($user->id);
            //CHUYỂN VNĐ SANG BB 1BB = 1000
            $sumPointCurrent = $sumPointCurrent / getConfigBB();

            // $numberPoint: BB CHI TRẢ CỦA ĐƠN HÀNG
            if ($numberPoint) {
                //Nu BB đơn hàng  >  Số dư BB trong ví
                if ($numberPoint > $sumPointCurrent) {
                    $totalPriceMoney = $totalPrice;
                    $totalPricePoint = 0;
                } elseif (pointToMoney($numberPoint) > $totalPrice) {
                    $totalPriceMoney = $totalPrice;
                    $totalPricePoint = 0;
                } else {
                    $totalPriceMoney = $totalPrice - $numberPoint * getConfigBB();
                    $totalPricePoint = $numberPoint;
                }
            } else {
                $totalPriceMoney = $totalPrice;
                $totalPricePoint = 0;
            }

        } else {

            //Tổng giá trị đơn hàng sau khi trừ bb
            $totalPriceMoney = $totalPrice - pointToMoney($numberPoint);
            $totalPricePoint = $numberPoint;
        }




        $user = auth()->guard('web')->user();
        $sumPointCurrent = $this->point->sumPointMuaHangCurrent($user->id);
        //CHUYỂN VNĐ SANG BB 1BB = 1000
        $sumPointCurrent = $sumPointCurrent / getConfigBB();
        // dd($this->cart->cartItems);
        $cartSale = $this->cart->cartSale;

        //Cộng lại giá trị đn hàng khi ví BB không đủ sẽ thanh toán bằng ví vnd hoặc tiền mặt
        $sumPointCurrent = round($sumPointCurrent); // Số dư trong ví BB
        // Nếu số (DƯ VÍ BB) > (BB CẦN MUA HÀNG) thì giữ nguyên tổng đơn hàng
        if($sumPointCurrent > $totalPointAccessUse || $sumPointCurrent == $totalPointAccessUse){
            $totalPrice = $totalPrice;
        }elseif ($sumPointCurrent < $totalPointAccessUse){
//            $BBCong = ($totalPointAccessUse - $sumPointCurrent) * config("point.typePoint.pointReward");
//            $totalPrice = $totalPrice + $BBCong;
            $totalPriceMoney = $totalPrice - ($sumPointCurrent * getConfigBB());
            //Cộng số tiền mặt cần trả
//            $totalPriceMoney = $totalPriceMoney + $BBCong;
        }

        // $totalPriceMoney: Số tiền phải trả sau khi trừ ví BB
        //TỔNG SỐ DƯ TRONG VÍ VNĐ

        $user = auth()->guard('web')->user();
        $sumEachTypeData = collect($this->point->sumEachTypeFrontend($user->id));

        //Kiểm tra xem c phải là sản phẩm không tích lũy không
        $checkSPTichLuy = reset($this->cart->cartItems);
        if($checkSPTichLuy){
            $checkSPTichLuy = $checkSPTichLuy['khong_tich_luy_ds'];
        }
        if($checkSPTichLuy == 1){
            //Nếu là đơn hàng ca sản phẩm không tích lũy thì trừ 20% trong số tổng hoa hồng được nhận
            $total20PhanTramDuocMua = $sumEachTypeData->whereIn('type', config("point.tonghoahongnhanduoc"))->sum('total') * 0.2;
            $total20PhanTramDaMua = $sumEachTypeData->whereIn('type', config("point.listTypePointDiem20PhanTram"))->sum('total');
            $totalViVNĐ = $total20PhanTramDuocMua - (-$total20PhanTramDaMua);
        }else{
            //Nếu là sản phẩm bình thường thì chạy luồng bình thường
            $totalViVNĐ = $sumEachTypeData->whereIn('type', config("point.listTypePointDiemThuong"))->sum('total');
        }
        // tạm cmt $totalViVNĐ = $sumEachTypeData->whereIn('type', config("point.listTypePointDiemThuong"))->sum('total');

        //Nếu số dư trong ví vnđ > 0 thì trừ ở ví vnđ trưc
        $totalViVndTra = 0;
        if($totalViVNĐ > 0) { //
            if($totalViVNĐ > $totalPriceMoney || $totalViVNĐ == $totalPriceMoney) {
                $totalViVnddu = $totalViVNĐ - $totalPriceMoney;
                $totalViVndTra = $totalViVNĐ - $totalViVnddu;
                $totalPriceMoney = 0;
            }else{
                $totalViVnddu = $totalViVNĐ;
                $totalViVndTra = $totalViVnddu;
                $totalPriceMoney =  $totalPriceMoney - $totalViVNĐ;
            }
        }


        $totalPriceCart = 0;
        foreach ($data as $totalPriceCarts){
            $totalPriceCart += $totalPriceCarts['totalPriceOneItem'];
        }
        $totalPrice = $totalPriceCart;
        //dump($totalPrice, $sumPointCurrent * config("point.typePoint.pointReward"));
        //$totalPrice = $totalPrice + ($totalPointAccessUse * config("point.typePoint.pointReward"));

        return view('frontend.pages.cart', [
            'data' => $data,
            'cities' => $cities,
            'totalPrice' => $totalPrice,
            'cartSale' => $cartSale,
            'totalQuantity' => $totalQuantity,
            'totalOldPrice' => $totalOldPrice,
            'unit' => $this->unit,
            'sumPointCurrent' => $sumPointCurrent,
            'totalPriceMoney' => $totalPriceMoney,
            'totalPricePoint' => $totalPricePoint,
            'totalViVNĐ' => $totalViVNĐ,
            'totalPointAccessUse' => $totalPointAccessUse,
            'pointUnit' => $this->pointUnit,
            'usePoint' => $numberPoint,
            'infoCart' => $infoCart,
            'totalViVndTra' => $totalViVndTra,
        ]);
    }

    public function add($id)
{
    $this->cart = new CartHelper();
    $user = auth()->guard('web')->user();
    $product = $this->product->find($id);
    // Kiểm tra sản phẩm có tồn tại
    if (!$product) {
        return response()->json([
            'code' => 404,
            'message' => 'Sản phẩm không tồn tại.'
        ], 404);
    }

    $this->cart->add($product, $user);

    return response()->json([
        'code' => 200,
        'message' => 'success'
    ], 200);
}

    public function buy($id)
    {
        $this->cart = new CartHelper();
        $user = auth()->guard('web')->user();

        $product = $this->product->find($id);

        $this->cart->add($product, $user);
        //  dd($this->cart->cartItems);
        return redirect()->route("cart.list");
    }
    public function remove($id, Request $request)
    {
        $user = auth()->guard('web')->user();
        //SỐ DƯ TRONG VÍ BB
        $sumPointCurrent = $this->point->sumPointMuaHangCurrent($user->id);




        $this->cart = new CartHelper();
        $data = $this->cart->cartItems;
        $this->cart->remove($id);
        $totalPrice =  $this->cart->getTotalPrice();
        $totalQuantity =  $this->cart->getTotalQuantity();

        $totalOldPrice =  $this->cart->getTotalOldPrice();
        $totalPointAccessUse = $this->cart->getTotalPointAccessUse();
        //    dd( $totalOldPrice);
        $numberPoint = 0;
        $errorNumberPoint = false;
        if ($request->has('usePoint')) {

            $numberPoint = (float)$request->input('usePoint');
            if ($numberPoint > $totalPrice) {
                $numberPoint = $totalPrice;
            }
            $pointaccess = $this->cart->getTotalPointAccessUse() ?? 0;
            $sumpointMhCurrent = $this->point->sumPointMuaHangCurrent(auth()->user()->id) ?? 0;
            if ($numberPoint > $pointaccess) {
                $numberPoint = $pointaccess;
            }
            if ($numberPoint > $sumpointMhCurrent) {
                $numberPoint = $sumpointMhCurrent;
            }



            if ($numberPoint) {
                //  dd($numberPoint);
                if ($numberPoint > $sumPointCurrent) {
                    $errorNumberPoint = "Số điểm sử dụng phi nhỏ hơn số điểm hiện có :" . $sumPointCurrent . " " . $this->pointUnit;
                    $totalPriceMoney = $totalPrice;
                    $totalPricePoint = 0;
                } elseif (pointToMoney($numberPoint) > $totalPrice) {
                    $errorNumberPoint = "Số điểm sử dụng tưng đương với " . number_format(pointToMoney($numberPoint)) . " " . $this->unit . " nhỏ hơn tổng giá trị sản phm:" . number_format($totalPrice) . " " . $this->unit;
                    $totalPriceMoney = $totalPrice;
                    $totalPricePoint = 0;
                } else {
                    $totalPriceMoney = $totalPrice - pointToMoney($numberPoint);
                    $totalPricePoint = $numberPoint;
                }
            } else {
                $totalPriceMoney = $totalPrice;
                $totalPricePoint = 0;
            }
        } else {
            $totalPriceMoney = $totalPrice - pointToMoney($numberPoint);
            $totalPricePoint = $numberPoint;
        }
        //   dd($errorNumberPoint);
        // dd($totalPriceMoney);
        $totalQuantity =  $this->cart->getTotalQuantity();
        $cartSale = $this->cart->cartSale;



        $user = auth()->guard('web')->user();
        $sumPointCurrent = $this->point->sumPointMuaHangCurrent($user->id);
        //CHUYỂN VNĐ SANG BB 1BB = 1000
        $sumPointCurrent = $sumPointCurrent / getConfigBB();
        // dd($this->cart->cartItems);
        $cartSale = $this->cart->cartSale;
        //Cộng lại giá trị đơn hàng khi ví BB không đủ sẽ thanh toán bằng ví vnd hoặc tiền mặt
        $sumPointCurrent =  round($sumPointCurrent); // Số dư trong ví BB
        // Nếu số (DƯ VÍ BB) > (BB CẦN MUA HÀNG) thì giữ nguyên tổng đơn hàng
        if($sumPointCurrent > $totalPointAccessUse || $sumPointCurrent == $totalPointAccessUse){
            $totalPrice = $totalPrice;
        }elseif ($sumPointCurrent < $totalPointAccessUse){
            $totalPriceMoney = $totalPrice - ( $sumPointCurrent * getConfigBB() );
        }

        // $totalPriceMoney: Số tin phải trả sau khi trừ ví BB
        //TỔNG SỐ DƯ TRONG VÍ VNĐ
        $user = auth()->guard('web')->user();
        $sumEachTypeData = collect($this->point->sumEachTypeFrontend($user->id));

        //Kiểm tra xem có phải là sản phẩm không tích lũy không
        $checkSPTichLuy = reset($this->cart->cartItems);
        if($checkSPTichLuy){
            $checkSPTichLuy = $checkSPTichLuy['khong_tich_luy_ds'];
        }
        if($checkSPTichLuy == 1){
            //Nếu là đơn hàng của sản phẩm không tích lũy thì trừ 20% trong số tổng hoa hồng được nhận
            $total20PhanTramDuocMua = $sumEachTypeData->whereIn('type', config("point.tonghoahongnhanduoc"))->sum('total') * 0.2;
            $total20PhanTramDaMua = $sumEachTypeData->whereIn('type', config("point.listTypePointDiem20PhanTram"))->sum('total');
            $totalViVNĐ = $total20PhanTramDuocMua - (-$total20PhanTramDaMua);
        }else{
            //Nếu là sản phẩm bình thường thì chạy luồng bình thưng
            $totalViVNĐ = $sumEachTypeData->whereIn('type', config("point.listTypePointDiemThuong"))->sum('total');
        }
        // Tạm cmt $totalViVNĐ = $sumEachTypeData->whereIn('type', config("point.listTypePointDiemThuong"))->sum('total');

        //Nếu số dư trong ví vnđ > 0 thì trừ ở ví vnđ trước
        $totalViVndTra = 0;
        if($totalViVNĐ > 0) {
            if($totalViVNĐ > $totalPriceMoney || $totalViVNĐ == $totalPriceMoney) {
                $totalViVnddu = $totalViVNĐ - $totalPriceMoney;
                $totalViVndTra = $totalViVNĐ - $totalViVnddu;
                $totalPriceMoney = 0;
            }else{
                $totalViVnddu = $totalViVNĐ;
                $totalViVndTra = $totalViVnddu;
                $totalPriceMoney =  $totalPriceMoney - $totalViVNĐ;
            }
        }


        $totalPriceCart = 0;
        foreach ($data as $totalPriceCarts){
            $totalPriceCart += $totalPriceCarts['totalPriceOneItem'];
        }
        $totalPrice = $totalPriceCart;
        //$totalPrice = $totalPrice + ($totalPointAccessUse * config("point.typePoint.pointReward"));

        return response()->json([
            'code' => 200,
            'htmlcart' => view('frontend.components.cart-component', [
                'data' => $this->cart->cartItems,
                'totalPrice' => $totalPrice,
                'totalQuantity' => $totalQuantity,
                'cartSale' => $cartSale,
                'totalPriceMoney' => $totalPriceMoney,
                'totalPricePoint' => $totalPricePoint,
                'sumPointCurrent' => $sumPointCurrent,
                'totalPointAccessUse' => $totalPointAccessUse,
                'totalOldPrice' => $totalOldPrice,
                'errorNumberPoint' => $errorNumberPoint,
                'totalViVNĐ' => $totalViVNĐ,
                'usePoint' => $numberPoint,
                'pointUnit' => $this->pointUnit,
                'unit' => $this->unit,
                'totalViVndTra' => $totalViVndTra,

            ])->render(),
            // 'totalPrice' => $totalPrice,
            'messange' => 'success'
        ], 200);
    }
    public function update($id, Request $request)
    {
    try {
        DB::beginTransaction();
        $user = auth()->guard('web')->user();
        $sumPointCurrent = $this->point->sumPointMuaHangCurrent($user->id);
        $this->cart = new CartHelper();
        $data = $this->cart->cartItems;
        $quantity = $request->quantity;
        if ($id) {
            $this->cart->update($id, $quantity);
            // // dd($this->cart->cartItems[$id]);
            //  if($this->cart->cartItems[$id]){
            //     $id=$this->cart->cartItems[$id]['id'];
            //    $total= $this->product->getTotalProductStore($id);
            //    // dd($total);
            //     if( $quantity<=$total){

            //     }else{
            //         $this->cart->update($id, $total);
            //         $dataCart=$this->cart->cartItems;
            //         $dataCart[$id]['error']="S? s?n ph?m ph?i nh? hon s? lu?ng s?n ph?m kho ".$total;
            //     }
            //  }
        }
        //  dd($dataCart??"");
        $totalPrice =  $this->cart->getTotalPrice();
        //Số tin mặt cần trả
        $totalOldPrice =  $this->cart->getTotalOldPrice();
        $numberPoint = 0;
        $errorNumberPoint = false;
        $totalPointAccessUse = $this->cart->getTotalPointAccessUse();
        if ($request->has('usePoint')) {

            $numberPoint = (float)$request->input('usePoint');
            if ($numberPoint > $totalPrice) {
                $numberPoint = $totalPrice;
            }
            $pointaccess = $this->cart->getTotalPointAccessUse() ?? 0;
            $sumpointMhCurrent = $this->point->sumPointMuaHangCurrent(auth()->user()->id) ?? 0;
            if ($numberPoint > $pointaccess) {
                $numberPoint = $pointaccess;
            }
            if ($numberPoint > $sumpointMhCurrent) {
                $numberPoint = $sumpointMhCurrent;
            }


            //  dd( $totalPrice);
            if ($numberPoint) {
                //  dd($numberPoint);
                if ($numberPoint > $totalPointAccessUse) {
                    $errorNumberPoint = "Số điểm sử dụng phải nhỏ hơn số điểm tối đa cho phép mua :" . number_format($totalPointAccessUse) . " " . $this->pointUnit;
                    $totalPriceMoney = $totalPrice;
                    $totalPricePoint = 0;
                } elseif ($numberPoint > $sumPointCurrent) {
                    $errorNumberPoint = "Số điểm s dụng phải nhỏ hơn số điểm hiện có :" . number_format($sumPointCurrent) . " " . $this->pointUnit;
                    $totalPriceMoney = $totalPrice;
                    $totalPricePoint = 0;
                } elseif (pointToMoney($numberPoint) > $totalPrice) {
                    $errorNumberPoint = "Số điểm sử dụng tương đương với " . number_format(pointToMoney($numberPoint)) . " " . $this->unit . " nhỏ hơn tổng giá trị sản phẩm:" . number_format($totalPrice) . " " . $this->unit;
                    $totalPriceMoney = $totalPrice;
                    $totalPricePoint = 0;
                } else {
                    $totalPriceMoney = $totalPrice - pointToMoney($numberPoint);
                    $totalPricePoint = $numberPoint;
                }
            } else {
                $totalPriceMoney = $totalPrice;
                $totalPricePoint = 0;
            }
        } else {
            $totalPriceMoney = $totalPrice - pointToMoney($numberPoint);
            $totalPricePoint = $numberPoint;
        }



        //   dd($totalPriceMoney);
        //   dd($errorNumberPoint);
        // dd($totalPriceMoney);
        $totalQuantity =  $this->cart->getTotalQuantity();
        $cartSale = $this->cart->cartSale;



        $user = auth()->guard('web')->user();
        $sumPointCurrent = $this->point->sumPointMuaHangCurrent($user->id);
        //CHUYỂN VNĐ SANG BB 1BB = 1000
        $sumPointCurrent = $sumPointCurrent / getConfigBB();
        // dd($this->cart->cartItems);
        $cartSale = $this->cart->cartSale;
        //Cng lại giá trị đơn hàng khi ví BB không đủ sẽ thanh toán bằng ví vnd hoặc tiền mặt
        $sumPointCurrent =  round($sumPointCurrent); // Số dư trong ví BB
        // Nếu số (DƯ VÍ BB) > (BB CẦN MUA HÀNG) thì giữ nguyên tổng đơn hàng
        if($sumPointCurrent > $totalPointAccessUse || $sumPointCurrent == $totalPointAccessUse){
            $totalPrice = $totalPrice;
        }elseif ($sumPointCurrent < $totalPointAccessUse){
            $totalPriceMoney = $totalPrice - ($sumPointCurrent * getConfigBB());
        }

        // $totalPriceMoney: Số tin phải trả sau khi trừ ví BB
        //TỔNG SỐ DƯ TRONG VÍ VNĐ
        $user = auth()->guard('web')->user();
        $sumEachTypeData = collect($this->point->sumEachTypeFrontend($user->id));

        //Kiểm tra xem có phải là sản phẩm không tích lũy không
        $checkSPTichLuy = reset($this->cart->cartItems);
        if($checkSPTichLuy){
            $checkSPTichLuy = $checkSPTichLuy['khong_tich_luy_ds'];
        }
        if($checkSPTichLuy == 1){
            //Nếu là đơn hàng của sản phẩm không tích lũy thì trừ 20% trong số tổng hoa hồng được nhận
            $total20PhanTramDuocMua = $sumEachTypeData->whereIn('type', config("point.tonghoahongnhanduoc"))->sum('total') * 0.2;
            $total20PhanTramDaMua = $sumEachTypeData->whereIn('type', config("point.listTypePointDiem20PhanTram"))->sum('total');
            $totalViVNĐ = $total20PhanTramDuocMua - (-$total20PhanTramDaMua);
        }else{
            //Nếu là sản phẩm bình thường thì chạy luồng bình thưng
            $totalViVNĐ = $sumEachTypeData->whereIn('type', config("point.listTypePointDiemThuong"))->sum('total');
        }
        //Tạm cmt $totalViVNĐ = $sumEachTypeData->whereIn('type', config("point.listTypePointDiemThuong"))->sum('total');

        //Nếu số dư trong ví vnđ > 0 thì trừ ở ví vnđ trước
        $totalViVndTra = 0;
        if($totalViVNĐ > 0) {
            if($totalViVNĐ > $totalPriceMoney || $totalViVNĐ == $totalPriceMoney) {
                $totalViVnddu = $totalViVNĐ - $totalPriceMoney;
                $totalViVndTra = $totalViVNĐ - $totalViVnddu;
                $totalPriceMoney = 0;
            }else{
                $totalViVnddu = $totalViVNĐ;
                $totalViVndTra = $totalViVnddu;
                $totalPriceMoney =  $totalPriceMoney - $totalViVNĐ;
            }
        }

        $totalPriceCart = 0;
        foreach ($data as $totalPriceCarts){
            $totalPriceCart += $totalPriceCarts['totalPriceOneItem'];
        }
        $totalPrice = $totalPriceCart;
        //$totalPrice = $totalPrice + ($totalPointAccessUse * config("point.typePoint.pointReward"));
        DB::commit();
        return response()->json([
            'code' => 200,
            'htmlcart' => view('frontend.components.cart-component', [
                'data' =>  $this->cart->cartItems,
                'totalPrice' => $totalPrice,
                'totalPriceMoney' => $totalPriceMoney,
                'totalPricePoint' => $totalPricePoint,
                'totalQuantity' => $totalQuantity,
                'sumPointCurrent' => $sumPointCurrent,
                'totalOldPrice' => $totalOldPrice,
                'errorNumberPoint' => $errorNumberPoint,
                'totalPointAccessUse' => $totalPointAccessUse,
                'usePoint' => $numberPoint,
                'pointUnit' => $this->pointUnit,
                'unit' => $this->unit,
                'cartSale' => $cartSale,
                'totalViVNĐ' => $totalViVNĐ,
                'totalViVndTra' => $totalViVndTra,
            ])->render(),
            // 'totalPrice' => number_format($totalPrice),
            // 'totalQuantity' => number_format($totalQuantity),
            // 'totalPriceMoney'=>number_format($totalPriceMoney),
            // 'totalPricePoint'=>number_format($totalPricePoint),
            // 'totalOldPrice'=>number_format($totalOldPrice),
            // 'sumPointCurrent'=>$sumPointCurrent,
            'messange' => 'success'
        ], 200);
        } catch (\Exception $exception) {
        dd($exception);
            //throw $th;
            DB::rollBack();
            Log::error('message' . $exception->getMessage() . 'line :' . $exception->getLine());
            return redirect()->route('cart.order.sucess', ['id' => 0])->with("error", "Đặt hàng không thành công");
        }
    }
    public function clear()
    {
        $this->cart = new CartHelper();
        $this->cart->clear();
        $totalPrice =  $this->cart->getTotalPrice();
        $totalQuantity =  $this->cart->getTotalQuantity();
        $totalPointAccessUse = $this->cart->getTotalPointAccessUse();
        $cartSale = $this->cart->cartSale;
        return response()->json([
            'code' => 200,
            'htmlcart' => view('frontend.components.cart-component', [
                'data' => $this->cart->cartItems,
                'totalPrice' => $totalPrice,
                'totalQuantity' => $totalQuantity,
                'totalPointAccessUse' => $totalPointAccessUse,
                'cartSale' => $cartSale,
            ])->render(),
            'totalPrice' => $totalPrice,
            'totalQuantity' => $totalQuantity,
            'totalPointAccessUse' => $totalPointAccessUse,
            'messange' => 'success'
        ], 200);
    }

    public function postOrder(ValidateUpdateOrder $request)
    {
        $this->cart = new CartHelper();
        $dataCart = $this->cart->cartItems;
        $data = $this->cart->cartItems;
        if (count($dataCart)) {
            try {
                DB::beginTransaction();
                //  dd($dataCart);
                $this->cart->setCartSale($request->input("code-sale"));
                $user = auth()->guard('web')->user();
                $totalPrice =  $this->cart->getTotalPrice();
                $totalQuantity =  $this->cart->getTotalQuantity();
                $totalPriceTinhThuong =  $this->cart->getTotalPriceTinhDiem();

                $code = makeCodeTransaction($this->transaction);

                //Tổng đơn hàng tri trả bằng BB
                $pointU = $request->input('usePoint') ? $request->input('usePoint') : 0;
                $sumEachTypeData = collect($this->point->sumEachTypeFrontend($user->id));
                $BBUser = $sumEachTypeData->whereIn('type', config('point.listTypePointMH'))->sum("total");

//                //Kiểm tra nếu ví bb nh hơn giá trị trả đơn hàng
//                if($pointU > intval($BBUser/config("point.typePoint.pointReward"))){
//                    return redirect(route("cart.list"))->with("error1", "Số BB vượt quá số BB trong ví");
//                }
                //Tổng đơn hàng chi trả bằng VNĐ
                $money = $request->input('useMoney');

                if ($money < 0) {
                    $pointU = moneyToPoint($totalPrice);
                    $money = 0;
                }

                $moneyTinhThuong = $totalPriceTinhThuong - (pointToMoney($request->input('usePoint') ? $request->input('usePoint') : 0));

                if ($moneyTinhThuong < 0) {
                    $moneyTinhThuong = 0;
                }


                $checkSPTichLuy = reset($this->cart->cartItems);
                if($checkSPTichLuy['khong_tich_luy_ds'] == 1){
                    //Xử lý luồng sản phẩm không tích lũy
                    //Trừ ví vnđ nếu ví vnđ dương
                    $vi_vnd = 0;
                    if ($request->has('vi_vnd')) {
                        if($request->input('vi_vnd') > 0) {
                            if ($user) {

                                if($request->input('vi_vnd') >= $totalPrice){
                                    $user->points()->create([
                                        'type' => $this->typePoint[22]['type'],
                                        'point' => 0 - $totalPrice,
                                        'active' => 1,
                                    ]);
                                    $vi_vnd = $totalPrice;
                                }elseif ($request->input('vi_vnd') < $totalPrice) {
                                    $user->points()->create([
                                        'type' => $this->typePoint[22]['type'],
                                        'point' => 0 - $request->input('vi_vnd'),
                                    ]);
                                    $vi_vnd = $request->input('vi_vnd');
                                }

                            }

                            $moneyTinhThuong = $moneyTinhThuong- $request->input('vi_vnd');


                            if($money < 0) {
                                $money = 0;
                            }
                            if($moneyTinhThuong < 0){
                                $moneyTinhThuong = 0;
                            }
                        }
                    }

                }else{

                    //Trừ ví vnđ nếu ví vnđ dương
                    $vi_vnd = 0;
                    if ($request->has('vi_vnd')) {
                        if($request->input('vi_vnd') > 0) {
                            if ($user) {
                                if($request->input('vi_vnd') >= $totalPrice){
                                    $user->points()->create([
                                        'type' => $this->typePoint[24]['type'],
                                        'point' => 0 - $totalPrice,
                                        'active' => 1,
                                    ]);
                                    $vi_vnd = $totalPrice;
                                }elseif ($request->input('vi_vnd') < $totalPrice) {
                                    $user->points()->create([
                                        'type' => $this->typePoint[24]['type'],
                                        'point' => 0 - $request->input('vi_vnd'),
                                    ]);
                                    $vi_vnd = $request->input('vi_vnd');
                                }

                            }

                            $moneyTinhThuong = $moneyTinhThuong- $request->input('vi_vnd');


                            if($money < 0) {
                                $money = 0;
                            }
                            if($moneyTinhThuong < 0){
                                $moneyTinhThuong = 0;
                            }
                        }
                    }

                }



                // dd($this->cart->cartItems);
                $cartSale = $this->cart->cartSale;
                //Cộng lại giá trị đơn hàng khi ví BB không đủ sẽ thanh toán bằng ví vnd hoặc tiền mặt
                $totalPointAccessUse = $this->cart->getTotalPointAccessUse();

                $sumPointCurrent = $this->point->sumPointMuaHangCurrent($user->id);
                //CHUYỂN VNĐ SANG BB 1BB = 1000
                $sumPointCurrent = $sumPointCurrent / getConfigBB();

                $sumPointCurrent =  round($sumPointCurrent); // Số dư trong ví BB
                // Nếu số (DƯ VÍ BB) > (BB CN MUA HÀNG) thì giữ nguyên tổng đơn hàng
                if($sumPointCurrent > $totalPointAccessUse || $sumPointCurrent == $totalPointAccessUse){
                    $totalPrice = $totalPrice;
                }elseif ($sumPointCurrent < $totalPointAccessUse){
                    $BBCong = ($totalPointAccessUse - $sumPointCurrent) * getConfigBB();
                    $totalPrice = $totalPrice + $BBCong;

                    //$totalPriceMoney = $totalPrice - $totalViVndTra - ($sumPointCurrent * config("point.typePoint.pointReward"));
                }

                $totalPriceCart = 0;
                foreach ($data as $totalPriceCarts){
                    $totalPriceCart += $totalPriceCarts['totalPriceOneItem'];
                }
                $totalPrice = $totalPriceCart;
                //$totalPrice = $totalPrice + ($totalPointAccessUse * config("point.typePoint.pointReward"));

                $dataTransactionCreate = [
                    'code' => $code,
                    'total' => $totalPrice,
                    'point' => $pointU,
                    'money' => $money ?? 0,
                    'money_tinh_thuong' => $moneyTinhThuong,
                    'money_code_sale' => $this->cart->cartSale["value"],
                    'code_sale' => $this->cart->cartSale["codeSale"],
                    'name' => $request->input('name'),
                    'phone' => $request->input('phone'),
                    'note' => $request->input('note'),
                    'email' => $request->input('email'),
                    'status' => 1,
                    'city_id' => $request->input('city_id'),
                    'district_id' => $request->input('district_id'),
                    'commune_id' => $request->input('commune_id'),
                    'address_detail' => $request->input('address_detail'),
                    'phone_nguoinhan' => $request->input('phone_nguoinhan'),
                    'admin_id' => 0,
                    'user_id' => Auth::check() ? Auth::user()->id : 0,
                    'vi_vnd' => $vi_vnd,
                ];

                // Trừ ví BB
                if ($request->has('usePoint')) {
                    if ($request->input('usePoint')) {
                        if ($user) {
                            $user->points()->create([
                                'type' => $this->typePoint[9]['type'],
                                'point' => 0 - ($pointU * getConfigBB()),//1BB = 1000
                                'active' => 1,
                            ]);
                        }
                    } else {
                        $dataTransactionCreate['point'] = 0;
                        $dataTransactionCreate['money'] = $money;
                    }
                }
                //dd($dataTransactionCreate);

                $transaction = $this->transaction->create($dataTransactionCreate);

                $dataOrderCreate = [];
                foreach ($dataCart as $cart) {
                    $dataOrderCreate[] = [
                        'name' => $cart['name'],
                        'quantity' => $cart['quantity'],
                        'new_price' => $cart['totalPriceOneItem'],
                        'old_price' => $cart['totalOldPriceOneItem'],
                        'avatar_path' => $cart['avatar_path'],
                        'sale' => $cart['sale'],
                        'product_id' => $cart['id'],
                    ];
                    $product = $this->product->find($cart['id']);
                    $pay = $product->pay;
                    $product->update([
                        'pay' => $pay + $cart['quantity'],
                    ]);
                }
                //   dd($dataOrderCreate);
                // insert database in orders table by createMany
                $transaction->orders()->createMany($dataOrderCreate);

                // �ua s?n ph?m trong kho sang tr?ng th�i d?i v?n chuy?n
                $dataStoreCreate = [
                    "active" => 1,
                    "type" => 2,
                ];
                $dataStoreCreate["transaction_id"] = $transaction->id;
                $orders = $transaction->orders;
                $listDataStoreCreate = [];
                foreach ($orders as $order) {
                    $storeItem = $dataStoreCreate;
                    $storeItem['quantity'] = -$order->quantity;
                    $storeItem['product_id'] = $order->product_id;
                    array_push($listDataStoreCreate, $storeItem);
                }
                //   dd($listDataStoreCreate);
                $transaction->stores()->createMany($listDataStoreCreate);
                if ($this->cart->cartSale["codeSale"]) {
                    $giamGia =  $this->codeSale->where("code", $this->cart->cartSale["codeSale"])->first();
                    Log::error('message' . $giamGia);
                    if ($giamGia) {
                        $countUseUpdate = $giamGia->count_use + $this->cart->cartSale["countSale"];
                        $giamGia = $giamGia->update([
                            "active" => $countUseUpdate >= $giamGia->count_sale ? 0 : 1,
                            "count_use" => $countUseUpdate,
                            "transaction_id" => $transaction->id,
                        ]);
                    }
                }
                // $this->cart->clear();
                DB::commit();
                return redirect()->route('cart.order.sucess', ['id' => $transaction->id])->with("sucess", "Đặt hàng thành công");
            } catch (\Exception $exception) {
                //throw $th;
                DB::rollBack();
                Log::error('message' . $exception->getMessage() . 'line :' . $exception->getLine());
                return redirect()->route('cart.order.sucess', ['id' => 0])->with("error", "Đặt hàng không thành công");
            }
        } else {
            return;
        }
    }
    public function getOrderSuccess(Request $request)
    {
        $id = $request->id;
        $data = $this->transaction->find($id);

        return view('frontend.pages.order-sucess', [
            'data' => $data,
            'pointUnit' => $this->pointUnit,
            'unit' => $this->unit,
        ]);
    }

    public function applyCodeSale(Request $request)
    {
        $code = $request->code;
        $user = auth()->guard('web')->user();
        $sumPointCurrent = $this->point->sumPointMuaHangCurrent($user->id);
        $this->cart = new CartHelper();
        if ($code) {
            $this->cart->setCartSale($code);
        }
        $totalPrice =  $this->cart->getTotalPrice();
        $totalOldPrice =  $this->cart->getTotalOldPrice();
        $numberPoint = 0;
        $errorNumberPoint = false;
        $totalPointAccessUse = $this->cart->getTotalPointAccessUse();
        if ($request->has('usePoint')) {

            $numberPoint = (float)$request->input('usePoint');

            if ($numberPoint > $totalPrice) {
                $numberPoint = $totalPrice;
            }

            $pointaccess = $this->cart->getTotalPointAccessUse() ?? 0;
            $sumpointMhCurrent = $this->point->sumPointMuaHangCurrent(auth()->user()->id) ?? 0;
            if ($numberPoint > $pointaccess) {
                $numberPoint = $pointaccess;
            }
            if ($numberPoint > $sumpointMhCurrent) {
                $numberPoint = $sumpointMhCurrent;
            }

            //  dd( $totalPrice);
            if ($numberPoint) {
                //  dd($numberPoint);
                if ($numberPoint > $totalPointAccessUse) {
                    $errorNumberPoint = "Số điểm sử dụng phải nhỏ hơn số điểm tối đa cho phép mua :" . number_format($totalPointAccessUse) . " " . $this->pointUnit;
                    $totalPriceMoney = $totalPrice;
                    $totalPricePoint = 0;
                } elseif ($numberPoint > $sumPointCurrent) {
                    $errorNumberPoint = "Số điểm sử dụng phải nhỏ hơn số điểm hiện c:" . number_format($sumPointCurrent) . " " . $this->pointUnit;
                    $totalPriceMoney = $totalPrice;
                    $totalPricePoint = 0;
                } elseif (pointToMoney($numberPoint) > $totalPrice) {
                    $errorNumberPoint = "Số điểm sử dụng tương đương với " . number_format(pointToMoney($numberPoint)) . " " . $this->unit . " nhỏ hơn tổng giá trị sản phẩm:" . number_format($totalPrice) . " " . $this->unit;
                    $totalPriceMoney = $totalPrice;
                    $totalPricePoint = 0;
                } else {
                    $totalPriceMoney = $totalPrice - pointToMoney($numberPoint);
                    $totalPricePoint = $numberPoint;
                }
            } else {
                $totalPriceMoney = $totalPrice;
                $totalPricePoint = 0;
            }
        } else {
            $totalPriceMoney = $totalPrice - pointToMoney($numberPoint);
            $totalPriceMoney = $numberPoint;
        }

        $cartSale = $this->cart->cartSale;

        //   dd($totalPriceMoney);
        //  dd($errorNumberPoint);
        // dd($totalPriceMoney);
        $totalQuantity =  $this->cart->getTotalQuantity();
        return response()->json([
            'code' => 200,
            'htmlcart' => view('frontend.components.cart-component', [
                'data' =>  $this->cart->cartItems,
                'totalPrice' => $totalPrice,
                'totalPriceMoney' => $totalPriceMoney,
                'totalPricePoint' => $totalPricePoint,
                'cartSale' => $cartSale,
                'totalQuantity' => $totalQuantity,
                'sumPointCurrent' => $sumPointCurrent,
                'totalOldPrice' => intval($totalOldPrice),
                'errorNumberPoint' => $errorNumberPoint,
                'totalPointAccessUse' => $totalPointAccessUse,
                'usePoint' => $numberPoint,
                'pointUnit' => $this->pointUnit,
                'unit' => $this->unit,
            ])->render(),
            // 'totalPrice' => number_format($totalPrice),
            // 'totalQuantity' => number_format($totalQuantity),
            // 'totalPriceMoney'=>number_format($totalPriceMoney),
            // 'totalPricePoint'=>number_format($totalPricePoint),
            // 'totalOldPrice'=>number_format($totalOldPrice),
            // 'sumPointCurrent'=>$sumPointCurrent,
            'messange' => 'success'
        ], 200);
    }
}
