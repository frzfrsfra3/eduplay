<footer class="footer">
    <div class="container">
        <div class="top_footer">
            <div class="row justify-content-md-center">
                <div class="col-md-3">
                    <div class="logo_scn">
                        <a href="#"><img src="{{asset('/assets/eduplaycloud/image/logo.svg')}}" alt="" class="footr_lg"></a>
                        <p class="simpl_txt">@lang('messages.HomeFooterMsg')</p>
                        <p class="copyrgt">@lang('messages.copyright')</p>
                        <a class="privcy_lnk" href="{{ route('privacy-policy') }}">@lang('messages.privacypolicy')</a>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="ftr_list_titl">
                        <h5 class="title_of_ftr">@lang('messages.aboutus')</h5>
                        <ul class="footer_links">
                            <li><a href="{{route('exercisesets.exerciseset.private')}}">@lang('messages.Home')</a></li>
                            <li><a href="{{ route('who-we-are') }}">@lang('messages.who_we_are')</a></li>
                            {{-- <li><a href="{{ route('what-we-do') }}">@lang('messages.what_we_do')</a></li> --}}
                            {{-- <li><a href="{{ route('careers') }}">@lang('messages.careers')</a></li> --}}
                            <li><a href="{{ route('contact-us') }}">@lang('messages.contact_us')</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="ftr_list_titl">
                        <h5 class="title_of_ftr">@lang('messages.how_it_works')</h5>
                        <ul class="footer_links_prvcy">
                            <li><a href="{{url('/parents')}}">@lang('messages.parents')</a></li>
                            <li><a href="{{url('/students')}}">@lang('messages.learners')</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="ftr_list_titl">
                        <h5 class="title_of_ftr">@lang('messages.help_support')</h5>
                        <ul class="footer_links_prvcy">
                            @if(session('local') == null || session('local') == 'en')
                                @php $urllang = 'en'; @endphp
                            @else
                                @php $urllang = 'ar'; @endphp
                            @endif
                            <li><a target="_blank" href="https://eduplaycloud.freshdesk.com/{{ $urllang }}/support/home">@lang('messages.faq')</a></li>
                            {{-- <li><a target="_blank" href="https://eduplaycloud.freshdesk.com/{{ $urllang }}/support/discussions">@lang('messages.forum')</a></li> --}}
                            {{-- <li><a target="_blank" href="{{ ($lang == 'en') ? 'https://eduplaycloud-en.blogspot.com/' : 'https://eduplaycloud-ar.blogspot.com/' }}">@lang('messages.blog')</a></li> --}}
                        </ul>
                    </div>
                </div>
                <div class="col-md-3">
                    <h5 class="title_of_ftr">@lang('messages.reach_us')</h5>
                    <ul class="share_links">
                        <li><a target="_blank" href="https://www.facebook.com/eduplaycloud" class="fb_i"></a></li>
                        <li><a target="_blank" href="https://twitter.com/EduPlayCloud" class="twtr_i"></a></li>
                        <li><a target="_blank" href="https://www.pinterest.com/eduplaycloud/" class="pntrst_i"></a></li>
                        <li><a target="_blank" href="https://www.youtube.com/channel/UC2rss8MWdalazlE9p-M8-fA" class="insgm_i"></a></li>
                    </ul>
                    <ul class="ph_mail_link">
                        <li><a href="javascript:;" class="ph_link">+961 81 864 912</a></li>
                        <li><a href="javascript:;" class="mail_link">info@eduplaycloud.com</a></li>
                    </ul>
                </div>
            </div>
        </div>
       {{-- <div class="bottom_footer">
            <p>@lang('messages.copyright')</p>
        </div>--}}
    </div>
</footer>