

    <!-- HEADER DESKTOP-->
    <header class="header-desktop">
        <div class="section__content section__content--p30">
            <div class="container-fluid">
                <div class="header-wrap">
                    <div class="col-9">
                        @yield('search')
                    </div>
                    <div class="col-3">
                        <div class="d-flex justify-content-end">
                            @auth('admins')
                            <div class="noti-wrap">
                                <div class="noti__item js-item-menu">
                                    <i class="zmdi zmdi-notifications"></i>
                                    <span class="quantity">{{ count(auth()->guard('admins')->user()->unreadNotifications) }}</span>
                                    <div class="notifi-dropdown js-dropdown">
                                        <div class="notifi__title">
                                            <p>You have {{ count(auth()->guard('admins')->user()->unreadNotifications) }} Notifications</p>
                                        </div>
                                        @foreach (auth()->guard('admins')->user()->notifications->take(5)  as $notification)
                                        <div class="notifi__item">
                                            <div class="bg-c1 img-cir img-40">
                                                <i class="zmdi zmdi-email-open"></i>
                                            </div>
                                            <div class="content">
                                                <a href="{{ route('author.notification.show', [$notification->id]) }}">
                                                    @if ($notification->read_at != NULL)
                                                    <p>{{ $notification->data['title'] ?? ''}}</p>
                                                    @else
                                                    <p style="color: red">{{ $notification->data['title'] ?? ''}}</p>
                                                    @endif
                                                    <span class="date">{{ $notification->created_at }}</span>
                                                </a>
                                            </div>
                                        </div>
                                        @endforeach
                                        <div class="notifi__footer">
                                            <a href="#">All notifications</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endauth
                            <div class="account-wrap">
                                @auth('admins')
                                <div class="account-item clearfix js-item-menu">
                                    <div class="content">
                                        <a class="js-acc-btn" href="#">john doe</a>
                                    </div>
                                    <div class="account-dropdown js-dropdown">
                                        <div class="info clearfix">
                                            <div class="content">
                                                <h5 class="name">
                                                    <a href="#">john doe</a>
                                                </h5>
                                                <span class="email">johndoe@example.com</span>
                                            </div>
                                        </div>
                                        <div class="account-dropdown__body">
                                            <div class="account-dropdown__item">
                                                <a href="#">
                                                    <i class="zmdi zmdi-account"></i>Account</a>
                                            </div>
                                            <div class="account-dropdown__item">
                                                <a href="#">
                                                    <i class="zmdi zmdi-settings"></i>Setting</a>
                                            </div>
                                            <div class="account-dropdown__item">
                                                <a href="{{ route('admin.change') }}">
                                                    <i class="zmdi zmdi-lock" aria-hidden="true"></i>Change Password</a>
                                            </div>
                                            <div class="account-dropdown__item">
                                                <a href="{{ route('delete.acc') }}">
                                                    <i class="fa fa-trash" aria-hidden="true"></i>Delete Account</a>
                                            </div>
                                        </div>                                        
                                        <div class="account-dropdown__footer">
                                            <a href="{{ route('admin.logout') }}">
                                                <i class="zmdi zmdi-power"></i>Logout</a>
                                        </div>
                                    </div>
                                </div>
                                @endauth
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>
    <!-- HEADER DESKTOP-->