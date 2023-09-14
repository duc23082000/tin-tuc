<?php

namespace App\Http\Controllers\Admin\Web;

use App\Enums\PostStatusEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\ListRequest;
use App\Http\Requests\PostRequest;
use App\ModelFilters\PostFilter;
use App\Models\Category;
use App\Models\Post;
use App\Models\Tag;
use App\Models\User;
use App\Notifications\TestNotification;
use App\Notifications\UserNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Str;
use App\ModelFilters\Admin\PostFilter as AdminFilter;
use Inertia\Inertia;

class PostController extends Controller
{
    private $post;

    public function __construct()
    {
        $this->post = new PostFilter();       
    }
    public function index()
    {
        return  Inertia::render('admins/web/posts/Index');
    }

    public function indexApi(ListRequest $request)
    {
        $search = $request->input('search');

        $column = $request->input('column') ?? 'updated_at';

        $sort = $request->input('sort') ?? 'desc';

        $posts = $this->post->listPost($search, $column, $sort)
            ->paginate(10)->withQueryString();
        
        $sort = $sort == 'asc' ? 'desc' : 'asc';
        return $posts;
    }

    public function create()
    {
        $tags = Tag::all();
        $categories = Category::all();
        return  Inertia::render('admins/web/posts/Create', [
            'tags' => $tags,
            'categories' => $categories,
            'status' => PostStatusEnum::asArray(),
        ]);
    }

    public function store(PostRequest $request)
    {
        $post = new Post();
        $post->title = $request->input('title');
        $post->content = $request->input('content');
        $post->category_id = $request->input('category');
        $post->status = $request->input('status');
        $post->posted_at = $request->input('posted_at');
        $post->created_by_id = app('admin_id');
        $post->modified_by_id = app('admin_id');
        $post->save();

        $post->tags()->sync($request->input('tags'));

        return redirect(route('admin.post.lists'));
    }

    public function upload(Request $request)
    {
        try {
            $request->validate(['upload' => 'required|image|mimes:jpeg,png,jpg,gif|max:5120']);
            if($request->hasFile('upload')){
                $image = $request->file('upload');
                
                $fileName = Str::random(40) . '.' . $image->getClientOriginalExtension();
    
                Storage::put('public/images/'.$fileName, file_get_contents($request->file('upload')->getRealPath()));
                $url = asset('storage/images/'.$fileName);
    
                if(session()->has('upload'.app('admin_id'))){
                    session()->push('upload'.app('admin_id'), $fileName);
                } else {
                    session()->put('upload'.app('admin_id'), [$fileName]);
                }
    
                return response()->json([
                    'fileName' => $fileName,
                    'uploaded' => 1,
                    'url' => $url
                ]);
            }
        } catch (\Throwable $error) {
            
            return response()->json([
                'uploaded' => 0,
                'error' => [
                    'message' => 'Ảnh phải có định dạng jpeg,png,jpg,gif và nhỏ hơn 5MB',
                ],
            ]);
        }
    }

    public function edit($id)
    {
        $post = Post::find($id);
        if(!$post){
            return redirect(route('admin.post.lists'));
        }
        $tags = Tag::all();
        $categories = Category::all();
        return view('admin.web.posts.edit', compact('post', 'tags', 'categories'));
    }

    public function editing($id, PostRequest $request)
    {
        $post = Post::find($id);
        if(!$post){
            return redirect(route('admin.post.lists'));
        }
        if(!empty($post->image)){
            session()->put('oldImage'.app('admin_id'), $post->image);
        }
        session()->put('contentImages'.app('admin_id'), $post->content);
        $post->title = $request->input('title');
        $post->content = $request->input('content');
        $post->category_id = $request->input('category');
        $post->status = $request->input('status');
        $post->posted_at = $request->input('posted_at'); 
        $post->modified_by_id = app('admin_id');
        $post->save();
        
        $post->tags()->sync($request->input('tags'));

        return redirect(route('admin.post.lists'));
    }

    public function delete($id)
    {
        
        $post = Post::find($id);
        if(!$post){
            return redirect(route('admin.post.lists'));
        }

        $post->delete();

        return redirect(route('admin.post.lists'));
    }
}
