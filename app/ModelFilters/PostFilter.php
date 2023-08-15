<?php

namespace App\ModelFilters;

use App\Models\Post;

class PostFilter extends Post
{
    public function listPost($search, $collum, $sort){
        return $this->join('users', 'posts.created_by_id', '=', 'users.id')
            ->join('users as users2', 'posts.modified_by_id', '=', 'users2.id')
            ->join('categories', 'posts.category_id', '=', 'categories.id')
            ->select('posts.*', 'users.email', 'users2.email as email2', 'categories.name')
            ->where(function($query) use($search){
                $query->where('posts.id', $search)
                ->orWhere('posts.title', 'LIKE', '%' .$search. '%')
                ->orWhere('posts.content', 'LIKE', '%' .$search. '%')
                ->orWhere('posts.posted_at', 'LIKE', '%' .$search. '%')
                ->orWhere('users.email', 'LIKE', '%' .$search. '%')
                ->orWhere('users2.email', 'LIKE', '%' .$search. '%')
                ->orWhere('categories.name', 'LIKE', '%' .$search. '%');
            })
            ->orderBy($collum, $sort);
    }
}