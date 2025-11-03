<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
//use Illuminate\Database\Eloquent\SoftDeletes;
use App\Components\Recusive;

class CategoryProduct extends Model
{
    //
    //use SoftDeletes;
    protected $table = "category_products";
    public $parentId = "parent_id";
    protected $guarded = [];
    // protected $guarded = [];
    protected $appends = ['slug_full'];
     public function getBreadcrumbAttribute()
     {
        $listIdParent=$this->getALlCategoryParent($this->attributes['id']);
        $allData= $this->select('id','name','slug')->find($listIdParent)->toArray();
         return $allData;
     }
     public function getSlugFullAttribute()
     {
         return makeLink('category_products',$this->attributes['id'],$this->attributes['slug']);
     }

    public static function getHtmlOption($parentId = "")
    {
        $data = self::all();
        $rec = new Recusive();
        // $prId=$this->parentId;
        return  $rec->categoryRecusive($data, 0, "parent_id", $parentId, "", "");
    }
    public static function getHtmlOptionEdit($parentId = "", $id)
    {
        $data = self::all()->where('id', '<>', $id);
        $rec = new Recusive();
        // $prId=$this->parentId;
        return  $rec->categoryRecusive($data, 0, "parent_id", $parentId, "", "");
    }

    // lấy html option có danh mục cha là $Id
    public static function getHtmlOptionAddWithParent($id)
    {

        $data = self::all();
        $parentId =$id;
        $rec = new Recusive();
        // $prId=$this->parentId;
        return  $rec->categoryRecusive($data, 0, "parent_id", $parentId, "", "");
    }
    // get admin_id was created category_product
    public function admin()
    {
        return $this->belongsTo(Admin::class, 'admin_id', 'id');
    }
    // get product was created category_product
    public function products()
    {
        return $this->hasMany(Product::class, 'category_id', 'id');
    }
    public function childs()
    {
        return $this->hasMany(CategoryProduct::class, 'parent_id', 'id');
    }
    public function parent()
    {
        return $this->belongsTo(CategoryProduct::class, 'parent_id', 'id');
    }

    public function getALlCategoryChildren($id)
    {
        $data = self::all();
        $rec = new Recusive();
        return  $rec->categoryRecusiveAllChild($data, $id);
    }
    public function getALlCategoryChildrenAndSelf($id){
        $data=self::select('id','parent_id')->get();
        $rec=new Recusive();
        $arrID=$rec->categoryRecusiveAllChild($data,$id);
        array_unshift($arrID,$id);
        return  $arrID;
    }
    public function getALlCategoryParent($id){
        $data=self::select('id','parent_id')->get();
        $rec=new Recusive();
        return  $rec->categoryRecusiveAllParent($data,$id);
    }
    public function getALlCategoryParentAndSelf($id){
        $data=self::select('id','parent_id')->get();
        $rec=new Recusive();
        $arrID=$rec->categoryRecusiveAllParent($data,$id);
        array_push($arrID,$id);
        return  $arrID;
    }
}
