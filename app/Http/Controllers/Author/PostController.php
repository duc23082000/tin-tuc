<?php

namespace App\Http\Controllers\Author;

use App\Enums\PostStatusEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\ListRequest;
use App\Http\Requests\PostRequest;
use App\ModelFilters\PostFilter;
use App\Models\Category;
use App\Models\Post;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Str;

class PostController extends Controller
{
    private $post;
    
    public function __construct()
    {
        $this->post = new PostFilter();
        View::share(['status' => PostStatusEnum::asArray(),
                    'statusName' => PostStatusEnum::getKeys(),
                ]);    
    }

    public function index(ListRequest $request){
        
        $search = $request->input('search');

        $collum = $request->input('collum') ?? 'updated_at';

        $sort = $request->input('sort') ?? 'desc';

        $posts = $this->post->listPost($search, $collum, $sort)
            ->paginate(10)->withQueryString();

        $sort = $sort == 'asc' ? 'desc' : 'asc';
        return view('author.posts.lists', compact('posts', 'search', 'sort'));
    }

    public function create(){
        $tags = Tag::all();
        $categories = Category::all();
        return view('author.posts.create', compact('tags', 'categories'));
    }

    public function creating(PostRequest $request){
        $post = new Post();
        $post->title = $request->input('title');
        $post->content = $request->input('content');
        $post->category_id = $request->input('category');
        $post->status = $request->input('status');
        $post->posted_at = $request->input('posted_at');
        $post->created_by_id = Auth::user()->id;
        $post->modified_by_id = Auth::user()->id;
        $post->save();

        $post->tags()->sync($request->input('tags'));

        return redirect(route('author.post.lists'));
    }

    public function upload(Request $request){
        try {
            $request->validate(['upload' => 'required|image|mimes:jpeg,png,jpg,gif|max:5120']);
            if($request->hasFile('upload')){
                $image = $request->file('upload');
                
                $fileName = Str::random(40) . '.' . $image->getClientOriginalExtension();
                Log::info(1);
    
                Storage::put('public/images/'.$fileName, file_get_contents($request->file('upload')->getRealPath()));
                $url = asset('storage/images/'.$fileName);
    
                if(session()->has('upload'.$request->user()->id)){
                    session()->push('upload'.$request->user()->id, $fileName);
                } else {
                    session()->put('upload'.$request->user()->id, [$fileName]);
                }
    
                return response()->json([
                    'fileName' => $fileName,
                    'uploaded' => 1,
                    'url' => $url
                ]);
            }
        } catch (\Exception $e) {
            return response()->json([
                'uploaded' => 0,
                'error' => [
                    'message' => 'Ảnh phải có định dạng jpeg,png,jpg,gif và nhỏ hơn 5MB'
                ]
            ]);
        }
    }

    public function edit($id){
        $post = Post::find($id);
        
        if(!$post || $post->created_by_id != Auth::user()->id){
            return redirect(route('author.post.lists'));
        }
        $tags = Tag::all();
        $categories = Category::all();
        return view('author.posts.edit', compact('post', 'tags', 'categories'));
    }

    public function editing($id, PostRequest $request){
        $post = Post::find($id);
        if(!$post){
            return redirect(route('author.post.lists'));
        }
        session()->put('contentImages', $post->content);
        $post->title = $request->input('title');
        $post->content = $request->input('content');
        $post->category_id = $request->input('category');
        $post->status = $request->input('status');
        $post->posted_at = $request->input('posted_at'); 
        $post->modified_by_id = Auth::user()->id;
        $post->save();
        
        $post->tags()->sync($request->input('tags'));

        return redirect(route('author.post.lists'));
    }

    public function delete($id){
        
        $post = Post::find($id);
        if(!$post || $post->created_by_id != Auth::user()->id){
            return redirect(route('author.post.lists'));
        }

        $post->delete();

        return redirect(route('author.post.lists'));
    }
}