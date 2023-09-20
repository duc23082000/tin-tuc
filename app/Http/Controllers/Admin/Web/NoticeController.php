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
use Inertia\Inertia;

class NoticeController extends Controller
{
    private $notices;
    public function __construct()
    {
        $this->notices = new NotificationFilter();

        View::share('status', NoticeStatusEnum::asArray());
    }

    public function index()
    {
        return Inertia::render('admins/web/notifications/Index');
    }

    public function indexApi(Request $request)
    {
        $search = $request->input('search');

        $collum = $request->input('collum') ?? 'updated_at';

        $sort = $request->input('sort') ?? 'desc';

        $notices = $this->notices->listNotification($search, $collum, $sort)->with(['users', 'authors'])->paginate(10)->withQueryString();

        $sort = $sort == 'asc' ? 'desc' : 'asc';

        return $notices;
    }

    public function create(){
        $users = User::all();
        $authors = Admin::where('role', UserRoleEnum::Author)->get(); 

        return Inertia::render('admins/web/notifications/Create', [
            'users' => $users,
            'authors' => $authors,
        ]);
    }

    public function store(NotificationRequest $request)
    {
        $data = array_merge($request->validated(), ['created_by_id' => app('admin_id')]);

        $notice = Notice::create($data);

        $notice->users()->sync($request->input('users'));
        $notice->authors()->sync($request->input('authors'));

        return response()->json([
            'success' => 'Tạo Thành công',
            'url' => route('admin.notice.lists'),
        ]);
    }

    public function edit($id){
        $notice = Notice::with(['users', 'authors'])->find($id);
        if(!$notice){
            return redirect(route('admin.post.lists'));
        }
        $users = User::all();
        $authors = Admin::where('role', UserRoleEnum::Author)->get(); 
        return Inertia::render('admins/web/notifications/Edit', [
            'users' => $users,
            'authors' => $authors,
            'notice' => $notice,
            'notified_users' => $notice->users->pluck('id')->toArray(),
            'notified_authors' => $notice->authors->pluck('id')->toArray(),
        ]);
    }

    public function editing($id, NotificationRequest $request)
    {
        $notice = Notice::find($id);
        if(!$notice){
            return redirect(route('admin.notice.lists'));
        }

        $data = array_merge($request->validated(), ['created_by_id' => app('admin_id')]);
        $notice->update($data);

        $notice->users()->sync($request->input('users'));
        $notice->authors()->sync($request->input('authors'));

        return response()->json([
            'success' => 'Tạo Thành công',
            'url' => route('admin.notice.lists'),
        ]);
    }

    public function delete($id)
    {
        
        $notice = Notice::find($id);
        if(!$notice){
            return redirect(route('admin.notice.lists'));
        }

        $notice->delete();

        return response()->json(['success' => 'Xóa thành công']);
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
        if(!empty($notice->authors)){
            FacadesNotification::send($notice->authors, new UserNotification($notice->created_by->email, $notice->title, $notice->content));
        }
        $notice->status = NoticeStatusEnum::Sent;
        $notice->save();

        return response()->json(['success' => 'Gửi thành công']);
    }
}
