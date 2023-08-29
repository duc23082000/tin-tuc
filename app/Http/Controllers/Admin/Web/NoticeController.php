<?php

namespace App\Http\Controllers\Admin\Web;

use App\Enums\NoticeStatusEnum;
use App\Enums\UserRoleEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\NotificationRequest;
use App\Http\Requests\TestValidate;
use App\ModelFilters\NotificationFilter;
use App\Models\Admin;
use App\Models\Notice;
use App\Models\User;
use App\Notifications\TestNotification;
use App\Notifications\UserNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification as FacadesNotification;
use Illuminate\Support\Facades\View;

class NoticeController extends Controller
{
    private $notices;
    public function __construct()
    {
        $this->notices = new NotificationFilter();

        View::share('status', NoticeStatusEnum::asArray());
    }

    public function index(Request $request){
        $search = $request->input('search');

        $collum = $request->input('collum') ?? 'updated_at';

        $sort = $request->input('sort') ?? 'desc';

        $notices = $this->notices->listNotification($search, $collum, $sort)->paginate(10)->withQueryString();

        $sort = $sort == 'asc' ? 'desc' : 'asc';

        return view('admin.web.notices.lists', compact('notices', 'search', 'sort'));
    }

    public function create(){
        $users = User::all();
        $authors = Admin::where('role', UserRoleEnum::Author)->get(); 

        return view('admin.web.notices.create', compact('users', 'authors'));
    }

    public function creating(NotificationRequest $request){

        $notice = new Notice();
        $notice->title = $request->input('title');
        $notice->content = $request->input('content');
        $notice->created_by_id = app('admin_id');
        $notice->save();

        $notice->users()->sync($request->input('user'));
        $notice->authors()->sync($request->input('author'));

        return redirect(route('admin.notice.lists'));
    }

    public function edit($id){
        $notice = Notice::find($id);
        if(!$notice){
            return redirect(route('admin.post.lists'));
        }
        $users = User::all();
        $authors = Admin::where('role', UserRoleEnum::Author)->get(); 
        return view('admin.web.notices.edit', compact('notice', 'users', 'authors'));
    }

    public function editing($id, NotificationRequest $request)
    {
        $notice = Notice::find($id);
        if(!$notice){
            return redirect(route('admin.notice.lists'));
        }
        $notice->title = $request->input('title');
        $notice->content = $request->input('content');
        $notice->modified_by_id = app('admin_id');
        $notice->save();
        
        $notice->users()->sync($request->input('user'));
        $notice->authors()->sync($request->input('author'));

        return redirect(route('admin.notice.lists'));
    }

    public function delete($id)
    {
        
        $notice = Notice::find($id);
        if(!$notice){
            return redirect(route('admin.notice.lists'));
        }

        $notice->delete();

        return redirect(route('admin.notice.lists'));
    }

    public function sendNotifications($id)
    {
        $notice = Notice::find($id);
        if(!$notice){
            return redirect(route('admin.notice.lists'));
        }
        if(!empty($notice->users)){
            FacadesNotification::send($notice->users, new UserNotification($notice->created_by->email, $notice->title, $notice->content));
        }
        if(!empty($notice->author)){
            FacadesNotification::send($notice->author, new UserNotification($notice->created_by->email, $notice->title, $notice->content));
        }
        $notice->status = NoticeStatusEnum::Send;
        $notice->save();
        return back();
    }
}
