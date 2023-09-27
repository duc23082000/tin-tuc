<?php

namespace App\Observers;

use App\Models\Post;
use App\Models\Tag;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

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
        // Kiểm tra xem người dùng có upload ảnh vào content hay không
        if(session()->has('upload'.app('admin_id'))){
            // Lấy ra toàn bộ ảnh mà người dùng upload
            $upload = session()->get('upload'.app('admin_id'));

            // Lấy ra những ảnh người dùng upload lên ckeditor nhưng không dùng và xóa nó đi
            foreach(array_diff($upload, get_image($post->content)) as $image){
                Storage::delete('public/images/'. $image);
            }
            session()->forget('upload'.auth()->guard('admins')->user()->id);
        }

        // Kiểm tra xem bài viết có ảnh cũ hay không
        if(session()->has('contentImages'.app('admin_id'))){
            $contentImages = session()->get('contentImages'.app('admin_id'));
            // Lấy ra những ảnh mà người dùng thay đổi và xóa nó đi
            foreach(array_diff(get_image($contentImages), get_image($post->content)) as $image){
                Storage::delete('public/images/'. $image);
            }
            session()->forget('contentImages'.app('admin_id'));
        }

        // Kiểm tra xem người dùng có Up ảnh cho bài viết hay không
        if(request()->image){
            // Kiểm tra xem bài viết có ảnh cũ hay không nếu có thì xóa ảnh cũ
            if(session()->has('oldImage'.app('admin_id'))){
                $oldImage = session()->get('oldImage'.app('admin_id'));
                Storage::delete('public/images/'.$oldImage);
            }
            // Lấy ra ảnh người dùng upload xử lí và lưu tên lên database
            $image = request()->image;
            $fileName = Str::random(40) . '.' . $image->getClientOriginalExtension();
            Storage::put('public/images/'.$fileName, file_get_contents(request()->image->getRealPath()));

            $post->image = $fileName;
        }
        session()->forget('oldImage'.app('admin_id'));
    }

    public function saved(Post $post) 
    {
        $tags = request()->input('tags', []);
        $tagAll = Tag::all()->pluck('id')->toArray();
        // $newtags = array_filter($tags, 'is_string');
        $newtags = array_diff($tags, $tagAll);

        if(!empty($newtags)){
            $tagInsert =  array_map(function($value) {
                return ['name' => $value];
            }, $newtags);
            
            Tag::insert($tagInsert);

            $tagId = Tag::whereIn('name', $newtags)->pluck('id')->toArray();

            $tagSame = array_intersect($tags, $tagAll);

            $tagAll = array_merge($tagSame, $tagId);
            $post->tags()->sync($tagAll);
        } else {
            $post->tags()->sync($tags);
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
