<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Menu;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Traits\DeleteRecordTrait;
use App\Http\Requests\Admin\ValidateAddMenu;
use App\Http\Requests\Admin\ValidateEditMenu;

class AdminMenuController extends Controller
{
    //
    use DeleteRecordTrait;
    private $menu;
    public function __construct(Menu $menu)
    {
        $this->menu = $menu;
    }
    public function index(Request $request)
    {
        $parentBr=null;
        if($request->has('parent_id')){
            $data = $this->menu->where('parent_id', $request->input('parent_id'))->orderBy("created_at", "desc")->paginate(15);
            if($request->input('parent_id')){
                $parentBr=$this->menu->find($request->input('parent_id'));
            }
        }else{
            $data = $this->menu->where('parent_id', 0)->orderBy("created_at", "desc")->paginate(15);
        }
        return view(
            "admin.pages.menu.list",
            [
                'data' => $data,
                'parentBr' => $parentBr,
            ]
        );
    }
    public function create(Request $request )
    {
        if($request->has("parent_id")){
            $htmlselect = $this->menu->getHtmlOptionAddWithParent($request->parent_id);
        }else{
            $htmlselect = $this->menu->getHtmlOption();
        }

        return view(
            "admin.pages.menu.add",
            [
                'option' => $htmlselect,
                'request' => $request
            ]
        );
    }
    public function store(ValidateAddMenu $request)
    {

        $dataMenuCreate=[
            "name"=>$request->input('name'),
            "slug"=>$request->input('slug'),
            "parent_id"=>$request->input('parentId'),
            "active"=>$request->input('active'),
            "admin_id"=>auth()->guard('admin')->id()
          ];
        if($this->menu->create($dataMenuCreate)){
            return redirect()->route("admin.menu.create",['parent_id'=>$request->parentId])->with("alert", "Thêm menu thành công");
        }else{
            return redirect()->route("admin.menu.create",['parent_id'=>$request->parentId])->with("error", "Thêm menu không thành công");
        }
    }
    public function edit($id)
    {
        $data = $this->menu->find($id);
        $parentId = $data->parent_id;
        $htmlselect = Menu::getHtmlOptionEdit($parentId,$id);
        return view("admin.pages.menu.edit", [
            'option' => $htmlselect,
            'data' => $data
        ]);
    }
    public function update(ValidateEditMenu $request, $id)
    {
        $this->menu->find($id)->update([
            'name' => $request->input('name'),
            'slug' => $request->input('slug'),
            'active' => $request->input('active'),
            'parent_id' => $request->input('parentId')
        ]);
        return redirect()->route("admin.menu.index")->with("alert", "Sửa menu thành công");
    }
    public function destroy($id)
    {
        return $this->deleteCategoryRecusiveTrait($this->menu, $id);
    }
}
