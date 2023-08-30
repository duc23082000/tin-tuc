<!-- HEADER DESKTOP-->
        <header class="header-desktop3 d-none d-lg-block">
            <div class="section__content section__content--p35">
                <div class="header3-wrap">
                    <div class="header__logo">
                        <a href="{{ route('home') }}">
                            <img src="{{ asset('images/icon/logo-white.png') }}" alt="CoolAdmin" />
                        </a>
                    </div>
                    <div class="header__navbar">
                        <ul class="list-unstyled">
                            <li class="has-sub">
                                <a href="#">
                                    <i class="fas fa-tachometer-alt"></i>Categories
                                    <span class="bot-line"></span>
                                </a>
                                <ul class="header3-sub-list list-unstyled">
                                    @foreach ($categories as $category)
                                    <li>
                                        <a href="{{ route('home', ['category' => $category->name]) }}">{{ $category->name }}</a>
                                    </li>
                                    @endforeach
                                </ul>
                            </li>
                            <li class="has-sub">
                                <a href="#">
                                    <i class="fas fa-shopping-basket"></i>Tags
                                    <span class="bot-line"></span>
                                </a>
                                <ul class="header3-sub-list list-unstyled">
                                    @foreach ($tags as $tag)
                                    <li>
                                        <a href="{{ route('home', ['tag' => $tag->name]) }}">{{ $tag->name }}</a>
                                    </li>
                                    @endforeach
                                </ul>
                            </li>
                            <li class="has-sub">
                                <a href="table.html">
                                    <i class="fas fa-trophy"></i>
                                    <span class="bot-line"></span>Authors</a>
                                <ul class="header3-sub-list list-unstyled">
                                    @foreach ($authors as $author)
                                    <li>
                                        <a href="{{ route('home', ['author' => $author->username]) }}">{{ $author->username }}</a>
                                    </li>
                                    @endforeach
                                </ul>
                            </li>
                            <li class="has-sub">
                                <a href="#">
                                    <i class="fas fa-copy"></i>
                                    <span class="bot-line"></span>Pages</a>
                                <ul class="header3-sub-list list-unstyled">
                                    <li>
                                        <a href="forget-pass.html">Forget Password</a>
                                    </li>
                                </ul>
                            </li>
                            <li class="has-sub">
                                <a href="#">
                                    <i class="fas fa-desktop"></i>
                                    <span class="bot-line"></span>UI Elements</a>
                                <ul class="header3-sub-list list-unstyled">
                                    <li>
                                        <a href="button.html">Button</a>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                    <div class="header__tool">
                        @auth
                        <div class="noti-wrap">
                            <div class="noti__item js-item-menu">
                                <i class="zmdi zmdi-notifications"></i>
                                <span class="quantity">{{ count(auth()->user()->unreadNotifications) }}</span>
                                <div class="notifi-dropdown js-dropdown">
                                    <div class="notifi__title">
                                        <p>You have {{ count(auth()->user()->unreadNotifications) }} Notifications</p>
                                    </div>
                                    @foreach (auth()->user()->notifications->take(5)  as $notification)
                                    <div class="notifi__item">
                                        <div class="bg-c1 img-cir img-40">
                                            <i class="zmdi zmdi-email-open"></i>
                                        </div>
                                        <div class="content">
                                            <a href="{{ route('notification.show', [$notification->id]) }}">
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
                        <div class="header-button-item js-item-menu">
                            <i class="zmdi zmdi-settings"></i>
                            <div class="setting-dropdown js-dropdown">
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
                                        <a href="#">
                                            <i class="zmdi zmdi-money-box"></i>Billing</a>
                                    </div>
                                </div>
                                <div class="account-dropdown__body">
                                    <div class="account-dropdown__item">
                                        <a href="#">
                                            <i class="zmdi zmdi-globe"></i>Language</a>
                                    </div>
                                    <div class="account-dropdown__item">
                                        <a href="#">
                                            <i class="zmdi zmdi-pin"></i>Location</a>
                                    </div>
                                    <div class="account-dropdown__item">
                                        <a href="#">
                                            <i class="zmdi zmdi-email"></i>Email</a>
                                    </div>
                                    <div class="account-dropdown__item">
                                        <a href="#">
                                            <i class="zmdi zmdi-notifications"></i>Notifications</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @auth('web')
                        <div class="account-wrap">
                            <div class="account-item account-item--style2 clearfix js-item-menu">
                                <div class="image">
                                    <img src="images/icon/avatar-01.jpg" alt="John Doe" />
                                </div>
                                <div class="content">
                                    <a class="js-acc-btn" href="#">{{ auth()->user()->username }}</a>
                                </div>
                                <div class="account-dropdown js-dropdown">
                                    <div class="info clearfix">
                                        <div class="image">
                                            <a href="#">
                                                <img src="images/icon/avatar-01.jpg" alt="John Doe" />
                                            </a>
                                        </div>
                                        <div class="content">
                                            <h5 class="name">
                                                <a href="#">{{ auth()->user()->username }}</a>
                                            </h5>
                                            <span class="email">{{ auth()->user()->email }}</span>
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
                        </div>
                        @endauth
                        @guest('web')
                        <div class="account-wrap">
                            <div class="content">
                                <a class="js-acc-btn" href="{{ route('account.login') }}">Log in</a>
                            </div>
                        </div>
                        @endguest
                    </div>
                </div>
            </div>
        </header>
        <!-- END HEADER DESKTOP-->