<?php

namespace App\ModelFilters;

use App\Models\User;

class UserFilter extends User
{
    public function listUser($search, $collum, $sort){
        return $this->where(function($query) use($search){
            $query->where('id', $search)
            ->orWhere('username', 'LIKE', '%' .$search. '%')
            ->orWhere('email', 'LIKE', '%' .$search. '%');
        })
        ->orderBy($collum, $sort);
    }
}