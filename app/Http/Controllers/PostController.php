<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Like;
use App\Models\Comment;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Models\PostComment;
use App\Models\CategoryPost;
use App\Models\CategoryProduct;
use App\Traits\StorageImageTrait;
use App\Traits\DeleteRecordTrait;

class PostController extends Controller
{
    //
    use StorageImageTrait, DeleteRecordTrait;

    private $post;
    private $categoryProduct;
    private $unit = 'đ';
    private $categoryPost;
    private $limitPost = 9;
    private $limitPostRelate = 5;
    private $idCategoryPostRoot = 21;
    private $breadcrumbFirst = [];
    public function __construct(Post $post, CategoryPost $categoryPost, CategoryProduct $categoryProduct)
    {
        $this->post = $post;
        $this->categoryPost = $categoryPost;
        $this->categoryProduct = $categoryProduct;
        $this->breadcrumbFirst = [
            'name' => 'Tin tức',
            'slug' => makeLink("post_all"),
            'id' => null,
        ];
    }
    public function index(Request $request)
    {

        // dd(route('product.index',['category'=>$request->category]));
        $breadcrumbs = [];
        $data = [];
        //dd($data);
        // get category
        $category = $this->categoryPost->where([
            ['id', $this->idCategoryPostRoot],
        ])->first();
        if ($category) {
            if ($category->count()) {
                $categoryId = $category->id;
                $listIdChildren = $this->categoryPost->getALlCategoryChildrenAndSelf($categoryId);

                $data =  $this->post->whereIn('category_id', $listIdChildren)->where('active', 1)->latest()->paginate($this->limitPost);
                $breadcrumbs[] = $this->categoryPost->select('id', 'name', 'slug')->find($this->idCategoryPostRoot)->toArray();
            }
        }

        //  dd($category);
        return view('frontend.pages.post', [
            'data' => $data,
            'unit' => $this->unit,
            'breadcrumbs' => $breadcrumbs,
            'typeBreadcrumb' => 'post_all',
            'category' => $category,
            'seo' => [
                'title' =>  $category->title_seo ?? "",
                'keywords' =>  $category->keywords_seo ?? "",
                'description' =>  $category->description_seo ?? "",
                'image' => $category->avatar_path ?? "",
                'abstract' =>  $category->description_seo ?? "",
            ]
        ]);

        // $breadcrumbs = [];
        // $data = [];
        // // get category
        // $categorys = $this->categoryPost->whereIn(
        //     'id', [13,20]
        // )->get();
        // if ($categorys) {
        //     if ($categorys->count()) {
        //         $listIdChildren=[];
        //         foreach ($categorys as $category) {
        //             $categoryId = $category->id;
        //             $listIdChild = $this->categoryPost->getALlCategoryChildrenAndSelf($categoryId);
        //             array_push($listIdChildren,...$listIdChild);
        //         }
        //         $data =  $this->post->whereIn('category_id', $listIdChildren)->paginate($this->limitPost);
        //     }
        // }

        // if ($this->breadcrumbFirst) {
        //     array_unshift($breadcrumbs, $this->breadcrumbFirst);
        // }


        // return view('frontend.pages.post', [
        //     'data' => $data,
        //     'unit' => $this->unit,
        //     'breadcrumbs' => $breadcrumbs,
        //     'typeBreadcrumb'=>'post_all',
        //     'title'=>"Tin tức"
        // ]);
    }



    public function socialNetwork()
    {
        $breadcrumbs = [];
        $data = [];
        // get category
        $category = $this->categoryPost->where([
            ['id', 29],
        ])->first();
        if ($category) {
            if ($category->count()) {
                $categoryId = $category->id;
                $listIdChildren = $this->categoryPost->getALlCategoryChildrenAndSelf($categoryId);

                // $data =  $this->post->whereIn('category_id', $listIdChildren)->get();
                // $breadcrumbs[] = $this->categoryPost->select('id', 'name', 'slug')->find($this->idCategoryPostRoot)->toArray();
            }
        }
        $data =  $this->post->where([['active', 1], ['category_id', 29]])->orderByDesc('created_at')->get();
        $dataLimit5 =  $this->post->where([['active', 1], ['category_id', 29]])->orderByDesc('created_at')->limit(5)->get();

        return view('frontend.pages.socialNetwork', [
            'dataLimit5' => $dataLimit5,
            'data' => $data,
            'unit' => $this->unit,
            // 'breadcrumbs' => $breadcrumbs,
            'typeBreadcrumb' => 'post_all',
            'category' => $category,
            'seo' => [
                'title' =>  $category->title_seo ?? "",
                'keywords' =>  $category->keywords_seo ?? "",
                'description' =>  $category->description_seo ?? "",
                'image' => $category->avatar_path ?? "",
                'abstract' =>  $category->description_seo ?? "",
            ]
        ]);
    }

    public function listPostByUser()
    {
        $user = auth()->guard('web')->user();
        $data = $this->post->where('user_id', $user->id)->orderByDesc('created_at')->paginate(10);
        return view('frontend.pages.list-post', [
            'data' => $data,
            'user' => $user,

        ]);
    }
    public function create()
    {
        $user = auth()->guard('web')->user();
        return view('frontend.pages.create-post', [
            'user' => $user,
        ]);
    }
    public function store(Request $request)
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
                "active" => 1,
                "category_id" => $request->input('category_id'),
                "admin_id" =>  0,
                "user_id" => $request->input('user_id'),
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
            return redirect()->route('socialNetwork')->with("alert", "Thêm bài viết thành công");
        } catch (\Exception $exception) {
            //throw $th;
            //dd($exception);
            DB::rollBack();
            Log::error('message' . $exception->getMessage() . 'line :' . $exception->getLine());
            return redirect()->route('listPostByUser')->with("error", "Thêm bài viết không thành công");
        }
    }
    public function edit($id)
    {
        $user = auth()->guard('web')->user();
        $data = $this->post->where('id', $id)->first();
        return view('frontend.pages.edit-post', [
            'data' => $data,
            'user' => $user,
        ]);
    }
    public function update(Request $request, $id)
    {
        try {
            DB::beginTransaction();
            $dataPostUpdate = [
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
                "admin_id" =>  0,
                "user_id" => $request->input('user_id'),
            ];
            $dataUploadAvatar = $this->storageTraitUpload($request, "avatar_path", "post");
            if (!empty($dataUploadAvatar)) {
                $dataPostUpdate["avatar_path"] = $dataUploadAvatar["file_path"];
            }
            // insert database in posts table
            $this->post->find($id)->update($dataPostUpdate);
            DB::commit();
            return redirect()->route('listPostByUser')->with("alert", "Sửa bài viết thành công");
        } catch (\Exception $exception) {
            DB::rollBack();
            Log::error('message' . $exception->getMessage() . 'line :' . $exception->getLine());
            return redirect()->route('listPostByUser')->with("error", "Sửa bài viết không thành công");
        }
    }

    public function commentPost(Request $request, $id)
    {
        try {
            DB::beginTransaction();
            $user = auth()->guard('web')->user();
            $commentOf = $this->post->find($id);
            $dataCommentCreate = [
                "content" => $request->input('content'),
                "like" => $request->input('like') ?? 0,
                "share" => $request->input('share') ?? 0,
                "parent_id" => $request->input('parent_id') ?? 0,
                'user_id' => $user->id ?? 0,
            ];
            $dataUploadImage = $this->storageTraitUpload($request, "image_path", "comment");
            if (!empty($dataUploadImage)) {
                $dataCommentCreate["image_path"] = $dataUploadImage["file_path"];
            }
            //  dd($dataCommentCreate);
            // insert database in comments table by createMany
            $commentOf->comments()->create($dataCommentCreate);
            $data = $commentOf->comments()->get();
            $id_post = $commentOf;

            DB::commit();
            $html = view('frontend.components.load-comment', compact('data', 'id_post'))->render();
            // return redirect()->route('post.congDong')->with("alert", "Thêm bài viết thành công");
            return response()->json([
                'code' => 200,
                'message' => 'Success',
                'countComment' => $data->count(),
                'html' => $html,
            ]);
        } catch (\Exception $exception) {
            //throw $th;
            //dd($exception);
            DB::rollBack();
            Log::error('message' . $exception->getMessage() . 'line :' . $exception->getLine());
            // return redirect()->back()->with("error", "Thêm bài viết không thành công");
            return response()->json([
                'code' => 500,
                'message' => 'Error',
            ]);
        }
    }
    public function destroyComment(Request $request, $id, $post_id)
    {
        try {
            DB::beginTransaction();
            $user = auth()->guard('web')->user();
            $commentOf = $this->post->find($post_id);
            //  dd($dataCommentCreate);
            // insert database in comments table by createMany
            $cmt = PostComment::where('id', $id)->first();
            Comment::where('id', $cmt->comment_id)->delete();
            $cmt->delete();
            $data = $commentOf->comments()->get();
            $id_post = $commentOf;
            DB::commit();
            $html = view('frontend.components.load-comment', compact('data', 'id_post'))->render();
            // return redirect()->route('post.congDong')->with("alert", "Thêm bài viết thành công");
            return response()->json([
                'code' => 200,
                'message' => 'Success',
                'countComment' => $data->count(),
                'html' => $html,
            ]);
        } catch (\Exception $exception) {
            //throw $th;
            //dd($exception);
            DB::rollBack();
            Log::error('message' . $exception->getMessage() . 'line :' . $exception->getLine());
            // return redirect()->back()->with("error", "Thêm bài viết không thành công");
            return response()->json([
                'code' => 500,
                'message' => 'Error',
            ]);
        }
    }
    public function like(Request $request, $id_post)
    {
        try {
            DB::beginTransaction();
            $user = auth()->guard('web')->user();
            $likePost = Like::where([['user_id', $user->id], ['post_id', $id_post]])->first();
            if ($likePost) {
                $delete = Like::where('id', $likePost->id)->delete();
                $liked = 0;
            } else {
                $dataLike = [
                    "user_id" => $user->id,
                    "post_id" => $id_post,
                ];
                $like = Like::create($dataLike);
                $liked = 1;
            }
            DB::commit();
            $likeCount = Like::where([['post_id', $id_post]])->count();
            $html = view('frontend.components.load-like', compact('liked', 'likeCount'))->render();
            // return redirect()->route('post.congDong')->with("alert", "Thêm bài viết thành công");
            return response()->json([
                'code' => 200,
                'message' => 'Success',
                'countLike' => $likeCount,
                'html' => $html,
            ]);
        } catch (\Exception $exception) {
            //throw $th;
            //dd($exception);
            DB::rollBack();
            Log::error('message' . $exception->getMessage() . 'line :' . $exception->getLine());
            // return redirect()->back()->with("error", "Thêm bài viết không thành công");
            return response()->json([
                'code' => 500,
                'message' => 'Error',
            ]);
        }
    }
    public function detail($id, $slug)
    {
        $breadcrumbs = [];
        $data = [];
        $data = $this->post->where([
            ['id', $id],
            ["slug", $slug],
        ])->first();
        $categoryId = $data->category_id;

        $listIdChildren = $this->categoryPost->getALlCategoryChildrenAndSelf($categoryId);

        $dataRelate =  $this->post->whereIn('category_id', $listIdChildren)->where([
            ["id", "<>", $data->id],
        ])->limit($this->limitPostRelate)->get();
        $listIdParent = $this->categoryPost->getALlCategoryParentAndSelf($categoryId);

        foreach ($listIdParent as $parent) {
            $breadcrumbs[] = $this->categoryPost->select('id', 'name', 'slug')->find($parent)->toArray();
        }

        return view('frontend.pages.post-detail', [
            'data' => $data,
            "dataRelate" => $dataRelate,
            'breadcrumbs' => $breadcrumbs,
            'typeBreadcrumb' => 'category_posts',
            'title' => $data ? $data->name : "",
            'category' => $data->category ?? null,
            'seo' => [
                'title' =>  $data->title_seo ?? "",
                'keywords' =>  $data->keywords_seo ?? "",
                'description' =>  $data->description_seo ?? "",
                'image' => $data->avatar_path ?? "",
                'abstract' =>  $data->description_seo ?? "",
            ]
        ]);
    }

    // danh sách product theo category
    public function postByCategory($id, $slug)
    {
        // dd(route('product.index',['category'=>$request->category]));
        $breadcrumbs = [];
        $data = [];
        // get category
        $category = $this->categoryPost->where([
            ['id', $id],
            ["slug", $slug],
        ])->first();
        if ($category) {
            if ($category->count()) {
                $categoryId = $category->id;
                $listIdChildren = $this->categoryPost->getALlCategoryChildrenAndSelf($categoryId);

                $data =  $this->post->whereIn('category_id', $listIdChildren)->where('active', 1)->latest()->paginate($this->limitPost);
                $listIdParent = $this->categoryPost->getALlCategoryParentAndSelf($categoryId);
                foreach ($listIdParent as $parent) {
                    $breadcrumbs[] = $this->categoryPost->select('id', 'name', 'slug')->find($parent)->toArray();
                }
            }
        }



        return view('frontend.pages.post', [
            'data' => $data,
            'unit' => $this->unit,
            'breadcrumbs' => $breadcrumbs,
            'typeBreadcrumb' => 'category_posts',
            'category' => $category,
            'seo' => [
                'title' =>  $category->title_seo ?? "",
                'keywords' =>  $category->keywords_seo ?? "",
                'description' =>  $category->description_seo ?? "",
                'image' => $category->avatar_path ?? "",
                'abstract' =>  $category->description_seo ?? "",
            ]
        ]);
    }
}
