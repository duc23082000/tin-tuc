<?php

namespace App\Http\Controllers\Admin\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\TagRequest;
use App\ModelFilters\TagFilter;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Http\Request;

class TagController extends Controller
{
    private $tags;
    public function __construct()
    {
        $this->tags = new TagFilter();
    }

    public function index(Request $request){
        $search = $request->input('search');

        $collum = $request->input('collum') ?? 'updated_at';

        $sort = $request->input('sort') ?? 'desc';

        $tags = $this->tags->listTag($search, $collum, $sort)
        ->paginate(10)->withQueryString();

        $sort = $sort == 'asc' ? 'desc' : 'asc';

        return view('admin.web.tags.lists', compact('tags', 'search', 'sort'));
    }

    public function create(){
        return view('admin.web.categories.create');
    }

    public function creating(TagRequest $request){

        $tag = new Tag();
        $tag->name = $request->input('name');
        $tag->save();

        return redirect(route('admin.tag.lists'));
    }

    public function edit($id){
        $tag = Tag::find($id);
        // dd($post->content);
        if(!$tag){
            return redirect(route('admin.tag.lists'));
        }
        return view('admin.web.tags.edit', compact('tag'));
    }

    public function editing($id, TagRequest $request){
        $tag = Tag::find($id);
        if(!$tag){
            return redirect(route('admin.tag.lists'));
        }
        $tag->name = $request->input('name');
        $tag->save();

        return redirect(route('admin.tag.lists'));
    }

    public function delete($id){
        // dd(1);
        $tag = Tag::find($id);
        if(!$tag){
            return redirect(route('admin.tag.lists'));
        }

        $tag->delete();

        return redirect(route('admin.tag.lists'));
    }
}
