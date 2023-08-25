@extends('layout.app')

@section('search')
<form class="form-header" action="" method="GET">
    <input class="au-input au-input--xl" type="text" name="search" value="{{ $search }}" placeholder="Search for datas &amp; reports..." />
    <button class="au-btn--submit" type="submit">
        <i class="zmdi zmdi-search"></i>
    </button>
</form>
@endsection

@section('content')
<div class="col-md-12">
    <!-- DATA TABLE -->
    <h3 class="title-5 m-b-35">Notification table</h3>

    <div class="table-data__tool-right">
        <a href="{{ route('admin.notice.create') }}" class="au-btn au-btn-icon au-btn--green au-btn--small">
            <i class="zmdi zmdi-plus"></i>add item</a>
    </div>

    <div class="table-data__tool">
        <div class="table-responsive table-responsive-data2">
            <table class="table table-data2">
                <thead>
                    <tr>
                        <th style="width: 7%">
                            <form action="" method="get" >
                                <input type="hidden" name="search" value="{{ $search }}">
                                <input type="hidden" name="collum" value="notices.id">
                                <input type="hidden" name="sort" value="{{ $sort }}">                           
                                <span>ID <button><i class="fa fa-sort" aria-hidden="true"></i></button></span>
                            </form>
                        </th>
                        <th style="width: 50%">
                            <form action="" method="get" >
                                <input type="hidden" name="search" value="{{ $search }}">
                                <input type="hidden" name="collum" value="notices.title">
                                <input type="hidden" name="sort" value="{{ $sort }}">                           
                                <span>title <button><i class="fa fa-sort" aria-hidden="true"></i></button></span>
                            </form>
                        </th>
                        <th>Status</th>
                        <th style="width: 10%">
                            <form action="" method="get" >
                                <input type="hidden" name="search" value="{{ $search }}">
                                <input type="hidden" name="collum" value="admins.email">
                                <input type="hidden" name="sort" value="{{ $sort }}">                           
                                <span>created by <button><i class="fa fa-sort" aria-hidden="true"></i></button></span>
                            </form>
                        </th>
                        <th style="width: 10%">
                            <form action="" method="get" >
                                <input type="hidden" name="search" value="{{ $search }}">
                                <input type="hidden" name="collum" value="notices.created_at">
                                <input type="hidden" name="sort" value="{{ $sort }}">                           
                                <span>created at <button><i class="fa fa-sort" aria-hidden="true"></i></button></span>
                            </form>
                        </th>
                        <th style="width: 10%">
                            <form action="" method="get" >
                                <input type="hidden" name="search" value="{{ $search }}">
                                <input type="hidden" name="collum" value="notices.updated_at">
                                <input type="hidden" name="sort" value="{{ $sort }}">                           
                                <span>modifited at <button><i class="fa fa-sort" aria-hidden="true"></i></button></span>
                            </form>
                        </th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($notices as $item)
                    <tr class="tr-shadow">
                        <td>{{ $item->id }}</td>
                        <td>{{ $item->title }}</td>
                        <td>{{ $item->status_name }}</td>
                        <td>{{ $item->email }}</td>
                        <td>{{ $item->created_at }}</td>
                        <td>{{ $item->updated_at }}</td>
                        <td>
                            <div class="table-data-feature">
                                <a class="item" href="{{ route('admin.notice.edit', [$item->id]) }}" data-toggle="tooltip" data-placement="top" title="" data-original-title="Edit">
                                    <i class="zmdi zmdi-edit"></i>
                                </a>
                                <a class="item" href="{{ route('admin.notice.delete', [$item->id]) }}" onclick="return confirm('Bạn có chắc chắn muốn xóa?')" data-toggle="tooltip" data-placement="top" title="" data-original-title="Delete">
                                    <i class="zmdi zmdi-delete"></i>
                                </a>
                                <button class="item" data-toggle="tooltip" data-placement="top" title="" data-original-title="More">
                                    <i class="zmdi zmdi-more"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <!-- END DATA TABLE -->
    </div>
</div>
<div class="d-flex justify-content-end">
    {{ $notices->links('pagination.simple-tailwind') }}
</div>
@endsection