<?php

namespace App\ModelFilters;

use App\Enums\PostStatusEnum;
use App\Enums\UserRoleEnum;
use App\Models\Post;
use Illuminate\Support\Facades\Auth;

class PostFilter extends Post
{
    public function listPost($search, $collum, $sort){
        return $this->join('admins', 'posts.created_by_id', '=', 'admins.id')
            ->join('admins as admins2', 'posts.modified_by_id', '=', 'admins2.id')
            ->join('categories', 'posts.category_id', '=', 'categories.id')
            ->select('posts.*', 'admins.email', 'admins2.email as email2', 'categories.name')
            ->where(function($query) use($search){
                $query->where('posts.id', $search)
                ->orWhere('posts.title', 'LIKE', '%' .$search. '%')
                ->orWhere('posts.content', 'LIKE', '%' .$search. '%')
                ->orWhere('posts.posted_at', 'LIKE', '%' .$search. '%')
                ->orWhere('admins.email', 'LIKE', '%' .$search. '%')
                ->orWhere('admins2.email', 'LIKE', '%' .$search. '%')
                ->orWhere('categories.name', 'LIKE', '%' .$search. '%');
            })
            ->when(Auth::guard('admins')->user()->role === UserRoleEnum::Author, function($q){
                $q->where('posts.created_by_id', app('admin_id'));
            })
            ->orderBy($collum, $sort);
    }

    public function listPostUser($search){
        return $this->where('title', 'LIKE', "%$search%")
            // ->where()
            ->where('status', PostStatusEnum::PubLic);
    }
}