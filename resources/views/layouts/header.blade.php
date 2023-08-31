<!-- Header -->

<div class="header">

    <a id="toggle_btn" href="javascript:void(0);">
        <span class="bar-icon">
            <span></span>
            <span></span>
            <span></span>
        </span>
    </a>
    
    <!-- Header Title -->
    <div class="page-title-box">
        <h3>Wolf</h3>
    </div>
    <!-- /Header Title -->
    
    <a id="mobile_btn" class="mobile_btn" href="#sidebar"><i class="fa fa-bars"></i></a>
    
    <!-- Header Menu -->
    <ul class="nav user-menu">
    
        <!-- Search -->
        <li class="nav-item">
            <div class="top-nav-search">
                <a href="javascript:void(0);" class="responsive-search">
                    <i class="fa fa-search"></i>
                </a>
                <form action="search.html">
                    <input class="form-control" type="text" placeholder="Search here">
                    <button class="btn" type="submit"><i class="fa fa-search"></i></button>
                </form>
            </div>
        </li>
        <!-- /Search -->
    
        <!-- Notifications -->
        <li class="nav-item dropdown">
            <a href="#" class="dropdown-toggle nav-link" data-toggle="dropdown">
                <i class="fa fa-bell-o"></i> <span class="badge badge-pill">{{ auth()->user()->unreadNotifications->count() }}</span>
            </a>
            <div class="dropdown-menu notifications">
                <div class="topnav-dropdown-header">
                    <span class="notification-title">Notifications</span>
                    <a href="{{ route('notifications.delete') }}" class="clear-noti"> Clear All </a>
                </div>
                <div class="noti-content">
                    <ul class="notification-list">
                        @forelse (auth()->user()->notifications as $notification)
                            <div class="media">
                                <a href="{{$notification->data['url']}}" class="dropdown-item">{{$notification->data['message']}}</a>
                            </div>
                        @empty
                            <div class="media">
                                <a href="" class="dropdown-item text-center">You have no new notification!</a>
                            </div>
                        @endforelse
                    </ul>
                </div>
                <div class="topnav-dropdown-footer">
                </div>
            </div>
        </li>
        <!-- /Notifications -->
        
       
        <li class="nav-item dropdown has-arrow main-drop">
            <a href="#" class="dropdown-toggle nav-link d-flex align-items-center" data-toggle="dropdown">
                <span class="user-img">
                    <img src="https://eu.ui-avatars.com/api/?name={{ auth()->user()->name }}&background=e63946&color=fff" width="40px" alt="">
                    <span class="status online"></span>
                </span>
                <span class="text-capitalize">{{ auth()->user()->name }}</span>
            </a>
            <div class="dropdown-menu">
                <a class="dropdown-item" href="{{ route('profile.edit') }}">My Profile</a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf

                        <a class="dropdown-item" href="{{ route('logout') }}"
                            onclick="event.preventDefault();
                                this.closest('form').submit();">Logout</a>
                    </form>
            </div>
        </li>
    </ul>
    <!-- /Header Menu -->
    
    <!-- Mobile Menu -->
    <div class="dropdown mobile-user-menu">
        <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="fa fa-ellipsis-v"></i></a>
        <div class="dropdown-menu dropdown-menu-right">
            <a class="dropdown-item" href="profile.html">My Profile</a>
            <a class="dropdown-item" href="settings.html">Settings</a>
            <a class="dropdown-item" href="login.html">Logout</a>
        </div>
    </div>
    <!-- /Mobile Menu -->
    
    <style>
        .user-img {
        margin-right: 5px;
        }
        .main-drop .user-img img {
            width: 35px;
        }
        .user-menu .user-img .status {
            bottom: 0;
        }
    </style>
</div>
<!-- /Header -->




