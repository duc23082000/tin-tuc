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

class AuthorController extends Controller
{
    private $author;
    public function __construct()
    {
        $this->author = new UserFilter();
    }
    public function index(Request $request){

        $search = $request->input('search');

        $collum = $request->input('collum') ?? 'updated_at';

        $sort = $request->input('sort') ?? 'desc';

        // $authors = $this->author->listUser($search, $collum, $sort, UserRoleEnum::Author)->paginate(10)->withQueryString();
        $authors = $this->author->listUser($search, $collum, $sort, UserRoleEnum::Author)->paginate(10)->withQueryString();
            // ->paginate(10)->withQueryString();

        $sort = $sort == 'asc' ? 'desc' : 'asc';
        return view('admin.web.authors.lists', compact('authors', 'search', 'sort'));
    }

    public function create(){
        return view('admin.web.authors.create');
    }

    public function creating(AuthRequest $request){
        // dd($request->posted_at);
        $user = new User();
        $user->username = $request->input('username');
        $user->email = $request->input('email');
        $user->password = Hash::make($request->input('password'));
        $user->role = UserRoleEnum::Author;
        $user->save();

        return redirect(route('admin.author.lists'));
    }

    public function edit($id){
        $user = User::find($id);
        if(!$user){
            return redirect(route('admin.author.lists'));
        }
        return view('admin.web.authors.edit', compact('user'));
    }

    public function editing($id, AuthRequest $request){
        $user = User::find($id);
        if(!$user){
            return redirect(route('admin.author.lists'));
        }
        $user->username = $request->input('username');
        $user->email = $request->input('email');
        $user->password = Hash::make($request->input('password'));
        $user->save();
        return redirect(route('admin.author.lists'));
    }

    public function delete($id){
        
        $user = User::find($id);
        if(!$user){
            return redirect(route('admin.author.lists'));
        }

        $user->delete();

        return redirect(route('admin.author.lists'));
    }
}
