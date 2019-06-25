<!DOCTYPE html>
<head>
<title>GreenWich</title>

<!-- CSRF Token -->
<meta name="csrf-token" content="{{ csrf_token() }}">

<meta name="viewport" content="width=device-width, initial-scale=1">
<script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); } </script>
<!-- bootstrap-css -->
<link rel="stylesheet" href="{{asset('css/bootstrap.min.css')}}" >
<!-- //bootstrap-css -->
<!-- Custom CSS -->
<link href="{{asset('css/style.css')}}" rel='stylesheet' type='text/css' />
<link href="{{asset('css/style-responsive.css')}}" rel="stylesheet"/>
<!-- font CSS -->
<!--     Fonts and icons     -->
<link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700|Roboto+Slab:400,700|Material+Icons" />
<!-- font-awesome icons -->
<link rel="stylesheet" href="{{asset('css/font.css')}}" type="text/css"/>
<link href="{{asset('css/font-awesome.css')}}" rel="stylesheet"> 
<!-- //font-awesome icons -->
<script src="{{asset('js/jquery2.0.3.min.js')}}"></script>

<!-- charts -->
<script src="{{asset('js/raphael-min.js')}}"></script>
<script src="{{asset('js/morris.js')}}"></script>
<link rel="stylesheet" href="{{asset('css/morris.css')}}">
<!-- //charts -->


</head>
<body>

	<section id="container">
        <!--header start-->
        <header class="header fixed-top clearfix">
            <!--logo start-->
            <div class="brand">

                <a href="{{URL('/')}}" class="logo">
                    GreenWich
                </a>
                <div class="sidebar-toggle-box">
                    <div class="fa fa-bars"></div>
                </div>
            </div>
            <!--logo end-->

            @if(Auth::user()->role==3)
                <div class="nav notify-row" id="top_menu">
                    <!--  notification start -->
                    <ul class="nav top-menu">
                        <!-- inbox dropdown start-->
                        <li id="header_inbox_bar" class="dropdown">
                            <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                                <i class="fa fa-envelope-o"></i>
                                <span class="badge bg-important">{{count($notifications)}}</span>
                            </a>
                            <ul class="dropdown-menu extended inbox">
                                <li>
                                    <p class="red">You have {{count($notifications)}} Mails</p>
                                </li>
                                @foreach( $notifications as $notification)
                                     <li>
                                        <a href="{{ URL('/notification').'/'.$notification->id }}">
                                            <span class="photo"><img alt="avatar" src="{{ asset('images/3.png') }}"></span>
                                            <span class="subject">
                                                <span class="from">{{ $notification->first_name." ".$notification->last_name }}</span>
                                                <span class="time">{{ $notification->created_at }}</span>
                                            </span>
                                            <span class="message">
                                                Submited a new Contribution.
                                            </span>
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </li>
                        <!-- inbox dropdown end -->
                    </ul>
                    <!--  notification end -->
                </div>
            @elseif(Auth::user()->role==4)
                <div class="nav notify-row" id="top_menu">
                    <!--  notification start -->
                    <ul class="nav top-menu">
                        <!-- inbox dropdown start-->
                        <li id="header_inbox_bar" class="dropdown">
                            <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                                <i class="fa fa-envelope-o"></i>
                                <span class="badge bg-important">{{count($messages)}}</span>
                            </a>
                            <ul class="dropdown-menu extended inbox">
                                <li>
                                    <p class="red">You have {{count($messages)}} Message</p>
                                </li>
                                @foreach( $messages as $message)
                                     <li>
                                        <a href="{{ URL('/message/seen').'/'.$message->id }}">
                                            <span class="photo"><img alt="avatar" src="{{ asset('images/3.png') }}"></span>
                                            <span class="subject">
                                                <span class="from">{{ $message->name }}</span>
                                                <span class="time">{{ $message->created_at }}</span>
                                            </span>
                                            <span class="message">
                                                Your have new message form {{ $message->name }}
                                            </span>
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </li>
                        <!-- inbox dropdown end -->
                    </ul>
                    <!--  notification end -->
                </div>
            @endif


            <div class="top-nav clearfix">
                <!--search & user info start-->
                <ul class="nav pull-right top-menu">
                    <!-- user login dropdown start-->
                    <li class="dropdown">
                        <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                            <img alt="" src="{{ asset('images/avater.png') }}">
							@if(Auth::user()->role==4)
								<span class="username">{{ $userInformation[0]->first_name }}</span>
							@else
								<span class="username">{{ $userInformation[0]->name }}</span>
							@endif
                            
                            <b class="caret"></b>
                        </a>
                        <ul class="dropdown-menu extended logout">
                            <li><a href="#"><i class=" fa fa-suitcase"></i>Profile</a></li>
                            <li>
                                <a class="dropdown-item" href="{{ route('logout') }}"
                                   onclick="event.preventDefault();
                                                 document.getElementById('logout-form').submit();">
                                    {{ __('Logout') }}
                                </a>

                                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                    @csrf
                                </form>
                            </li>
                        </ul>
                    </li>
                    <!-- user login dropdown end -->

                </ul>
                <!--search & user info end-->
            </div>
        </header>
        <!--header end-->
        <!--sidebar start-->
        <aside>
            <div id="sidebar" class="nav-collapse">
                <!-- sidebar menu start-->
                <div class="leftside-navigation">
                    <ul class="sidebar-menu" id="nav-accordion">
						@if(Auth::user()->role == 1)
                            <li>
                                <a class="{{ Request::is('/') ? 'active' : '' }} {{ Request::is('report/statistics') ? 'active' : '' }}" href="{{ URL('/') }}">
                                    <i class="fa fa-dashboard"></i>
                                    <span>Dashboard</span>
                                </a>
                            </li>
                            <li>
                                <a class="{{ Request::is('report/exception') ? 'active' : '' }}" href="{{ URL('/report/exception') }}">
                                    <i class="fa fa-dashboard"></i>
                                    <span>Exception reports</span>
                                </a>
                            </li>
                            <li>
                                <a class="{{ Request::is('magazine') ? 'active' : '' }}"  href="{{ URL('/magazine') }}">
                                    <i class="fa fa-dashboard"></i>
                                    <span>Magazine</span>
                                </a>
                            </li>
							<li>
								<a class="{{ Request::is('magazine/create') ? 'active' : '' }}" href="{{ URL('/magazine/create') }}">
									<i class="fa fa-dashboard"></i>
									<span>Create Magazine</span>
								</a>
							</li>
						@elseif(Auth::user()->role == 2)
                            <li>
                                <a class="{{ Request::is('/') ? 'active' : '' }} {{ Request::is('magazine') ? 'active' : '' }}" href="{{ URL('/') }}">
                                    <i class="fa fa-dashboard"></i>
                                    <span>Dashboard</span>
                                </a>
                            </li>
						@elseif(Auth::user()->role == 3)
                            <li>
                                <a class="{{ Request::is('/') ? 'active' : '' }} {{ Request::is('magazine') ? 'active' : '' }}" href="{{ URL('/') }}">
                                    <i class="fa fa-dashboard"></i>
                                    <span>Dashboard</span>
                                </a>
                            </li>
						@elseif(Auth::user()->role == 5)
                            <li>
                                <a class="{{ Request::is('/') ? 'active' : '' }} {{ Request::is('report/statistics') ? 'active' : '' }}" href="{{ URL('/') }}">
                                    <i class="fa fa-dashboard"></i>
                                    <span>Dashboard</span>
                                </a>
                            </li>
                        @elseif(Auth::user()->role == 4)
                            <li>
                                <a class="{{ Request::is('/') ? 'active' : '' }}" href="{{ URL('/') }}">
                                    <i class="fa fa-dashboard"></i>
                                    <span>Dashboard</span>
                                </a>
                            </li>
                            <li>
                                <a class="{{ Request::is('magazine') ? 'active' : '' }}"  href="{{ URL('/magazine') }}">
                                    <i class="fa fa-dashboard"></i>
                                    <span>Magazine</span>
                                </a>
                            </li>
							<li>
                                <a class="{{ Request::is('message') ? 'active' : '' }}"  href="{{ URL('/message') }}">
                                    <i class="fa fa-dashboard"></i>
                                    <span>Message</span>
                                </a>
                            </li>
						@endif
                    </ul>
                </div>
                <!-- sidebar menu end-->
            </div>
        </aside>
        <!--sidebar end-->

	
    	@yield('content')


    </section>


    @yield('modal-or-js')
    
    
	<script src="{{asset('js/bootstrap.js')}}"></script>
	<script src="{{asset('js/jquery.dcjqaccordion.2.7.js')}}"></script>
	<script src="{{asset('js/scripts.js')}}"></script>
	<script src="{{asset('js/jquery.slimscroll.js')}}"></script>
	<script src="{{asset('js/jquery.nicescroll.js')}}"></script>
	<script src="{{asset('js/jquery.scrollTo.js')}}"></script>
</body>
</html>