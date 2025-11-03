<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
//use Illuminate\Database\Eloquent\SoftDeletes;
use App\Components\Recusive;
class Menu extends Model
{
    //
  //  use SoftDeletes;
    protected $table="menus";
    public $parentId="parent_id";
    protected $guarded = [];
     //  protected $appends = ['breadcrumb'];
     public function getBreadcrumbAttribute()
     {
        $listIdParent=$this->getALlCategoryPostParent($this->attributes['id']);
        $allData= $this->select('id','name','slug')->find($listIdParent)->toArray();
         return $allData;
     }
    public static function getHtmlOption($parentId=""){
        $data=self::all();
        $rec=new Recusive();
       // $prId=$this->parentId;
        return  $rec->categoryRecusive($data,0,"parent_id",$parentId,"","");
    }
    public static function getHtmlOptionEdit($parentId="",$id){
        $data=self::all()->where('id','<>',$id);
        $rec=new Recusive();
       // $prId=$this->parentId;
        return  $rec->categoryRecusive($data,0,"parent_id",$parentId,"","");
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
    public function childs(){
        return $this->hasMany(Menu::class,'parent_id','id');
    }
    public function parent(){
        return $this->belongsTo(Menu::class,'parent_id','id');
    }
    public function getALlCategoryPostChildren($id){
        $data=self::select('id','parent_id')->get();
        $rec=new Recusive();
        return  $rec->categoryRecusiveAllChild($data,$id);
    }
    public function getALlCategoryPostParent($id){
        $data=self::select('id','parent_id')->get();
        $rec=new Recusive();
        return  $rec->categoryRecusiveAllParent($data,$id);
    }
}
