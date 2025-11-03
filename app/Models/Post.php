<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
//use Illuminate\Database\Eloquent\SoftDeletes;
use App\Components\Recusive;

class Post extends Model
{
    //use SoftDeletes;
    protected $table = "posts";
    public $parentId = "parent_id";
    protected $guarded = [];
    // public $fillable =['name'];

    protected $appends = ['slug_full'];
    public function getSlugFullAttribute()
    {
        return makeLink('post', $this->attributes['id'], $this->attributes['slug']);
    }

    // get tags by relationship nhieu-nhieu by table trung gian post_tags
    // 1 post có nhiều post_tags
    // 1 tag có nhiều post_tags
    // table trung gian post_tags chứa column post_id và tag_id
    public function tags()
    {
        return $this
            ->belongsToMany(Tag::class, PostTag::class, 'post_id', 'tag_id')
            ->withTimestamps();
    }
    // get category by relationship 1 - nhieu
    // 1 category_posts có nhiều post
    // 1 post có 1 category_posts
    // use belongsTo để truy xuất ngược từ post lấy data trong table category
    public function category()
    {
        return $this->belongsTo(CategoryPost::class, 'category_id', 'id');
    }

    // get category by relationship nhiều - 1
    public function getAdmin()
    {
        return $this->belongsTo(Admin::class, 'admin_id', 'id');
    }
    // get category by relationship nhiều - 1
    public function admin()
    {
        return $this->belongsTo(Admin::class, 'admin_id', 'id');
    }
    // get comment by relationship nhieu-nhieu by table trung gian post_comments
    // 1 post có nhiều post_comments
    // 1 tag có nhiều post_comments
    // table trung gian post_comments chứa column post_id và tag_id
    public function comments()
    {
        return $this
            ->belongsToMany(Comment::class, PostComment::class, 'post_id', 'comment_id')
            ->withTimestamps();
    }

    public static function getHtmlOption($parentId = "")
    {
        $data = self::all();
        $rec = new Recusive();
        // $prId=$this->parentId;
        return  $rec->categoryRecusive($data, 0, "parent_id", $parentId, "", "");
    }
}
