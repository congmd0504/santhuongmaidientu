<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Store;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Traits\DeleteRecordTrait;
use App\Http\Requests\Admin\ValidateAddStore;
use App\Http\Requests\Admin\ValidateEditStore;
use App\Models\Product;
use App\Models\Transaction;
use App\Models\Admin;

class AdminStoreController extends Controller
{
    //
    use DeleteRecordTrait;
    private $store;
    private $admin;
    private $product;
    private $transaction;
    private $typeStore;

    public function __construct(Store $store, Product $product, Transaction $transaction, Admin $admin)
    {
        $this->store = $store;
        $this->product = $product;
        $this->admin = $admin;
        $this->transaction = $transaction;
        $this->typeStore = config('point.typeStore');
    }
    public function index(Request $request)
    {
        $data = $this->store->where('active', 1);
        $where = [];
        $whereIn = [];
        $orWhere = null;

        if ($request->input('keyword')) {
            // dd($request->input('keyword'));
            $adminId = $this->admin->where([
                ['email', 'like', '%' . $request->input('keyword') . '%'],
            ])->orWhere([
                ['name', 'like', '%' . $request->input('keyword') . '%'],
            ])->pluck('id')->toArray();

            // $whereIn[] = ['user_id',   $adminId];

            $transactionId = $this->transaction->where([
                ['code', 'like', '%' . $request->input('keyword') . '%'],
            ])->pluck('id')->toArray();
            //   dd($transactionId);
            $productId = $this->product->where([
                ['masp', 'like', '%' . $request->input('keyword') . '%'],
            ])->orWhere([
                ['name', 'like', '%' . $request->input('keyword') . '%'],
            ])->pluck('id')->toArray();
            $data = $data->whereIn('admin_id', $adminId)
                ->orWhereIn('product_id', $productId)
                ->orWhereIn('transaction_id', $transactionId);

            //  dd($userId);
            //  dd( $data = $data->whereIn('user_id',   $userId)->get());

        }
        if ($request->has('fill_action') && $request->input('fill_action')) {
            $key = $request->input('fill_action');

            switch ($key) {
                case 1:
                    $where[] = ['type', '=', 1];
                    break;
                case 2:
                    $where[] = ['type', '=', 2];
                    break;
                case 3:
                    $where[] = ['type', '=', 3];
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



      //  $data = $this->store->where('active', 1)->orderBy("created_at", "desc")->paginate(15);
        return view("admin.pages.store.list",
            [
                'data' => $data,
                'typeStore' => $this->typeStore,
                'keyword' => $request->input('keyword') ? $request->input('keyword') : "",
                'order_with' => $request->input('order_with') ? $request->input('order_with') : "",
                'fill_action' => $request->input('fill_action') ? $request->input('fill_action') : "",
            ]
        );
    }


    public function create(Request $request)
    {
        if (false !== array_search($request->type, [1, 3])) {
            return view(
                "admin.pages.store.add",
                [
                    'request' => $request,
                ]
            );
        } else {
            return;
        }
    }
    public function store(ValidateAddStore $request)
    {
        if (false === array_search($request->type, [1, 3])) {
            return;
        }
        try {
            DB::beginTransaction();
            $masp = $request->input('masp');
            $product = $this->product->where([
                'masp' => $masp,
            ])->first();
            $dataStoreCreate = [
                "active" => $request->input('active'),
                "type" => $request->input('type'),
                "admin_id" => auth()->guard('admin')->id()
            ];
            if ($request->type == 1) {
                $dataStoreCreate['quantity'] = $request->input('quantity') ?? null;
                $dataStoreCreate['product_id'] = $product->id;
                $store = $this->store->create($dataStoreCreate);
            }
            if ($request->type == 3) {
                //   dd($request->input('transaction_code'));
                $transaction = $this->transaction->where([
                    'code' => $request->input('transaction_code'),
                ])->first();

                // cập nhập admin xuất kho
                //   dd($listDataStoreCreate);
                foreach ($transaction->stores as $store) {
                    $store->update([
                        "admin_id" => auth()->guard('admin')->id(),
                        "type" => 3
                    ]);
                }
                //    dd($transaction->stores );
                // cập nhập transaction sang trạng thái vận chuyển
                $transaction->update([
                    'status' => 3,
                ]);
                //  dd($transaction->status);
            }
            //  dd($dataStoreCreate);

            DB::commit();
            return redirect()->route("admin.store.create", ['type' => $request->input('type') ?? 0])->with("alert", "Thêm thành công");
        } catch (\Exception $exception) {
            //throw $th;
            DB::rollBack();
            Log::error('message' . $exception->getMessage() . 'line :' . $exception->getLine());
            return redirect()->route("admin.store.create", ['type' => $request->input('type') ?? 0])->with("error", "Thêm không thành công");
        }
    }
    public function edit($id)
    {
        $data = $this->store->find($id);
        return view("admin.pages.store.edit", [
            'data' => $data
        ]);
    }
    public function update(ValidateEditStore $request, $id)
    {
        $store = $this->store->find($id);
        //  dd($store);
        if ($store->type == 1) {
            $product = $this->product->where([
                'masp' => $request->input('masp'),
            ])->first();
            $store->update([
                'product_id' => $product->id,
                'quantity' => $request->input('quantity'),
                'active' => $request->input('active'),
            ]);
            return redirect()->route("admin.store.index")->with("alert", "Sửa  thành công");
        }
    }
    public function destroy($id)
    {
        $store = $this->find($id);
        if ($store->type == 1) {
            return $this->deleteCategoryRecusiveTrait($this->store, $id);
        }
    }
}
