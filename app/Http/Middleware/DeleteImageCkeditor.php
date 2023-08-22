<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\Response;

class DeleteImageCkeditor
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if(session()->has('upload'.Auth::guard('admins')->user()->id)){
            foreach(session()->get('upload'.Auth::guard('admins')->user()->id) as $fileName){
                Storage::delete('public/images/'.$fileName);
            }
            session()->forget('upload'.Auth::guard('admins')->user()->id);
        }
        return $next($request);
    }
}
