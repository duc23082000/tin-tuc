<?php

namespace App\Models;

use App\Enums\PostStatusEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'posts';
    public $timestamps = true;
    protected $dates = ['deleted_at'];

    public function user_create(){
        return $this->belongsTo(User::class, 'created_by_id');
    }

    public function user_modify(){
        return $this->belongsTo(User::class, 'modified_by_id');
    }

    public function getStatusNameAttribute(){
        return PostStatusEnum::getKey($this->status);
    }

}
