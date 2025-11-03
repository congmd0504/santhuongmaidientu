<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\CategoryPost;
use App\Models\Tag;
use App\Models\PostTag;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Traits\StorageImageTrait;
use App\Traits\DeleteRecordTrait;
use App\Http\Requests\Admin\ValidateAddPost;
use App\Http\Requests\Admin\ValidateEditPost;

use App\Exports\ExcelExportsDatabase;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\ExcelImportsDatabase;


class AdminPostController extends Controller
{
    use StorageImageTrait, DeleteRecordTrait;
    private $post;
    private $categoryPost;
    private $htmlselect;
    private $tag;
    private $postTag;
    public function __construct(Post $post, CategoryPost $categoryPost,  Tag $tag, PostTag $postTag)
    {
        $this->post = $post;
        $this->categoryPost = $categoryPost;
        $this->tag = $tag;
        $this->postTag = $postTag;
    }
    //
    public function index(Request $request)
    {
        $data = $this->post;
        if ($request->input('category')) {
            $categoryPostId = $request->input('category');
            $idCategorySearch = $this->categoryPost->getALlCategoryChildren($categoryPostId);
            $idCategorySearch[] = (int)($categoryPostId);
            $data = $data->whereIn('category_id', $idCategorySearch);
            $htmlselect = $this->categoryPost->getHtmlOption($categoryPostId);
        } else {
            $htmlselect = $this->categoryPost->getHtmlOption();
        }
        $where = [];
        if ($request->input('keyword')) {
            $where[] = ['name', 'like', '%' . $request->input('keyword') . '%'];
        }
        if ($request->has('fill_action') && $request->input('fill_action')) {
            $key = $request->input('fill_action');
            switch ($key) {
                case 'hot':
                    $where[] = ['hot', '=', 1];
                    break;
                default:
                    break;
            }
        }
        if ($where) {
            $data = $data->where($where);
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

        return view(
            "admin.pages.post.list",
            [
                'data' => $data,
                'option' => $htmlselect,
                'keyword' => $request->input('keyword') ? $request->input('keyword') : "",
                'order_with' => $request->input('order_with') ? $request->input('order_with') : "",
                'fill_action' => $request->input('fill_action') ? $request->input('fill_action') : "",
            ]
        );
    }


    public function create(Request $request = null)
    {
        $htmlselect = $this->categoryPost->getHtmlOption();
        return view(
            "admin.pages.post.add",
            [
                'option' => $htmlselect,
                'request' => $request
            ]
        );
    }
    public function store(ValidateAddPost $request)
    {
        try {
            DB::beginTransaction();
            $dataPostCreate = [
                "name" => $request->input('name'),
                "slug" => $request->input('slug'),
                "hot" => $request->input('hot') ?? 0,
                "view" => $request->input('view') ?? 0,
                "description" => $request->input('description'),
                "description_seo" => $request->input('description_seo'),
                "title_seo" => $request->input('title_seo'),
                "content" => $request->input('content'),
                "active" => $request->input('active'),
                "category_id" => $request->input('category_id'),
                "admin_id" => auth()->guard('admin')->id()
            ];
            $dataUploadAvatar = $this->storageTraitUpload($request, "avatar_path", "post");
            if (!empty($dataUploadAvatar)) {
                $dataPostCreate["avatar_path"] = $dataUploadAvatar["file_path"];
            }
            // insert database in posts table
            $post = $this->post->create($dataPostCreate);

            // insert database to post_tags table
            if ($request->has("tags")) {
                foreach ($request->tags as $tagItem) {
                    $tagInstance = $this->tag->firstOrCreate(["name" => $tagItem]);
                    $tag_ids[] = $tagInstance->id;
                }
                $post->tags()->attach($tag_ids);
            }
            DB::commit();
            return redirect()->route('admin.post.create')->with("alert", "Thêm bài viết thành công");
        } catch (\Exception $exception) {
            //throw $th;
            DB::rollBack();
            Log::error('message' . $exception->getMessage() . 'line :' . $exception->getLine());
            return redirect()->route('admin.post.create')->with("error", "Thêm bài viết không thành công");
        }
    }
    public function edit($id)
    {
        $data = $this->post->find($id);
        $category_id = $data->category_id;
        $htmlselect = $this->categoryPost->getHtmlOption($category_id);
        return view("admin.pages.post.edit", [
            'option' => $htmlselect,
            'data' => $data
        ]);
    }
    public function update(ValidateEditPost $request, $id)
    {
        try {
            DB::beginTransaction();
            $dataPostUpdate = [
                "name" => $request->input('name'),
                "slug" => $request->input('slug'),
                "hot" => $request->input('hot') ?? 0,
                // "view" => $request->input('view'),
                "description" => $request->input('description'),
                "description_seo" => $request->input('description_seo'),
                "title_seo" => $request->input('title_seo'),
                "content" => $request->input('content'),
                "active" => $request->input('active'),
                "category_id" => $request->input('category_id'),
                "admin_id" => auth()->guard('admin')->id(),
            ];
            $dataUploadAvatar = $this->storageTraitUpload($request, "avatar_path", "post");
            if (!empty($dataUploadAvatar)) {
                $dataPostUpdate["avatar_path"] = $dataUploadAvatar["file_path"];
            }
            // insert database in post table
            $this->post->find($id)->update($dataPostUpdate);
            $post = $this->post->find($id);

            // insert database to post_tags table
            if ($request->has("tags")) {
                foreach ($request->tags as $tagItem) {
                    $tagInstance = $this->tag->firstOrCreate(["name" => $tagItem]);
                    $tag_ids[] = $tagInstance->id;
                }
                // Các syncphương pháp chấp nhận một loạt các ID để ra trên bảng trung gian. Bất kỳ ID nào không nằm trong mảng đã cho sẽ bị xóa khỏi bảng trung gian.
                $post->tags()->sync($tag_ids);
            }
            DB::commit();
            return redirect()->route('admin.post.index')->with("alert", "sửa bài viết thành công");
        } catch (\Exception $exception) {
            //throw $th;
            DB::rollBack();
            Log::error('message' . $exception->getMessage() . 'line :' . $exception->getLine());
            return redirect()->route('admin.post.index')->with("error", "Sửa bài viết không thành công");
        }
    }
    public function destroy($id)
    {
        return $this->deleteTrait($this->post, $id);
    }

    public function loadActive($id)
    {
        $post   =  $this->post->find($id);
        $active =$post->active;
        if($active){
            $activeUpdate=0;
        }else{
            $activeUpdate=1;
        }
        $updateResult =  $post->update([
            'active'=>$activeUpdate,
        ]);
        $post   =  $this->post->find($id);
        if( $updateResult){
            return response()->json([
                "code" => 200,
                "html"=>view('admin.components.load-change-active',['data'=>$post,'type'=>'bài viết'])->render(),
                "message" => "success"
            ], 200);
        }else{
            return response()->json([
                "code" => 500,
                "message" => "fail"
            ], 500);
        }

    }
    public function loadHot($id)
    {
        $post   =  $this->post->find($id);
        $hot =$post->hot;

        if($hot){
            $hotUpdate=0;
        }else{
            $hotUpdate=1;
        }
        $updateResult =  $post->update([
            'hot'=>$hotUpdate,
        ]);

        $post   =  $this->post->find($id);
        if( $updateResult){
            return response()->json([
                "code" => 200,
                "html"=>view('admin.components.load-change-hot',['data'=>$post,'type'=>'bài viết'])->render(),
                "message" => "success"
            ], 200);
        }else{
            return response()->json([
                "code" => 500,
                "message" => "fail"
            ], 500);
        }

    }

    public function excelExportDatabase()
    {
        return Excel::download(new ExcelExportsDatabase(config('excel_database.post')), config('excel_database.post.excelfile'));
    }
    public function excelImportDatabase()
    {
        $path =request()->file('fileExcel')->getRealPath();
        Excel::import(new ExcelImportsDatabase(config('excel_database.post')), $path);
    }
}
