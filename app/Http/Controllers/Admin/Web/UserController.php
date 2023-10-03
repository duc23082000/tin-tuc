<?php

namespace App\Http\Controllers\Admin\Web;

use App\Enums\UserRoleEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\AuthRequest;
use App\ModelFilters\UserFilter;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Inertia\Inertia;

class UserController extends Controller
{
    private $users;
    public function __construct()
    {
        $this->users = new UserFilter();
    }

    public function index()
    {
        return Inertia::render('admins/web/users/Index');
    }

    public function indexApi(Request $request)
    {
        $search = $request->input('search');

        $collum = $request->input('collum') ?? 'updated_at';

        $sort = $request->input('sort') ?? 'desc';

        $users = $this->users->listUser($search, $collum, $sort)->paginate(10)->withQueryString();

        return $users;

    }

    public function create(){
        return Inertia::render('admins/web/users/Create');
    }

    public function store(AuthRequest $request){
        $user = new User();
        $user->username = $request->input('username');
        $user->email = $request->input('email');
        $user->password = Hash::make($request->input('password'));
        $user->save();

        return response()->json([
            'success' => 'Tạo Thành công',
            'url' => route('admin.user.lists'),
        ]);
    }

    public function edit($id){
        $user = User::find($id);
        if(!$user){
            return redirect(route('admin.user.lists'));
        }
        
        return  Inertia::render('admins/web/users/Edit', [
            'user' => $user,
        ]);
    }
    

    public function update($id, AuthRequest $request){
        $user = User::find($id);
        if(!$user){
            return redirect(route('admin.author.lists'));
        }
        $user->username = $request->input('username');
        $user->email = $request->input('email');
        $user->password = Hash::make($request->input('password'));
        $user->save();
        return response()->json([
            'success' => 'Sửa Thành công',
            'url' => route('admin.user.lists'),
        ]);
    }

    public function delete($id)
    {
        $user = User::find($id);
        if(!$user){
            return redirect(route('admin.author.lists'));
        }
        $user->delete();

        return response()->json(['success' => 'Xóa thành công']);

    }
}
