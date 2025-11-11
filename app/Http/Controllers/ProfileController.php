<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Point;
use App\Models\Product;
use App\Models\Post;
use App\Traits\StorageImageTrait;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Requests\Frontend\ValidateAddUser;
use App\Http\Requests\Frontend\ValidateEditUser;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\Frontend\ValidateDrawPoint;
use App\Http\Requests\Frontend\ValidateMomoPayment;
use App\Models\Bank;
use App\Models\Transaction;
use App\Traits\PointTrait;
use App\Http\Requests\Frontend\ValidateAdduserReferral;
use App\Http\Requests\Frontend\ValidatePointToXu;
use App\Models\Pointtt;
use App\Models\Setting;
use Illuminate\Support\Carbon;
use PHPUnit\TextUI\XmlConfiguration\Extension;
use App\Helper\NLClass;
use App\NganLuong\Lib\Alepay;
use App\Mail\ForgotPasswordEmail;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;

class ProfileController extends Controller
{
    //
    use StorageImageTrait, PointTrait;
    private $user;
    private $point;
    private $product;
    private $typePoint;
    private $rose;
    private $typePay;
    private $datePay;
    private $bank;
    private $transaction;
    private $listStatus;
    private $setting;
    private $pointtt;

    public function __construct(User $user, Point $point, Bank $bank, Transaction $transaction, Product $product, Setting $setting, Pointtt $pointtt)
    {

        $this->user = $user;
        $this->point = $point;
        $this->bank = $bank;
        $this->typePoint = config('point.typePoint');
        $this->typePay = config('point.typePay');
        $this->rose = config('point.rose');
        $this->datePay = config('point.datePay');
        $this->transaction = $transaction;
        $this->listStatus = $this->transaction->listStatus;
        $this->product = $product;
        $this->setting = $setting;
        $this->pointtt = $pointtt;
    }
    public function index(Request $request)
    {
        // $rawHash = "partnerCode=MOMOBKUN20180529&accessKey=klm05TvNBzhg7h7j&requestId=1675770248&bankCode=SML&amount=5000000&orderId=1675770248&orderInfo=Thanh toán qua MoMo&returnUrl=http://127.0.0.1:8000/profile/momo_payment_success&notifyUrl=http://127.0.0.1:8000/profile/momo_payment?mes=error&extraData=&requestType=payWithMoMoATM";
        // $secretKey = "at67qH6mk8w5Y1nAyMoYKMWACiEi2bsa";
        // $signature = "8e74cc09e669af41a69c5329646e4b9f724f2a7cad7f9b1436435d0fbb1b1b89";
        // $m2signature = "603833e6d0d52333d418c66e17ccdad35e581b2d626bb6ed9b97720b56cfe597";
        // $partnerSignature = hash_hmac("sha256", $rawHash, $secretKey);
        // dd($partnerSignature);

        $user = auth()->guard()->user();
        //  dd($user);

       $sumEachType = collect([
            [
                'name' => 'Ví KTG',
                "total" => 0,
                'listType' => config("point.listTypePointMH"),
                'class' => 'bg-info',
                'donvi' => 'KTG'
            ],

            [
                'name' => 'Ví (VNĐ)',
                "total" => 0,
                'listType' => config("point.listTypePointDiemThuong"),
                'class' => 'bg-info',
                'donvi' => 'đ',
            ],

            [
                'name' => 'Ví Đặt Cọc',
                "total" => 0,
                'listType' => [1], // không dùng trong sumEachTypeData
                'class' => 'bg-info',
                'donvi' => 'đ',
            ],
        ]);

        $sumEachTypeData = collect($this->point->sumEachTypeFrontend($user->id));

        $sumEachType = $sumEachType->map(function ($item) use ($sumEachTypeData) {
            $item['total'] = $sumEachTypeData->whereIn('type', $item['listType'])->sum("total") ;
            return $item;
        });

        $sumDepositWallet = \App\Models\DepositWallet::where('user_id', $user->id)
            ->where('status', 'active')
            ->sum('remaining_amount');

        $sumEachType = $sumEachType->map(function ($item) use ($sumDepositWallet) {
            if ($item['name'] === 'Ví Đặt Cọc') {
                $item['total'] = $sumDepositWallet;
            }
            return $item;
        });

        $sumPointCurrent = $this->point->sumPointCurrent($user->id);

        $openPay = (date('d') >= $this->datePay['start'] && date('d') <= $this->datePay['end']);

        return view('frontend.pages.profile', [
            'user' => $user,
            'sumEachType' => $sumEachType,
            'sumPointCurrent' => $sumPointCurrent,
            'typePoint' => $this->typePoint,
            'openPay' => $openPay,

        ]);
    }

    public function forgotPassWord()
    {
        return view('auth.forgot-pasword');
    }
    public function resetPassword(Request $request)
    {
        $user = User::where('email', $request->input('email'))->first();
        if ($user) {
            $newPassword = Str::random(8);
            $hashedPassword = Hash::make($newPassword);
            $user->update([
                'password' => $hashedPassword,
                'login_failed' => 0,
            ]);

            Mail::to($user->email)->send(new ForgotPasswordEmail($user, $newPassword));
            return redirect()->back()->with(['alert' => 'Hệ thống đã cấp mật khẩu mới về email của bạn!']);
        }

        return redirect()->back()->with(['error' => 'Email không tồn tại trong hệ thống']);
    }
    public function notification()
    {
        $user = auth()->guard()->user();
        $postsHotNew = Post::where('active', 1)
            ->orderByDesc('created_at')
            ->limit(20)
            ->get();
        return view('frontend.pages.notification', [
            'user' => $user,
            'postsHotNew' => $postsHotNew,
        ]);
    }

    public function history(Request $request)
    {
        $user = auth()->guard()->user();
        $data = $user->transactions()->paginate(15);

        $transactionGroupByStatus = $user->transactions()->select($this->transaction->raw('count(status) as total'), 'status')->groupBy('status')->get();
        $totalTransaction =  $user->transactions()->count();
        //   dd( $transactionGroupByStatus);
        $dataTransactionGroupByStatus = $this->listStatus;
        foreach ($transactionGroupByStatus as $item) {
            $dataTransactionGroupByStatus[$item->status]['total'] = $item->total;
        }

        //   dd($data);
        //  $sumEachType = $this->point->sumEachType($user->id);
        //   $sumPointCurrent = $this->point->sumPointCurrent($user->id);

        return view('frontend.pages.profile-history', [
            'dataTransactionGroupByStatus' => $dataTransactionGroupByStatus,
            'totalTransaction' => $totalTransaction,
            'user' => $user,
            'data' => $data,
            'listStatus' => $this->listStatus,
        ]);
    }
    public function historyDrawPoint(Request $request)
    {
        $user = auth()->guard()->user();
        $data = $user->pays()->paginate(15);
        // dd($data);

        return view('frontend.pages.profile-history-draw-point', [
            'user' => $user,
            'data' => $data,
            'typePay' => $this->typePay,
        ]);
    }
    public function lichSuNapTien(Request $request)
    {
        $user = auth()->guard()->user();
        $data = $user->points()->where("type", config("point.typePoint.1.type"))->paginate(15);
        // dd($data);

        return view('frontend.pages.profile-lich-su-nap-tien', [
            'user' => $user,
            'data' => $data,
            'typePay' => $this->typePay,
        ]);
    }
    public function lichSuRutTien(Request $request)
    {
        $user = auth()->guard()->user();
        $data = $user->points()->where("type", config("point.typePoint.7.type"))->paginate(15);
        // dd($data);

        return view('frontend.pages.profile-lich-su-rut-tien', [
            'user' => $user,
            'data' => $data,
            'typePay' => $this->typePay,
        ]);
    }
    public function loadTransactionDetail($id)
    {
        $orders = $this->transaction->find($id)->orders()->get();

        return response()->json([
            'code' => 200,
            'html' => view('frontend.components.transaction-detail', [
                'orders' => $orders,
            ])->render(),
            'messange' => 'success'
        ], 200);
    }


    public function editInfo()
    {
        $user = auth()->guard('web')->user();
        $banks = $this->bank->get();
        $ndtb = $this->setting->find(101);
        return view('frontend.pages.profile-edit-info', ['data' => $user, 'banks' => $banks, 'user' => $user, 'ndtb' => $ndtb]);
    }
    public function updateInfo($id, ValidateEditUser $request)
    {
        try {
            DB::beginTransaction();
            $user = $this->user->find($id);
            if ($user->status == 0) {
                $dataUserUpdate = [
                    "name" => $request->input('name'),
                    "email" => $request->input('email'),
                    "username" => $request->input('username'),
                    "phone" => $request->input('phone'),
                    // "date_birth" => $request->input('date_birth'),
                    "address" => $request->input('address'),
                    // "hktt" => $request->input('hktt'),
                    "cmt" => $request->input('cmt'),
                    "stk" => $request->input('stk'),
                    "ctk" => $request->input('ctk'),
                    "bank_id" => $request->input('bank_id'),
                    // "bank_branch" => $request->input('bank_branch'),
                    "sex" => $request->input('sex'),
                    'status' => 1,
                    // "active" => $request->input('active'),
                ];
                // $this->addPointKYC($user);
            } else {
                $dataUserUpdate = [
                    //  "name" => $request->input('name'),
                    //  "email" => $request->input('email'),
                    //  "username" => $request->input('username'),
                    //   "phone" => $request->input('phone'),
                    //    "date_birth" => $request->input('date_birth'),
                    //   "address" => $request->input('address'),
                    //    "hktt" => $request->input('hktt'),
                    //   "cmt" => $request->input('cmt'),
                    // "stk" => $request->input('stk'),
                    // "ctk" => $request->input('ctk'),
                    // "bank_id" => $request->input('bank_id'),
                    // "bank_branch" => $request->input('bank_branch'),
                    // "sex" => $request->input('sex'),
                    // 'status' => 2,
                    // "active" => $request->input('active'),
                ];
            }

            $dataUploadAvatar = $this->storageTraitUpload($request, "avatar_path", "user");
            if (!empty($dataUploadAvatar)) {
                $dataUserUpdate["avatar_path"] = $dataUploadAvatar["file_path"];
            }
            $dataUploadCmtMattren = $this->storageTraitUpload($request, "cmt_mattren_path", "user");
            if (!empty($dataUploadCmtMattren)) {
                $dataUserUpdate["cmt_mattren_path"] = $dataUploadCmtMattren["file_path"];
            }
            $dataUploadCmtMatDuoi = $this->storageTraitUpload($request, "cmt_matduoi_path", "user");
            if (!empty($dataUploadCmtMatDuoi)) {
                $dataUserUpdate["cmt_matduoi_path"] = $dataUploadCmtMatDuoi["file_path"];
            }

            if (request()->input('password')) {
                $dataUserUpdate['password'] = Hash::make($request->input('password'));
            }
            // dd($dataUserUpdate);
            // insert database in product table
            $this->user->find($id)->update($dataUserUpdate);
            $user = $this->user->find($id);

            DB::commit();
            return redirect()->route('profile.editInfo', ['user' => $user])->with("alert", "Thay đổi thông tin thành công");
        } catch (\Exception $exception) {
            DB::rollBack();
            Log::error('message' . $exception->getMessage() . 'line :' . $exception->getLine());
            return redirect()->route('profile.editInfo', ['user' => $user])->with("error", "Thay đổi thông tin không thành công");
        }
    }

    // danh sách hoa hồng được thưởng từ 20 lớp và hệ thống
    public function listRose()
    {
        $user = auth()->guard()->user();
        $data = $this->point->where([
            ['user_id', $user->id],
            ['active', 1]
        ])->orderby('created_at', 'DESC')->get();
        return view('frontend.pages.profile-list-rose', [
            'data' => $data,
            'typePoint' => $this->typePoint,
            'user' => $user,
        ]);
    }
    public function listMember()
    {
        $user = auth()->guard()->user();
        //  dd($data);
        $data = $user->childs;

        //  dd($data);
        return view('frontend.pages.profile-list-member', [
            'data' => $data,
            'typePoint' => $this->typePoint,
            'user' => $user,
        ]);
    }
    public function createMember(Request $request)
    {
        $user = auth()->guard()->user();
        return view('frontend.pages.profile-create-member', [
            'user' => $user,
        ]);
    }
    public function storeMember(ValidateAddUser $request)
    {
        $userParent = auth()->guard()->user();
        try {
            DB::beginTransaction();
            $dataAdminUserFrontendCreate = [
                "name" => $request->input('name'),
                "username" => $request->input('username'),
                "parent_id" => $userParent->id,
                "password" => Hash::make('A123456'),
                "active" => 0,
                "code" => makeCodeUser($this->user),
            ];
            // dd($dataAdminUserFrontendCreate);
            // insert database in user table
            $user = $this->user->create($dataAdminUserFrontendCreate);
            // insert database to product_tags table
            // thêm số điểm nạp lúc đầu

            // if ($request->has('startpoint')) {
            //     $user->points()->create([
            //         'type' => $this->typePoint[4]['type'],
            //         'point' => $request->input('startpoint'),
            //         'active' => 1,
            //     ]);
            // }

            // thêm điểm thưởng lúc đầu
            $user->points()->create([
                'type' => $this->typePoint[1]['type'],
                'point' => $this->typePoint['defaultPoint'],
                'active' => 0,
            ]);
            $user->points()->create([
                'type' => config("point.typePoint")[31]['type'],
                'point' => configCreateUser() * getConfigBB(),
                'active' => 1,
                'userorigin_id' => $user->id,
            ]);

            $product = $this->product->where(['masp' => $request->input('masp')])->first();

            $code = makeCodeTransaction($this->transaction);

            $totalPrice = $product->price * (100 - $product->sale) / 100;

            // thêm số điểm nạp lúc đầu
            $user->points()->create([
                'type' => $this->typePoint[4]['type'],
                'point' => moneyToPoint($totalPrice),
                'active' => 0,
            ]);

            // Trừ điểm mua sản phẩm
            $user->points()->create([
                'type' => $this->typePoint[6]['type'],
                'point' => -moneyToPoint($totalPrice),
                'active' => 0,
            ]);

            $dataTransactionCreate = [
                'code' => $code,
                'total' => $totalPrice,
                'point' =>  0,
                'money' => $totalPrice,
                'name' => $user->name,
                'phone' => null,
                'note' => null,
                'email' => null,
                'status' => 1,
                'city_id' => null,
                'district_id' => null,
                'commune_id' => null,
                'address_detail' => null,
                'admin_id' => 0,
                'user_id' => $user->id,
                'active' => 0,
                'add_point_20' => 0
            ];

            // tạo giao dịch
            //    dd($this->transaction);
            $transaction = $this->transaction->create($dataTransactionCreate);
            // tạo các order của transaction
            $dataOrderCreate = [];

            $dataOrderCreate[] = [
                'name' => $product->name,
                'quantity' => 1,
                'new_price' => $totalPrice,
                'old_price' => $product->price,
                'avatar_path' => $product->avatar_path,
                'sale' => $product->sale,
                'product_id' => $product->id,
            ];
            // $pay = $product->pay;
            // $product->update([
            //     'pay' => $pay + $dataOrderCreate[0]['quantity'],
            // ]);

            //   dd($dataOrderCreate);
            // insert database in orders table by createMany
            $transaction->orders()->createMany($dataOrderCreate);

            // Đưa sản phẩm trong kho sang trạng thái đợi vận chuyển
            $dataStoreCreate = [
                "active" => 0,
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

            DB::commit();
            return redirect()->route('profile.createMember')->with("alert", "Thêm thành viên thành công");
        } catch (\Exception $exception) {
            DB::rollBack();
            Log::error('message' . $exception->getMessage() . 'line :' . $exception->getLine());
            return redirect()->route('profile.createMember')->with("error", "Thêm thành viên không thành công");
        }
    }


    public function createRegisterReferral($code, Request $request)
    {
        if ($this->user->where([
            'code' => $code,
            ['active', '<>', 0],
        ])->exists()) {
            $userparent = $this->user->where([
                'code' => $code,
                ['active', '<>', 0],
            ])->first();
            return view('frontend.pages.profile-create-member-referral', [
                'code' => $code,
                'userparent' => $userparent
            ]);
        } else {
            return;
        }
    }

    public function storeRegisterReferral(ValidateAdduserReferral $request)
    {

        $userParent = $this->user->where([
            'code' => $request->code,
            ['active', '<>', 0],
        ])->first();
        if ($userParent->count() > 0) {
            try {
                DB::beginTransaction();
                $parentKey = "|" . $userParent->id . "|";
                if ($userParent->parent_all_key) {
                    $parentKey = $userParent->parent_all_key . $userParent->id . "|";
                }

                $dataAdminUserFrontendCreate = [
                    "name" => $request->input('name'),
                    "username" => $request->input('username'),
                    "parent_id" => $userParent->id,
                    'email' => $request->input('email'),
                    'address' => $request->input('address'),
                    'password' => Hash::make($request->input('password')),
                    "active" => 1,
                    "parent_all_key" => $parentKey,
                    "code" => makeCodeUser($this->user),
                    'thuong_cap' => null,
                ];
                // dd($dataAdminUserFrontendCreate);
                // insert database in user table
                $user = $this->user->create($dataAdminUserFrontendCreate);
                $user->points()->create([
                    'type' => config("point.typePoint")[31]['type'],
                    'point' => configCreateUser() * getConfigBB(),
                    'active' => 1,
                    'userorigin_id' => $user->id,
                ]);
                // insert database to product_tags table
                // thêm số điểm nạp lúc đầu

                // if ($request->has('startpoint')) {
                //     $user->points()->create([
                //         'type' => $this->typePoint[4]['type'],
                //         'point' => $request->input('startpoint'),
                //         'active' => 1,
                //     ]);
                // }

                // thêm điểm thưởng lúc đầu
                // $user->points()->create([
                //     'type' => $this->typePoint[1]['type'],
                //     'point' => $this->typePoint['defaultPoint'],
                //     'active' => 0,
                // ]);

                // $product = $this->product->where(['masp' => $request->input('masp')])->first();
                //  dd($product);
                //   dd($product);
                // $code = makeCodeTransaction($this->transaction);

                // $totalPrice = $product->price * (100 - $product->sale) / 100;

                // thêm số điểm nạp lúc đầu
                // $user->points()->create([
                //     'type' => $this->typePoint[4]['type'],
                //     'point' => moneyToPoint($totalPrice),
                //     'active' => 0,
                // ]);

                // Trừ điểm mua sản phẩm
                // $user->points()->create([
                //     'type' => $this->typePoint[6]['type'],
                //     'point' => -moneyToPoint($totalPrice),
                //     'active' => 0,
                // ]);

                // $dataTransactionCreate = [
                //     'code' => $code,
                //     'total' => $totalPrice,
                //     'point' =>  0,
                //     'money' => $totalPrice,
                //     'name' => $user->name,
                //     'phone' => null,
                //     'note' => null,
                //     'email' => null,
                //     'status' => 1,
                //     'city_id' => null,
                //     'district_id' => null,
                //     'commune_id' => null,
                //     'address_detail' => null,
                //     'admin_id' => 0,
                //     'user_id' => $user->id,
                //     'active' => 0,
                //     'add_point_20' => 0
                // ];

                // // tạo giao dịch
                // //    dd($this->transaction);
                // $transaction = $this->transaction->create($dataTransactionCreate);
                // // tạo các order của transaction
                // $dataOrderCreate = [];

                // $dataOrderCreate[] = [
                //     'name' => $product->name,
                //     'quantity' => 1,
                //     'new_price' => $totalPrice,
                //     'old_price' => $product->price,
                //     'avatar_path' => $product->avatar_path,
                //     'sale' => $product->sale,
                //     'product_id' => $product->id,
                // ];
                // $pay = $product->pay;
                // $product->update([
                //     'pay' => $pay + $dataOrderCreate[0]['quantity'],
                // ]);

                //   dd($dataOrderCreate);
                // insert database in orders table by createMany
                // $transaction->orders()->createMany($dataOrderCreate);

                // // Đưa sản phẩm trong kho sang trạng thái đợi vận chuyển
                // $dataStoreCreate = [
                //     "active" => 0,
                //     "type" => 2,
                // ];

                // $dataStoreCreate["transaction_id"] = $transaction->id;
                // $orders = $transaction->orders;
                // $listDataStoreCreate = [];
                // foreach ($orders as $order) {
                //     $storeItem = $dataStoreCreate;
                //     $storeItem['quantity'] = -$order->quantity;
                //     $storeItem['product_id'] = $order->product_id;
                //     array_push($listDataStoreCreate, $storeItem);
                // }
                //   dd($listDataStoreCreate);
                // $transaction->stores()->createMany($listDataStoreCreate);
                DB::commit();
                return redirect()->route('login')->with("alert", "Thêm thành viên thành công");
            } catch (\Exception $exception) {
                DB::rollBack();
                Log::error('message' . $exception->getMessage() . 'line :' . $exception->getLine());
                return redirect()->route('profile.register-referral.create', ['code' => $request->code])->with("error", "Thêm thành viên không thành công");
            }
        } else {
            return;
        }
    }


    public function drawPoint(ValidateDrawPoint $request)
    {

//        if ((float)($request->input('pay')) < moneyToPoint(config('point.typePoint.minMoneyRut'))) {
//            return redirect()->route('profile.index')->with("error", "Số tiền tối thiểu rút là: " . number_format(moneyToPoint(config('point.typePoint.minMoneyRut'))));
//        }

        
        if ((float)($request->input('pay')) < configMinRutVi()) {
            return redirect()->route('profile.index')->with("error", "Số tiền tối thiểu được rút là: " . number_format(configMinRutVi())."đ");
        }

//        $viVnd = $request->input('check_vivnd');
//        $eightyPercent = $viVnd * 0.8;

        $user = auth()->guard('web')->user();
        $persent = configPersentRutVi() / 100;
        $persentF = configPersentRutVi();
    
        $eightyPercent = $this->point->sumPointDiemCoTheRutCurrent($user->id) * $persent;

        //dd($this->point->where('type', 7)->where('user_id', $user->id)->sum('point'), $this->point->where('type', 8)->where('user_id', $user->id)->sum('point'));
        // dd($this->point->sumPointDiemCoTheRutCurrent($user->id));

        // $pointDaRut = $user->pays()->whereIn('status', [1, 2])->sum('point');
        // $pointDaMua = $this->point->where('user_id', $user->id)->whereIn('type', config("point.listTypePointDaMua"))->sum('point');
        
        //$pointDaRut = (float)($request->input('pay'));
        //dd($eightyPercent, $pointDaRut);
        //Nếu tổng số tiền rút lớn hơn 80% hoa hồng nhận được
        
        if($request->input('pay') > $eightyPercent){
            return redirect()->route('profile.index')->with("error", "Số tiền rút lớn hơn $persentF% tổng ví VNĐ được nhận");
        }
       
        
        if ((float)($request->input('pay')) > $eightyPercent) {
            if(($eightyPercent) > configMinRutVi()){
                return redirect()->route('profile.index')->with("error", "Số tiền tối đa được rút là: " . number_format($eightyPercent)."đ");
            }else{
                return redirect()->route('profile.index')->with("error", "Số tiền không đủ để rút");
            }
            
        }
        
        // if ((float)($request->input('pay')) > $eightyPercent) {
            
                
        //         return redirect()->route('profile.index')->with("error", "Số tiền tối đa được rút là: " . number_format($eightyPercent)."đ");
            
            
        // }
        
        

        if (date('d') >= $this->datePay['start'] && date('d') <= $this->datePay['end']) {
        
            $user = auth()->guard('web')->user();
            // if ($user->status == 2) {
            try {
                DB::beginTransaction();
                // Trừ điểm rút
                $user->points()->create([
                    'type' => $this->typePoint[7]['type'],
                    'point' => -(float)$request->input('pay'),
                    'active' => 1,
                ]);
                $user->pays()->create([
                    'status' => $this->typePay[1]['type'],
                    'user_id' => $user->id,
                    'point' => (float)$request->input('pay'),
                    'active' => 1,
                ]);

                DB::commit();
                return redirect()->route('profile.index')->with("alert", "Đã gửi thông tin rút điểm");
            } catch (\Exception $exception) {
                DB::rollBack();
                Log::error('message' . $exception->getMessage() . 'line :' . $exception->getLine());
                return redirect()->route('profile.index')->with("error", "Gửi thông tin rút điểm không thành công");
            }
            // } else {
            //     return redirect()->route('profile.editInfo')->with('drawPoint', 'Bạn phải hoàn thiện thông tin trước khi rút điểm');
            // }
        } else {
            return;
        }
    }
    public function pointToXu(ValidatePointToXu $request)
    {
        if ((float)($request->input('pay')) < moneyToPoint(config('point.typePoint.minMoneyRut'))) {
            return redirect()->route('profile.index')->with("error", "Số điểm tối thiểu rút là: " . number_format(moneyToPoint(config('point.typePoint.minMoneyRut'))));
        }

        if (date('d') >= $this->datePay['start'] && date('d') <= $this->datePay['end']) {
            $user = auth()->guard('web')->user();
            try {
                DB::beginTransaction();
                // Trừ điểm rút
                $user->points()->createMany([
                    [
                        'type' => $this->typePoint[11]['type'],
                        'point' => -(float)$request->input('pay'),
                        'active' => 1,
                    ],
                     [
                         'type' => $this->typePoint[10]['type'],
                         'point' => (float)$request->input('pay'),
                         'active' => 1,
                     ]
                ]);
                //$this->addPointWhenNapTien($user, (float)$request->input('pay'));
                DB::commit();
                return redirect()->route('profile.index')->with("alert", "Đã chuyển điểm sang xu thành công");
            } catch (\Exception $exception) {
                DB::rollBack();
                Log::error('message' . $exception->getMessage() . 'line :' . $exception->getLine());
                return redirect()->route('profile.index')->with("error", "Đã chuyển điểm sang xu không thành công");
            }
        } else {
            return;
        }
    }
    public function momoPayment(Request $request)
    {
        $user = auth()->user();
        $settingPay = $this->setting->find(100);
        return view("frontend.pages.profile_momo_payment", [
            'user' => $user,
            'settingPay' => $settingPay,
        ]);
    }
    public function momoPaymentPost(ValidateMomoPayment $request)
    {

        if ($request->type == "yeuem") {
            try {
                DB::beginTransaction();
                $point = $this->pointtt->create([
                    'money' => $request->pay,
                    'active' => 0,
                    'user_id' => auth()->id(),
                ]);
                DB::commit();
                return redirect(route("profile.momoPayment"))->with("alert", "Gửi yêu cầu thành công. Admin sẽ xử lý");
            } catch (\Exception $exception) {
                //throw $th;
                DB::rollBack();
                Log::error('message' . $exception->getMessage() . 'line :' . $exception->getLine());
                return redirect(route("profile.momoPayment"))->with("error", "Không thành công");
            }
        }
        $endpoint = config("laravel-omnipay.gateways.MoMoAIO.options.link");
        $orderInfo = "Thanh toán qua MoMo";
        $orderId = time() . "";
        // $returnUrl = "http://localhost:8000/atm/result_atm.php";
        $notifyurl = route("profile.momoPayment", ["mes" => "error"]);
        // Lưu ý: link notifyUrl không phải là dạng localhost
        $bankCode = "SML";

        $partnerCode = config("laravel-omnipay.gateways.MoMoAIO.options.partnerCode");
        $accessKey = config("laravel-omnipay.gateways.MoMoAIO.options.accessKey");
        $serectkey = config("laravel-omnipay.gateways.MoMoAIO.options.secretKey");
        $orderid =  time() . "";
        $orderInfo = $orderInfo;
        $amount = $request->pay;
        $bankCode = $bankCode;
        $returnUrl = route("profile.momoPaymentSuccess");
        $requestId = time() . "";
        $requestType = "payWithMoMoATM";
        $extraData = "";
        //before sign HMAC SHA256 signature
        $rawHashArr =  array(
            'partnerCode' => $partnerCode,
            'accessKey' => $accessKey,
            'requestId' => $requestId,
            'amount' => $amount,
            'orderId' => $orderid,
            'orderInfo' => $orderInfo,
            'bankCode' => $bankCode,
            'returnUrl' => $returnUrl,
            'notifyUrl' => $notifyurl,
            'extraData' => $extraData,
            'requestType' => $requestType
        );

        $rawHash = "partnerCode=" . $partnerCode . "&accessKey=" . $accessKey .
            "&requestId=" . $requestId . "&bankCode=" . $bankCode . "&amount=" .
            $amount . "&orderId=" . $orderid . "&orderInfo=" . $orderInfo .
            "&returnUrl=" . $returnUrl . "&notifyUrl=" . $notifyurl . "&extraData=" .
            $extraData . "&requestType=" . $requestType;

        $signature =  hash_hmac("sha256", $rawHash, $serectkey);

        $data =  array(
            'partnerCode' => $partnerCode,
            'accessKey' => $accessKey,
            'requestId' => $requestId,
            'amount' => $amount,
            'orderId' => $orderid,
            'orderInfo' => $orderInfo,
            'returnUrl' => $returnUrl,
            'bankCode' => $bankCode,
            'notifyUrl' => $notifyurl,
            'extraData' => $extraData,
            'requestType' => $requestType,
            'signature' => $signature,
        );

        $result = $this->execPostRequest($endpoint, json_encode($data));
        $jsonResult = json_decode($result, true);  // decode json
        //  dd($jsonResult);
        return redirect($jsonResult['payUrl']);
    }
    /*
    public function nganLuongPaymentPost(ValidateMomoPayment $request)
    {

        $NGANLUONG_URL = config('nganluong.NGANLUONG_URL');
        $RECEIVER =  config('nganluong.RECEIVER');
        $MERCHANT_ID =  config('nganluong.MERCHANT_ID');
        $MERCHANT_PASS =  config('nganluong.MERCHANT_PASS');
        $receiver = $RECEIVER;
        //Mã đơn hàng
        $order_code = 'NL_' . time();
        //Khai báo url trả về
        $return_url = $_SERVER['HTTP_REFERER'] . "/nl_payment_success";
        // Link nut hủy đơn hàng
        $cancel_url = $_SERVER['HTTP_REFERER'];
        $notify_url = $_SERVER['HTTP_REFERER'] . "/nl_payment_success";
        //Giá của cả giỏ hàng
        $txh_name = $request->txh_name;
        $txt_email = $request->txt_email;
        $txt_phone = $request->txt_phone;

        $flag = true;
        if (strlen($txh_name) > 50 || strlen($txt_email) > 50 || strlen($txt_phone) > 20) {
            $flag = false;
        }
        if (preg_match('/[\'^£$%&*()}{@#~?><>,|=_+¬-]/', $txh_name)) {
            $flag = false;
        }
        if (!$flag) {
            $user = auth()->user();
            $settingPay = $this->setting->find(100);
            return view("frontend.pages.profile_momo_payment", [
                'user' => $user,
                'settingPay' => $settingPay,
                'flag' => $flag,
            ]);
        }
        if ($flag) {
            $price = (int)$request->pay;
            //Thông tin giao dịch
            $transaction_info = "Thong tin giao dich";
            $currency = "vnd";
            $quantity = 1;
            $tax = 0;
            $discount = 0;
            $fee_cal = 0;
            $fee_shipping = 0;
            $order_description = "Thong tin don hang: " . $order_code;
            $buyer_info = $txh_name . "*|*" . $txt_email . "*|*" . $txt_phone;
            $affiliate_code = "";
            //Khai báo đối tượng của lớp NL_Checkout
            $nl = new NLClass();
            $nl->nganluong_url = $NGANLUONG_URL;
            $nl->merchant_site_code = $MERCHANT_ID;
            $nl->secure_pass = $MERCHANT_PASS;
            //Tạo link thanh toán đến nganluong.vn
            $url = $nl->buildCheckoutUrlExpand($return_url, $receiver, $transaction_info, $order_code, $price, $currency, $quantity, $tax, $discount, $fee_cal,    $fee_shipping, $order_description, $buyer_info, $affiliate_code);
            //$url= $nl->buildCheckoutUrl($return_url, $receiver, $transaction_info, $order_code, $price);


            //echo $url; die;
            if ($order_code != "") {
                //một số tham số lưu ý
                //&cancel_url=http://yourdomain.com --> Link bấm nút hủy giao dịch
                //&option_payment=bank_online --> Mặc định forcus vào phương thức Ngân Hàng
                $url .= '&cancel_url=' . $cancel_url . '&notify_url=' . $notify_url;
                //$url .='&option_payment=bank_online';

                echo '<meta http-equiv="refresh" content="0; url=' . $url . '" >';
                //&lang=en --> Ngôn ngữ hiển thị google translate
            }
        }
    }
    */
    public function nganLuongPaymentPost(ValidateMomoPayment $request)
    {
        $URL_DEMO =  (isset($_SERVER['HTTPS']) ? "https" : "http") . "://" . $_SERVER['HTTP_HOST'];

        $URL_CALLBACK =    $URL_DEMO . '/profile/nl_payment_success'; // URL đón nhận kết quả
        $config = array(
            "apiKey" => config('nganluong.apiKey'), //Là key dùng để xác định tài khoản nào đang được sử dụng.
            "encryptKey" => config('nganluong.encryptKey'), //Là key dùng để mã hóa dữ liệu truyền tới Alepay.
            "checksumKey" => config('nganluong.checksumKey'), //Là key dùng để tạo checksum data.
            "callbackUrl" => $URL_CALLBACK,
            "env" => config('nganluong.env'),
        );
        // dd($config);
        $alepay = new Alepay($config);
        $data = array();

        // parse_str(file_get_contents('php://input'), $params); // Lấy thông tin dữ liệu bắn vào

        $data['cancelUrl'] = $URL_DEMO;
        $data['amount'] = intval(preg_replace('@\D+@', '', $request->pay));
        $data['orderCode'] = date('dmY') . '_' . uniqid();
        $data['currency'] = 'VND';
        $data['orderDescription'] = 'Nạp tiền'; //$request->orderDescription;
        $data['totalItem'] = intval($request->totalItem);
        $data['checkoutType'] = 3; // Thanh toán trả góp
        $data['allowDomestic'] = true; // Thanh toán trả góp
        $data['buyerName'] = trim($request->buyerName);
        $data['buyerEmail'] = trim($request->buyerEmail);
        $data['buyerPhone'] = trim($request->phoneNumber);
        $data['buyerAddress'] = trim($request->buyerAddress);
        $data['buyerCity'] = trim($request->buyerCity);
        $data['buyerCountry'] = trim($request->buyerCountry);
        $data['month'] = 3;
        $data['paymentHours'] = 48; //48 tiếng :  Thời gian cho phép thanh toán (tính bằng giờ)

        foreach ($data as $k => $v) {
            if (empty($v)) {
                $alepay->return_json("NOK", "Bắt buộc phải nhập/chọn tham số [ " . $k . " ]");
                die();
            }
        }

        $baseUrlV3 = config("nganluong.baseUrl");

        $result = $alepay->sendOrderV3($baseUrlV3 . 'request-payment', $data);
        if (!empty($result->code)) {
            if ($result->code == '000') {
                echo '<meta http-equiv="refresh" content="0;url=' . $result->checkoutUrl . '">';
            } else {
                echo '<p style="text-align: center; margin-top: 15px;"><b>Response:</b> ' . json_encode($result, JSON_UNESCAPED_UNICODE) . '</p>';
            }
        }
    }

    public function nganLuongPaymentSuccess(Request $request)
    {

        $URL_DEMO =  (isset($_SERVER['HTTPS']) ? "https" : "http") . "://" . $_SERVER['HTTP_HOST'];

        $URL_CALLBACK =    $URL_DEMO . '/profile/nl_payment_success'; // URL đón nhận kết quả
        $config = array(
            "apiKey" => config('nganluong.apiKey'), //Là key dùng để xác định tài khoản nào đang được sử dụng.
            "encryptKey" => config('nganluong.encryptKey'), //Là key dùng để mã hóa dữ liệu truyền tới Alepay.
            "checksumKey" => config('nganluong.checksumKey'), //Là key dùng để tạo checksum data.
            "callbackUrl" => $URL_CALLBACK,
            "env" => config("nganluong.env"),
        );


        $errorCode = isset($request->errorCode) ? $request->errorCode : '';
        $transactionCode = isset($request->transactionCode) ? $request->transactionCode : '';
        $alepay = new Alepay($config);
        $utils = new \AlepayUtils();

        if ($errorCode == '000' || $errorCode == '155') {
            try {
                $info = json_decode($alepay->getTransactionInfo($transactionCode));
                $price = $info->amount;
                DB::beginTransaction();
                $user = auth()->user();
                $amount = $price;
                $this->addPointWhenNapTien($user, $amount);
                DB::commit();
                return redirect(route("profile.momoPayment"))->with("alert", "Thành công");
            } catch (\Exception $exception) {
                //throw $th;
                DB::rollBack();
                Log::error('message' . $exception->getMessage() . 'line :' . $exception->getLine());
                return redirect(route("profile.momoPayment"))->with("error", "Không thành công");
            }
        } else {
            return redirect(route("profile.momoPayment"))->with("error", "Giao dịch thất bại");
        }
    }
    // public function nganLuongPaymentSuccess(Request $request)
    // {

    //     if ($request->has('payment_id')) {
    //         // Lấy các tham số để chuyển sang Ngânlượng thanh toán:

    //         $transaction_info = $request->transaction_info;
    //         $order_code = $request->order_code;
    //         $price = $request->price;
    //         $payment_id = $request->payment_id;
    //         $payment_type = $request->payment_type;
    //         $error_text = $request->error_text;
    //         $secure_code = $request->secure_code;
    //         //Khai báo đối tượng của lớp NL_Checkout
    //         $nl = new NLClass();
    //         $nl->merchant_site_code = config('nganluong.MERCHANT_ID');
    //         $nl->secure_pass = config('nganluong.MERCHANT_PASS');
    //         //Tạo link thanh toán đến nganluong.vn
    //         $checkpay = $nl->verifyPaymentUrl($transaction_info, $order_code, $price, $payment_id, $payment_type, $error_text, $secure_code);

    //         if ($checkpay) {
    //             // echo 'Payment success: <pre>';
    //             // bạn viết code vào đây để cung cấp sản phẩm cho người mua
    //             // dd($request);
    //             try {
    //                 DB::beginTransaction();
    //                 $user = auth()->user();
    //                 $amount = $price;
    //                 $this->addPointWhenNapTien($user, $amount);
    //                 DB::commit();
    //                 return redirect(route("profile.momoPayment"))->with("alert", "Thành công");
    //             } catch (\Exception $exception) {
    //                 //throw $th;
    //                 DB::rollBack();
    //                 Log::error('message' . $exception->getMessage() . 'line :' . $exception->getLine());
    //                 return redirect(route("profile.momoPayment"))->with("error", "Không thành công");
    //             }
    //         } else {
    //             return redirect(route("profile.momoPayment"))->with("error", "Không hách được đâu cưng");
    //         }
    //     }
    // }

    function execPostRequest($url, $data)
    {
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt(
            $ch,
            CURLOPT_HTTPHEADER,
            array(
                'Content-Type: application/json',
                'Content-Length: ' . strlen($data)
            )
        );
        curl_setopt($ch, CURLOPT_TIMEOUT, 5);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
        //execute post
        $result = curl_exec($ch);
        //close connection
        curl_close($ch);
        return $result;
    }
    public function momoPaymentSuccess(Request $request)
    {
        $secretKey =  config("laravel-omnipay.gateways.MoMoAIO.options.secretKey"); //Put your secret key in there
        $partnerCode = $request->partnerCode;
        $accessKey = $request->accessKey;
        $orderId = $request->orderId;
        $localMessage = $request->localMessage;
        $message = $request->message;
        $transId = $request->transId;
        $orderInfo = $request->orderInfo;
        $amount = $request->amount;
        $errorCode = $request->errorCode;
        $responseTime = $request->responseTime;
        $requestId = $request->requestId;
        $extraData = $request->extraData;
        $payType = $request->payType;
        $orderType = $request->orderType;
        $extraData = $request->extraData;
        $m2signature = $request->signature;

        $rawHash = "partnerCode=" . $partnerCode . "&accessKey=" . $accessKey . "&requestId="
            . $requestId . "&amount=" . $amount . "&orderId=" . $orderId . "&orderInfo=" .
            $orderInfo . "&orderType=" . $orderType . "&transId=" . $transId . "&message=" .
            $message . "&localMessage=" . $localMessage . "&responseTime=" . $responseTime
            . "&errorCode=" . $errorCode . "&payType=" . $payType . "&extraData=" . $extraData;

        $partnerSignature = hash_hmac("sha256", $rawHash, $secretKey);
        $user = auth()->user();
        // dd($m2signature, $partnerSignature);
        if ($m2signature == $partnerSignature) {

            if ($errorCode == '0') {
                try {
                    DB::beginTransaction();
                    $this->addPointWhenNapTien($user, $amount);
                    DB::commit();
                    return redirect(route("profile.momoPayment"))->with("alert", "Thành công");
                } catch (\Exception $exception) {
                    //throw $th;
                    DB::rollBack();
                    Log::error('message' . $exception->getMessage() . 'line :' . $exception->getLine());
                    return redirect(route("profile.momoPayment"))->with("error", "Không thành công");
                }
            } else {
                return redirect(route("profile.momoPayment"))->with("error", "Không thành công");
            }
        }
        return redirect(route("profile.momoPayment"))->with("error", "Không hách được đâu cưng");
    }

    public function upDatePointWhenEndMonth()
    {
        $endMonth = Carbon::now()->endOfMonth()->format("d-m-y");
        $currentMonth = Carbon::now()->format("d-m-y");

        if ($endMonth == $currentMonth) {
            $this->point->where([
                ["type", 5],
                ["active", 0],
            ])->update([
                "active" => 1
            ]);
        }
    }
    public function upDatePointWhenEndYear()
    {
        $currentYear = date('Y');
        $currentCheck = Carbon::create($currentYear, 12, 1)->endOfMonth()->format("d-m-y");
        $check = Carbon::now()->format("d-m-y");
        if ($currentCheck == $check) {
            $this->point->where([
                ["type", 6],
                ["active", 0],
            ])->update([
                "active" => 1
            ]);
        }
    }

    //Bắn điểm cho user cha và con
    public function shootBB(Request $request)
    {
        try {
            DB::beginTransaction();
            $point = $request->BB;
            $user_id_nhan = $request->userSelect;
            $id_user_chuyen = $request->id_user;
            $sumEachTypeData = collect($this->point->sumEachTypeFrontend($id_user_chuyen));
            $bbUserChuyen = $sumEachTypeData->whereIn('type', config('point.listTypePointMH'))->sum("total");
            if( $point * getConfigBB() <= $bbUserChuyen){
                //Trừ bb của tài khoản chuyển
                Point::create([
                    'type' => config("point.typePoint")[16]['type'],
                    'point' => $point * getConfigBB(), //1BB = 1000
                    'active' => 1,
                    'user_id' => $user_id_nhan,
                    'userorigin_id' => $id_user_chuyen,
                    'point_id' => null,
                    'phantram' => null,
                    'created_at' => new \DateTime()
                ]);
                //Cộng bb của tài khoản
                Point::create([
                        'type' => config("point.typePoint")[15]['type'],
                        'point' => 0-($point * getConfigBB()), //1BB = 1000
                        'active' => 1,
                        'user_id' => $id_user_chuyen,
                        'userorigin_id' => $user_id_nhan,
                        'point_id' => null,
                        'phantram' => null,
                        "created_at" => new \DateTime()
                ]);
            }else{
                return redirect(route("profile.index"))->with("error1", "Số BB chuyển không được vượt quá số BB trong ví");
            }

            DB::commit();
            return redirect(route("profile.index"))->with("alert1", "Bắn BB thành công");
        } catch (\Exception $exception) {
            DB::rollBack();
            Log::error('message' . $exception->getMessage() . 'line :' . $exception->getLine());
            return redirect(route("profile.index"))->with("error1", "Bắn BB không thành công");
        }
    }
}
