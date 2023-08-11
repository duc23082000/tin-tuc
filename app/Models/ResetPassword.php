<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ResetPassword extends Model
{
    use HasFactory;

    protected $table = 'password_reset_tokens';

    public function user(){
        return $this->hasOne(User::class, 'email', 'email');
    }
}
