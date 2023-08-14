<?php

namespace App\ModelFilters;

use App\Models\Tag;

class TagFilter extends Tag
{
    public function listTag($search, $collum, $sort){
        return $this->where(function($query) use($search){
            $query->where('id', $search)
            ->orWhere('name', 'LIKE', "%$search%");
        })
        ->orderBy($collum, $sort);
    }
}