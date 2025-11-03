<?php

namespace App\Http\Controllers\Admin;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Transaction;
use App\Models\User;
use App\Models\Admin;
use App\Traits\DeleteRecordTrait;
use PDF;
use App\Traits\PointTrait;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Models\Point;
use App\Models\Setting;
class AdminTransactionController extends Controller
{
    //
    use DeleteRecordTrait, PointTrait;
    private  $transaction;
    private $unit;
    private $listStatus;
    private $typePoint;
    private $rose;
    private $admin;
    private $user;
	   private $point;
    public function __construct(Transaction $transaction, User $user, Admin $admin, Point $point)
    {
        $this->transaction = $transaction;
        $this->user = $user;
        $this->admin = $admin;
        $this->unit = "";
        $this->listStatus = $this->transaction->listStatus;
        $this->typePoint = config('point.typePoint');
        $this->rose = config('point.rose');
		$this->point = $point;
    }
    public function index(Request $request)
    {

		//  $totalMoney = $this->transaction->where([
        //     ["active", 1],
        //     ["status", 4]
        // ])->select(DB::raw("sum(total) as total"))->first()->total;
        $totalHoaHong = $this->point->whereIn("type", config("point.listTypePointDiemThuong"))->select(DB::raw("sum(point) as total"))->first()->total;
        $totalMoney = $this->point->where("type", config("point.typePoint.1.type"))->select(DB::raw("sum(point) as total"))->first()->total;
         $phantram = 0;
        if ($totalMoney != 0) {
            $phantram = round($totalHoaHong/$totalMoney *100, 2);
        }
       // dd($totalMoney, $totalHoaHong, $phantram);

        //thống kê giao dịch
        $transactionGroupByStatus = $this->transaction->where(['active' => 1])->select($this->transaction->raw('count(status) as total'), 'status')->groupBy('status')->get();


        $dataTransactionGroupByStatus = $this->listStatus;
        foreach ($transactionGroupByStatus as $item) {
            $dataTransactionGroupByStatus[$item->status]['total'] = $item->total;
        }
        //    dd($dataTransactionGroupByStatus);

        $transactions = $this->transaction->where(['active' => 1]);
        $where = [];
        $orWhere = null;
        if ($request->has('keyword') && $request->input('keyword')) {
           //   $where[] = ['name', 'like', '%' . $request->input('keyword') . '%'];
          //  $orWhere = ['code', 'like', '%' . $request->input('keyword') . '%'];


            //   dd($transactionId);
          //  $transactions= $transactions->whereIn('user_id',$userId)->orWhere('code', 'like', '%' . $request->input('keyword') . '%');

          $transactions= $transactions->where(function($query){
            $keyword =request()->input('keyword');
            $userId = $this->user->where([
                ['username', 'like', '%' .$keyword . '%'],
            ])->orWhere([
                ['name', 'like', '%' . $keyword . '%'],
            ])->pluck('id')->toArray();
            $adminId = $this->admin->where([
                ['name', 'like', '%' .$keyword . '%'],
            ])->orWhere([
                ['email', 'like', '%' . $keyword . '%'],
            ])->pluck('id')->toArray();

            $query->whereIn('user_id',$userId)
            ->orWhere('code', 'like', '%' . $keyword . '%')
            ->orWhereIn('admin_id',$adminId);

          });
        }
        if ($request->has('status') && $request->input('status')) {
            $where[] = ['status', $request->input('status')];
        }
        if ($where) {
            $transactions = $transactions->where($where);
        }
        //  dd($where);
        $orderby = [];
        if ($request->has('order_with') && $request->input('order_with')) {
            $key = $request->input('order_with');
            switch ($key) {
                case 'dateASC':
                    $orderby[] = ['created_at'];
                    break;
                case 'dateDESC':
                    $orderby[] = [
                        'created_at',
                        'DESC'
                    ];
                    break;
                case 'statusASC':
                    $orderby[] = ['status', 'ASC'];
                    $orderby[] = ['created_at', 'DESC'];
                    break;
                case 'statusDESC':
                    $orderby[] = ['status', 'DESC'];
                    $orderby[] = [
                        'created_at',
                        'DESC'
                    ];
                    break;
                default:
                    $orderby[]  = [
                        'created_at',
                        'DESC'
                    ];
                    break;
            }
            foreach ($orderby as $or) {
                $transactions = $transactions->orderBy(...$or);
            }
        } else {
            $transactions = $transactions->orderBy("created_at", "DESC");
        }
        $totalTransaction = $transactions->count();
      //  dd($totalTransaction);
        $transactions =  $transactions->paginate(15);
        
        
        
        
        return view('admin.pages.transaction.index', [
            'data' => $transactions,
            'dataTransactionGroupByStatus' => $dataTransactionGroupByStatus,
            'totalTransaction' => $totalTransaction,
            'listStatus' => $this->listStatus,
            'keyword' => $request->input('keyword') ? $request->input('keyword') : "",
            'order_with' => $request->input('order_with') ? $request->input('order_with') : "",
            'statusCurrent' => $request->input('status') ? $request->input('status') : "",
			'totalHoaHong' => $totalHoaHong,
			'totalMoney' => $totalMoney,
			'phantram' => $phantram,
        ]);
    }
    public function loadNextStepStatus(Request $request)
    {
        try {
            DB::beginTransaction();
            $id = $request->id;
            $transaction = $this->transaction->find($id);
            $status = $transaction->status;
            $add_point_20 = false;
            $dataUpdate = [];
            switch ($status) {
                case -1:
                    break;
                case 1:
                    $status += 1;
                    $dataUpdate['admin_id']=auth()->guard('admin')->user()->id;
                    break;
                case 2:
                    $status += 1;
                    $dataUpdate['admin_id']=auth()->guard('admin')->user()->id;
                    break;
                case 3:
                    $status += 1;
                    $dataUpdate['admin_id']=auth()->guard('admin')->user()->id;
                    // thêm số điểm cây 20 lớp
                    $i = 1;
                    $user = $transaction->user;
                    // $this->addPointParentAndUpdateMoney($user, $transaction);
                    break;
                case 4:
                    break;
                default:
                    break;
            }
            $dataUpdate['status']=$status;
            $transaction->update($dataUpdate);

            DB::commit();
            return response()->json([
                'code' => 200,
                'htmlStatus' => view('admin.components.status', [
                    'dataStatus' => $transaction,
                    'listStatus' => $this->listStatus,
                ])->render(),
                'messange' => 'success'
            ], 200);
        } catch (\Exception $exception) {
            //throw $th;
            DB::rollBack();
            Log::error('message' . $exception->getMessage() . 'line :' . $exception->getLine());
            return response()->json([
                'code' => 500,
                'htmlStatus' => "",
                'messange' => $exception->getMessage()
            ], 200);
        }

    }
    public function loadTransactionDetail($id)
    {
        $orders = $this->transaction->find($id)->orders()->get();
        return response()->json([
            'code' => 200,
            'htmlTransactionDetail' => view('admin.components.transaction-detail', [
                'orders' => $orders,
            ])->render(),
            'messange' => 'success'
        ], 200);
    }

    public function destroy($id)
    {
        return $this->deleteTrait($this->transaction, $id);
    }

    public function show($id)
    {
        $transactions = $this->transaction->find($id);
        return view('admin.pages.transaction.show', [
            'data' => $transactions,
            "unit" => $this->unit,
        ]);
    }
    public function exportPdfTransactionDetail($id)
    {

        $transactions = $this->transaction->find($id);
        $unit = $this->unit;
        $data = $transactions;
        $pdf = \App::make('dompdf.wrapper');

        $pdf->loadView("admin.pages.transaction.show-pdf", compact('data'), compact('unit'));

        return $pdf->download("transaction.pdf");
    }

	  public function editStatus($id)
    {
        $transaction=$this->transaction->find($id);
        if(!$transaction){
            abort(404);
        }

        return response()->json([
            'code' => 200,
            'html' => view('admin.components.loadStatusTransaction', [
                'data'=>$transaction
            ])->render(),
            'messange' => 'success'
        ], 200);
    }
    public function updateStatus($id,Request $request){
        try {
            DB::beginTransaction();
            $transaction=$this->transaction->find($id);
            if(!$transaction || $transaction->status == 4){
                abort(404);
            }
            if ($request->status == 4) {
                //  $this->addPointParentAndUpdateMoney($user, $transaction);
                $user = $this->user->find($transaction->user_id);
                $orderId = Order::where('transaction_id', $transaction->id)->first();
                $product = Product::find($orderId->product_id);
                if ($user) {
                
                    //Xây dựng luồng sản phẩm không tích lũy
                    if($product->khong_tich_luy_ds){
                        $phanTramThuongC1 = Setting::find(127)->value;
                        $parentC1 = $user->parent;
                        if ($parentC1) {
                            if($parentC1->level >= 2){
                                $parentC1->points()->createMany([
                                    [
                                        'type' => config("point.typePoint")[21]['type'],
                                        'point' => $transaction->total * $phanTramThuongC1 / 100,
                                        'active' => 1,
                                        'userorigin_id' => $user->id,
                                        'point_id' => null,
                                        'phantram' => null,
                                    ]
                                ]);
                            }

                            $parentC2 = $parentC1->parent;
                            $phanTramThuongC2 = Setting::find(128)->value;
                            if ($parentC2) {
                                if($parentC2->level >= 3){
                                    $parentC2->points()->createMany([
                                        [
                                            'type' => config("point.typePoint")[21]['type'],
                                            'point' => $transaction->total * $phanTramThuongC2 / 100,
                                            'active' => 1,
                                            'userorigin_id' => $user->id,
                                            'point_id' => null,
                                            'phantram' => null,
                                        ]
                                    ]);
                                }

                                $parentC3 = $parentC2->parent;
                                $phanTramThuongC3 = Setting::find(129)->value;
                                if ($parentC3) {
                                    if($parentC3->level >= 4){
                                        $parentC3->points()->createMany([
                                            [
                                                'type' => config("point.typePoint")[21]['type'],
                                                'point' => $transaction->total * $phanTramThuongC3 / 100,
                                                'active' => 1,
                                                'userorigin_id' => $user->id,
                                                'point_id' => null,
                                                'phantram' => null,
                                            ]
                                        ]);
                                    }
                                }
                            }
                        }

                    }

                    //Nếu mà sản phẩm được tính điểm thì mới cộng doanh số
                    if($product->is_tinh_diem == 1){
                        $totalMoney = $transaction->vi_vnd + $transaction->money;
                        //$totalMoney = $transaction->total;
                        $this->addPointWhenMuaHang($user, $totalMoney);
                    }
                }
            }

            $transaction->update([
                'status'=>$request->status,
            ]);

            
            //Thực hiện hoàn lại điểm và bb khi hủy đơn hàng
            if ($request->status == -1) {
                
                $user = $transaction->user;
                // hoàn điểm
                if ($user) {
                    //Check sản phẩm không tích lũy
                    $checkSPTichLuy = $transaction->orders()->first()->product->khong_tich_luy_ds;
                    if($checkSPTichLuy == 1){

                        //hoàn điểm bb
                        if($transaction->point > 0){
                            $user->points()->create([
                                'type' => $this->typePoint[26]['type'],
                                'point' => $transaction->point * getConfigBB(),//1BB = 1000
                                'active' => 1,
                            ]);
                        }

                        //hoàn điểm vnđ
                        if($transaction->vi_vnd > 0){
                            $user->points()->create([
                                'type' => $this->typePoint[23]['type'],
                                'point' => $transaction->vi_vnd,
                                'active' => 1,
                            ]);
                        }
                        
                        
                    }else{
                        
                        //hoàn điểm bb
                        if($transaction->point > 0){
                            $user->points()->create([
                                'type' => $this->typePoint[26]['type'],
                                'point' => $transaction->point * getConfigBB(),//1BB = 1000
                                'active' => 1,
                            ]);
                        }
                        //hoàn điểm vnđ
                        if($transaction->vi_vnd > 0){
                            $user->points()->create([
                                'type' => $this->typePoint[25]['type'],
                                'point' => $transaction->vi_vnd,
                                'active' => 1,
                            ]);
                        }
                    }
                }
                
            }
            DB::commit();
            return response()->json([
                'code' => 200,
                'html' => view('admin.components.status', [
                    'dataStatus' => $transaction,
                    'listStatus' => $this->listStatus,
                ])->render(),
                'messange' => 'success'
            ], 200);
        } catch (\Exception $exception) {
            //throw $th;
            DB::rollBack();
            Log::error('message' . $exception->getMessage() . 'line :' . $exception->getLine());
            return response()->json([
                'code' => 500,
                'html' => "",
                'messange' => 'error'
            ], 500);
        }

    }
}
