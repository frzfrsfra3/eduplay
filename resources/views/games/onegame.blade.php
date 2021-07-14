@extends('authenticated.layouts.default')
@section('header_styles')
<link href="{{asset('assets/eduplaycloud/customs/js/raty-master/lib/jquery.raty.css')}}" />
@stop
@section('content')
<!---Content-->
<div class="work_page mrgn_top_secn mrgn-bt-60 exercesi_block text-ar-right">
        <div class="container">
        <div class="row justify-content-center">
            <div class="col-xl-11">
                <div class="mrgn-tp-30 text-ar-right">
                    <nav aria-label="tp-breadcm" class="tp-breadcm">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="#">@lang('games.games')</a></li>
                        <li class="breadcrumb-item active" aria-current="page">{{ $gamedetails->game['game_name'] }}</li>
                        </ol>
                    </nav>
                    <div class="clearfix"></div>
                    <div class="main_summery_earth">
                    <div class="earth_publish mrgn-tp-30 mrgn-bt-10">
                        <div class="name_list float-left float-left-as">
                            <h4>{{ $gamedetails->game['game_name'] }}</h4>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                    <div class="row">
                        <div class="col-lg-12 mrgn-bt-25">
                            <div class="gm_dtls_tp_info">
                            <img src="{{ asset('assets/eduplaycloud/image/game_8.png') }}" alt="" class="gm_img">
                                <h4>{{ $gamedetails->game['game_name'] }}</h4>
                                <ul class="gm_dt_list">
                                    <li><span class="t_text">{{ $gamedetails->game->developer['name']}}</span></li>
                                <li>{{ $gamedetails->game['patform'] }}</li>
                                </ul>
                                <ul class="gm_dt_list mrgn-bt-30">
                                    <li>
                                        <ul class="star_wth_user medium_star_user">
                                            <li>
                                                <div class="gray_star">
                                                    <div class="orng_star" style="width: {{(@$game->averageRating(1)[0]) * 100 / 5}}%;"></div>
                                                </div>
                                                <span class="rtng">{{@$game->averageRating(1)[0]}}</span>
                                            </li>
                                        </ul>
                                    </li>
                                    <li>{{ $downloadCount }} @lang('games.downloads')</li>
                                    <li>{{ $gamedetails->game['minimum_age'] }} @lang('games.years')</li>
                                </ul>
                                <ul class="gm_dt_list">
                                    @if($gamedetails->platform == 'IOS') 
                                        @php
                                            $downloadUrl = $gamedetails->ios_link;
                                            $alsoAvailableName = 'Android';
                                            $alsoAvailableURL = $gamedetails->android_link;
                                        @endphp
                                    @else 
                                        @php
                                            $downloadUrl = $gamedetails->android_link;
                                            $alsoAvailableName = 'IOS';
                                            $alsoAvailableURL = $gamedetails->ios_link;
                                        @endphp
                                    @endif
                                <li><a href="{{ $downloadUrl }}" target="_blank()" class="add_btn add_privt_lbr_btn">@lang('games.download')</a></li>
                                    <li>@lang('games.also_available_on') : 
                                    <a href="{{ $alsoAvailableURL }}" target="_blank()">{{ $alsoAvailableName }}</a>
                                    </li>
                                </ul>
                            </div>
    
                        </div>
                    </div>
                        <div class="row mrgn-bt-60">
                        <div class="col-sm-6 col-md-3 rsp_mrgn_30"><img src="{{ asset('assets/eduplaycloud/image/gray_img.png') }}" alt="" class="img-fluid"></div>
                            <div class="col-sm-6 col-md-3"><img src="image/gray_img.png" alt="" class="img-fluid"></div>
                            <div class="col-sm-6 col-md-3"><img src="image/gray_img.png" alt="" class="img-fluid"></div>
                            <div class="col-sm-6 col-md-3"><img src="image/gray_img.png" alt="" class="img-fluid"></div>
                        </div>
                        <div class="row">
                            
                            
                            <div class="col-md-12">
                                <div class="review_section2">
                                  <div class="row">
                                      <div class="col-xl-10">
                                          <div class="inner_review_section">
                                              <h3>@lang('games.reviews_ratings')</h3>
                                              <div class="row">
                                                    <div class="col-lg-5 col-xl-4">
                                                            <ul class="star_wth_user big_star_user">
                                                                <li>
                                                                    <div class="gray_star">
                                                                        <div class="orng_star" style="width: {{(@$game->averageRating(1)[0]) * 100 / 5}}%;"></div>
                                                                    </div>
                                                                    <span class="rtng">{{@$game->averageRating(1)[0]}}</span>
                                                                </li>
                                                            </ul>
                                                            <div class="rating_graph mrgn-tp-20">
                                                                <div class="row_rating">
                                                                    @for($i = 5; $i >= 1; $i--)
                                                                        <div class="rtng_bbx">
                                                                        <div class="side">
                                                                            <div>{{$i}}</div>
                                                                        </div>
                                                                        <div class="middle">
                                                                            <div class="bar-container">
                                                                                @php $total = 0; 
                                                                                    foreach($userrate as $ratekey => $item) {
                                                                                        if($item->rate == $i)
                                                                                            $total += 1;
                                                                                    }
                                                                                    $avg = 0;
                                                                                    if(count($userrate))
                                                                                        $avg = (@$total) * 100 / count(@$userrate)
                                                                                @endphp
                                                                                <div class="bar-{{$i}}" style="width: {{$avg}}%;"></div>
                                                                            </div>
                                                                            <small class="pull-right" style="color:blue;">{{$total}}</small>
                                                                        </div>                                                                   
                                                                        </div>
                                                                    @endfor
                                                                </div>
                                                            </div>
                                                        </div>
                                                  <div class="col-lg-7 col-xl-8">
                                                      <div class="rating_view_detail">
                                                            @foreach($userrate as $ratekey => $item)
                                                            {{-- <div class="rew_prfl_sectin after_{{$ratekey}}"> --}}
                                                            <div class="rew_prfl_sectin after_">    
                                                                <div class="prfl_img">
                                                                    
                                                                    @if($item->user_image)
                                                                    <img src="{{asset('assets/images/profiles')}}/{{  $item->user_image }}">
                                                                    @else
                                                                    <img src="{{asset('assets/images/profiles/userdefaultimg.png')}}">
                                                                    @endif
                                                                </div>
                                                                <div class="rate_date">
                                                                    <div class="title_star">
                                                                        <h6>{{@$item->user_name}}</h6>
                                                                        <div class="gray_star">
                                                                            <div class="orng_star" style="width: {{(@$item->rate) * 100 / 5}}%;"></div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="date_frmt">
                                                                        <span>{{@\Carbon\Carbon::parse($item->created_at)->format('M d, Y')}}</span>
                                                                    </div>
                                                                </div>
                                                                <p>{{@$item->body}}</p>
                                                            </div>
                                                        @endforeach
                                                         
                                                          
                                                          
                                                          {{-- <div class="rew_prfl_sectin view_more">
                                                                <a href="javascript:;" id="view_more_link" class="view_more_btn">@lang('exerciseset_show.view_more')</a>
                                                                <a href="javascript:;" id="view_less_link" class="view_more_btn" style="display:none;">@lang('exerciseset_show.view_less')</a>
                                                            </div> --}}
                                                          
                                                  </div>
                                              </div>
                                          </div>
                                      </div>
                                  </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </div>
    </div>
@endsection

<?php /*Load jquery to footer section*/ ?>
@push('inc_script')
<script src="{{asset('assets/eduplaycloud/customs/js/raty-master/lib/jquery.raty.js')}}"></script>
@endpush

<?php /*Load jquery to footer section*/ ?>
@push('inc_jquery')
<script>

    var numItems = 0;
    $(document).ready(function()
    {
        $('body li #homeMenu').removeClass('active');
        numItems = $('.rew_prfl_sectin').nextUntil('.view_more').length;

        if(numItems >= 4) {
            $('div.after_1').nextUntil('.view_more').hide();
        }
        else {
            $('#view_more_link').hide();
        }
    });

    $('#view_more_link').click(function()
    {
        if(numItems >= 4)
        {
            $('div.after_1').nextAll().show();
            $(this).hide();
            $('#view_less_link').show();
        }
    });

    $('#view_less_link').click(function()
    {
        if(numItems >= 4)
        {
            $('div.after_1').nextUntil('.view_more').hide();
            $(this).hide();
            $('#view_more_link').show();
        }
    });

    $('#give_rate').raty({
        starOff: "{{asset('assets/eduplaycloud/customs/js/raty-master/lib/images/star-off.png')}}",
        starOn: "{{asset('assets/eduplaycloud/customs/js/raty-master/lib/images/star-on.png')}}",
        hints: ['bad', 'poor', 'regular', 'good', 'gorgeous'],
    });


    $("#submit_review").click( function()
    {
        $.ajax({
            url: "{{route('games.game.addreview')}}",
            type: "post",
            dataType: 'json',
            data: $('#review_form').serialize(),
            success: function(response){ // What to do if we succeed
                if(response == 'success')
                    location.reload();
            },
            error: function(response){
                console.log('Error'+response);
            }
        });
    });

    $('#clear_review').click(function()
    {
        $('#comment').val('');
        $('#give_rate').raty('reload'); 
    });
</script>
@endpush