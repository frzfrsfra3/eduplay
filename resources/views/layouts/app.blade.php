
<html class="no-js" lang="">
<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

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
    <link href="{{ asset('assets/css/fonts.css') }}" rel="stylesheet">

    <!-- Favicon
    ============================================ -->
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('assets/images') }}/favicon.ico">
    <!-- Bootstrap CSS
    ============================================ -->
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
    <!-- font-awesome CSS
    ============================================ -->
    <link rel="stylesheet" href="{{ asset('assets/css/font-awesome.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/glyphicon.css') }}">
    <!-- meanmenu CSS
    ============================================ -->
    <link rel="stylesheet" href="{{ asset('assets/css/meanmenu.min.css') }}">
    <!-- style CSS
    ============================================ -->
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    <!-- responsive CSS
    ============================================ -->
    <link rel="stylesheet" href="{{ asset('assets/css/responsive.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/common.css') }}">

    <!-- Fancybox CSS
           ============================================ -->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/jquery.fancybox.min.css') }}">
<style>
    .fancybox-iframe{min-height: 600px}
    .fancybox-content{min-height: 600px}
</style>
<!--page level css-->
@yield('header_styles')
<!--end of page level css-->
</head>

<body class="home-2" id="main">
<!-- Header Start -->
<!-- header start -->
<header>
    <div class="header-area">
        <div class="container">
            <div class="row ">
                <!-- logo -->
                <div class="col-md-2 col-lg-3">
                    <div class="logo">
                        <a href="{{route('welcome')}}"><img src="{{ asset('assets/images/') }}/eduplay_logo.png" alt="" /></a>
                    </div>
                </div>
                <!-- mainmenu start -->
                <div class="col-md-10 col-lg-9">
                    <ul>
                        <li class="FLR">
                            <div class="mainmenu" style="padding-top:20px;margin-right: 15px">
                                <nav>
                                    <ul id="nav">
                                        <li><a href="{{route('home')}}#">@lang('messages.Home')</a></li>
                                        <!-- Explore Link -->
                                        @auth()
                                        <li><a href="{{route('topics.topic.index')}}">@lang('messages.Explore')</a></li>
                                        @endauth
                                        @guest()
                                            <li><a href="{{route('topics.topic.index')}}">@lang('messages.Explore')</a></li>
                                        @endguest

                                        <!-- Authentication Links -->
                                        @guest
                                        <li style="padding-right:10px;"><a href="{{ route('login') }}?popup=y" data-fancybox data-type="iframe">@lang('messages.Login')</a></li>
                                     <li style="padding-right:10px;"><a href="{{ route('signup') }}?popup=y"  data-fancybox-2 data-type="iframe"  class="btn-primary">@lang('messages.Signup')</a></li>
                                            {{--<li style="padding-right:10px;"><a href="{{ route('register') }}"  class="btn-primary">@lang('messages.Signup')</a></li>--}}
                                        @else
                                            <!-- Authenticated Menu "Private Library", Profile, Logout -->
                                            <li><a href="{{route('exercisesets.exerciseset.private')}}">@lang('messages.Private')</a></li>
                                                <li><a href="{{route ('users.user.profile',Auth::user()->id)}}" ><img src="{{ Avatar::create(Auth::user()->name)->toBase64() }}" /></a></li>
                                                <li style="padding-right:10px;"><a href="{{ route('logout')}}" onclick="event.preventDefault();
                                                    document.getElementById('logout-form').submit();">Logout
                                                </a>

                                                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                                    @csrf
                                                </form>
                                            </li>
                                        @endguest
                                        <!-- Languages selection -->
                                        <li>
                                            <div class="selectWrapper">
                                                @if(Session::has('local'))
                                                    @php($lang=session('local'))
                                                @else
                                                    @php($lang='en')
                                                @endif
                                                <select class="selectBox" id="langselector" onchange=""   selected="{{$lang}}" >
                                                    <option value="{{route ('language.switch',"en")}}" @if($lang=='en')selected @endif>@lang('messages.English')</option>
                                                    <option value="{{route ('language.switch',"fr")}}"  @if($lang=='fr')selected @endif >@lang('messages.French')</option>
                                                    <option value="{{route ('language.switch',"ar")}}"  @if($lang=='ar')selected @endif>@lang('messages.Arabic')</option>

                                                </select>
                                            </div>

                                        </li>
                                    </ul>
                                </nav>
                            </div>
                        </li>
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
                                <li><a href="{{route('disciplines.discipline.index')}}">@lang('messages.Explore')</a></li>
                                <li><a href="{{ route('login') }}" data-fancybox data-type="iframe">@lang('messages.Login')</a></li>
                                <li><a href="{{ route('signup') }}"  data-fancybox-2 data-type="iframe"  class="btn-primary">@lang('messages.Signup')</a></li>
                            </ul>
                        </nav>
                    </div>
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

<!-- Content -->
@yield('content')

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
                            <li><a href=/"teachers_information">@lang('messages.taechers')</a></li>
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
                        <div class="contact_mail_footer" style="clear:both;"><i class="fa fa-phone" style="color:#fff;" aria-hidden="true"></i><span>+961 81 864 912</span></div>
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
<script type="text/javascript" src="{{ asset('assets/js/main.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/js/bootstrap.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/js/jquery.meanmenu.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/js/jquery-sortable.js') }}"></script>
<script src="{{ asset('assets/js/jquery.fancybox.min.js') }}"></script>


<script>
    $('[data-fancybox]').fancybox({
        toolbar  : false,
        smallBtn : true,
        iframe : {
            preload : false,
            css : {
                width : '900px',
                height:'580px',

            },

        },
        afterClose: function () {
            @guest

            @else
                parent.location = "/home";
            @endguest
        }
    });
    $('[data-fancybox-2]').fancybox({
        toolbar  : false,
        smallBtn : true,
        iframe : {
            preload : false,
            css : {
                width : '900px',
                height:'600px'
            }
        },
        afterClose: function () {
            @guest

                    @else
                parent.location = "/home";
            @endguest
        }
    });

    function gotoSection(section) {
        window.location.href =  section;
    }
</script>

<script>
    $(function(){
        // bind change event to select
        $('#langselector').on('change', function () {
            var url = $(this).val(); // get selected value
            if (url) { // require a URL

                $.ajax({
                    type: "POST",
                    dataType: "text",
                    url: url,
                    data: {
                        "_token": "{{ csrf_token() }}",
                    },
                    success: function (response) {
                        console.log('lang changed');
                        location.reload();

                    },
                    error: function (err) {
                        console.log("AJAX error in request: " + JSON.stringify(err, null, 2));
                    }
                })




            //    window.location = url; // redirect
            }
            return false;


        });
    });
</script>

<!--global js end-->
<!-- begin page level js -->
@yield('footer_scripts')
<!-- end page level js -->

</body>

</html>
