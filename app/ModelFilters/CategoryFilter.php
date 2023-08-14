<?php

namespace App\ModelFilters;

use App\Models\Category;

class CategoryFilter extends Category
{
    public function listCategory($search, $collum, $sort){
        return $this->where(function($query) use($search){
                $query->where('id', $search)
                ->orWhere('name', 'LIKE', "%$search%");
            })
            ->orderBy($collum, $sort);
    }
}