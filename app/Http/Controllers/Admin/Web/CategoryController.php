<?php

namespace App\Http\Controllers\Admin\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryRequest;
use App\ModelFilters\CategoryFilter;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;

class CategoryController extends Controller
{
    private $categories;
    public function __construct()
    {
        $this->categories = new CategoryFilter();
    }

    public function index()
    {
        return Inertia::render('admins/web/categories/Index');
    }

    public function indexApi(Request $request)
    {

        $search = $request->input('search');

        $collum = $request->input('column') ?? 'updated_at';

        $sort = $request->input('sort') ?? 'desc';

        Log::info($request->all());

        $categories = $this->categories->listCategory($search, $collum, $sort)
        ->paginate(10);

        return response()->json($categories);
    }

    public function create(){
        return Inertia::render('admins/web/categories/Create');
    }

    public function store(CategoryRequest $request){
        // dd($request->posted_at);
        $category = new Category();
        $category->name = $request->input('name');
        $category->save();

        return response()->json(['success' => 'Tạo Thành công']);
    }

    public function creating(CategoryRequest $request){
        // dd($request->posted_at);
        $category = new Category();
        $category->name = $request->input('name');
        $category->save();

        return redirect(route('admin.category.lists'));
    }

    public function edit($id){
        Log::info($id);
        return Inertia::render('admins/web/categories/Edit', ['id' => $id]);
    }

    public function editApi($id){
        $category = Category::find($id);
        // dd($post->content);
        if(!$category){
            return redirect(route('admin.category.lists'));
        }
        return $category;
    }

    public function update($id, CategoryRequest $request){
        $category = Category::find($id);
        if(!$category){
            return redirect(route('admin.category.lists'));
        }
        $category->name = $request->input('name');
        $category->save();

        return response()->json([
            'success' => 'Sửa Thành công',
            'url' => route('admin.category.lits'),
        ]);
    }

    public function delete($id){
        
        $category = Category::find($id);
        if(!$category){
            return redirect(route('admin.category.lists'));
        }

        $category->delete();

        return response()->json(['success' => 'Xóa thành công']);
    }
}
