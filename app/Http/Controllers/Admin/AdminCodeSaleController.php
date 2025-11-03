<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Slider;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Traits\StorageImageTrait;
use App\Traits\DeleteRecordTrait;
use App\Http\Requests\Admin\ValidateAddSlider;
use App\Http\Requests\Admin\ValidateEditSlider;
use App\Models\CodeSale;
use App\Models\Point;
use App\Models\Product;
use DateTime;
use Illuminate\Support\Str;
class AdminCodeSaleController extends Controller
{
    //
    use StorageImageTrait,DeleteRecordTrait;
    private $codeSale;
    private $product;
    private $point;
    public function __construct(CodeSale $codeSale, Product $product, Point $point)
    {
        $this->codeSale = $codeSale;
        $this->product = $product;
        $this->point = $point;
    }
    //
    public function index()
    {
        $data = $this->codeSale->orderBy("created_at", "desc")->paginate(15);

        return view("admin.pages.codeSale.list",
            [
                'data' => $data
            ]
        );
    }
    public function create(Request $request)
    {
        $dataProduct = $this->product->select("id", "name")->where("active", 1)->orderByDesc("created_at")->get();
        return view("admin.pages.codeSale.add",
            [
                'dataProduct' => $dataProduct,
            ]
        );
    }
    public function store(Request $request)
    {
        try {
            DB::beginTransaction();
            $dataCodeSale = collect();
            $count_sale = 1;
            if ($request->count_sale >0) {
                $count_sale = $request->count_sale;
            }
            for($i = 0; $i <= $request->number - 1; $i++) {
                $dataCodeSale->push([
                    "money" => $request->money,
                    'count_sale' => $count_sale,
                    "code" => Str::upper(Str::random(16)),
                    "date_start" => $request->date_start,
                    "date_end" => $request->date_end,
                    "created_at" => new DateTime(),
                    "product_id" => $request->product_id,
                    "active" => 1,
                    'admin_id' => auth()->guard("admin")->id(),
                ]);
            }
           // dd($dataCodeSale);
            $dataCodeSale->chunk(200)->each(function ($idPointChunk, $key) {
                DB::table("code_sales")->insert($idPointChunk->toArray());
            });
            DB::commit();
            return redirect()->route('admin.codeSale.index')->with("alert", "Thêm mã giảm giá  thành công");
        } catch (\Exception $exception) {
            //throw $th;
            DB::rollBack();
            Log::error('message' . $exception->getMessage() . 'line :' . $exception->getLine());
            return redirect()->route('admin.codeSale.create')->with("error", "Thêm mã giảm giá  không thành công");
        }
    }
    public function edit($id)
    {
        $data = $this->slider->find($id);
        return view("admin.pages.slider.edit", [
            'data' => $data
        ]);
    }
    public function update(ValidateEditSlider $request, $id)
    {
         try {
            DB::beginTransaction();
            $dataSliderUpdate = [
                "name" => $request->input('name'),
                "slug" => $request->input('slug'),
                "description" => $request->input('description'),
                "active" => $request->input('active'),
                "admin_id" => auth()->guard('admin')->id()
            ];
            $dataUploadImage = $this->storageTraitUpload($request, "image_path", "slider");
            if (!empty($dataUploadImage)) {
                $dataSliderUpdate["image_path"] = $dataUploadImage["file_path"];
            }
            // insert database in product table
            $this->slider->find($id)->update($dataSliderUpdate);
            DB::commit();
            return redirect()->route('admin.slider.index')->with("alert", "Sửa slider thành công");
        } catch (\Exception $exception) {
            //throw $th;
            DB::rollBack();
            Log::error('message' . $exception->getMessage() . 'line :' . $exception->getLine());
            return redirect()->route('admin.slider.edit', ['id' => $id])->with("error", "Sửa slider không thành công");;
        }
    }
    public function destroy($id)
    {
        return $this->deleteTrait($this->slider, $id);
    }

    public function loadActive($id)
    {
        $slider   =  $this->slider->find($id);
        $active = $slider->active;
        if ($active) {
            $activeUpdate = 0;
        } else {
            $activeUpdate = 1;
        }
        $updateResult =  $slider->update([
            'active' => $activeUpdate,
        ]);
        $slider   =  $this->slider->find($id);
        if ($updateResult) {
            return response()->json([
                "code" => 200,
                "html" => view('admin.components.load-change-active', ['data' => $slider,'type'=>'slider'])->render(),
                "message" => "success"
            ], 200);
        } else {
            return response()->json([
                "code" => 500,
                "message" => "fail"
            ], 500);
        }
    }
}
