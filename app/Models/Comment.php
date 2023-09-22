<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    protected $table = 'comments';
    protected $fillable = ['content', 'post_id', 'commented_by_id'];

    public function commented_by(){
        return $this->belongsTo(User::class, 'commented_by_id', 'id');
    }
}
