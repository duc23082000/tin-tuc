<?php

namespace App\Models;

use App\Enums\PostStatusEnum;
use App\ModelFilters\Admin\PostFilter;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use EloquentFilter\Filterable;

class Post extends Model
{
    use HasFactory, SoftDeletes, Filterable;

    protected $table = 'posts';
    protected $fillable = ['title', 'content', 'status', 'category_id', 'created_by_id', 'modified_by_id'];
    public $timestamps = true;
    protected $dates = ['deleted_at'];

    protected $appends = ['status_name', 'tags_id'];

    public function modelFilter()
    {
        return $this->provideFilter(PostFilter::class);
    }

    public function user_create(){
        return $this->belongsTo(Admin::class, 'created_by_id');
    }

    public function user_modify(){
        return $this->belongsTo(Admin::class, 'modified_by_id');
    }

    public function getStatusNameAttribute(){
        return PostStatusEnum::getKey($this->status);
    }

    public function getTagsIdAttribute(){
        return $this->tags->pluck('id')->toArray();
    }

    public function category(){
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }

    public function tags(){
        return $this->belongsToMany(Tag::class, 'post_tag', 'post_id', 'tag_id');
    }

    public function likes(){
        return $this->belongsToMany(User::class, 'post_like', 'post_id');
    }

    public function comments()
    {
        return $this->hasMany(Comment::class, 'post_id', 'id');
    }

}
