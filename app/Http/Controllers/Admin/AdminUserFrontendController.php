<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\User;
use App\Models\Point;
use App\Traits\DeleteRecordTrait;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Requests\Admin\ValidateAddAdminUserFrontend;
use App\Http\Requests\Admin\ValidateEditAdminUserFrontend;
use Illuminate\Support\Facades\Hash;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Http\Requests\Admin\ValidateTranferPointBetweenXY;
use App\Http\Requests\Admin\ValidateTranferPointRandom;
use App\Http\Requests\Frontend\ValidateEditUser;
use App\Traits\PointTrait;
use App\Models\Bank;
use App\Models\Product;
use App\Models\Transaction;
use App\Traits\StorageImageTrait;
use Illuminate\Support\Facades\Auth;
use App\Models\Admin;
use App\Exports\ExcelExportsDatabase;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\ExcelImportsDatabase;
use App\Exports\ExcelExportsDatabaseUser;
use App\Http\Requests\Admin\ValidateAddPay;
use App\Http\Requests\Admin\ValidateBanDiem;
use App\Models\Pointtt;
use Exception;

class AdminUserFrontendController extends Controller
{
    //
    // các trạng thái tài khoản active
    // 0 vừa tạo chưa kích hoạt
    // 1 đã kích hoat
    // 2 khóa tài khoản
    use DeleteRecordTrait, PointTrait, StorageImageTrait;

    private $user;

    private $numberChild = 3;
    private $typePoint;
    private $rose;
    private $tranferPointDefault;
    private $bank;
    private $product;
    private $transaction;
    private $admin;
    private $point;
    private $pointtt;
    public function __construct(Point $point, User $user, Bank $bank, Product $product, Transaction $transaction, Admin $admin, Pointtt $pointtt)
    {
        $this->typePoint = config('point.typePoint');

        $this->rose = config('point.rose');
        $this->tranferPointDefault = config('point.transferPointDefault');
        $this->user = $user;
        $this->point = $point;
        $this->bank = $bank;
        $this->product = $product;
        $this->transaction = $transaction;
        $this->admin = $admin;
        $this->pointtt = $pointtt;
    }
    public function index(Request $request)
    {
        //  dd($this->product->setAppends(['number_pay'])->find(1));
        //   $a=  $this->product->setAppends(['pay'])->get()->toArray();
        //   asort($a);
        //  dd($a);
        // $this->point->where('type',3)->update([
        //     'point'=>1,
        // ]);


        $dataUserParent = $this->user->where('parent_id', 0)
            ->orWhereNull('parent_id')->get();
        $this->renderParent($dataUserParent);
        $totalUser = $this->user->count();
        $data = $this->user;
        $where = [];
        $orWhere = null;
        if ($request->input('keyword')) {
            $data = $data->where('name', 'like', '%' . $request->input('keyword') . '%')
                ->orWhere('username', 'like', '%' . $request->input('keyword') . '%');
        }
        if ($request->input('fill_status') != '') {
            $data = $data->where('status', $request->input('fill_status'));
        }
        if ($request->has('fill_action') && $request->input('fill_action')) {
            $key = $request->input('fill_action');

            switch ($key) {
                case 'userNoActive':
                    $where[] = ['active', '=', 0];
                    break;
                case 'userActive':
                    $where[] = ['active', '=', 1];
                    break;
                case 'userActiveKey':
                    $where[] = ['active', '=', 2];
                    break;
                default:
                    break;
            }
        }
        if ($where) {
            $data = $data->where($where);
        }
        //  dd($orWhere);
        if ($orWhere) {
            $data = $data->orWhere(...$orWhere);
        }
        if ($request->input('order_with')) {
            $key = $request->input('order_with');
            switch ($key) {
                case 'dateASC':
                    $orderby = ['created_at'];
                    break;
                case 'dateDESC':
                    $orderby = [
                        'created_at',
                        'DESC'
                    ];
                    break;
                case 'usernameASC':
                    $orderby = [
                        'username',
                        'ASC'
                    ];
                    break;
                case 'usernameDESC':
                    $orderby = [
                        'username',
                        'DESC'
                    ];
                    break;
                default:
                    $orderby =  $orderby = [
                        'created_at',
                        'DESC'
                    ];
                    break;
            }
            $data = $data->orderBy(...$orderby);
        } else {
            $data = $data->orderBy("created_at", "DESC");
        }
        //  dd($this->product->select('*', \App\Models\Store::raw('Sum(quantity) as total')->whereRaw('products.id','stores.product_id'))->orderBy('total')->paginate(15));

        $data = $data->paginate(15);

        //  $data = $this->user->whereIn('active', [1,2])->orderBy("order", "desc")->orderBy("created_at", "desc")->paginate(15);
        return view(
            "admin.pages.user_frontend.list",
            [
                'data' => $data,
                'totalUser' => $totalUser,
                'keyword' => $request->input('keyword') ? $request->input('keyword') : "",
                'order_with' => $request->input('order_with') ? $request->input('order_with') : "",
                'fill_action' => $request->input('fill_action') ? $request->input('fill_action') : "",
                'fill_status' => $request->input('fill_status'),
            ]
        );
    }
    public $i = 0;
    function renderParent($data)
    {
        $this->i++;
        foreach ($data as $user) {
            if ($user->parent_id == null || $user->parent_id == 0) {
                $user->update([
                    'parent_all_key' => null,
                ]);
            } else {

                $userParent = $user->parent;

                if ($userParent) {
                    $keyUpdate = "";
                    $parentKey = $userParent->parent_all_key;
                    if ($parentKey) {
                        $keyUpdate = $parentKey . $userParent->id . "|";
                    } else {
                        $keyUpdate = "|" . $userParent->id . "|";
                    }


                    $user->update([
                        'parent_all_key' => $keyUpdate,
                    ]);
                    // if ($this->i == 3) {
                    //     dd($user);
                    // }
                }
            }
        }
        // $listId = $data->map(function ($item, $key) {
        //     return $item->id;
        // });
        // $dataChild = $this->user->whereIn('parent_id', $listId)->get();
        // if ($dataChild->count() > 0) {
        //     $this->renderParent($dataChild);
        // } else {
        //     dd($this->i);
        // }
    }

    // public function listNoActive()
    // {
    //     $data = $this->user->where('active', 0)->orderBy("created_at", "desc")->paginate(15);
    //     return view(
    //         "admin.pages.user_frontend.list",
    //         [
    //             'data' => $data
    //         ]
    //     );
    // }

    public function detail($id, Request $request)
    {

        $user = $this->user->find($id);


        $rose = $this->point->where([
            ['user_id', $user->id],
            ['active', 1],
        ])->orderby('created_at', 'DESC')->paginate(15);
        //  dd($rose);
        $htmlRoseUserFrontend = view('admin.components.load-rose-user-front-end', [
            'user' => $user,
            'rose' => $rose,
            'typePoint' => $this->typePoint
        ])->render();



        $dataUserTotal = $user->childs;
        $dataUser = $this->paginate($dataUserTotal, 15);
        $dataUser->withPath(route('admin.user_frontend.detail', [
            'id' => $id
        ]));
        $htmlUserFrontend = view('admin.components.load-user-front-end', [
            'user' => $user,
            'dataUser' => $dataUser,
            'typePoint' => $this->typePoint
        ])->render();

        // $sumEachType = $this->point->sumEachType($user->id);
        $sumPointCurrent = $this->point->sumPointCurrent($user->id);

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

        ]);


        $sumEachTypeData = collect($this->point->sumEachTypeFrontend($user->id));
        $sumEachType = $sumEachType->map(function ($item) use ($sumEachTypeData) {
            $item['total'] = $sumEachTypeData->whereIn('type', $item['listType'])->sum("total");

            return $item;
        });


        if ($request->ajax()) {
            if ($request->type == 'user_frontend') {
                return response()->json([
                    'code' => 200,
                    'html' => $htmlUserFrontend,
                    'type' => 'user_frontend',
                    'messange' => 'success'
                ], 200);
            } else if ($request->type == 'rose-user_frontend') {
                return response()->json([
                    'code' => 200,
                    'html' => $htmlRoseUserFrontend,
                    'type' => 'rose-user_frontend',
                    'messange' => 'success'
                ], 200);
            }
        }
        return view(
            "admin.pages.user_frontend.detail",
            [
                'user' => $user,
                'rose' => $rose,
                'htmlRoseUserFrontend' => $htmlRoseUserFrontend,
                'htmlUserFrontend' => $htmlUserFrontend,
                'typePoint' => $this->typePoint,
                'sumEachType' => $sumEachType,
                'sumPointCurrent' => $sumPointCurrent
            ]
        );
    }
    public function create(Request $request = null)
    {
        //    $parent_id2 = $this->user->getParentIdOfNewUser();
        //   dd(   $parent_id2 );
        return view(
            "admin.pages.user_frontend.add",
            [
                'request' => $request,

            ]
        );
    }
    public function store(ValidateAddAdminUserFrontend $request)
    {
        try {
            DB::beginTransaction();

            //  $parent_id2 = $this->getParentIdOfNewUser();
            $parent_id2 = $this->user->getParentIdOfNewUser();
            //   dd( $parent_id2);
            $dataAdminUserFrontendCreate = [
                "name" => $request->input('name'),
                "username" => $request->input('username'),
                "email" => $request->input('email'),
                'order' => $this->user->getOrderOfNewUser(),
                "parent_id" => 0,
                "parent_id2" => $parent_id2,
                "password" => Hash::make('A123456'),
                "active" => 1,
                "code" => makeCodeUser($this->user),
                "admin_id" => auth()->guard('admin')->user()->id,
            ];
            //  dd($dataAdminUserFrontendCreate);
            // insert database in user table
            $user = $this->user->create($dataAdminUserFrontendCreate);
            // insert database to product_tags table

            $user->points()->create([
                'type' => $this->typePoint[1]['type'],
                'point' => $this->typePoint['defaultPoint'],
                'active' => 1,
                'userorigin_id' => 0
            ]);



            // thêm điểm thưởng cây 7 lớp
            //   dd($user->parent2);
            $this->addPointTo7($user);


            //   dd($this->product);
            $product = $this->product->where(['masp' => $request->input('masp')])->first();

            //   dd($product);
            $code = makeCodeTransaction($this->transaction);

            $totalPrice = $product->price * (100 - $product->sale) / 100;

            // thêm số điểm nạp lúc đầu
            $user->points()->create([
                'type' => $this->typePoint[4]['type'],
                'point' => moneyToPoint($totalPrice),
                'active' => 1,
            ]);

            // Trừ điểm mua sản phẩm
            $user->points()->create([
                'type' => $this->typePoint[6]['type'],
                'point' => -moneyToPoint($totalPrice),
                'active' => 1,
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
                'admin_id' => Auth::guard('admin')->user()->id,
                'user_id' => $user->id,
                'add_point_20' => 1,
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
            $pay = $product->pay;
            $product->update([
                'pay' => $pay + $dataOrderCreate[0]['quantity'],
            ]);

            //   dd($dataOrderCreate);
            // insert database in orders table by createMany
            $transaction->orders()->createMany($dataOrderCreate);

            // Đưa sản phẩm trong kho sang trạng thái đợi vận chuyển
            $dataStoreCreate = [
                "type" => 2,
                'active' => 1,
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

            // thêm điểm thưởng cây 20 lớp
            $this->addPointTo20($user, $totalPrice);

            DB::commit();
            return redirect()->route('admin.user_frontend.create')->with("alert", "Thêm thành viên  thành công");
        } catch (\Exception $exception) {
            DB::rollBack();
            Log::error('message' . $exception->getMessage() . 'line :' . $exception->getLine());
            return redirect()->route('admin.user_frontend.create')->with("error", "Thêm thành viên không thành công");
        }
    }

    public function edit($id)
    {

        $data = $this->user->find($id);

        $banks = $this->bank->get();
        return view("admin.pages.user_frontend.edit", [
            'data' => $data,
            'banks' => $banks,
        ]);
    }

    public function update($id, ValidateEditAdminUserFrontend $request)
    {

        // dd($request->input('bank_id'));
        try {
            DB::beginTransaction();
            $user = $this->user->find($id);
            $dataUserUpdate = [
                "name" => $request->input('name'),
                "email" => $request->input('email'),
                "username" => $request->input('username'),
                "phone" => $request->input('phone'),
                "date_birth" => $request->input('date_birth'),
                "address" => $request->input('address'),
                "hktt" => $request->input('hktt'),
                "cmt" => $request->input('cmt'),
                "stk" => $request->input('stk'),
                "ctk" => $request->input('ctk'),
                "bank_id" => $request->input('bank_id'),
                "bank_branch" => $request->input('bank_branch'),
                "sex" => $request->input('sex'),
                "level" => $request->input('level'),
                // 'status' => 2,
                // "active" => $request->input('active'),
            ];
            //  dd($dataUserUpdate);
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
            if (request()->has('password')) {
                if (request()->input('password')) {
                    $dataUserUpdate['password'] = Hash::make($request->input('password'));
                }
            }
            //   dd($dataUserUpdate);
            // insert database in product table
            $this->user->find($id)->update($dataUserUpdate);
            $user = $this->user->find($id);
            DB::commit();
            return redirect()->route('admin.user_frontend.index')->with("alert", "Thay đổi thông tin thành công");
        } catch (\Exception $exception) {
            DB::rollBack();
            Log::error('message' . $exception->getMessage() . 'line :' . $exception->getLine());
            return redirect()->route('admin.user_frontend.index')->with("error", "Thay đổi thông tin không thành công");
        }
    }

    public function destroy($id)
    {
        return $this->deleteTrait($this->user, $id);
    }
    public function destroyPointt($id)
    {
        return $this->deleteTrait($this->pointtt, $id);
    }
    public function getParentIdOfNewUser()
    {
        $numberChild = $this->numberChild;
        // công thức tính tổng số phần tử ở vòng thứ n là x*0 + (x^(n+1)-x)/(x-1);
        // công thức tính số phần tử của vòng thứ n = x^n;
        $numberUserDatabase = $this->user->where([
            'active' => 1,
        ])->get()->count();
        if ($numberUserDatabase > 0) {
            $numberUser = $numberUserDatabase + 1;
            $totalCicle = log((($numberUser - 1) * ($numberChild - 1) + $numberChild), $numberChild) - 1;
            // vòng hoàn thiện cuối cùng
            $n = floor($totalCicle);
            // dd($n);
            // tổng số user đến vòng thứ n là
            $numberUserN = 1 + (pow($numberChild, $n + 1) - $numberChild) / ($numberChild - 1);
            // dd($numberUserN);
            // số user đã có ở vòng tiếp theo
            $numberUserNNext = $numberUser - $numberUserN;
            // dd($numberUserNNext);
            // số user tối đa ở vòng tiếp theo là
            $numberUserMaxNNext = pow($numberChild, $n + 1);
            //  dd($numberUserMaxNNext);
            // số lượt rải chu kì ở vòng tiếp theo
            $nchuki = $numberUserMaxNNext / $numberChild;
            // user sẽ được làm cha của user mới là user thứ
            if ($numberUserNNext < $nchuki) {

                $nUserParent = $numberUserNNext;
            } else {
                if ($numberUserNNext % $nchuki == 0) {
                    $nUserParent = $nchuki;
                } else {
                    $nUserParent = $numberUserNNext % $nchuki;
                }
            }
            // if ($numberUserNNext % $nchuki == 0) {
            //     $nUserParent = $nchuki;
            // } else {
            //     $numberUserNNext = $numberUserNNext % $nchuki;
            //     $x = $numberUserNNext % $numberChild;
            //     while ($x>=$numberChild) {

            //     }

            // }
            // vị trị của thằng cha là
            $stt = $numberUserN - pow($numberChild, $n) + $nUserParent;
            // dd($nchuki);
            //  dd($nUserParent);
            // dd($stt);
            $userParent = $this->user->where([
                'active' => 1
            ])->orderBy('order', 'asc')->offset($stt - 1)->limit(1)->first();
            //   dd($nchuki);
            //  dd($n);
            //   dd($userParent);
            $parent_id2 = $userParent->id;
        } else {
            $parent_id2 = 0;
        }
        return $parent_id2;
    }

    public function loadActive($id)
    {
        try {
            DB::beginTransaction();
            $user   =  $this->user->find($id);
            $active = $user->active;
            $activeUpdate = 0;

            if ($active) {
                // $activeUpdate = 0;
            } else {
                $adminId = auth()->guard('admin')->user()->id;

                $activeUpdate = 1;

                $updateResult =  $user->update([
                    'active' => $activeUpdate,
                    'admin_id' => $adminId,
                ]);
                // dd($user->created_at);

            }

            DB::commit();

            return response()->json([
                "code" => 200,
                "html" => view('admin.components.load-change-active-user', ['data' => $user, 'type' => 'user'])->render(),
                "message" => "success"
            ], 200);
        } catch (\Exception $exception) {
            DB::rollBack();
            Log::error('message' . $exception->getMessage() . 'line :' . $exception->getLine());
            return response()->json([
                "code" => 500,
                "message" => "fail"
            ], 500);
        }
    }
    public function loadStatus($id)
    {
        try {
            DB::beginTransaction();
            $user   =  $this->user->find($id);
            $active = $user->status;
            $activeUpdate = 2;

            if ($active == 2 || $active == 0) {
                return response()->json([
                    "code" => 500,
                    "message" => "fail"
                ], 500);
            } else {
                $adminId = auth()->guard('admin')->user()->id;
                $updateResult =  $user->update([
                    'status' => $activeUpdate,
                    'admin_id' => $adminId,
                ]);
                $this->addPointKYC($user);
            }

            DB::commit();

            return response()->json([
                "code" => 200,
                "html" => view('admin.components.load-change-status-user', ['data' => $user, 'type' => 'user'])->render(),
                "message" => "success"
            ], 200);
        } catch (\Exception $exception) {
            DB::rollBack();
            Log::error('message' . $exception->getMessage() . 'line :' . $exception->getLine());
            return response()->json([
                "code" => 500,
                "message" => "fail"
            ], 500);
        }
    }
    // khóa tài khoản
    public function loadActiveKey($id)
    {


        $user   =  $this->user->find($id);
        $active = $user->active;

        if ($active) {
            try {
                DB::beginTransaction();
                $adminId = auth()->guard('admin')->user()->id;
                if ($active == 1) {
                    $activeUpdate = 2;
                } elseif ($active == 2) {
                    $activeUpdate = 1;
                }
                $orderUpdate = $this->user->getOrderOfNewUser();
                $updateResult =  $user->update([
                    'active' => $activeUpdate,
                    'admin_id' => $adminId,
                ]);
                DB::commit();
                if ($updateResult) {
                    return response()->json([
                        "code" => 200,
                        "html" => view('admin.components.load-change-active-user', ['data' => $user, 'type' => 'user'])->render(),
                        "message" => "success"
                    ], 200);
                } else {
                    return response()->json([
                        "code" => 500,
                        "message" => "fail"
                    ], 500);
                }
            } catch (\Exception $exception) {
                DB::rollBack();
                Log::error('message' . $exception->getMessage() . 'line :' . $exception->getLine());
                return response()->json([
                    "code" => 500,
                    "message" => "fail",
                    'title' => "Khóa tài khoản không thành công",
                ], 500);
            }
        } else {
            return response()->json([
                "code" => 500,
                "message" => "fail",
                'title' => "Khóa tài khoản không thành công do tài khoản chưa được kích hoạt",
            ], 200);
        }
    }
    public function banDiem()
    {
        $data = $this->user->select('id', 'username')->where('active', 1)->get();
        //dd($data);
        return view("admin.pages.user_frontend.ban-diem", [
            'data' => $data
        ]);
    }
    public function banDiemPost(ValidateBanDiem $request)
    {
        try {
            DB::beginTransaction();

            $point = $request->pay;
            $list = collect();

            /**
             * =============================
             *   Xử lý danh sách user nhận điểm
             * =============================
             */
            if ($request->type_shoot === 'user') {

                // Nếu chọn thành viên (một hoặc nhiều)
                if ($request->user_id) {
                    $list = collect($request->user_id);
                } else {
                    // Không chọn => bắn cho tất cả active
                    $list = $this->user->where("active", 1)->pluck("id");
                }
            } elseif ($request->type_shoot === 'rank') {

                // BẮN THEO RANK => Lấy các user có rank tương ứng
                if ($request->rank_id) {
                    return back()->with("error", "Vui lòng chọn hạng thành viên");
                }

                $list = $this->user
                    ->where("active", 1)
                    ->where("level", $request->rank_id)
                    ->pluck("id");
            }

            Log::info("Danh sách user nhận điểm: " . $list->implode(', '));

            /**
             * =============================
             *     Xử lý loại và số điểm
             * =============================
             */
            if ($request->type == 'diem') {
                $type = config("point.typePoint.13.type");
            }

            if ($request->type == 'xu') {
                $type = config("point.typePoint.12.type");
                $point = $point * getConfigBB(); // 1BB = 1000
            }

            /**
             * =============================
             *      Tạo dữ liệu insert
             * =============================
             */
            $dataInsert = $list->map(function ($id) use ($point, $type) {
                return [
                    'type'       => $type,
                    'point'      => $point,
                    'active'     => 1,
                    'user_id'    => $id,
                    'created_at' => now(),
                ];
            });

            // Chia nhỏ insert tránh tràn bộ nhớ
            $dataInsert->chunk(200)->each(function ($chunk) {
                DB::table("points")->insert($chunk->toArray());
            });

            DB::commit();
            return redirect(route("admin.user_frontend.banDiem"))
                ->with("alert", "Bắn điểm thành công");
        } catch (\Exception $exception) {

            DB::rollBack();
            Log::error('message: ' . $exception->getMessage() . ' line: ' . $exception->getLine());

            return redirect(route("admin.user_frontend.banDiem"))
                ->with("error", "Bắn điểm không thành công");
        }
    }

    public function banDiemIndex()
    {
        $data = $this->point->where('type', config("point.typePoint.12.type"))->orderByDesc("created_at")->paginate(15);
        return view("admin.pages.user_frontend.list-nap-tien-tu-admin", [
            'data' => $data,
        ]);
    }
    // load chi tiết user
    public function loadUserDetail($id)
    {
        $user = $this->user->find($id);
        $sumEachType = $this->point->sumEachType($id);
        $sumPointCurrent = $this->point->sumPointCurrent($id);
        //  dd($user);
        return response()->json([
            'code' => 200,
            'htmlTransactionDetail' => view('admin.components.user_frontend-detail', [
                'user' => $user,
                'sumEachType' => $sumEachType,
                'sumPointCurrent' => $sumPointCurrent,
                'typePoint' => $this->typePoint
            ])->render(),
            'messange' => 'success'
        ], 200);
    }

    // băn điểm với giá trị mặc định
    public function transferPoint($id)
    {
        try {
            DB::beginTransaction();


            $user   =  $this->user->whereIn('active', [1])->find($id);
            $adminId = auth()->guard('admin')->user()->id;
            $user->points()->create([
                'type' => $this->typePoint[8]['type'],
                'point' => $this->tranferPointDefault,
                'active' => 1,
                'userorigin_id' => $adminId
            ]);
            DB::commit();
            return response()->json([
                "code" => 200,
                "html" => '',
                "message" => "success"
            ], 200);
        } catch (\Exception $exception) {
            DB::rollBack();
            Log::error('message' . $exception->getMessage() . 'line :' . $exception->getLine());
            return response()->json([
                "code" => 500,
                "message" => "fail"
            ], 500);
        }
    }
    // bắn điểm từ STT x - y
    public function transferPointBetweenXY(ValidateTranferPointBetweenXY $request)
    {
        try {
            DB::beginTransaction();
            $adminId = auth()->guard('admin')->user()->id;
            $users   =  $this->user->whereIn('active', [1])->whereBetween('order', [$request->input('start'), $request->input('end')])->get();
            //  dd($users);
            $numberUser = $users->count();
            // dd($numberUser);
            foreach ($users as $user) {
                $user->points()->create([
                    'type' => $this->typePoint[8]['type'],
                    'point' => $this->tranferPointDefault,
                    'active' => 1,
                    'userorigin_id' => $adminId
                ]);
            }
            DB::commit();
            return redirect()->route("admin.user_frontend.index")->with("transferPointBetweenXY", "Bắn điểm thành công đên tổng số " . $numberUser . " thành viên từ STT " . $request->input('start') . "-" . $request->input('end'));
        } catch (\Exception $exception) {
            DB::rollBack();
            Log::error('message' . $exception->getMessage() . 'line :' . $exception->getLine());
            return redirect()->route("admin.user_frontend.index")->with("transferPointBetweenXYError", "Bắn điểm không  thành công");
        }
    }

    // bắn điểm với giá trị tùy chọn
    public function transferPointRandom(ValidateTranferPointRandom $request)
    {
        try {
            DB::beginTransaction();
            $adminCurrent = auth()->guard('admin')->user();
            //    dd($adminCurrent);
            $users   =  $this->user->whereIn('active', [1])->where('order', $request->input('order'))->get();
            //  dd($users);
            $numberUser = $users->count();
            // dd($numberUser);
            foreach ($users as $user) {
                $user->points()->create([
                    'type' => $this->typePoint[1]['type'],
                    'point' => $request->input('point'),
                    'active' => 1,
                    'userorigin_id' => $adminCurrent->id,
                ]);
            }
            DB::commit();
            return redirect()->route("admin.user_frontend.index")->with("transferPointRandom", "Bắn điểm thành công đên tổng số " . $numberUser . " thành viên có  STT " . $request->input('order'));
        } catch (\Exception $exception) {
            DB::rollBack();
            Log::error('message' . $exception->getMessage() . 'line :' . $exception->getLine());
            return redirect()->route("admin.user_frontend.index")->with("transferPointRandomError", "Bắn điểm không  thành công");
        }
    }

    public function paginate($items, $perPage = 5, $page = null, $options = [])
    {
        $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);
        $items = $items instanceof Collection ? $items : Collection::make($items);
        return new LengthAwarePaginator($items->forPage($page, $perPage), $items->count(), $perPage, $page, $options);
    }
    public function excelExportDatabase(Request $request)
    {
        $start = $request->input('start');
        $end = $request->input('end');
        $typeUser = $request->input('typeUser');
        //  dd($typeUser);
        // dd($start,$end);
        return Excel::download(new ExcelExportsDatabaseUser($start, $end, $typeUser), 'user.xlsx');
    }


    public function napTien($id)
    {
        $data = $this->user->find($id);
        return view("admin.pages.user_frontend.nap-tien", [
            'data' => $data,
        ]);
    }
    public function napTienPost($id, ValidateAddPay $request)
    {
        try {
            DB::beginTransaction();
            $user = $this->user->find($id);
            $this->addPointWhenNapTien($user, $request->pay);
            DB::commit();
            return redirect(route("admin.user_frontend.index"))->with("alert", "Thành công");
        } catch (\Exception $exception) {
            DB::rollBack();
            Log::error('message' . $exception->getMessage() . 'line :' . $exception->getLine());
            return redirect(route("admin.user_frontend.napTien"))->with("error", "Nạp không thành công");
        }
    }
    public function napTienIndex()
    {
        $data = $this->point->where([
            ["type", config('point.typePoint.1.type')],
        ])->paginate(15);
        return view("admin.pages.user_frontend.list-nap-tien", [
            'data' => $data,
        ]);
    }
    public function napTienDuyetIndex()
    {
        $data = $this->pointtt->orderByDesc("created_at")->paginate(15);
        return view("admin.pages.user_frontend.list-nap-tien-duyet", [
            'data' => $data,
        ]);
    }
    public function napTienDuyet($id)
    {

        $data = $this->pointtt->find($id);
        if (!$data || $data->active == 1 || !$data->user) {
            return redirect(route("admin.user_frontend.napTienDuyetIndex"))->with("error", "Không thành công");
        }
        try {
            // DB::beginTransaction();
            //dd($this->addPointWhenNapTien($data->user, $data->money));
            $this->addPointWhenNapTien($data->user, $data->money);
            // dd($updateResult);
            $data->update([
                'active' => 1,
            ]);


            return response()->json([
                "code" => 200,
                "html" => view('admin.components.load-change-pay', ['data' => $data, 'type' => 'duyệt'])->render(),
                "message" => "success"
            ], 200);
            // if ($updateResult) {


            // } else {
            //     return response()->json([
            //         "code" => 500,
            //         "message" => "fail"
            //     ], 500);
            // }
            // DB::commit();
            // return redirect(route("admin.user_frontend.napTienDuyetIndex"))->with("alert", "Thành công");
        } catch (\Exception $exception) {
            DB::rollBack();
            Log::error('message' . $exception->getMessage() . 'line :' . $exception->getLine());
            return response()->json([
                "code" => 500,
                "message" => "fail"
            ], 500);
            //return redirect(route("admin.user_frontend.napTienDuyetIndex"))->with("error", "Không thành công");
        }
    }
    public function upDatePointWhenEndMonth()
    {
        try {
            DB::beginTransaction();
            $this->point->where([
                ["type", 18],
                ["active", 0],
            ])->update([
                "active" => 1
            ]);
            DB::commit();
            return redirect(route("admin.user_frontend.index"))->with("alert", "Thành công");
        } catch (\Exception $exception) {
            DB::rollBack();
            Log::error('message' . $exception->getMessage() . 'line :' . $exception->getLine());
            return redirect(route("admin.user_frontend.index"))->with("error", "Không thành công");
        }
    }
    public function upDatePointWhenEndYear()
    {
        try {
            DB::beginTransaction();
            $this->point->where([
                ["type", 19],
                ["active", 0],
            ])->update([
                "active" => 1
            ]);
            DB::commit();
            return redirect(route("admin.user_frontend.index"))->with("alert", "Thành công");
        } catch (\Exception $exception) {
            DB::rollBack();
            Log::error('message' . $exception->getMessage() . 'line :' . $exception->getLine());
            return redirect(route("admin.user_frontend.index"))->with("error", "Không thành công");
        }
    }

    public function level(Request $request)
    {
        $id = $request->id;
        $user = $this->user->find($id);
        return view('admin.pages.user_frontend.level', [
            'user' => $user,
        ]);
    }

    public function updatLevel($id, Request $request)
    {

        try {
            DB::beginTransaction();
            $typePoint = config('point.typePoint');
            $user = $this->user->find($id);
            $thanhTien = getConfigBB(); //1BB = 1000
            //Cập nhật lại level cho user
            $dataUserUpdate = [
                "level" => $request->input('level'),
            ];
            $user->update($dataUserUpdate);
            //Thưởng cấp BB
            $level = $user->level;
            $thuongCap = $user->thuong_cap;

            if ($level > $thuongCap) {
                if ($level == 5) {

                    $user->points()->create([
                        'type' => $typePoint[20]['type'],
                        'point' => 200000 * $thanhTien,
                        'active' => 1,
                        'userorigin_id' => $user->id,
                    ]);
                    $dataUserUpdateCap = [
                        "thuong_cap" => $level,
                    ];
                    $user->update($dataUserUpdateCap);
                } else if ($level == 4) {

                    $user->points()->create([
                        'type' => $typePoint[20]['type'],
                        'point' => 75000 * $thanhTien,
                        'active' => 1,
                        'userorigin_id' => $user->id,
                    ]);
                    $dataUserUpdateCap = [
                        "thuong_cap" => $level,
                    ];
                    $user->update($dataUserUpdateCap);
                } else if ($level == 3) {

                    $user->points()->create([
                        'type' => $typePoint[20]['type'],
                        'point' => 22000 * $thanhTien,
                        'active' => 1,
                        'userorigin_id' => $user->id,
                    ]);
                    $dataUserUpdateCap = [
                        "thuong_cap" => $level,
                    ];
                    $user->update($dataUserUpdateCap);
                } else if ($level == 2) {

                    $user->points()->create([
                        'type' => $typePoint[20]['type'],
                        'point' => 10000 * $thanhTien,
                        'active' => 1,
                        'userorigin_id' => $user->id,
                    ]);
                    $dataUserUpdateCap = [
                        "thuong_cap" => $level,
                    ];
                    $user->update($dataUserUpdateCap);
                } else  if ($level == 1) {

                    $user->points()->create([
                        'type' => $typePoint[20]['type'],
                        'point' => 2000 * $thanhTien,
                        'active' => 1,
                        'userorigin_id' => $user->id,
                    ]);
                    $dataUserUpdateCap = [
                        "thuong_cap" => $level,
                    ];
                    $user->update($dataUserUpdateCap);
                }
            }


            DB::commit();
            return redirect()->route('admin.user_frontend.index')->with("alert", "Cập nhật level thành công");
        } catch (\Exception $exception) {
            dd($exception);
            DB::rollBack();
            Log::error('message' . $exception->getMessage() . 'line :' . $exception->getLine());
            return redirect()->route('admin.user_frontend.index')->with("error", "Cập nhật level không thành công");
        }
    }
}
