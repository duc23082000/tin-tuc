<?php

namespace App\Models;

use App\Enums\NoticeStatusEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notice extends Model
{
    use HasFactory;
    
    protected $table = 'notices';
    protected $fillable = ['title', 'content', 'created_by_id', 'status'];

    protected $appends = ['status_name'];

    public function created_by(){
        return $this->belongsTo(Admin::class, 'created_by_id', 'id');
    }

    public function users(){
        return $this->belongsToMany(User::class, 'notification_user', 'notice_id', 'user_id');
    }

    public function authors(){
        return $this->belongsToMany(Admin::class, 'notification_author', 'notice_id', 'author_id');
    }

    public function getStatusNameAttribute(){
        return NoticeStatusEnum::getKey($this->status);
    }

}
