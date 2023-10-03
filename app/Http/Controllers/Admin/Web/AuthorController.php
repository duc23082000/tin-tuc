<?php

namespace App\Http\Controllers\Admin\Web;

use App\Enums\UserRoleEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\AuthRequest;
use App\ModelFilters\AdminFilter;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Inertia\Inertia;

class AuthorController extends Controller
{
    private $author;
    public function __construct()
    {
        $this->author = new AdminFilter();
    }

    public function index()
    {
        return Inertia::render('admins/web/authors/Index');
    }

    public function indexApi(Request $request)
    {
        $search = $request->input('search');

        $collum = $request->input('collum') ?? 'updated_at';

        $sort = $request->input('sort') ?? 'desc';

        $authors = $this->author->listUser($search, $collum, $sort, UserRoleEnum::Author)->paginate(10)->withQueryString();

        return $authors;
    }

    public function create(){
        return Inertia::render('admins/web/authors/Create');
    }

    public function store(AuthRequest $request){

        $user = new Admin();
        $user->username = $request->input('username');
        $user->email = $request->input('email');
        $user->password = Hash::make($request->input('password'));
        $user->role = UserRoleEnum::Author;
        $user->save();

        return response()->json([
            'success' => 'Tạo Thành công',
            'url' => route('admin.author.lists'),
        ]);
    }

    public function edit($id){
        $user = Admin::find($id);
        if(!$user){
            return redirect(route('admin.author.lists'));
        }
        
        return  Inertia::render('admins/web/authors/Edit', [
            'user' => $user,
        ]);
    }

    public function update($id, AuthRequest $request){
        $user = Admin::find($id);
        if(!$user){
            return redirect(route('admin.author.lists'));
        }
        $user->username = $request->input('username');
        $user->email = $request->input('email');
        $user->password = Hash::make($request->input('password'));
        $user->save();
        
        return response()->json([
            'success' => 'Sửa Thành công',
            'url' => route('admin.author.lists'),
        ]);
    }

    public function delete($id){
        
        $user = Admin::find($id);
        if(!$user){
            return redirect(route('admin.author.lists'));
        }

        $user->delete();

        return response()->json(['success' => 'Xóa thành công']);
    }
}
