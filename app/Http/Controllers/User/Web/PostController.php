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

class PostController extends Controller
{
    private $posts;
    public function __construct()
    {
        $this->posts = new PostFilter();
        $categories = Category::all(); 

        $tags = Tag::all();

        $authors = Admin::where('role', UserRoleEnum::Author)->get();

        View::share([
            'categories' => $categories,
            'tags' => $tags,
            'authors' => $authors,
        ]);
    }

    public function index(Request $request){
        $search = $request->input('search');

        $category = $request->input('category');

        $author = $request->input('author');

        $tag = $request->input('tag');

        $posts = $this->posts->listPostUser($search, $category, $author, $tag)->paginate(20)->withQueryString();

        return view('client.web.home', compact('posts'));
    }

    public function show($id){
        $post = Post::find($id);
        $comments = Comment::with('commented_by')->where('post_id', $id)->get();
        return view('client.web.show', compact('post', 'comments'));
    }

    public function like($id){
        $post = Post::find($id);

        if ($post->likes->contains(Auth::user()->id)) {
            $post->likes()->detach(Auth::user()->id);
        } else {
            $post->likes()->attach(Auth::user()->id);
        }
        return back();
    }

    public function comment($id, Request $request){
        $request->validate(['comment' => 'required|max:255']);
        $comment = new Comment();
        $comment->content = $request->comment;
        $comment->post_id = $id;
        $comment->commented_by_id = Auth::user()->id;
        $comment->save();
        return back();
    }
}
