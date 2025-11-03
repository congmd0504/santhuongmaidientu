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
class AdminSliderController extends Controller
{
    //
    use StorageImageTrait,DeleteRecordTrait;
    private $slider;
    public function __construct(Slider $slider)
    {
        $this->slider = $slider;
    }
    //
    public function index()
    {
        $data = $this->slider->orderBy("created_at", "desc")->paginate(15);

        return view(
            "admin.pages.slider.list",
            [
                'data' => $data
            ]
        );
    }
    public function create(Request $request = null)
    {
        return view(
            "admin.pages.slider.add",
            [
                'request' => $request
            ]
        );
    }
    public function store(ValidateAddSlider $request)
    {
        try {
            DB::beginTransaction();
            $dataSliderCreate = [
                "name" => $request->input('name'),
                "slug" => $request->input('slug'),
                "description" => $request->input('description'),
                "active" => $request->input('active'),
                "admin_id" => auth()->guard('admin')->id()
            ];
            $dataUploadImage = $this->storageTraitUpload($request, "image_path", "slider");
            if (!empty($dataUploadImage)) {
                $dataSliderCreate["image_path"] = $dataUploadImage["file_path"];
            }

            // insert database in slider table
            $this->slider->create($dataSliderCreate);

            DB::commit();
            return redirect()->route('admin.slider.create')->with("alert", "Thêm slider thành công");
        } catch (\Exception $exception) {
            //throw $th;
            DB::rollBack();
            Log::error('message' . $exception->getMessage() . 'line :' . $exception->getLine());
            return redirect()->route('admin.slider.create')->with("error", "Thêm slider không thành công");
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
