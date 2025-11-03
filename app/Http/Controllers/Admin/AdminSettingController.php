<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Setting;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Traits\StorageImageTrait;
use App\Traits\DeleteRecordTrait;
use App\Http\Requests\Admin\ValidateAddSetting;
use App\Http\Requests\Admin\ValidateEditSetting;

class AdminSettingController extends Controller
{
    //
    use StorageImageTrait, DeleteRecordTrait;
    private $setting;
    public function __construct(Setting $setting)
    {
        $this->setting = $setting;
    }
    public function index(Request $request)
    {
        $parentBr=null;
        if($request->has('parent_id')){
            $data = $this->setting->where('parent_id', $request->input('parent_id'))->orderBy("created_at", "desc")->paginate(15);
            if($request->input('parent_id')){
                $parentBr=$this->setting->find($request->input('parent_id'));
            }
        }else{
            $data = $this->setting->where('parent_id', 0)->orderBy("created_at", "desc")->paginate(15);
        }
        return view(
            "admin.pages.setting.list",
            [
                'data' => $data,
                'parentBr' => $parentBr,
            ]
        );
    }
    public function create(Request $request )
    {
        if($request->has("parent_id")){
            $htmlselect = $this->setting->getHtmlOptionAddWithParent($request->parent_id);
        }else{
            $htmlselect = $this->setting->getHtmlOption();
        }
        return view(
            "admin.pages.setting.add",
            [
                'option' => $htmlselect,
                'request' => $request
            ]
        );
    }
    public function store(ValidateAddSetting $request)
    {
        try {
            DB::beginTransaction();
            $dataSettingCreate = [
                "name" => $request->input('name'),
                "value" => $request->input('value'),
                "slug" => $request->input('slug'),
                "parent_id" => $request->input('parentId'),
                "description" => $request->input('description'),
                "active" => $request->input('active'),
                "order" => $request->input('order'),
                "admin_id" => auth()->guard('admin')->id()
            ];

            $dataUploadImage = $this->storageTraitUpload($request, "image_path", "setting");
            if (!empty($dataUploadImage)) {
                $dataSettingCreate["image_path"] = $dataUploadImage["file_path"];
            }
            // insert database in setting table
            $this->setting->create($dataSettingCreate);
            DB::commit();
            return redirect()->route('admin.setting.create',['parent_id'=>$request->parentId])->with("alert", "Thêm setting thành công");
        } catch (\Exception $exception) {
            //throw $th;
            DB::rollBack();
            Log::error('message' . $exception->getMessage() . 'line :' . $exception->getLine());
            return redirect()->route('admin.setting.create',['parent_id'=>$request->parentId])->with("error", "Thêm setting không thành công");
        }
    }
    public function edit($id)
    {
        $data = $this->setting->find($id);
        $parentId = $data->parent_id;
        $htmlselect = Setting::getHtmlOptionEdit($parentId, $id);
        return view("admin.pages.setting.edit", [
            'option' => $htmlselect,
            'data' => $data,
        ]);
    }
    public function update(ValidateEditSetting $request, $id)
    {
        try {
            DB::beginTransaction();
            $dataSettingUpdate = [
                "name" => $request->input('name'),
                "value" => $request->input('value'),
                "slug" => $request->input('slug'),
                "description" => $request->input('description'),
                "active" => $request->input('active'),
                "order" => $request->input('order'),
                'parent_id' => $request->input('parentId')
            ];

            $dataUploadImage = $this->storageTraitUpload($request, "image_path", "setting");
            if (!empty($dataUploadImage)) {
                $dataSettingUpdate["image_path"] = $dataUploadImage["file_path"];
            }
            $this->setting->find($id)->update($dataSettingUpdate);

            DB::commit();
            return redirect()->route('admin.setting.index')->with("alert", "Sửa setting thành công");
        } catch (\Exception $exception) {
            //throw $th;
            DB::rollBack();
            Log::error('message' . $exception->getMessage() . 'line :' . $exception->getLine());
            return redirect()->route('admin.setting.create')->with("error", "Sửa setting thành công");
        }
    }
    public function destroy($id)
    {
        return $this->deleteCategoryRecusiveTrait($this->setting, $id);
    }
}
