<?php

namespace App\Http\Controllers\User\Web;

use App\Enums\UserRoleEnum;
use App\Http\Controllers\Controller;
use App\ModelFilters\PostFilter;
use App\Models\Admin;
use App\Models\Category;
use App\Models\Comment;
use App\Models\Notice;
use App\Models\Post;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Inertia\Inertia;

class PostController extends Controller
{
    private $posts;
    public function __construct()
    {
        $this->posts = new PostFilter();
    }

    public function index(Request $request)
    {
        $search = $request->input('search');

        $category = $request->input('category');

        $author = $request->input('author');

        $tag = $request->input('tag');

        $posts = $this->posts->listPostUser($search, $category, $author, $tag)->paginate(20)->withQueryString();

        return Inertia::render('clients/web/home/HomePage', [
            'posts' => $posts, 
            'search' => $search,  
            'category' => $category,  
            'author' => $author,  
            'tag' => $tag,  
        ]);
    }

    public function categories()
    {
        return Category::all();
    }

    public function authors()
    {
        return Admin::where('role', UserRoleEnum::Author)->get();
    }

    public function tags()
    {
        return Tag::all();
    }

    public function show($title){
        $post = Post::with('likes')->where('title', $title)->first();
        // dd($post);
        if(!$post) {
            return redirect(route('home'));
        }
        $comments = Comment::with('commented_by')->where('post_id', $post->id)->get();


        $checkLike = auth()->check() == true ? $post->likes->contains(Auth::user()->id) : false;

        return Inertia::render('clients/web/home/ShowPost', [
            'post' => $post,
            'comments' => $comments,
            'checkLike' => $checkLike,
        ]);
    }

    public function like($id){
        $post = Post::find($id);

        if ($post->likes->contains(Auth::user()->id)) {
            $post->likes()->detach(Auth::user()->id);
            return response()->json(['success' => 'minus']);
        } else {
            $post->likes()->attach(Auth::user()->id);
            return response()->json(['success' => 'plus']);
        }
    }

    public function comment($id, Request $request){
        $data = $request->validate(['content' => 'required|max:255']);
        $data = array_merge($data, [
            'post_id' => $id,
            'commented_by_id' =>  Auth::user()->id,
        ]);

        Comment::create($data);

        $comments = Comment::with('commented_by')->where('post_id', $id)->get();

        return response()->json(['comment' => $comments]);

    }
}
