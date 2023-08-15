<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Tag extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'tags';
    public $timestamps = true;
    protected $dates = ['deleted_at'];

    public function posts(){
        return $this->belongsToMany(Post::class);
    }
}
