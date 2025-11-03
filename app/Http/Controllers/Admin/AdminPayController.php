<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Point;
use App\Models\User;
use App\Models\Pay;
use App\Models\Admin;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Exports\ExcelExportsDatabasePay;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Requests\Admin\ValidateExportExcelPay;

class AdminPayController extends Controller
{
    //
    private $numberChild = 3;
    private $typePoint;
    private $rose;
    private $user;
    private $pay;
    private $admin;
    private $typePay;
    public function __construct(Point $point, User $user, Pay $pay, Admin $admin)
    {
        $this->typePoint = config('point.typePoint');
        $this->rose = config('point.rose');
        $this->typePay = config('point.typePay');
        $this->user = $user;
        $this->point = $point;
        $this->pay = $pay;
        $this->admin = $admin;
    }
    public function index(Request $request)
    {

        $totalPay = $this->pay->count();
        $data = $this->pay->with(['user', 'admin']);

        $where = [];
        $whereIn = [];
        $orWhere = null;
        if ($request->input('keyword')) {
            // dd($request->input('keyword'));
            $userId = $this->user->where([
                ['username', 'like', '%' . $request->input('keyword') . '%'],
            ])->orWhere([
                ['name', 'like', '%' . $request->input('keyword') . '%'],
            ])->pluck('id')->toArray();
            //   dd($userId);
            //   dd();
            $whereIn[] = ['user_id',   $userId];
            //   dd($userId);
            //  dd( $data = $data->whereIn('user_id',   $userId)->get());
        }
        if ($request->has('fill_action') && $request->input('fill_action')) {
            $key = $request->input('fill_action');

            switch ($key) {
                case 'handle':
                    $where[] = ['status', '=', 1];
                    break;
                case 'complate':
                    $where[] = ['status', '=', 2];
                    break;
                case 'cancel':
                    $where[] = ['status', '=', 3];
                    break;

                default:
                    break;
            }
        }
        if ($where) {
            $data = $data->where($where);
        }
        if ($whereIn) {
            foreach ($whereIn as $w) {
                $data = $data->whereIn(...$w);
            }
        }
        //  dd($data->get());
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
                case 'statusASC':
                    $orderby = [
                        'status',
                        'ASC'
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

        $data = $data->paginate(15);


        // $data = $this->pay->where([
        //     'active' => 1,
        // ])->orderBy("created_at", "desc")->paginate(15);

        return view("admin.pages.pay.list",
            [
                'data' => $data,
                'typePay' => $this->typePay,
                'totalPay' => $totalPay,
                'keyword' => $request->input('keyword') ? $request->input('keyword') : "",
                'order_with' => $request->input('order_with') ? $request->input('order_with') : "",
                'fill_action' => $request->input('fill_action') ? $request->input('fill_action') : "",
            ]
        );
    }

    public function updateDrawPoint(Request $request)
    {
        try {
            DB::beginTransaction();
            if ($request->has('type') && $request->has('id')) {

                $adminId = auth()->guard('admin')->user()->id;
                //    dd($adminId);
                $type = $request->type;
                $id = $request->id;
                $pay = $this->pay->find($id);

                switch ($type) {
                    case 'complate':
                        $statusUpdate = 2;
                        break;
                    case 'error':
                        $statusUpdate = 3;
                        $user = $this->user->find($pay->user->id);
                        $user->points()->create([
                            'type' => $this->typePoint[8]['type'],
                            'point' => $pay->point,
                            'active' => 1,
                            'userorigin_id' => $adminId,
                        ]);
                        break;
                    default:
                        return;
                        break;
                }

                $resultUpdate = $pay->update([
                    'status' => $statusUpdate,
                    'admin_id' => $adminId,
                ]);
            }
            $pay = $this->pay->find($id);
            DB::commit();
            return response()->json([
                "code" => 200,
                "html" => $this->typePay[$pay->status]['name'],
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
    public function updateDrawPointAll(Request $request)
    {
        //   dd($request->has('type') && $request->has('id'));

        if ($request->has('type') && $request->has('id')) {
            $adminId = auth()->guard('admin')->user()->id;
            $type = $request->type;
            $listId = $request->get('id');
            switch ($type) {
                case 'complate':
                    $statusUpdate = 2;
                    break;
                case 'error':
                    $statusUpdate = 3;
                    break;
                default:
                    return;
                    break;
            }
            try {
                DB::beginTransaction();
                $dem = 0;
                foreach ($listId as $id) {
                    $pay = $this->pay->find($id);
                    $resultUpdate = $pay->update([
                        'status' => $statusUpdate,
                        'admin_id' => $adminId,
                    ]);
                    if ($resultUpdate) {
                        $dem++;
                    }
                    switch ($type) {
                        case 'complate':
                            $numberUpdate = "Đã chuyển " . $dem . " yêu cầu rút tiền sang trạng thái hoàn thành";
                            break;
                        case 'error':
                            $user = $this->user->find($pay->user->id);
                            $user->points()->create([
                                'type' => $this->typePoint[8]['type'],
                                'point' => $pay->point,
                                'active' => 1,
                                'userorigin_id' => $adminId,
                            ]);
                            break;
                        default:
                            return;
                            break;
                    }
                }

                switch ($type) {
                    case 'complate':
                        $numberUpdate = "Đã chuyển " . $dem . " yêu cầu rút tiền sang trạng thái hoàn thành";
                        break;
                    case 'error':
                        $numberUpdate = "Đã chuyển " . $dem . " yêu cầu rút tiền sang trạng thái lỗi và hoàn điểm lại";

                        break;
                    default:
                        return;
                        break;
                }

                DB::commit();
                return redirect()->route('admin.pay.index')->with("alert", "Xác nhận  thành công")->with("numberUpdate", $numberUpdate);
            } catch (\Exception $exception) {
                //throw $th;
                DB::rollBack();
                Log::error('message' . $exception->getMessage() . 'line :' . $exception->getLine());
                return redirect()->route('admin.pay.index')->with("error", "Xác nhận không thành công");
            }
        }
    }

    public function excelExportDatabase(ValidateExportExcelPay $request)
    {
        $start = $request->input('start');
        $end = $request->input('end');
        return Excel::download(new ExcelExportsDatabasePay($start, $end), 'pay.xlsx');
    }

    public function historyPoint(Request $request)
    {

        $data = $this->point->where(function($query){

            $query->where([
                'type' => 8,
                'active' => 1
            ])
            ->orWhere([
                'type' => 1,
                ['userorigin_id', '<>', 0]
            ]);
        });

        $where = [];
        $whereIn = [];
        $orWhere = null;

        if ($request->input('keyword')) {

            $adminId = $this->admin->where([
                ['name', 'like', '%' . $request->input('keyword') . '%'],
            ])->orWhere([
                ['email', 'like', '%' . $request->input('keyword') . '%'],
            ])->pluck('id')->toArray();
            //   dd($userId);
            //   dd();
            $whereIn[] = ['userorigin_id',   $adminId];
        }
        if ($request->has('fill_action') && $request->input('fill_action')) {
            $key = $request->input('fill_action');

            switch ($key) {
                case 'point':
                    $where[] = ['type', '=', 8];
                    break;
                case 'pointPM':
                    $where[] = ['type', '=', 1];
                    break;
                default:
                    break;
            }
        }
        if ($where) {
            $data = $data->where($where);
        }
        if ($whereIn) {
            foreach ($whereIn as $w) {
                $data = $data->whereIn(...$w);
            }
        }
        //  dd($data->get());
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
                case 'typeASC':
                    $orderby = [
                        'type',
                        'ASC'
                    ];
                    break;
                case 'typeDESC':
                    $orderby = [
                        'type',
                        'DESC'
                    ];
                    break;
                default:
                    $orderby = [
                        'created_at',
                        'DESC'
                    ];
                    break;
            }
            $data = $data->orderBy(...$orderby);
        } else {
            $data = $data->orderBy("created_at", "DESC");
        }

        $data = $data->paginate(15);


        // $data = $this->point->where([
        //     'type' => 8,
        //     'active' => 1
        // ])->orWhere([
        //     'type' => 1,
        //     ['userorigin_id', '<>', 0]
        // ])->paginate(15);
        //    dd($data);
        return view('admin.pages.pay.history-point', [
            'data' => $data,
            'typePoint' => $this->typePoint,
            'keyword' => $request->input('keyword') ? $request->input('keyword') : "",
            'order_with' => $request->input('order_with') ? $request->input('order_with') : "",
            'fill_action' => $request->input('fill_action') ? $request->input('fill_action') : "",
        ]);
    }
}
