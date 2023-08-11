<?php

namespace App\Http\Controllers\Client;

use App\Enums\PostStatusEnum;
use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(){
        $posts = Post::where('status', PostStatusEnum::PubLic)->paginate(10);
        // dd($posts[0]->title);
        return view('client.web.home', compact('posts'));
    }
}
