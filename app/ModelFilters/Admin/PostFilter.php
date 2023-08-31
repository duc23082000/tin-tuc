<?php 

namespace App\ModelFilters\Admin;

use App\Enums\UserRoleEnum;
use EloquentFilter\ModelFilter;
use Illuminate\Support\Facades\Auth;

class PostFilter extends ModelFilter
{
    /**
    * Related Models that have ModelFilters as well as the method on the ModelFilter
    * As [relationMethod => [input_key1, input_key2]].
    *
    * @var array
    */
    public $relations = [];

    public function search($search){
        return $this->where(function($query) use($search){
            $query->where('id', $search)
            ->orWhere('title', 'LIKE', '%' .$search. '%')
            ->orWhere('content', 'LIKE', '%' .$search. '%')
            ->orWhere('posted_at', 'LIKE', '%' .$search. '%')
            ->orWhereHas('user_create', function($q) use ($search){
                $q->Where('email', 'LIKE', '%' .$search. '%');
            })
            ->orWhereHas('user_modify', function($q) use ($search){
                $q->Where('email', 'LIKE', '%' .$search. '%');
            })
            ->orWhereHas('category', function($q) use ($search){
                $q->Where('name', 'LIKE', '%' .$search. '%');
            });
        });
        
    }

    // public function author(){
    //     return $this->when(Auth::guard('admins')->user()->role === UserRoleEnum::Author, function($q){
    //         $q->where('posts.created_by_id', app('admin_id'));
    //     });
    // }

    // public function collum($collum){
    //     dd(1);
    //     return $this->orderBy($collum, $sort);
    // }
}
