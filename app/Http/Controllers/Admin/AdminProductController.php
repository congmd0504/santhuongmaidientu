<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\CategoryProduct;
use App\Models\ProductImage;
use App\Models\Tag;
use App\Models\ProductTag;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Traits\StorageImageTrait;
use App\Traits\DeleteRecordTrait;
use App\Http\Requests\Admin\ValidateAddProduct;
use App\Http\Requests\Admin\ValidateEditProduct;

use App\Exports\ExcelExportsDatabase;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\ExcelImportsDatabase;

class AdminProductController extends Controller
{
    //
    use StorageImageTrait, DeleteRecordTrait;
    private $product;
    private $categoryProduct;
    private $htmlselect;
    private $productImage;
    private $tag;
    private $productTag;
    public function __construct(Product $product, CategoryProduct $categoryProduct, ProductImage $productImage, Tag $tag, ProductTag $productTag)
    {
        $this->product = $product;
        $this->categoryProduct = $categoryProduct;
        $this->productImage = $productImage;
        $this->tag = $tag;
        $this->productTag = $productTag;
    }
    //
    public function index(Request $request)
    {
        $totalProduct = $this->product->all()->count();
        $data = $this->product;
        if ($request->input('category')) {
            $categoryProductId = $request->input('category');
            $idCategorySearch = $this->categoryProduct->getALlCategoryChildren($categoryProductId);
            $idCategorySearch[] = (int)($categoryProductId);
            $data = $data->whereIn('category_id', $idCategorySearch);
            $htmlselect = $this->categoryProduct->getHtmlOption($categoryProductId);
        } else {
            $htmlselect = $this->categoryProduct->getHtmlOption();
        }
        $where = [];
        $orWhere=null;
        if ($request->input('keyword')) {
            $where[] = ['name', 'like', '%' . $request->input('keyword') . '%'];
            $orWhere=['masp', 'like', '%' . $request->input('keyword') . '%'];
        }
        if ($request->has('fill_action') && $request->input('fill_action')) {
            $key = $request->input('fill_action');

            switch ($key) {
                case 'hot':
                    $where[] = ['hot', '=', 1];
                    break;
                case 'no_hot':
                    $where[] = ['hot', '=', 0];
                    break;
                case 'active':
                    $where[] = ['active', '=', 1];
                    break;
                case 'no_active':
                    $where[] = ['active', '=', 0];
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
                case 'viewASC':
                    $orderby = [
                        'view',
                        'ASC'
                    ];
                    break;
                case 'viewDESC':
                    $orderby = [
                        'view',
                        'DESC'
                    ];
                    break;
                case 'priceASC':
                    $orderby = [
                        'price',
                        'ASC'
                    ];
                    break;
                case 'priceDESC':
                    $orderby = [
                        'price',
                        'DESC'
                    ];
                    break;
                case 'payASC':
                    $orderby = [
                        'pay',
                        'ASC'
                    ];
                    break;
                case 'payDESC':
                    $orderby = [
                        'pay',
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

        return view("admin.pages.product.list",
            [
                'data' => $data,
                'totalProduct'=>$totalProduct,
                'option' => $htmlselect,
                'keyword' => $request->input('keyword') ? $request->input('keyword') : "",
                'order_with' => $request->input('order_with') ? $request->input('order_with') : "",
                'fill_action' => $request->input('fill_action') ? $request->input('fill_action') : "",
            ]
        );
    }

    public function loadActive($id)
    {
        $product   =  $this->product->find($id);
        $active = $product->active;
        if ($active) {
            $activeUpdate = 0;
        } else {
            $activeUpdate = 1;
        }
        $updateResult =  $product->update([
            'active' => $activeUpdate,
        ]);
       // dd($updateResult);
        $product   =  $this->product->find($id);
        if ($updateResult) {
            return response()->json([
                "code" => 200,
                "html" => view('admin.components.load-change-active', ['data' => $product,'type'=>'sản phẩm'])->render(),
                "message" => "success"
            ], 200);
        } else {
            return response()->json([
                "code" => 500,
                "message" => "fail"
            ], 500);
        }
    }

    public function loadHot($id)
    {
        $product   =  $this->product->find($id);
        $hot = $product->hot;

        if ($hot) {
            $hotUpdate = 0;
        } else {
            $hotUpdate = 1;
        }
        $updateResult =  $product->update([
            'hot' => $hotUpdate,
        ]);

        $product   =  $this->product->find($id);
        if ($updateResult) {
            return response()->json([
                "code" => 200,
                "html" => view('admin.components.load-change-hot', ['data' => $product,'type'=>'sản phẩm'])->render(),
                "message" => "success"
            ], 200);
        } else {
            return response()->json([
                "code" => 500,
                "message" => "fail"
            ], 500);
        }
    }
    public function loadKhoiNghiep($id)
    {
        $product   =  $this->product->find($id);
        $khoiNghiep = $product->sp_khoi_nghiep;

        if ($khoiNghiep) {
            $khoiNghiepUpdate = 0;
        } else {
            $khoiNghiepUpdate = 1;
        }
        $updateResult =  $product->update([
            'sp_khoi_nghiep' => $khoiNghiepUpdate,
        ]);

        $product   =  $this->product->find($id);
        if ($updateResult) {
            return response()->json([
                "code" => 200,
                "html" => view('admin.components.load-change-khoi-nghiep', ['data' => $product,'type'=>'sản phẩm'])->render(),
                "message" => "success"
            ], 200);
        } else {
            return response()->json([
                "code" => 500,
                "message" => "fail"
            ], 500);
        }
    }

    public function create(Request $request = null)
    {
        $htmlselect = $this->categoryProduct->getHtmlOption();
        return view("admin.pages.product.add",
            [
                'option' => $htmlselect,
                'request' => $request
            ]
        );
    }
    public function store(ValidateAddProduct $request)
    {
        try {
            DB::beginTransaction();
            $dataProductCreate = [
                "masp" => $request->input('masp'),
                "name" => $request->input('name'),
                "slug" => $request->input('slug'),
                "price" => $request->input('price')??0,
                "sale" => $request->input('sale') ?? 0,
                "order" => $request->input('order') ?? null,
                "phantramdiem" => $request->input('phantramdiem') ?? 0,
                "loi_nhuan" => $request->input('loi_nhuan') ?? 0,
                "hot" => $request->input('hot') ?? 0,
                "sp_khoi_nghiep" => $request->input('sp_khoi_nghiep') ?? 0,
                "sp_tieu_dung" => $request->input('sp_tieu_dung') ?? 0,
				"gio_vang" => $request->input('gio_vang') ?? 0,
                "het_hang" => $request->input('het_hang') ?? 0,
                // "pay"=>$request->input('pay'),
                // "number"=>$request->input('number'),
                "warranty" => $request->input('warranty') ?? 0,
                "view" => $request->input('view') ?? 0,
                "description" => $request->input('description'),
                "description_seo" => $request->input('description_seo'),
                "title_seo" => $request->input('title_seo'),
                "content" => $request->input('content'),
                "active" => $request->input('active'),
                "is_tinh_diem" => $request->input('is_tinh_diem') ?? 1,
                "khong_tich_luy_ds" => $request->input('khong_tich_luy_ds') ?? 0,
                "category_id" => $request->input('category_id'),
                "suppiler_id" => 0,
                "admin_id" => auth()->guard('admin')->id()
            ];
            $dataUploadAvatar = $this->storageTraitUpload($request, "avatar_path", "product");
            if (!empty($dataUploadAvatar)) {
                $dataProductCreate["avatar_path"] = $dataUploadAvatar["file_path"];
            }
            // insert database in product table
            $product = $this->product->create($dataProductCreate);
            // insert database to product_images table
            if ($request->hasFile("image")) {
                //
                $dataProductImageCreate = [];
                foreach ($request->file('image') as $fileItem) {
                    $dataProductImageDetail = $this->storageTraitUploadMutiple($fileItem, "product");
                    $dataProductImageCreate[] = [
                        "name" => $dataProductImageDetail["file_name"],
                        "image_path" => $dataProductImageDetail["file_path"]
                    ];
                }
                // insert database in product_images table by createMany
                $product->images()->createMany($dataProductImageCreate);
            }

            // insert database to product_tags table
            if ($request->has("tags")) {
                foreach ($request->tags as $tagItem) {
                    $tagInstance = $this->tag->firstOrCreate(["name" => $tagItem]);
                    $tag_ids[] = $tagInstance->id;
                    // $this->productTag->create([
                    //   "product_id"=> $product->id,
                    //   "tag_id"=>$tagInstance->id,
                    // ]);
                }
                $product->tags()->attach($tag_ids);
            }
            DB::commit();
            return redirect()->route('admin.product.create')->with("alert", "Thêm sản phẩm thành công");
        } catch (\Exception $exception) {
            dd($exception);
            //throw $th;
            DB::rollBack();
            Log::error('message' . $exception->getMessage() . 'line :' . $exception->getLine());
            return redirect()->route('admin.product.create')->with("error", "Thêm sản phẩm không thành công");
        }
    }
    public function edit($id)
    {
        $data = $this->product->find($id);
        $category_id = $data->category_id;
        $htmlselect = $this->categoryProduct->getHtmlOption($category_id);
        return view("admin.pages.product.edit", [
            'option' => $htmlselect,
            'data' => $data
        ]);
    }
    public function update(ValidateEditProduct $request, $id)
    {

        try {
            DB::beginTransaction();
            $dataProductUpdate = [
                "masp" => $request->input('masp'),
                "name" => $request->input('name'),
                "slug" => $request->input('slug'),
                "price" => $request->input('price')??0,
                "sale" => $request->input('sale') ?? 0,
                "order" => $request->input('order') ?? null,
                "phantramdiem" => $request->input('phantramdiem') ?? 0,
                "loi_nhuan" => $request->input('loi_nhuan') ?? 0,
                "hot" => $request->input('hot') ?? 0,
                "sp_khoi_nghiep" => $request->input('sp_khoi_nghiep') ?? 0,
                "sp_tieu_dung" => $request->input('sp_tieu_dung') ?? 0,
				"gio_vang" => $request->input('gio_vang') ?? 0,
                "het_hang" => $request->input('het_hang') ?? 0,
                // "pay"=>$request->input('pay'),
                // "number"=>$request->input('number'),
                "warranty" => $request->input('warranty'),
                // "view" => $request->input('view'),
                "description" => $request->input('description'),
                "description_seo" => $request->input('description_seo'),
                "title_seo" => $request->input('title_seo'),
                "content" => $request->input('content'),
                "active" => $request->input('active'),
                "is_tinh_diem" => $request->input('is_tinh_diem') ?? 1,
                "khong_tich_luy_ds" => $request->input('khong_tich_luy_ds') ?? 0,
                "category_id" => $request->input('category_id'),
                //  "suppiler_id" => 0,
                "admin_id" => auth()->guard('admin')->id()
            ];

            $dataUploadAvatar = $this->storageTraitUpload($request, "avatar_path", "product");
            if (!empty($dataUploadAvatar)) {
                $dataProductUpdate["avatar_path"] = $dataUploadAvatar["file_path"];
            }
            // insert database in product table
            $this->product->find($id)->update($dataProductUpdate);
            $product = $this->product->find($id);
            // insert database to product_images table
            if ($request->hasFile("image")) {
                //
                $product->images()->where("product_id", $id)->delete();
                $dataProductImageUpdate = [];
                foreach ($request->file('image') as $fileItem) {
                    $dataProductImageDetail = $this->storageTraitUploadMutiple($fileItem, "product");
                    $dataProductImageUpdate[] = [
                        "name" => $dataProductImageDetail["file_name"],
                        "image_path" => $dataProductImageDetail["file_path"]
                    ];
                }
                // insert database in product_images table by createMany
                $product->images()->createMany($dataProductImageUpdate);
            }

            // insert database to product_tags table
            if ($request->has("tags")) {
                foreach ($request->tags as $tagItem) {
                    $tagInstance = $this->tag->firstOrCreate(["name" => $tagItem]);
                    $tag_ids[] = $tagInstance->id;
                    // $this->productTag->create([
                    //   "product_id"=> $product->id,
                    //   "tag_id"=>$tagInstance->id,
                    // ]);
                }
                // Các syncphương pháp chấp nhận một loạt các ID để ra trên bảng trung gian. Bất kỳ ID nào không nằm trong mảng đã cho sẽ bị xóa khỏi bảng trung gian.
                $product->tags()->sync($tag_ids);
            }
            DB::commit();
            return redirect()->route('admin.product.index')->with("alert", "Sửa sản phẩm thành công");
        } catch (\Exception $exception) {
            //throw $th;
            DB::rollBack();
            Log::error('message' . $exception->getMessage() . 'line :' . $exception->getLine());
            return redirect()->route('admin.product.index')->with("error", "Sửa sản phẩm không thành công");
        }
    }
    public function destroy($id)
    {
        return $this->deleteTrait($this->product, $id);
    }

    public function destroyProductAvatar($id)
    {
        return $this->deleteAvatarTrait($this->product, $id);
    }

    public function destroyProductImage($id)
    {
        return $this->deleteImageTrait($this->productImage, $id);
    }

    public function excelExportDatabase()
    {
        return Excel::download(new ExcelExportsDatabase(config('excel_database.product')), config('excel_database.product.excelfile'));
    }
    public function excelImportDatabase()
    {
        $path =request()->file('fileExcel')->getRealPath();
        Excel::import(new ExcelImportsDatabase(config('excel_database.product')), $path);
    }
}
