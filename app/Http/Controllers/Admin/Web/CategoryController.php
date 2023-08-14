<?php

namespace App\Http\Controllers\Admin\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryRequest;
use App\ModelFilters\CategoryFilter;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    private $categories;
    public function __construct()
    {
        $this->categories = new CategoryFilter();
    }

    public function index(Request $request){

        $search = $request->input('search');

        $collum = $request->input('collum') ?? 'updated_at';

        $sort = $request->input('sort') ?? 'desc';

        $categories = $this->categories->listCategory($search, $collum, $sort)
        ->paginate(10)->withQueryString();

        $sort = $sort == 'asc' ? 'desc' : 'asc';

        return view('admin.web.categories.lists', compact('categories', 'search', 'sort'));
    }

    public function create(){
        return view('admin.web.categories.create');
    }

    public function creating(CategoryRequest $request){
        // dd($request->posted_at);
        $category = new Category();
        $category->name = $request->input('name');
        $category->save();

        return redirect(route('admin.category.lists'));
    }

    public function edit($id){
        $category = Category::find($id);
        // dd($post->content);
        if(!$category){
            return redirect(route('admin.category.lists'));
        }
        return view('admin.web.categories.edit', compact('category'));
    }

    public function editing($id, CategoryRequest $request){
        $category = Category::find($id);
        if(!$category){
            return redirect(route('admin.category.lists'));
        }
        $category->name = $request->input('name');
        $category->save();

        return redirect(route('admin.category.lists'));
    }

    public function delete($id){
        // dd(1);
        $category = Category::find($id);
        if(!$category){
            return redirect(route('admin.category.lists'));
        }

        $category->delete();

        return redirect(route('admin.category.lists'));
    }
}
