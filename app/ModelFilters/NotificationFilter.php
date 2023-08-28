<?php

namespace App\ModelFilters;

use App\Models\Notice;

class NotificationFilter extends Notice
{
    public function listNotification($search, $collum, $sort){
        return $this->join('admins', 'notices.created_by_id', '=', 'admins.id')
            ->select('notices.*', 'admins.email')
            ->where(function($query) use($search){
                $query->where('notices.id', $search)
                ->orWhere('notices.title', 'LIKE', '%' .$search. '%')
                ->orWhere('notices.content', 'LIKE', '%' .$search. '%')
                ->orWhere('admins.email', 'LIKE', '%' .$search. '%');
            })
            ->orderBy($collum, $sort);
    }
}