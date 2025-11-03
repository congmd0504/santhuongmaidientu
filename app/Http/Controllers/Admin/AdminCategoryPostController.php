<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CategoryPost;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Traits\StorageImageTrait;
use App\Http\Requests\Admin\ValidateEditCategoryPost;
use App\Http\Requests\Admin\ValidateAddCategoryPost;
use App\Traits\DeleteRecordTrait;
use Illuminate\Support\Collection;

use App\Exports\ExcelExportsDatabase;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\ExcelImportsDatabase;


class AdminCategoryPostController extends Controller
{
    private $categoryPost;
    use StorageImageTrait, DeleteRecordTrait;
    public function __construct(CategoryPost $categoryPost)
    {
        $this->categoryPost = $categoryPost;
    }
    //
    public function index(Request $request)
    {

        $parentBr=null;
        if($request->has('parent_id')){
            $data = $this->categoryPost->where('parent_id', $request->input('parent_id'))->orderBy("created_at", "desc")->paginate(15);
            if($request->input('parent_id')){
                $parentBr=$this->categoryPost->find($request->input('parent_id'));
            }
        }else{
            $data = $this->categoryPost->where('parent_id',0)->orderBy("created_at", "desc")->paginate(15);
        }
        // $allData = $data->map(function ($data){
        //     $listIdParent=$this->categoryPost->getALlCategoryParent($data->id);
        //     $data->breadcrumbs= $this->categoryPost->select('id','name','slug')->find($listIdParent)->toArray();
        //     return $data;
        // });

        return view(
            "admin.pages.categorypost.list",
            [
                'data' => $data,
                'parentBr' => $parentBr,
            ]
        );
    }
    public function create(Request $request )
    {
        if($request->has("parent_id")){
            $htmlselect = $this->categoryPost->getHtmlOptionAddWithParent($request->parent_id);
        }else{
            $htmlselect = $this->categoryPost->getHtmlOption();
        }

        return view(
            "admin.pages.categorypost.add",
            [
                'option' => $htmlselect,
                'request' => $request
            ]
        );
    }
    public function store(ValidateAddCategoryPost $request)
    {
        try {
            DB::beginTransaction();
            $dataCategoryPostCreate = [
                "name" =>  $request->name,
                "slug" =>  $request->slug,
                "description" => $request->input('description'),
                "description_seo" => $request->input('description_seo'),
                "title_seo" => $request->input('title_seo'),
                "content" => $request->input('content'),
                "active" => $request->active,
                "parent_id" => $request->parentId,
                "admin_id" => auth()->guard('admin')->id()
            ];
            $dataUploadIcon = $this->storageTraitUpload($request, "icon_path", "category-post");
            if (!empty($dataUploadIcon)) {
                $dataCategoryPostCreate["icon_path"] = $dataUploadIcon["file_path"];
            }
            $dataUploadAvatar = $this->storageTraitUpload($request, "avatar_path", "category-post");
            if (!empty($dataUploadAvatar)) {
                $dataCategoryPostCreate["avatar_path"] = $dataUploadAvatar["file_path"];
            }
            $this->categoryPost->create($dataCategoryPostCreate);
            DB::commit();
            return redirect()->route("admin.categorypost.create",['parent_id'=>$request->parentId])->with("alert", "Thêm bài viết thành công");
        } catch (\Exception $exception) {
            DB::rollBack();
            Log::error('message' . $exception->getMessage() . 'line :' . $exception->getLine());
            return redirect()->route('admin.categorypost.create',['parent_id'=>$request->parentId])->with("error", "Thêm bài viết không thành công");
        }
    }
    public function edit($id)
    {
        $data = $this->categoryPost->find($id);
        $parentId = $data->parent_id;
        $htmlselect = CategoryPost::getHtmlOptionEdit($parentId,$id);
        return view("admin.pages.categorypost.edit", [
            'option' => $htmlselect,
            'data' => $data
        ]);
    }
    public function update(ValidateEditCategoryPost $request, $id)
    {
        try {
            DB::beginTransaction();
            $dataCategoryPostUpdate = [
                "name" =>  $request->name,
                "slug" =>  $request->slug,
                "description" => $request->input('description'),
                "description_seo" => $request->input('description_seo'),
                "title_seo" => $request->input('title_seo'),
                "content" => $request->input('content'),
                "active" => $request->active,
                "parent_id" => $request->parentId,
                "admin_id" => auth()->guard('admin')->id()
            ];

            $dataUpdateIcon = $this->storageTraitUpload($request, "icon_path", "category-post");
            if (!empty($dataUpdateIcon)) {
                $dataCategoryPostUpdate["icon_path"] = $dataUpdateIcon["file_path"];
            }
            $dataUpdateAvatar = $this->storageTraitUpload($request, "avatar_path", "category-post");
            if (!empty($dataUpdateAvatar)) {
                $dataCategoryPostUpdate["avatar_path"] = $dataUpdateAvatar["file_path"];
            }
            $this->categoryPost->find($id)->update($dataCategoryPostUpdate);
            DB::commit();
            return redirect()->route("admin.categorypost.index")->with("alert", "Sửa bài viết  thành công");
        } catch (\Exception $exception) {
            //throw $th;
            DB::rollBack();
            Log::error('message' . $exception->getMessage() . 'line :' . $exception->getLine());
            return redirect()->route('admin.categorypost.index')->with("error", "Sửa  bài viết không thành công");;
        }
    }
    public function destroy($id)
    {
        return $this->deleteCategoryRecusiveTrait($this->categoryPost, $id);
    }
    public function excelExportDatabase()
    {
        return Excel::download(new ExcelExportsDatabase(config('excel_database.categoryPost')), config('excel_database.categoryPost.excelfile'));
    }
    public function excelImportDatabase()
    {
        $path =request()->file('fileExcel')->getRealPath();
        Excel::import(new ExcelImportsDatabase(config('excel_database.categoryPost')), $path);
    }
}
