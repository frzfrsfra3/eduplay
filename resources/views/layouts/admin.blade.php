<!doctype html>
<html class="no-js" lang="">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="x-ua-compatible" content="ie=edge">
        <title>
          EduPlayCloud.com - @section('title')
        @show
    </title>
        <meta name="description" content="">
		<!-- Mobile specific metas
		============================================ -->
        <meta name="viewport" content="width=device-width, initial-scale=1">
		<!-- Fonts
		============================================ -->
        <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">

		<!-- Favicon
		============================================ -->
		<link rel="shortcut icon" type="image/x-icon" href="{{ asset('assets/images') }}/favicon.ico">
		<!-- CSS  -->
		<!-- Bootstrap CSS
		============================================ -->
        <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
		<!-- font-awesome CSS
		============================================ -->
         <link rel="stylesheet" href="{{ asset('assets/css/font-awesome.css') }}">
		<!-- meanmenu CSS
		============================================ -->
         <link rel="stylesheet" href="{{ asset('assets/css/meanmenu.min.css') }}">
		<!-- style CSS
		============================================ -->
         <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/css/eduplay.css') }}">
		<!-- responsive CSS
		============================================ -->
         <link rel="stylesheet" href="{{ asset('assets/css/responsive.css') }}">
         <!--page level css-->
            @yield('header_styles')
        <!--end of page level css-->
    </head>

<body class="home-2">
    <!-- Header Start -->
   		<!-- header start -->
	<header>
		<div class="header-area">
			<div class="container">
				<div class="row">
					<!-- logo start -->
					<div class="col-md-2 col-lg-3">
						<div class="logo">
							<a href="{{route('welcome')}}"><img src="{{ asset('assets/images/') }}/eduplay_logo.png" alt="" /></a>
						</div>
					</div>
					<!-- logo end -->
					<!-- mainmenu start -->
					<div class="col-md-10 col-lg-9">
						<ul>
                        	<li class="flL" style="padding-top:15px; padding-left:40px;">
                              <form>
                              <div class="flL">
                             	<input class="search-field" type="Text" name="search" value="Search"></div>
                                <div class="flL"><input type="image" src="{{ asset('assets/images/') }}/search-btn.png" border="0"></div>
                             </form>

                            </li>
                            <li class="FLR"><div class="mainmenu" style="padding-top:20px;">
							<nav>
								<ul id="nav">
									<li><a href="{{route('exercisesets.exerciseset.private')}}">@lang('messages.Home')</a></li>
									<li><a href="{{ route('explore.exerciseset') }}">@lang('messages.Explore')</a></li>
                                    <!-- Authentication Links -->
                                    @guest
                                        <li style="padding-right:10px;"><a href="{{ route('login') }}" >@lang('messages.Login')</a></li>
                                        <li style="padding-right:10px;"><a href="{{ route('register') }}"  class="btn-primary">@lang('messages.Signup')</a></li>
                                    @else
                                        <li style="padding-right:10px;"><a href="{{ route('logout')}}" onclick="event.preventDefault();
                                                    document.getElementById('logout-form').submit();"><img src="{{ Avatar::create('ADMIN')->toBase64() }}" />:Logout
                                            </a>

                                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                                @csrf
                                            </form>
                                        </li>
                                    @endguest
                                    <li>
                                    	<div class="selectWrapper">
                                            <select class="selectBox">
                                                <option>@lang('messages.English')</option>
                                                <option>@lang('messages.French')</option>
                                                <option>@lang('messages.Arabic')</option>
                                            </select>
                                        </div>
                                    </li>
								</ul>
							</nav>
						</div></li>
                        </ul>
					</div>
					<!-- mainmenu end -->
				</div>
			</div>
		</div>
		<!-- mobile-menu-area start -->
		<div class="mobile-menu-area">
			<div class="container">
				<div class="row">
					<div class="col-md-12">
						<div class="mobile-menu">
							<div class="logo">

								<a href="{{route('welcome')}}"><img src="{{ asset('assets/images/') }}/eduplay_logo_s.png" alt="" /></a>
							</div>
							<nav id="dropdown">
								<ul>
									<li><a href="#">@lang('messages.Home')</a></li>
									<li><a href="{{route('disciplines.discipline.index')}}#">@lang('messages.Explore')</a></li>
									<li><a href="#">@lang('messages.Login')</a></li>
									<li><a href="#">@lang('messages.Signup')</a></li>
								</ul>
							</nav>
						</div>
					</div>
                    <div class="col-md-12 col-xs-offset-1">
                    	<form>
                    			<ul>
                                <li class="flL" style=" width:70%; padding-left:20px; padding-top:10px;">
                             	<input class="search-field-mobile" type="Text" name="search" value="@lang('messages.Search')"></li>
                                <li class="flL" style="padding-top:10px;">
                                <input type="image" src="{{ asset('assets/images/') }}/search-btn.png" border="0">
                                </li>
                                </ul>
                             </form>
                    </div>
				</div>
			</div>
		</div>
		<!-- mobile-menu-area end -->
	</header>
	<!-- header end -->
    <!-- //Header End -->

    <!-- slider / breadcrumbs section -->
    @yield('top')
    <main class="py-4">
        <div class="container">
            <div class="row">
                <div class="col-md-4">
                    <!-- It can be fixed with bootstrap affix http://getbootstrap.com/javascript/#affix-->
                    <div id="sidebar" class="well sidebar-nav">
                        <h5><i class="glyphicon glyphicon-home"></i>
                            <small><b>Manage Users</b></small>
                        </h5>
                        <ul class="nav nav-pills nav-stacked">
                            <li class={{ \Request::is('users/*') ? 'active' : '' }}><a href="{{url('/users')}}">List Users</a></li>
                            <li class={{ \Request::is('avatars') ? 'active' : '' }}><a href="{{url('/avatars')}}">Avatars</a></li>
                            <li class={{ \Request::is('avatars/*') ? 'active' : '' }}><a href="{{url('/avatars/accessories')}}">Avatar Accessories</a></li>
                            {{-- <li class={{ \Request::is('avatars/*') ? 'active' : '' }}><a href="{{url('/useractivitylogs')}}">Activity Logs</a></li> --}}
                            <li class={{ \Request::is('invitedusers') ? 'active' : '' }}><a href="{{url('/invitedusers')}}">Invited Users</a></li>
                        </ul>
                        <h5><i class="glyphicon glyphicon-file"></i>
                            <small><b>Manage Exercise</b></small>
                        </h5>
                        <ul class="nav nav-pills nav-stacked">
                            <li class={{ \Request::is('exercisesets/*') ? 'active' : '' }} ><a href="{{url('/exercisesets/listall')}}">List Exercise</a></li>
                        </ul>
                        <h5><i class="glyphicon glyphicon-user"></i>
                            <small><b>Manage Lists</b></small>
                        </h5>
                        <ul class="nav nav-pills nav-stacked">
                            @can('create',App\Models\Country::class)
                                <li class={{ \Request::is('countries/*') ? 'active' : '' }}><a href="{{url('/countries')}}">Countries</a></li>
                            @endcan
                            <li class={{ \Request::is('curricula') ? 'active' : '' }}><a href="{{url('/curricula')}}">Curricula Grade List</a></li>
                            <li class={{ \Request::is('schools') ? 'active' : '' }}><a href="{{url('/schools')}}">Schools</a></li>
                        </ul>
                        <h5><i class="glyphicon glyphicon-user"></i>
                            <small><b>Manage Disciplines</b></small>
                        </h5>
                        <ul class="nav nav-pills nav-stacked">
                            <li class={{ \Request::is('disciplines/*') ? 'active' : '' }}><a href="{{url('/disciplines')}}/listall">List Disciplines</a></li>
                            <li class={{ \Request::is('disciplinecollaborators') ? 'active' : '' }}><a href="{{url('/disciplinecollaborators')}}">collaborators</a></li>
                        </ul>
                        <h5><i class="glyphicon glyphicon-user"></i>
                            <small><b>Manage Skills</b></small>
                        </h5>
                        <ul class="nav nav-pills nav-stacked">
                            <li class={{ \Request::is('skillcategories') ? 'active' : '' }}><a href="{{url('/skillcategories')}}">List Skill Category</a></li>
                            <li class={{ \Request::is('skills') ? 'active' : '' }}><a href="{{url('/skills')}}">List Skills</a></li>
                        </ul>
                        <h5><i class="glyphicon glyphicon-user"></i>
                            <small><b>Manage Badges</b></small>
                        </h5>
                        <ul class="nav nav-pills nav-stacked">
                            <li class={{ \Request::is('badges') ? 'active' : '' }}><a href="{{url('/badges')}}">List Badges</a></li>
                            <li><a href="#">Manage Conditions</a></li>
                        </ul>
                         <h5><i class="glyphicon glyphicon-user"></i>
                            <small><b>Manage Database</b></small>
                        </h5>
                        <ul class="nav nav-pills nav-stacked">
                          <li class={{ \Request::is('db-clean') ? 'active' : '' }}><a href="{{url('/admin/db-clean')}}">Clean Database</a></li>
                        </ul>
                        <h5><i class="glyphicon glyphicon-user"></i>
                            <small><b>Manage Plans</b></small>
                        </h5>
                        <ul class="nav nav-pills nav-stacked">
                          <li class={{ \Request::is('plans') ? 'active' : '' }}><a href="{{url('/admin/plans')}}">Plans</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-md-8">
                    <!-- Content Here -->
                    @yield('content')
                </div>
            </div>
        </div>
    </main>
    <!-- Footer Section Start -->
     <!-- Footer -->
 <footer class="ux-footer"  id="">
    <div class="container ft-widgets">
        <div class="row block">

            <div class="col-md-4 col-sm-4 col-xs-12">

                <div class="ux-widget">
                    <img src="{{ asset('assets/images/') }}/eduplay_logo.png" width="200" />
                    <span>@lang('messages.HomeFooterMsg')</span>

                    <div class="copyright-text">@lang('messages.copyright') <a title="Privacy Policy" href="privacy">&nbsp;
                            @lang('messages.privacypolicy')</a>
                    </div>

                </div>
            </div>
            <div class="footer-bottom-right">
                <div class="col-lg-2 col-sm-2 col-xs-12  footer-tab-about">
                    <div class="ux-widget">

                        <h5 class="widget-title-tab">@lang('messages.aboutus')</h5>
                        <ul class="list-unstyled padding-bottom-25">
                            <li><a href="/who_we_are">@lang('messages.who_we_are')</a></li>
                            <li><a href="/what_we_do">@lang('messages.what_we_do')</a></li>
                            <li><a href="#">@lang('messages.team')</a></li>
                            <li><a href="#">@lang('messages.careers')</a></li>
                            <li><a href="contact_us">@lang('messages.contact_us')</a></li>

                        </ul>

                    </div>
                </div>
                <div class="col-lg-2 col-sm-2 col-xs-12 footer-tab-work">
                    <div class="ux-widget">

                        <h5 class="widget-title-tab">@lang('messages.how_it_works')</h5>
                        <ul class="list-unstyled padding-bottom-25">
                            <li><a href=/"teachers_information">@lang('messages.teachers')</a></li>
                            <li><a href="/students_information">@lang('messages.learners')</a></li>
                            <li><a href="/parents_information">@lang('messages.parents')</a></li>
                        </ul>

                    </div>
                </div>

                <div class="col-lg-2 col-sm-2 col-xs-12 footer-tab-work">
                    <div class="ux-widget">

                        <h5 class="widget-title-tab">@lang('messages.help_support')</h5>
                        <ul class="list-unstyled padding-bottom-25">
                            <li><a title="FAQ" href="https://eduplaycloud.freshdesk.com/solution/folders/33000194687" target="_blank">@lang('messages.faq')</a></li>
                            <li><a title="Forum" href="https://eduplaycloud.freshdesk.com/discussions/33000063455" target="_blank">@lang('messages.forum')</a></li>
                            <li><a title="Blog" href="#">@lang('messages.blog')</a></li>
                        </ul>

                    </div>
                </div>
                <div class="col-lg-2 col-sm-2 col-xs-12 footer-last-left">
                    <div class="ux-widget">

                        <h5 class="widget-title-tab">@lang('messages.reach_us')</h5>
                        <div class="social-icons text-left">
                            <ul>
                                <li><a title="Facebook"  href="javascript:void(0);" class="facebook"><i class="fa fa-facebook" style="color:#FFF;"></i></a></li>
                                <li><a title="Twitter" href="http://www.twitter.com/share?url=" class="twitter"><i class="fa fa-twitter" aria-hidden="true"></i></a></li>
                                <!--li><a title="Instagram" href="javascript:void(0);" class="pinterest"><i class="fa fa-instagram" aria-hidden="true"></i></a></li-->
                                <li><a title="YouTube" href="javascript:void(0);" class="youtube"><i class="fa fa-youtube"></i></a></li>

                                <li><a title="Linked In" href="#" class="google-plus"><i class="fa fa-linkedin"></i></a></li>
                            </ul>

                        </div>
                        <div class="contact_mail_footer" style="clear:both;"><i class="fa fa-phone" style="color:#fff;" aria-hidden="true"></i><span>70-360-518</span></div>
                        <div class="contact_mail_footer mailicon"><i class="fa fa-envelope" style="color:#fff;" aria-hidden="true"></i><span><a href="mailto:info@eduplaycloud.com">info@eduplaycloud.com</a></span></div>
                    </div>
                </div>
            </div>
        </div>
</div>

</footer>
    <!--/Footer -->
    <!-- //Footer Section End -->
    <!--global js starts-->
    <script type="text/javascript" src="{{ asset('assets/js/jquery-1.9.1.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/js/bootstrap.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/js/jquery.meanmenu.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/js/main.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/js/jquery-sortable.js') }}"></script>
    <!--global js end-->
    <!-- begin page level js -->
    @yield('footer_scripts')
    @yield('footer_scripts2')
    <!-- end page level js -->
</body>

</html>
