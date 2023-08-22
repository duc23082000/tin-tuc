<?php

namespace App\Observers;

use App\Models\Post;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PostObserver
{
    /**
     * Handle the Post "created" event.
     */
    public function created(Post $post): void
    {
        //
    }

    /**
     * Handle the Post "updated" event.
     */
    public function updated(Post $post): void
    {
        //
    }

    public function saving(Post $post): void
    {
        // Kiểm tra xem người dùng có upload ảnh hay không
        if(session()->has('upload'.auth()->guard('admins')->user()->id)){
            // Lấy ra toàn bộ ảnh mà người dùng upload
            $upload = session()->get('upload'.auth()->guard('admins')->user()->id);

            // Lấy ra những ảnh người dùng upload lên ckeditor nhưng không dùng và xóa nó đi
            foreach(array_diff($upload, get_image($post->content)) as $image){
                Storage::delete('public/images/'. $image);
            }
            session()->forget('upload'.auth()->guard('admins')->user()->id);
        }

        // Kiểm tra xem bài viết có ảnh cũ hay không
        if(session()->has('contentImages')){
            $contentImages = session()->get('contentImages'.Auth::guard('admins')->user()->id);
            // Lấy ra những ảnh mà người dùng thay đổi và xóa nó đi
            foreach(array_diff(get_image($contentImages), get_image($post->content)) as $image){
                Storage::delete('public/images/'. $image);
            }
        }
        
    }

    /**
     * Handle the Post "deleted" event.
     */
    public function deleted(Post $post): void
    {
        //
    }

    /**
     * Handle the Post "restored" event.
     */
    public function restored(Post $post): void
    {
        //
    }

    /**
     * Handle the Post "force deleted" event.
     */
    public function forceDeleted(Post $post): void
    {
        //
    }
}
