<header class="header {{ Request::segment(1) === 'privacy-policy' ||  Request::segment(1) === 'faq' ||  Request::segment(1) === 'topics' ||  Request::segment(1) === 'forum' ||  Request::segment(1) === 'contact-us' ||  Request::segment(1) === 'careers' || Request::segment(2) === 'parentapproval' || Request::segment(1) === 'terms' ||  Request::segment(1) === 'arrprovedAccount' ? 'login_header' : null }}">
    <div class="container">
        <div class="row">
            <div class="col-4 text-ar-right"><a class="navbar-brand" href="{{route('exercisesets.exerciseset.private')}}"><img src="{{ asset('assets/eduplaycloud/image/logo.svg') }}" alt="" class="logo"></a></div>
            <div class="col-8 text-right text-ar-left">
                <ul class="header_nave">
                    <li class="mrgn_rtlf">
                        <nav class="navbar navbar-expand-lg" id="mainNav">
                            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                                <span class="navbar-toggler-icon"></span>
                            </button>
                            <div class="collapse navbar-collapse nv_light collps_menu" id="navbarSupportedContent">
                                <ul class="navbar-nav mr-auto">
                                    <li class="nav-item {{ Request::segment(1) === 'home' ? 'active' : null }}"><a class="nav-link js-scroll-trigger" href="{{route('exercisesets.exerciseset.private')}}">@lang('messages.Home')</a></li>
                                    {{-- <li class="nav-item {{ Auth::user() ? "" : "m2" }} {{ Request::segment(1) === 'topics' ? 'active' : null }}"><a class="nav-link p" href="{{route('topics.topic.index')}}">@lang('messages.Explore')</a></li> --}}
                                    <li id="exploreMenu" class="nav-item {{ Request::segment(1) === 'topics' || Request::segment(1) === 'explore' || Request::segment(1) ==='exercisesets' && Request::segment(2) ==='summary' && str_replace(url('/'), '', url()->previous()) != '/exercisesets/private' || str_replace(url('/'), '', url()->current()) == '/explore/classes' ? 'active' : null }}">
                                         <a class="nav-link p" href="{{ route('explore.exerciseset') }}" >@lang('messages.Explore')</a>
                                    </li>
                                </ul>
                            </div>
                        </nav>
                    </li>
                    <!-- Authentication Links -->
                    @guest
                    <li class="combo_lgnsp mrgn_rtlf"><a class="lgn_link brdr_rht" href="javascript:void(0)" data-toggle="modal" data-target="#login_btn">@lang('messages.Login')</a><a class="lgn_link" href="javascript:void(0)" data-toggle="modal" data-target="#sign_up">@lang('messages.Signup')</a></li>
                    @else
                    <li class="combo_lgnsp mrgn_rtlf">
                        <div class="dropdown user_dropdown">
                            <a id="user_dropdown" href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" role="button" aria-expanded="false">
                                @php
                                    $user=Auth::user();
                                @endphp
                                @if(strtolower($user->provider) == 'facebook' || strtolower($user->provider) == 'google')
                                    <img src="{{ $user->user_image }}" alt="{{ $user->name }}">
                                @elseif(isset($user->user_image) && !empty($user->user_image))
                                    @if (strlen($user->user_image) > 0 && File::exists(public_path()."/assets/images/profiles/".$user->user_image))
                                        <img src="{{ asset('assets/images/profiles') }}/{{  $user->user_image }}" alt="{{ $user->name }}">
                                    @else
                                        <img src="{{ asset('uploads/profile') }}/profile_img.jpg" alt="{{ $user->name }}">
                                    @endif
                                @else
                                    <img src="{{ asset('uploads/profile') }}/profile_img.jpg" alt="{{ $user->name }}">
                                @endif
                                {{-- <img src="{{ asset('assets/eduplaycloud/image/profile_img.jpg') }}" alt=""> --}}
                            </a>
                            <ul class="dropdown-menu" role="menu" aria-labelledby="user_dropdown">
                                <li>
                                    <a href="{{route ('users.user.profile',Auth::user()->id)}}">
                                        <i class="prfl_i"></i>@lang('auth.my_profile')
                                    </a>
                                </li>
                                {{-- <li>
                                    <a href="javascript:;">
                                        <i class="stng_i"></i>@lang('auth.settings')
                                    </a>
                                </li> --}}
                                <li>
                                    <a href="{{ route('logout')}}" onclick="event.preventDefault();
                                    document.getElementById('logout-form').submit();">
                                        <i class="lgut_i"></i>@lang('auth.logout')
                                    </a>
                                </li>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                    @csrf
                                </form>
                            </ul>
                        </div>
                    </li>
                    <li class="combo_lgnsp mrgn_rtlf m2">
                        <div class="dropdown user_dropdown ntfctn_dropdown {{ Request::segment(1) == 'parents' || Request::segment(1) == 'students' || Request::segment(1) == 'who-we-are' || Request::segment(1) == 'what-we-do'  ? 'ntfctn_dropdown_wt' : null }}">
                            <a id="ntfctn_dropdown" href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" role="button" aria-expanded="false">
                                <i class="ntfctn_icon"></i>
                            </a>
                            @php
                                $notificationsObj = QueryHelper::userNotifications(6);
                            @endphp
                            <ul class="dropdown-menu" role="menu" aria-labelledby="ntfctn_dropdown">
                            @if(count($notificationsObj['user_notifications']) > 0)
                                @for($n=0; $n < count($notificationsObj['user_notifications']); $n++)
                                <li>
                                    <p>
                                        <i class="not_i_1"></i>
                                        {{ $notificationsObj['user_notifications'][$n]['notificationtpl'] }}
                                    </p>
                                </li>
                                @endfor
                            @else
                            <li><p><center>@lang('auth.no_notifications_found')</center></p></li>
                            @endif
                            </ul>
                        </div>
                    </li>
                    @endguest
                    @if(Session::has('local'))
                        @php($lang = session('local'))
                    @else
                        @php($lang = 'en')
                    @endif
                    <li class="custm_drp dropdown mrgn_rtlf">
                        <div class="df-select">
                        <select class="selectpicker" id="langselector" selected="{{ $lang }}">
                            <option value="{{ route('language.switch', 'en') }}" @if($lang == 'en')selected @endif>@lang('messages.English')</option>
                            <option value="{{ route('language.switch', 'fr') }}" @if($lang == 'fr')selected @endif >@lang('messages.French')</option>
                            <option value="{{ route('language.switch', 'ar') }}" @if($lang == 'ar')selected @endif>@lang('messages.Arabic')</option>
                        </select>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</header>