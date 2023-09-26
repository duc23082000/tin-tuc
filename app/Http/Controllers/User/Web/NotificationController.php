<?php

namespace App\Http\Controllers\User\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;

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
        return Inertia::render('clients/web/notification/ShowNotification', [
            'notification' => $notification
        ]);
    }
}
