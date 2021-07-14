@extends('guest.layouts.default')
@section('content')
<section class="strmng_edctn" id="strmng_edctn">
    <div class="container">
        <div class="row">
            <div class="col-md-7">
                <img class="d-block w-100" src="{{ asset('assets/eduplaycloud/image/students_img.png')}}" alt="">
            </div>
            <div class="col-md-5">
                <div class="eductn_strming text-ar-right">
                    <h4>@lang('for_students.for_every_students')</h4>
                    <h3>@lang('for_students.out_there')</h3>
                    <h5>@lang('for_students.do_you_want_to')</h5>
                    <ul class="bnr_list">
                        @lang('for_students.do_you_want_to_li')
                    </ul>
                    @guest
                    <a href="javascript:;" data-toggle="modal" data-target="#sign_up" class="getstrd_btn">@lang('for_students.sign_up')</a>
                    @endguest
                </div>
            </div>
        </div>
    </div>
</section>
<section class="practice_exercises bg_white">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xl-10 text-ar-right">
                <h3 class="blue_title">@lang('for_students.practice_a_discipline')</h3>
                <p class="def_p">@lang('for_students.practice_a_discipline_content')</p>
                <div class="row">
                    @foreach ($topicsSimple as $topic)
                    <div class="col-sm-6 col-lg-3">
                        <div class="discipline_bx">
                            <a href="javascript:;" class="dcpln_a">
                                @if (strlen($topic->iconurl) == 0)
                                    <img src="{{ asset('assets/eduplaycloud/image/pctc_1.png') }}" alt="">
                                    @else
                                    <img src={{ asset('assets/images/'.$topic->iconurl) }} alt="">
                                @endif
                                <h5>{{ $topic->topic_name }}</h5>
                                <ul class="bl_or_txt">
                                    <li>@lang('for_students.curriculum') {{ $topic->discipilnes->count() }}</li>
                                    <li class="orng_li">@lang('for_students.exercise_set') {{ $topic->countofexercisesets() }}</li>
                                </ul>
                            </a>
                            <button class="stngs_btn hvr-push m2"></button>
                            <button class="strs_btn hvr-push m2"></button>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>

@include('subscription.pricing');

<section class="for_did_you_know class_section">
    <div class="container">
        <div class="row justify-content-end">
            <div class="col-md-11">
                <div class="row">
                    <div class="col-md-9 col-lg-7 text-ar-right">
                        <h3 class="black_title">@lang('for_students.find_a_class')</h3>
                        <div class="row">
                            @foreach ($classes as $class)
                            <div class="col-md-6 col-lg-6 col-xl-6 cusmize-col">
                                <div class="main_info">
                                    <a href="javascript:;" class="info_exercise">
                                        <img src="{{ asset('assets/eduplaycloud/image/class_emt_img.png') }}" class="img-fluid">
                                        <div class="whit_checbx">
                                            <div class="profile_name">
                                                @php
                                                if (isset($child->user_image) && !empty($child->user_image)) {
                                                    if (strlen($child->user_image) > 0 && File::exists(public_path()."/uploads/profile/".$child->user_image)) {
                                                        $childImage = $child->user_image;
                                                    } else {
                                                        $childImage = 'proflie_welcome.png';
                                                    }
                                                } else {
                                                    $childImage = 'proflie_welcome.png';
                                                }
                                                @endphp
                                                <img src="{{ asset('uploads/profile') }}/{{ $childImage }}">
                                                <p>{{ $class->teacher->name }}</p>
                                            </div>
                                        </div>
                                        <div class="right_gnrl_info">
                                            <ul class="gnrl_info float-right">
                                                <li class="check_lst_i">{{ count($class->getLearnerExam) }}</li>
                                                <li class="list_i">{{ count($class->exercises)}}</li>
                                                <li class="user_i_i">{{ count($class->getLearner)}}</li>
                                            </ul>
                                        </div>
                                    </a>
                                    <ul class="title_cmbo text-ar-right">
                                        <li><a href="javascript:;">{{$class->class_name}}</a></li>
                                        @if($class->discipline)
                                            <li><p>{{ optional($class->discipline)->discipline_name }}</p></li>
                                        @else
                                            <li><span>@lang('filter.n/a')</span></li>
                                        @endif
                                    </ul>
                                    <ul class="star_wth_user text-ar-right">
                                        <li>
                                            <div class="gray_star">
                                                <div class="orng_star" style="width: {{(@$class->averageRating(1)[0]) * 100 / 5}}%;"></div>
                                            </div>
                                            <span class="rtng">{{@$class->averageRating(1)[0]}}</span>
                                        </li>
                                        @if($class->grade)
                                            <li title="{{ optional($class->grade)->grade_name}}"><span>{{ str_limit(optional($class->grade)->grade_name , '18') }}</span></li>
                                        @else 
                                            <li><span>@lang('filter.n/a')</span></li>
                                        @endif
                                        <li><small>{{ $class->created_at }}</small></li>
                                    </ul>
                            </div>
                        </div>
                            @endforeach
                            <div class="col-md-12">
                                <button class="btn btn-login" href="javascript:;" data-toggle="modal" data-target="#sign_up">@lang('for_students.sign_up')</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection