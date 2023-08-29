<?php

namespace App\Http\Controllers\User\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function show($id)
    {
        $notification = auth()->user()->notifications()->find($id);
        if(!$notification){
            return redirect(route('home'));
        }
        if($notification->read_at == NULL){
            $notification->read_at = now();
            $notification->save();
        }
        return view('client.web.notifications.show', compact('notification'));
    }
}
