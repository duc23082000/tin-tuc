

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
                                @auth('web')
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
                                                <a href="{{ route('account.change') }}">
                                                    <i class="zmdi zmdi-lock" aria-hidden="true"></i>Change Password</a>
                                            </div>
                                        </div>                                        
                                        <div class="account-dropdown__footer">
                                            <a href="{{ route('account.logout') }}">
                                                <i class="zmdi zmdi-power"></i>Logout</a>
                                        </div>
                                    </div>
                                </div>
                                @endauth
                                @guest('web')
                                <div class="account-item clearfix">
                                    <div class="content">
                                        <a class="js-acc-btn" href="{{ route('account.login') }}">Log in</a>
                                    </div>
                                </div>
                                @endguest
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>
    <!-- HEADER DESKTOP-->