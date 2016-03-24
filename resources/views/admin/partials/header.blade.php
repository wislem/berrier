<!-- Main Header -->
<header class="main-header">

    <!-- Logo -->
    <a href="{{url('admin')}}" class="logo">
        <!-- mini logo for sidebar mini 50x50 pixels -->
        <span class="logo-mini"><b>B</b>R</span>
        <!-- logo for regular state and mobile devices -->
        <span class="logo-lg"><b>Berr</b>ier</span>
    </a>

    <!-- Header Navbar -->
    <nav class="navbar navbar-static-top" role="navigation">
        <!-- Sidebar toggle button-->
        <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
            <span class="sr-only">Toggle navigation</span>
        </a>
        <!-- Navbar Right Menu -->
        <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
                <!-- Notifications Menu -->
                <li class="dropdown notifications-menu">
                    <!-- Menu toggle button -->
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <i class="fa fa-bell-o"></i>
                        @if($notification_quantity)
                        <span class="label label-warning">{{$notification_quantity}}</span>
                        @endif
                    </a>
                    <ul class="dropdown-menu">
                        <li class="header">You have {{$notification_quantity}} notifications</li>
                        <li>
                            <!-- Inner Menu: contains the notifications -->
                            <ul class="menu">
                                @foreach($notifications as $notice)
                                <li><!-- start notification -->
                                    <a href="{{url($notice->uri)}}">
                                        <i class="fa fa-bell text-aqua"></i> {{$notice->content}}
                                    </a>
                                </li><!-- end notification -->
                                @endforeach
                            </ul>
                        </li>
                        <li class="footer"><a href="{{url('admin/notifications')}}">View all</a></li>
                    </ul>
                </li>
                <!-- User Account Menu -->
                <li class="dropdown user user-menu">
                    <!-- Menu Toggle Button -->
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <!-- hidden-xs hides the username on small devices so only the image appears. -->
                        <span class="hidden-xs">{{$user->first_name.' '.$user->last_name}}</span>
                    </a>
                    <ul class="dropdown-menu">
                        <!-- The user image in the menu -->
                        <li class="user-header">
                            <p>
                                {{$user->first_name.' '.$user->last_name}}
                                <small>Member since {{$user->created_at->format('M. Y')}}</small>
                            </p>
                        </li>
                        <!-- Menu Footer-->
                        <li class="user-footer">
                            <div class="pull-left">
                                <a href="{{url('admin/users/'.$user->id.'/edit')}}" class="btn btn-default btn-flat">Settings</a>
                            </div>
                            <div class="pull-right">
                                <a href="{{url('admin/auth/logout')}}" class="btn btn-default btn-flat">Sign out</a>
                            </div>
                        </li>
                    </ul>
                </li>
                <!-- Control Sidebar Toggle Button -->
                <li>
                    <a href="#" data-toggle="control-sidebar"><i class="fa fa-gears"></i></a>
                </li>
            </ul>
        </div>
    </nav>
</header>