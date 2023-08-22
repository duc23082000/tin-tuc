<?php

namespace App\ModelFilters;

use App\Models\Admin;

class AdminFilter extends Admin
{
    public function listUser($search, $collum, $sort, $role){
        return $this->where(function($query) use($search){
            $query->where('id', $search)
            ->orWhere('username', 'LIKE', '%' .$search. '%')
            ->orWhere('email', 'LIKE', '%' .$search. '%');
        })
        ->where('role', $role)
        ->orderBy($collum, $sort);
    }
}