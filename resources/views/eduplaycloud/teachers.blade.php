@extends('guest.layouts.default')
@section('content')
<section class="strmng_edctn" id="strmng_edctn">
    <div class="container">
        <div class="row">
            <div class="col-md-7">
                <img class="d-block w-100" src="{{ asset('assets/eduplaycloud/image/teacher_img.png') }}" alt="">
            </div>
            <div class="col-md-5">
                <div class="eductn_strming text-ar-right">
                    <h4>@lang('for_teachers.for_all_teachers')</h4>
                    <h3>@lang('for_teachers.out_there')</h3>
                    <h5>@lang('for_teachers.would_you_like_to')</h5>
                    <ul class="bnr_list">
                        @lang('for_teachers.learn_how_technology')
                    </ul>
                    <a class="getstrd_btn" href="javascript:;" data-toggle="modal" data-target="#sign_up">@lang('for_teachers.sign_up')</a>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="for_did_you_know own_exercises sec_with_mrgn bld_tlt">
    <div class="container">
        <div class="row justify-content-end">
            <div class="col-md-11">
                <div class="row">
                    <div class="col-md-7 text-ar-right">
                        <h3 class="black_title">@lang('for_teachers.how_can_technology_help')</h3>
                        @lang('for_teachers.how_can_technology_help_content')
                        <ul>
                            @lang('for_teachers.how_can_technology_help_li')
                        </ul>
                        <p class="def_p">@lang('for_teachers.eduplaycloud_will_help')</p>
                        <ul>
                            @lang('for_teachers.eduplaycloud_will_help_li')
                        </ul>
                        <button class="btn btn-login" href="javascript:;" data-toggle="modal" data-target="#sign_up">@lang('for_teachers.sign_up')</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@include('subscription.pricing');

<section class="practice_exercises">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10 text-ar-right">
                <h3 class="blue_title">@lang('for_teachers.check_your_peers_works')</h3>
                <p class="def_p">@lang('for_teachers.check_your_peers_works_content')</p>
                <div class="row">
                    @foreach ($exercisesets as $exerciseset)
                    <div class="col-md-6 col-lg-6 col-xl-4 cusmize-col">
                        <div class="main_info">
                            <a href="javascript:;" class="info_exercise" style="cursor: default;">
                                <img src="{{ asset('assets/eduplaycloud/image/exers_prfl.png')}}" class="img-fluid">
                                <div class="whit_checbx">
                                    <div class="profile_name">
                                        @php
                                        if (isset(optional($exerciseset->owner)->user_image) && !empty(optional($exerciseset->owner)->user_image)) {
                                            if (strlen(optional($exerciseset->owner)->user_image) > 0 && File::exists(public_path()."/uploads/profile/".optional($exerciseset->owner)->user_image)) {
                                                $ownerImage = optional($exerciseset->owner)->user_image;
                                            } else {
                                                $ownerImage = 'proflie_welcome.png';
                                            }
                                        } else {
                                            $ownerImage = 'proflie_welcome.png';
                                        }
                                        @endphp
                                        <img src="{{ asset('uploads/profile') }}/{{ $ownerImage }}">
                                        <p>{{ optional($exerciseset->owner)->name }}</p>
                                    </div>
                                </div>
                                <div class="left_time_info">
                                    <ul class="time_info float-left">
                                        <li>
                                            @if ($exerciseset->price !=0)
                                                ${{$exerciseset->price}} @lang('for_teachers.buy')
                                            @else
                                                @lang('for_teachers.free')
                                            @endif
                                        </li>
                                        <li class="time_icn">{{ gmdate("H:i:s",$exerciseset->question->sum('maxtime')) }}</li>
                                    </ul>
                                    <ul class="skill_info float-right">
                                        <li>@lang('for_teachers.skills') {{ ($exerciseset->question->where('skill_id','!=',null)->groupby('skill_id')->count('skill_id')) }}</li>
                                        <li>@lang('for_teachers.questions') {{ $exerciseset->question->count() }} </li>
                                    </ul>
                                </div>
                            </a>
                            <ul class="creat_exr title_cmbo">
                                <li><a href="javascript:;" style="cursor: default;">{{ str_limit($exerciseset->title,'30') }}</a></li>
                                @if($exerciseset->discipline)
                                    <li><p>{{  str_limit(@$exerciseset->discipline->discipline_name, '50') }}</p></li>
                                @endif
                            </ul>
                            <ul class="star_wth_user text-ar-right">
                                <li>
                                    <div class="gray_star">
                                        <div class="orng_star" style="width: 80%;"></div>
                                    </div>
                                    <span class="rtng">{{ $exerciseset->averageRating(1)[0] }}</span>
                                </li>
                                @if($exerciseset->grade)
                                    <li title="{{ $exerciseset->grade->grade_name }}"><span>{{ str_limit(@$exerciseset->grade->grade_name, '18')}}</span></li>
                                @endif
                            </ul>
                                <div class="rew_prfl_sectin text-ar-right">
                                    @php $reviewCount = 1; @endphp
                                    @foreach ($exerciseset->ratings_data as $rate)
                                        @if($reviewCount < 3)
                                        <div class="prfl_img">
                                            @php
                                            if (isset($rate->user_image) && !empty($rate->user_image)) {
                                                if (strlen($rate->user_image) > 0 && File::exists(public_path()."/uploads/profile/".$rate->user_image)) {
                                                    $userImage = $rate->user_image;
                                                } else {
                                                    $userImage = 'proflie_welcome.png';
                                                }
                                            } else {
                                                $userImage = 'proflie_welcome.png';
                                            }
                                            @endphp
                                            <img src="{{ asset('assets/eduplaycloud/image/prfl_rtng.png')}}">
                                        </div>
                                        <div class="rate_date">
                                            <div class="title_star">
                                                <h6>{{ $rate->user_name }}</h6>
                                                <div class="gray_star">
                                                    <div class="orng_star" style="width: 60%;"></div>
                                                </div>
                                            </div>
                                            <div class="date_frmt">
                                                <span>{{\Carbon\Carbon::parse($rate->created_at)->format('F j \\, Y') }}</span>
                                            </div>
                                        </div>
                                        <p>{{$rate->body}}</p>
                                        @endif
                                        @php $reviewCount++; @endphp
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>
<section class="for_did_you_know own_exercises rmv_img pad_0_imp">
    <div class="container">
        <div class="row justify-content-end">
            <div class="col-md-11">
                <div class="row">
                    <div class="col-md-7 text-ar-right">
                        <h3 class="black_title">@lang('for_teachers.create_your_own_exercise_set')</h3>
                        <p class="def_p">
                            @lang('for_teachers.create_your_own_exercise_set_content')
                        </p>
                        <button class="btn btn-login" href="javascript:;" data-toggle="modal" data-target="#sign_up">@lang('for_teachers.create')</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection