<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CategoryProduct;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

use App\Exports\ExcelExportsDatabase;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\ExcelImportsDatabase;


use App\Traits\StorageImageTrait;
use App\Http\Requests\Admin\ValidateEditCategoryProduct;
use App\Http\Requests\Admin\ValidateAddCategoryProduct;
use App\Traits\DeleteRecordTrait;


//use PDF;
class AdminCategoryProductController extends Controller
{
    use StorageImageTrait, DeleteRecordTrait;
    private $categoryProduct;
    public function __construct(CategoryProduct $categoryProduct)
    {
        $this->categoryProduct = $categoryProduct;
    }
    //
    public function index(Request $request)
    {

        // $pdf = \App::make('dompdf.wrapper');
        // $pdf->loadHTML('<h1>Test</h1>');
        // return $pdf->stream();

        $parentBr = null;
        if ($request->has('parent_id')) {
            $data = $this->categoryProduct->where('parent_id', $request->input('parent_id'))->orderBy("order")->paginate(15);
            if ($request->input('parent_id')) {
                $parentBr = $this->categoryProduct->find($request->input('parent_id'));
            }
        } else {
            $data = $this->categoryProduct->where('parent_id', 0)->orderBy("order")->paginate(15);
        }
        //  dd(config('excel_database.category_product.title'));
        //  dd( view(
        //      "admin.pages.categoryproduct.list",
        //      [
        //          'data' => $data
        //      ]
        //  )->renderSections()['content']);
        return view(
            "admin.pages.categoryproduct.list",
            [
                'data' => $data,
                'parentBr' => $parentBr,
            ]
        );
    }
    public function create(Request $request)
    {
        //    dd($request->query());
        if ($request->has("parent_id")) {
            $htmlselect = CategoryProduct::getHtmlOptionAddWithParent($request->parent_id);
        } else {
            $htmlselect = $this->categoryProduct->getHtmlOption();
        }

        return view(
            "admin.pages.categoryproduct.add",
            [
                'option' => $htmlselect,
                'request' => $request
            ]
        );
    }
    public function store(ValidateAddCategoryProduct $request)
    {

        try {
            DB::beginTransaction();
            $dataCategoryProductCreate = [
                "name" =>  $request->name,
                "slug" =>  $request->slug,
                "description" => $request->input('description'),
                "description_seo" => $request->input('description_seo'),
                "title_seo" => $request->input('title_seo'),
                "content" => $request->input('content'),
                "active" => $request->active,
                "order" => $request->order,
                "parent_id" => $request->parentId,
                "admin_id" => auth()->guard('admin')->id()
            ];
            $dataUploadIcon = $this->storageTraitUpload($request, "icon_path", "category-product");
            if (!empty($dataUploadIcon)) {
                $dataCategoryProductCreate["icon_path"] = $dataUploadIcon["file_path"];
            }
            $dataUploadAvatar = $this->storageTraitUpload($request, "avatar_path", "category-product");
            if (!empty($dataUploadAvatar)) {
                $dataCategoryProductCreate["avatar_path"] = $dataUploadAvatar["file_path"];
            }
            $this->categoryProduct->create($dataCategoryProductCreate);

            DB::commit();
            return redirect()->route("admin.categoryproduct.create", ['parent_id' => $request->parentId])->with("alert", "Thêm danh mục sản phẩm thành công");
        } catch (\Exception $exception) {
            DB::rollBack();
            Log::error('message' . $exception->getMessage() . 'line :' . $exception->getLine());
            return redirect()->route('admin.categoryproduct.create', ['parent_id' => $request->parentId])->with("error", "Thêm danh mục sản phẩm không thành công");
        }
    }
    public function edit($id)
    {
        $data = $this->categoryProduct->find($id);
        $parentId = $data->parent_id;
        $htmlselect = CategoryProduct::getHtmlOptionEdit($parentId, $id);
        return view("admin.pages.categoryproduct.edit", [
            'option' => $htmlselect,
            'data' => $data
        ]);
    }
    public function update(ValidateEditCategoryProduct $request, $id)
    {
        try {
            DB::beginTransaction();
            $dataCategoryProductUpdate = [
                "name" =>  $request->name,
                "slug" =>  $request->slug,
                "description" => $request->input('description'),
                "description_seo" => $request->input('description_seo'),
                "title_seo" => $request->input('title_seo'),
                "content" => $request->input('content'),
                "active" => $request->active,
                "order" => $request->order,
                "parent_id" => $request->parentId,
                "admin_id" => auth()->guard('admin')->id()
            ];

            $dataUpdateIcon = $this->storageTraitUpload($request, "icon_path", "category-product");
            if (!empty($dataUpdateIcon)) {
                $dataCategoryProductUpdate["icon_path"] = $dataUpdateIcon["file_path"];
            }
            $dataUpdateAvatar = $this->storageTraitUpload($request, "avatar_path", "category-product");
            if (!empty($dataUpdateAvatar)) {
                $dataCategoryProductUpdate["avatar_path"] = $dataUpdateAvatar["file_path"];
            }
            $this->categoryProduct->find($id)->update($dataCategoryProductUpdate);

            DB::commit();
            return redirect()->route("admin.categoryproduct.index")->with("alert", "Sửa sản phẩm thành công");
        } catch (\Exception $exception) {
            //throw $th;
            DB::rollBack();
            Log::error('message' . $exception->getMessage() . 'line :' . $exception->getLine());
            return redirect()->route('admin.categoryproduct.index')->with("error", "Sửa bài viết không thành công");
        }
    }
    public function destroy($id)
    {
        return $this->deleteCategoryRecusiveTrait($this->categoryProduct, $id);
    }

    public function excelExportDatabase()
    {
        return Excel::download(new ExcelExportsDatabase(config('excel_database.categoryProduct')), config('excel_database.categoryProduct.excelfile'));
    }
    public function excelImportDatabase()
    {
        $path = request()->file('fileExcel')->getRealPath();
        Excel::import(new ExcelImportsDatabase(config('excel_database.categoryProduct')), $path);
    }

    public function loadOrder($id, $order)
    {
        $data = $this->categoryProduct->find($id);

        try {
            DB::beginTransaction();



            DB::commit();
            return response()->json([
                "code" => 200,
                "html" => view()->render(),
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
}
