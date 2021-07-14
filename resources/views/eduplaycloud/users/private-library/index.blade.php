@extends('authenticated.layouts.default')

@section('content')
@include('eduplaycloud.users.welcome-header')
<div class="work_page dashboard_page text-ar-right">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-12">
                <div class="my_private_libray">
                    <div class="tbs_of_report tbs_of_report-as">
                        <div class="dropdown">
                            <button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown">@lang('exercisesets.my_private_library')
                                <span class="caret"></span>
                            </button>
                            @include('eduplaycloud.users.private-library.menu')
                        </div>
                    </div>
                    <div class="clearfix"></div>
                    <div class="tabs_publish mrgn-tp-30">
                        @if(Session::has('success_message'))
                        <div class="alert alert-success">
                            <i class="fa fa-check-square-o" aria-hidden="true"></i>
                            {!! session('success_message') !!}
                            <button type="button" class="close" data-dismiss="alert" aria-label="close">
                                <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        @endif
                        @if(Session::has('error_message'))
                        <div class="alert alert-danger">
                            <i class="fa fa-check-square-o" aria-hidden="true"></i>
                            {!! session('error_message') !!}
                            <button type="button" class="close" data-dismiss="alert" aria-label="close">
                                <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        @endif
                        <div id="custom-jquery-msg">
                        </div>
                        <div class="row">
                            <div class="col-sm-6 col-md-8">
                                <ul class="exe_tbs nav private-lib-pills nav-pills mb-3" id="pills-tab" role="tablist">
                                    @if(!Auth::user()->hasRole('Admin'))
                                    <li class="nav-item">
                                        <a class="nav-link active" id="pills-exersice-tab" data-toggle="pill" href="#pills-exersice" role="tab" aria-controls="pills-exersice" aria-selected="true">@lang('exercisesets.exercise_set')</a>
                                    </li>
                                    <li class="nav-item ">
                                        <a class="nav-link" id="pills-pins-tab" data-toggle="pill" href="#pills-pins" role="tab" aria-controls="pills-pins" aria-selected="false">@lang('exercisesets.pins')</a>
                                    </li>
                                    @endif
                                    {{--  <li class="nav-item m3">
                                        <a class="nav-link" id="pills-study-tab" data-toggle="pill" href="#pills-study" role="tab" aria-controls="pills-study" aria-selected="false">@lang('exercisesets.study_set')</a>
                                    </li>  --}}
                                </ul>
                            </div>
                            
                        </div>
                    </div>
                    <div class="tab-content" id="pills-tabContent">
                        <div class="tab-pane fade show active" id="pills-exersice" role="tabpanel" aria-labelledby="pills-exersice-tab">
                            <div class="row">
                                <div class="col-sm-12 text-sm-right text-sm-ar-left">
                                    @if (Auth::user()->hasRole('Teacher'))
                                        <a href="javascript:;" id="publish_to_gclass_btn" class="publish_class_btn">Publish to Google class</a>
                                        <a href="javascript:;" id="publish_to_class_btn" class="publish_class_btn">@lang('exercisesets.publish_to_class')</a>
                                    @endif
                                </div>
                            </div>
                                
                            <div class="my_exercise mrgn-tp-20">
                                    <div class="main_detail_fltr">
                                        <div class="title_with_shrtby">
                                            <div class="float-sm-left filtr_with_titile">
                                                <h4 class="exersc_title">@if(!Auth::user()->hasRole('Admin')) @lang('exercisesets.my_exercises') @else @lang('exercisesets.exercises') @endif</h4>
                                                @if(!Auth::user()->hasRole('Admin'))
                                                  <a href="{{route('exercisesets.exerciseset.create')}}" class="creat_new">@lang('exercisesets.create_new')</a>
                                                @endif
                                                <a class="mrgn_lft_20 collps_fltr" data-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample"><span class="flr-i"></span></a>
                                            </div>
                                            <div class="float-sm-right short_by text-right">
                                                <div class="short_by_select">
                                                    <label>@lang('filter.sort_by') :</label>
                                                    <select class="selectpicker" id="filter-heading">
                                                        <option value="Topic">@lang('filter.topic')</option>
                                                        <option value="Curriculum">@lang('filter.curriculum')</option>
                                                        <option value="Grade">@lang('filter.grade')</option>
                                                        <option value="Title">@lang('filter.title')</option>
                                                        <option value="Number Of Questions">@lang('filter.number_of_questions')</option>
                                                        <option value="Number Of Student">@lang('filter.number_of_student')</option>
                                                    </select>
                                                    <select class="selectpicker" id="sort-by">
                                                        <option value="Ascending">@lang('filter.ascending')</option>
                                                        <option value="Descending">@lang('filter.descending')</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="clearfix"></div>
                                        <div class="list_of_filter collapse" id="collapseExample">
                                            <div class="card card-body">
                                            <!--Filter Form Apply-->
                                            <form id="filter-form" method="GET">
                                                <input id="base_path" type="hidden" value="{{url('/')}}">
                                                <div class="mani_menu_list">
                                                    <div class="float-left">
                                                        <a class="open_filter" href="javascript:;"><i class="plus_icn"></i></a>
                                                        <ul class="studnt_list_nm" id="fltered-text-list">
                                                            <!--Filter text append here-->
                                                        </ul>
                                                    </div>
                                                    <div class="float-right clear_all_cls">
                                                        <a href="javascript:;" id="clear_all_btn" class="clear_all_btn">@lang('filter.clear_all')</a>
                                                    </div>
                                                </div>
                                            </form>
                                            <!--End filer form-->

                                                <div class="slct_drop_box">
                                                    <ul class="demo-accordion demo-accordion1 accordionjs "data-active-index="false">
                                                      <li>
                                                          <div class="section_cls">
                                                              <h3>@lang('filter.topic')</h3>
                                                          </div>
                                                          <div class="class-detail">
                                                              <form  class="def_form">
                                                                  <div class="form-group">
                                                                      <div class="df-select">
                                                                          <select class="selectpicker" id="topic-operator">
                                                                              <option value="0"  selected disabled>@lang('filter.select_operator')</option>
                                                                              <option value="=">=</option>
                                                                              <option value="like">@lang('filter.like')</option>
                                                                              {{-- <option value="na">@lang('filter.n/a')</option> --}}
                                                                          </select>
                                                                      </div>
                                                                  </div>
                                                                  <div class="form-group">
                                                                      <div class="df-select">
                                                                          <input type="text" id="topic-name" class="form-control">
                                                                      </div>
                                                                  </div>
                                                                  <button id="topic-apply" type="button" class="btn btn-primary apply_sm_btn">@lang('filter.apply')</button>
                                                              </form>
                                                          </div>
                                                        </li>
                                                        <li>
                                                            <div class="section_cls">
                                                                <h3>@lang('filter.curriculum')</h3>
                                                            </div>
                                                            <div class="class-detail">
                                                                <form  class="def_form">
                                                                    <div class="form-group">
                                                                        <div class="df-select">
                                                                            <select class="selectpicker" id="disicipline-operator">
                                                                                <option value="0"  selected disabled>@lang('filter.select_operator')</option>
                                                                                <option value="=">=</option>
                                                                                <option value="like">@lang('filter.like')</option>
                                                                                <option value="na">@lang('filter.n/a')</option>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <div class="df-select">
                                                                            <input type="text" id="disicipline-name" class="form-control">
                                                                        </div>
                                                                    </div>
                                                                    <button id="disicipline-apply" type="button" class="btn btn-primary apply_sm_btn">@lang('filter.apply')</button>
                                                                </form>
                                                            </div>
                                                        </li>
                                                        <li>
                                                            <div class="section_cls">
                                                                <h3>@lang('filter.grade')</h3>
                                                            </div>
                                                            <div class="class-detail">
                                                                <form  class="def_form">
                                                                    <div class="form-group">
                                                                        <div class="df-select">
                                                                            <select class="selectpicker" id="grade-operator">
                                                                                <option value="0"  selected disabled>@lang('filter.select_operator')</option>
                                                                                <option>=</option>
                                                                                <option value="like">@lang('filter.like')</option>
                                                                                <option value="na">@lang('filter.n/a')</option>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <div class="df-select">
                                                                            <input type="text" id="grade-name" class="form-control">
                                                                        </div>
                                                                    </div>
                                                                    <button id="grade-apply" type="button" class="btn btn-primary apply_sm_btn">@lang('filter.apply')</button>
                                                                </form>
                                                            </div>
                                                        </li>
                                                        <li>
                                                            <div class="section_cls">
                                                                <h3>@lang('filter.title')</h3>
                                                            </div>
                                                            <div class="class-detail">
                                                                <form  class="def_form">
                                                                    <div class="form-group">
                                                                        <div class="df-select">
                                                                            <select class="selectpicker" id="title-operator">
                                                                                <option value="0" selected disabled>@lang('filter.select_operator')</option>
                                                                                <option value="=" >@lang('filter.equal')</option>
                                                                                <option value="like">@lang('filter.contains')</option>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <div class="df-select">
                                                                            <input type="text" id="title-name" class="form-control">
                                                                        </div>
                                                                    </div>
                                                                    <button id="title-apply" type="button" class="btn btn-primary apply_sm_btn">@lang('filter.apply')</button>
                                                                </form>
                                                            </div>
                                                        </li>
                                                        <li>
                                                            <div class="section_cls">
                                                                <h3>@lang('filter.number_of_questions')</h3>
                                                            </div>
                                                            <div class="class-detail">
                                                                <form  class="def_form">
                                                                    <div class="form-group">
                                                                        <div class="df-select">
                                                                            <select class="selectpicker" id="question-operator">
                                                                                <option value="0"  selected disabled>@lang('filter.select_operator')</option>
                                                                                <option value="="> = </option>
                                                                                <option value="<"> < </option>
                                                                                <option value=">"> > </option>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <div class="df-select">
                                                                            <input type="text" id="question-name" class="form-control">
                                                                        </div>
                                                                    </div>
                                                                    <button id="question-apply" type="button" class="btn btn-primary apply_sm_btn">@lang('filter.apply')</button>
                                                                </form>
                                                            </div>
                                                        </li>
                                                        <li>
                                                            <div class="section_cls">
                                                                <h3>@lang('filter.number_of_student')</h3>
                                                            </div>
                                                            <div class="class-detail">
                                                                <form  class="def_form">
                                                                    <div class="form-group">
                                                                        <div class="df-select">
                                                                            <select class="selectpicker" id="buyer-operator">
                                                                                <option value="0"  selected disabled>@lang('filter.select_operator')</option>
                                                                                <option value="="> = </option>
                                                                                <option value="<"> < </option>
                                                                                <option value=">"> > </option>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <div class="df-select">
                                                                            <input type="text" id="buyer-name" class="form-control">
                                                                        </div>
                                                                    </div>
                                                                    <button id="buyer-apply" type="button" class="btn btn-primary apply_sm_btn">@lang('filter.apply')</button>
                                                                </form>
                                                            </div>
                                                        </li>
                                                        <li>
                                                            <div class="section_cls">
                                                                <h3>@lang('filter.rating')</h3>
                                                            </div>
                                                            <div class="class-detail">
                                                                <form  class="def_form">
                                                                    <div class="form-group">
                                                                        <div class="df-select">
                                                                            <select class="selectpicker" id="rating-name">
                                                                                <option value="0"  selected disabled>@lang('filter.select_operator')</option>
                                                                                <option data-content="&lt;i class=&#039;fa fa-star&#039;&gt;&lt;/i&gt;" value="1.0"></option>
                                                                                <option data-content="&lt;i class=&#039;fa fa-star&#039;&gt;&lt;/i&gt;&lt;i class=&#039;fa fa-star&#039;&gt;&lt;/i&gt;" value="2.0"></option>
                                                                                <option data-content="&lt;i class=&#039;fa fa-star&#039;&gt;&lt;/i&gt;&lt;i class=&#039;fa fa-star&#039;&gt;&lt;/i&gt;&lt;i class=&#039;fa fa-star&#039;&gt;&lt;/i&gt;" value="3.0"></option>
                                                                                <option data-content="&lt;i class=&#039;fa fa-star&#039;&gt;&lt;/i&gt;&lt;i class=&#039;fa fa-star&#039;&gt;&lt;/i&gt;&lt;i class=&#039;fa fa-star&#039;&gt;&lt;/i&gt;&lt;i class=&#039;fa fa-star&#039;&gt;&lt;/i&gt;" value="4.0"></option>
                                                                                <option data-content="&lt;i class=&#039;fa fa-star&#039;&gt;&lt;/i&gt;&lt;i class=&#039;fa fa-star&#039;&gt;&lt;/i&gt;&lt;i class=&#039;fa fa-star&#039;&gt;&lt;/i&gt;&lt;i class=&#039;fa fa-star&#039;&gt;&lt;/i&gt;&lt;i class=&#039;fa fa-star&#039;&gt;&lt;/i&gt;" value="5.0"></option>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                    <button id="rating-apply" type="button" class="btn btn-primary apply_sm_btn">@lang('filter.apply')</button>
                                                                </form>
                                                            </div>
                                                        </li>  
                                                        <li>
                                                            <div class="section_cls">
                                                                <h3>@lang('filter.age')</h3>
                                                            </div>
                                                            <div class="class-detail">
                                                                <form  class="def_form">
                                                                    <div class="form-group">
                                                                        <div class="df-select">
                                                                            <input type="text" id="min-age" name="minAge" class="form-control" placeholder="@lang('filter.min_age')">
                                                                        </div>
                                                                        <div class="df-select">
                                                                            <input type="text" id="max-age" name="maxAge" class="form-control" placeholder="@lang('filter.max_age')">
                                                                        </div>
                                                                    </div>
                                                                    <button id="age-apply" type="button" class="btn btn-primary apply_sm_btn">@lang('filter.apply')</button>
                                                                </form>
                                                            </div>
                                                        </li>  
                                                        <li>
                                                            <div class="section_cls">
                                                                <h3>@lang('filter.publish_date')</h3>
                                                            </div>
                                                            <div class="class-detail">
                                                                <form  class="def_form">
                                                                    <div class="form-group">
                                                                        <div class="df-select">
                                                                            <input type="text" class="form-control" placeholder="@lang('filter.start_date')" name="startDate" id="startDate">
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <div class="df-select">
                                                                            <input type="text" class="form-control" placeholder="@lang('filter.end_date')" name="endDate" id="endDate">
                                                                        </div>
                                                                    </div>
                                                                    <button id="created-date-apply" type="button" class="btn btn-primary apply_sm_btn">@lang('filter.apply')</button>
                                                                </form>
                                                            </div>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <!--  -->
                                <div class="list_of_exercise">
                                <!--new content will be displayed in here-->
                                <div class="row"  id="my-private-lib">
                                    @if(count($myExercises))
                                        @foreach($myExercises as $exerciseset)
                                            @php
                                                $ispublic = 0;
                                                $rn = rand(1,3);
                                            @endphp
                                            <div class="col-md-6 col-lg-6 col-xl-3 cusmize-col">
                                                <div class="main_info">
                                                    <div class="main_shr">
                                                        <button type="button" data-exerciseset="{{route('practice.index', [ $exerciseset->id ])}}" 
                                                            id="share_{{$exerciseset->id}}" onclick="generateEmailUrl(this.id)" data-toggle="modal" data-target="#exercisesets/private" 
                                                            data-toggle="tooltip" title="@lang('exercisesets.share')"
                                                            class="share_link_icn">
                                                        </button>
                                                    </div>
                                                    <a href="@can ('update', $exerciseset){{route('exercisesets.exerciseset.show', [ $exerciseset->id  , ($exerciseset->publish_status === 'public' ) ? 1 : 0 ])}}@endcan">
                                                        <div class="info_exercise">
                                                            @php
                                                            if (isset($exerciseset->exerciseset_image) && !empty($exerciseset->exerciseset_image)) {
                                                                if (strlen($exerciseset->exerciseset_image) > 0 && File::exists(public_path()."/uploads/exercisesets/".$exerciseset->exerciseset_image)) {
                                                                    $exercisesetImage = '/uploads/exercisesets/'.$exerciseset->exerciseset_image;
                                                                    
                                                                } else {
                                                                    $exercisesetImage = 'assets/eduplaycloud/image/exers_prfl.png';
                                                                }
                                                            } else {
                                                                $exercisesetImage = 'assets/eduplaycloud/image/exers_prfl.png';
                                                            }
                                                            @endphp
                                                        <img src="{{ asset($exercisesetImage) }}" class="img-fluid">
                                                        <div class="whit_checbx">
                                                            <div class="custom-control checkbox custom-checkbox chbx_wt">
                                                                @if (Auth::user()->hasRole('Teacher'))
                                                                    <input name="exerses[]" value="{{$exerciseset->id}}" id="exerses_{{$exerciseset->id}}" type="checkbox" class="custom-control-input">
                                                                    <label class="custom-control-label" for="exerses_{{$exerciseset->id}}"></label>
                                                                @endif
                                                            </div>
                                                        </div>

                                                        <div class="left_time_info">
                                                            <ul class="time_info float-left">
                                                                <li>
                                                                    @if ($exerciseset->price != 0)
                                                                        ${{ $exerciseset->price }}
                                                                    @else
                                                                        @lang('exercisesets.free')
                                                                    @endif
                                                                </li>
                                                                <li class="time_icn">
                                                                    {{ gmdate("H:i:s", $exerciseset->question->sum('maxtime')) }}
                                                                </li>
                                                            </ul>
                                                            <ul class="skill_info float-right">
                                                                <li>
                                                                    @lang('exercisesets.skills'):
                                                                    {{ ($exerciseset->question->where('skill_id','!=',null)->groupby('skill_id')->count('skill_id')) }}
                                                                </li>
                                                                <li>
                                                                    @lang('exercisesets.question'):
                                                                    {{ $exerciseset->question->count() }}
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                    <ul class="creat_exr title_cmbo">
                                                        <li>
                                                            <label class="pointer" title="{{$exerciseset->title}}">{{ str_limit($exerciseset->title,'30') }}</label>
                                                        </li>
                                                        @if($exerciseset->discipline)
                                                            <li>
                                                                <span>{{  str_limit(@$exerciseset->discipline->discipline_name, '50') }}</span>
                                                            </li>
                                                            <li>
                                                                <span>{{  str_limit(@$exerciseset->topic->topic_name, '50') }}</span>
                                                            </li>
                                                        @else 
                                                            <li><span>@lang('filter.n/a')</span></li>
                                                        @endif
                                                        @if($exerciseset->topic)
                                                            <li>
                                                                <span>{{  str_limit(@$exerciseset->topic->topic_name, '50') }}</span>
                                                            </li>
                                                        @else 
                                                            <li><span>@lang('filter.n/a')</span></li>
                                                        @endif
                                                            <li>
                                                                @if($exerciseset->publish_status == 'private')
                                                                    <span>@lang('exerciseset_form.private')</span>
                                                                @else
                                                                    <span>@lang('exerciseset_form.public')</span>
                                                                @endif
                                                            </li>
                                                    </ul>
                                                </a>
                                                 @if(Auth::user()->id == $exerciseset->createdby)
                                                      <form id="remove_exercise_from_{{$exerciseset->id}}" method="POST" action="{{route('exercisesets.owner.destroy', [$exerciseset->id])}}">
                                                        {{ csrf_field() }}
                                                        {{ method_field('DELETE') }}
                                                        <button class="btn my_exercises_delete" onclick="confirmFunction({{$exerciseset->id}})" type="button"></button>
                                                    </form>
                                                  @endif
                                                  @if(Auth::user()->hasRole('Admin'))
                                                    <form id="remove_exercise_from_{{$exerciseset->id}}" method="POST" action="{{route('exercisesets.owner.destroy', [$exerciseset->id])}}">
                                                        {{ csrf_field() }}
                                                        {{ method_field('DELETE') }}
                                                        <button class="btn my_exercises_delete" onclick="confirmFunction({{$exerciseset->id}})" type="button"></button>
                                                    </form>
                                                  @endif
                                                    <ul class="star_wth_user">
                                                        <li>
                                                            <div class="gray_star">
                                                                <div class="orng_star" style="width: {{(@$exerciseset->averageRating(1)[0]) * 100 / 5}}%;"></div>
                                                            </div>
                                                            <span class="rtng">{{@$exerciseset->averageRating(1)[0]}}</span>
                                                        </li>
                                                        @if($exerciseset->grade)
                                                            <li title="{{ $exerciseset->grade->grade_name }}"><span>{{ str_limit(@$exerciseset->grade->grade_name, '18')}}</span></li>
                                                        @else 
                                                            <li><span>@lang('filter.n/a')</span></li>
                                                        @endif
                                                        <li><small>{{ $exerciseset->created_at }}</small></li>
                                                    </ul>
                                                    @foreach($exerciseRatingList as $ratekey => $rate)
                                                        @php $reviewCount = 1; @endphp
                                                        @if($rate->id == $exerciseset->id)
                                                            @if(count($rate->ratings_data) > 0)
                                                                @foreach($rate->ratings_data as $item)
                                                                    {{-- @if($reviewCount < 3) --}}
                                                                    <div class="rew_prfl_sectin">
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
                                                                    {{-- @endif --}}
                                                                @php $reviewCount++; @endphp
                                                                @endforeach
                                                            @endif
                                                        @endif
                                                    @endforeach
                                                </div>
                                            </div>
                                        @endforeach
                                    @else
                                    <div class="col-md-12">
                                        <p>@lang('filter.no_library_available') !!</p>
                                        <div class="clearfix"></div><br/>
                                        <div class="clearfix"></div><br/>
                                    </div>
                                    @endif
                                </div>
                                @if(!Auth::user()->hasRole('Admin'))
                                <div class="list_of_exercise add_nw_exrsc">
                                    <h4 class="exersc_title"> @lang('exercisesets.exercise_followed')</h4>
                                    <a href="{{route('explore.exerciseset')}}" class="creat_new">@lang('exercisesets.add_new')</a>
                                    <div class="row">
                                    @if(count($exercisesBuy))
                                        @foreach($exercisesBuy as $exerciseset)
                                            <div class="col-md-6 col-lg-6 col-xl-3 cusmize-col">
                                                <div class="main_info">
                                                    <div class="main_shr">
                                                        <button type="button" data-exerciseset="{{route('practice.index', [ $exerciseset->id ])}}" 
                                                            id="share_{{$exerciseset->id}}" onclick="generateEmailUrl(this.id)" data-toggle="modal" data-target="#exercisesets/private" 
                                                            data-toggle="tooltip" title="@lang('exercisesets.share')"
                                                            class="share_link_icn">
                                                        </button>
                                                        </div>
                                                    <a href="{{route('exercisesets.exerciseset.summary', [ $exerciseset->id  , ($exerciseset->publish_status === 'public' ) ? 1 : 0 ])}}" class="info_exercise">
                                                            @php
                                                            if (isset($exerciseset->exerciseset_image) && !empty($exerciseset->exerciseset_image)) {
                                                                if (strlen($exerciseset->exerciseset_image) > 0 && File::exists(public_path()."/uploads/exercisesets/".$exerciseset->exerciseset_image)) {
                                                                    $exercisesetImage = '/uploads/exercisesets/'.$exerciseset->exerciseset_image;
                                                                    
                                                                } else {
                                                                    $exercisesetImage = 'assets/eduplaycloud/image/exers_prfl.png';
                                                                }
                                                            } else {
                                                                $exercisesetImage = 'assets/eduplaycloud/image/exers_prfl.png';
                                                            }
                                                            @endphp
                                                        <img src="{{ asset($exercisesetImage) }}" class="img-fluid">
                                                        {{--  <img src="{{ asset('assets/eduplaycloud/image/exers_prfl.png') }}" class="img-fluid">  --}}
                                                        <div class="whit_checbx">
                                                            <div class="profile_name">
                                                                @if($exerciseset->owner)
                                                                <img src="{{asset('assets/images/profiles')}}/{{  $exerciseset->owner->user_image }}">
                                                                @else
                                                                <img src="{{asset('assets/images/profiles/userdefaultimg.png')}}">
                                                                @endif
                                                                <p>{{ optional($exerciseset->owner)->name }}</p>
                                                            </div>
                                                        </div>
                                                        <div class="left_time_info">
                                                            <ul class="time_info float-left">
                                                                <li>
                                                                    @if ($exerciseset->price != 0)
                                                                        ${{ $exerciseset->price }}
                                                                    @else
                                                                        @lang('exercisesets.free')
                                                                    @endif
                                                                </li>
                                                                <li class="time_icn">
                                                                    {{ gmdate("H:i:s", $exerciseset->question->sum('maxtime')) }}
                                                                </li>
                                                            </ul>
                                                            <ul class="skill_info float-right">
                                                                <li>
                                                                    @lang('exercisesets.skills'):
                                                                    {{($exerciseset->question->where('skill_id','!=',null)->groupby('skill_id')->count('skill_id')) }}
                                                                </li>
                                                                <li>
                                                                    @lang('exercisesets.question'):
                                                                    {{ $exerciseset->question->count() }}
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </a>
                                                    <ul class="title_cmbo">
                                                        <li>
                                                            <a href="javascript:;">{{ str_limit($exerciseset->title,'30') }}</a>
                                                        </li>
                                                        @if($exerciseset->discipline)
                                                            <li>
                                                                {{-- <a href="javascript:;"> --}}
                                                                {{ str_limit(@$exerciseset->discipline->discipline_name,'50') }}
                                                                {{-- </a> --}}
                                                            </li>
                                                        @else 
                                                           <li><span>@lang('filter.n/a')</span></li>
                                                        @endif
                                                        @if($exerciseset->topic)
                                                            <li>
                                                                <span>{{  str_limit(@$exerciseset->topic->topic_name, '50') }}</span>
                                                            </li>
                                                        @else 
                                                            <li><span>@lang('filter.n/a')</span></li>
                                                        @endif
                                                     
                                                    </ul>
                                                    <ul class="star_wth_user">
                                                        <li>
                                                            <div class="gray_star">
                                                                <div class="orng_star" style="width: {{(@$exerciseset->averageRating(1)[0]) * 100 / 5}}%;"></div>
                                                            </div>
                                                        </li>
                                                        @if($exerciseset->grade)
                                                            <li><span>{{str_limit(@$exerciseset->grade->grade_name, '18')}}</span></li>
                                                        @else 
                                                           <li><span>@lang('filter.n/a')</span></li>
                                                        @endif
                                                        <li><small>{{ $exerciseset->created_at }}</small></li>
                                                    </ul>
                                                    @foreach($exerciseBuyRatingList as $ratekey => $rate)
                                                        @php $codereviewCount = 1; @endphp
                                                        @if($rate->id == $exerciseset->id)
                                                            @if(count($rate->ratings_data) > 0)
                                                                @foreach($rate->ratings_data as $item)
                                                                @if($codereviewCount < 3)
                                                                <div class="rew_prfl_sectin">
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
                                                                @endif
                                                                @php $codereviewCount++; @endphp
                                                                @endforeach
                                                            @endif
                                                        @endif
                                                    @endforeach
                                                </div>
                                            </div>
                                        @endforeach
                                    @else
                                    <div class="col-md-12">
                                        <p>@lang('filter.no_public_library_available')</p>
                                        <div class="clearfix"></div><br/>
                                        <div class="clearfix"></div><br/>
                                    </div>
                                    @endif
                                    </div>
                                </div>
                                @endif
                            </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="pills-pins" role="tabpanel" aria-labelledby="pills-pins-tab">
                            <div class="row">
                                <div class="col-md-12 text-sm-right text-sm-ar-left">
                                    @if (Auth::user()->hasRole('Teacher'))
                                        <a href="javascript:;" id="pins_publish" class="publish_class_btn">@lang('exercisesets.publish_to_class')</a>
                                    @endif
                                </div>
                            </div>
                            <div class="my_exercise mrgn-tp-20">
                                <div class="main_detail_fltr">
                                    <div class="title_with_shrtby">
                                        <div class="float-sm-left filtr_with_titile">
                                                <h4 class="exersc_title">@lang('classcourse.pins')</h4>
                                                <a href="javascript:;"  data-toggle="modal"
                                                data-target="#create_pin" data-dismiss="modal" class="creat_new"> @lang('exercisesets.create_new')</a>
                                            <a class="mrgn_lft_20 collps_fltr" data-toggle="collapse" href="#collapseExample_pin" role="button" aria-expanded="false" aria-controls="collapseExample_pin"><span class="flr-i"></span></a>
                                        </div>
                                        <div class="float-sm-right short_by text-right">
                                            <div class="short_by_select">
                                                <label>@lang('filter.sort_by_description') : </label>
                                                <select class="selectpicker" id="sort-by-pin">
                                                    <option value="Ascending">@lang('filter.ascending')</option>
                                                    <option value="Descending">@lang('filter.descending')</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="clearfix"></div>
                                    <div class="list_of_filter collapse" id="collapseExample_pin">
                                        <div class="card card-body">
                                            <!--Filter Form Apply-->
                                            <form id="filter-form-pin" method="GET">
                                                <input type="hidden" name="classId" value="" />
                                                <div class="mani_menu_list">
                                                    <div class="float-left">
                                                        <a class="open_filter" href="javascript:;"><i class="plus_icn"></i></a>
                                                        <ul class="studnt_list_nm" id="fltered-text-list-pin">
                                                            <!--Filter text append here-->
                                                        </ul>
                                                    </div>
                                                    <div class="float-right clear_all_cls">
                                                        <a href="javascript:;" id="clear_all_btn-pin" class="clear_all_btn">@lang('filter.clear_all')</a>
                                                    </div>
                                                </div>
                                            </form>
                                            <!--End filer form-->

                                            <div class="slct_drop_box">
                                                <ul class="demo-accordion demo-accordion2 accordionjs " data-active-index="false">
                                                    <li>
                                                        <div class="section_cls">
                                                            <h3>@lang('filter.description')</h3>
                                                        </div>
                                                        <div class="class-detail">
                                                            <form  class="def_form">
                                                                <div class="form-group">
                                                                    <div class="df-select">
                                                                        <select class="selectpicker" id="description-operator">
                                                                            <option value="0" selected disabled>@lang('filter.select_operator')</option>
                                                                            <option value="=" >@lang('filter.equal')</option>
                                                                            <option value="like">@lang('filter.contains')</option>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                                <div class="form-group">
                                                                    <div class="df-select">
                                                                        <input type="text" id="description-name" class="form-control">
                                                                    </div>
                                                                </div>
                                                                <button id="descriptio-apply" type="button" class="btn btn-primary apply_sm_btn">@lang('filter.apply')</button>
                                                            </form>
                                                        </div>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                    @include('eduplaycloud.users.private-library.pins')
                                </div>
                            </div>
                        </div>
                        {{--  <div class="tab-pane fade" id="pills-study" role="tabpanel" aria-labelledby="pills-study-tab">
                                @lang('exercisesets.study_set')
                        </div>  --}}
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@include("eduplaycloud.pin_form")

<!--Share By Mail Model-->
<div class="modal fade default_modal wht_bg_mdl" id="share_mail" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="right_contnt text-ar-right">
                            <h3>@lang('exercisesets.mail')</h3>
                            <form class="def_form" action="{{route('mail.exerciseset')}}" id="share_email_form" method="POST">
                                {{ csrf_field() }}
                                <div class="form-group">
                                    <input type="hidden" id="url" name="url" value=""  class="form-control">
                                </div>
                                <div class="form-group">
                                    <label>@lang('exercisesets.enter_email'): </label>
                                   <input type="email" id="email" name="email" value=""  class="form-control" required>
                                </div>
                                <div class="form-group mrgn-tp-30">
                                    <button type="submit" class="btn btn-primary btn-login drk_bg_btn">@lang('exercisesets.send')</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!--publish-to-class-->
<div class="modal fade default_modal wht_bg_mdl" id="publish_cls" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="right_contnt text-ar-right">
                                <h3>@lang('exercisesets.select_class')</h3>
                                <form class="def_form" id="publishtoclass_form">
                                    @if(count($courseclasses))
                                    <div class="form-group">
                                        <div class="df-select">
                                            <select class="selectpicker" id="select_class" required>
                                                @foreach($courseclasses as $class)
                                                    <option value="{{$class->id}}" {{($class->id == $class_id) ? "selected" : "" }} >{{$class->class_name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <!--This is for pop flag pass in pins and exercise-->
                                        <input type="hidden" id="publish_type" >
                                        <input type="hidden" id="class_id" value="{{$class_id}}">
                                    </div>
                                    <div class="form-group publis_mrgn">
                                        <button type="button" id="publish_submit" class="btn btn-primary btn-login">@lang('exercisesets.publish')</button>
                                    </div>
                                    @else 
                                        <p>@lang('exercisesets.please_create_your_class_first')</p>
                                    @endif
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

  
<!--publish-to-class-->
<div class="modal fade default_modal wht_bg_mdl" id="publish_g_class" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="right_contnt text-ar-right">
                                <h3>Select Google Classroom</h3>
                                <form class="def_form" id="publish_to_g_class_form">
                                    @if(count($googleclasses))
                                    <div class="form-group">
                                        <div class="df-select">
                                            <select class="selectpicker" id="select_gclass" required>
                                                @foreach($googleclasses as $gclass)
                                                    <option value="{{$gclass->id}}">{{$gclass->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <!--This is for pop flag pass in pins and exercise-->
                                        <input type="hidden" id="gpublish_type" >
                                        <input type="hidden" id="gclass_id" value="">
                                    </div>
                                    <div class="form-group publis_mrgn">
                                        <button type="button" id="gpublish_submit" class="btn btn-primary btn-login">@lang('exercisesets.publish')</button>
                                    </div>
                                    @else 
                                        <p>@lang('exercisesets.please_create_your_class_first')</p>
                                    @endif
                                </form>
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
<?php /* Only for M1 start*/ ?>
<script type="text/javascript" src="{{ asset('assets/eduplaycloud/js/circlos.js') }}"></script>
<?php /* Only for M1 start*/ ?>
<script src="{{ asset('assets/eduplaycloud/js/accordion.js') }}"></script>
@endpush

<?php /*Load jquery to footer section*/ ?>
@push('inc_jquery')
<script type="text/javascript" src="{{ asset('assets/eduplaycloud/customs/js/jquery-validate/jquery.validate.min.js') }}"></script>
<script type="text/javascript" src="https://ajax.aspnetcdn.com/ajax/jquery.validate/1.11.1/additional-methods.min.js"></script>
<script src="{{ asset('assets/eduplaycloud/customs/js/block-ui/jquery.blockUI.js') }}"></script>
<script src="{{ asset('assets/eduplaycloud/customs/js/filter/private-library-filter.js') }}"></script>
<script src="{{ asset('assets/eduplaycloud/customs/js/filter/pins-filter.js') }}"></script>
{{-- <script src="{{ asset('assets/eduplaycloud/customs/js/filter/global-filter.js') }}"></script>1 --}}
<script src="{{ asset('assets/eduplaycloud/customs/js/filter/save-filter.js') }}"></script>

<script>
    $(document).on("click","#close",function() {
        $("#pin_form").trigger('reset');
    });

     $(window).bind("pageshow", function() { // update hidden input field 
        //$('#formid')[0].reset(); 
        $("#sort-by").val(0).selectpicker("refresh");
    });
    
    /*accordian*/
    jQuery(document).ready(function($){
        $(".demo-accordion1").accordionjs();
    });
    /*accordian 2*/
    jQuery(document).ready(function($){
        $(".demo-accordion2").accordionjs();
    });
</script>
<script>
   $(function () {
       $('#startDate').datetimepicker({
           format: 'DD-MM-YYYY',
           maxDate: 'now',
           /*debug: true*/
       });
       $('#endDate').datetimepicker({
           format: 'DD-MM-YYYY',
           useCurrent: false,
           maxDate: 'now'
       });
       $("#startDate").on("dp.change", function (e) {
           $('#endDate').data("DateTimePicker").minDate(e.date);
       });
       $("#endDate").on("dp.change", function (e) {
           $('#startDate').data("DateTimePicker").maxDate(e.date);
       });
   });

   //Email send in exersice id get.
   function generateEmailUrl(id){
       $('#url').val($('#'+id).attr('data-exerciseset'));
       $('#share_mail').modal('show');
   }

   //Develop by WC
   $("#share_email_form").validate({
        rules: {
            email: {
                required: true,
                email: true
            },
        },
        messages: {

        }
    });

    //Pins in pagination event click
    $(document).on('click', '.pagination a',function(event)
    {
        event.preventDefault();

        $('li').removeClass('active');
        $(this).parent('li').addClass('active');

        var myurl = $(this).attr('href');
        window.location = myurl + '#pills-pins';
    });

    // Create Pin
    $("#pin_form").validate({
        rules: {
            url: {
                url: true
            },
            description: {
                required: true
            },
            image : {
                accept: "image/jpg,image/jpeg,image/png,image/gif"
            }
        },
        messages: {
            image: { 
                accept: '@lang("pins.please_select_only_image")'
            }
        }
    });

    // Edit Pin
    $("#edit_pin_form").validate({
        rules: {
            url: {
                url: true
            },
            description: {
                required: true
            },
            image : {
                accept: "image/jpg,image/jpeg,image/png,image/gif"
            }
        },
        messages: {
            image: { 
                accept: '@lang("pins.please_select_only_image")'
            }
        }
    });

    // Edit pin
    function editPin(id) {
        var authId = '{{ Auth::user()->id }}';
        $.ajax({
            url: site_url + '/pins/' + id +'/edit',
            type: 'GET',
            success: function(result) {
                $('#pin_id').val(id);
                $('#edit_pin').modal('show');
                $('#pin_edit_url').val(result.url);
                $("textarea").val(result.description);
                if(result.image != null){
                    var url = site_url + '/assets/eduplaycloud/users-'+ authId +'/pins/' + result.image;
                    $('#output2').attr('src',url);
                } else {
                    var url = '';
                    $('#output2').attr('src',url);
                }
            }
        });
    }

    // Delete Pin
    function deletePin(id) {
        swal({
          title: 'Pin' ,
          text: "@lang('pins.sure_delete')",
          icon: "warning",
          buttons: [
            '@lang("exercisesets.cancel_it")',
            '@lang("exercisesets.sure")'
          ],
          dangerMode: true,
        }).then(function(isConfirm) {
            if (isConfirm) {
                window.location.href = site_url + '/pins/pin/' + id;
            } 
        });
    }

//profile progress js
$(".cdev").circlos();
//Check box checked for publish to class

var checkboxValues = [];
$('#publish_to_class_btn').on('click',function () {
    var checkedNum = $('input[name="exerses[]"]:checked').length;
    if (checkedNum) {
        $('#publish_type').val('exercises');
        $('#publish_cls').modal('show');

        $('input[name="exerses[]"]:checked').each(function(index, elem) {
            checkboxValues.push($(elem).val());
        });

    } else {
        $('#custom-jquery-msg').html('<div class="alert alert-danger"><i class="fa fa-check-square-o" aria-hidden="true"></i>@lang("exercisesets.please_select_exercise_first")<button type="button" class="close" data-dismiss="alert" aria-label="close"><span aria-hidden="true">&times;</span></button></div>');
    }
});


//Check box checked for pins publish to class
var pinscheckboxValues = [];
$('#pins_publish').on('click',function () {
    var pinscheckedNum = $('input[name="pin[]"]:checked').length;
    if (pinscheckedNum) {
        $('#publish_type').val('pins');
        $('#publish_cls').modal('show');
        
        $('input[name="pin[]"]:checked').each(function(index, elem) {
            pinscheckboxValues.push($(this).val());
        });
    } else {
        $('#custom-jquery-msg').html('<div class="alert alert-danger"><i class="fa fa-check-square-o" aria-hidden="true"></i>@lang("exercisesets.please_select_exercise_first")<button type="button" class="close" data-dismiss="alert" aria-label="close"><span aria-hidden="true">&times;</span></button></div>');
    }
});

  // add the rule here
  $.validator.addMethod("valueNotEquals", function(value, element, arg){
    return arg !== value;
    }, "Value must not equal arg.");

    // configure your validation
    $("#publishtoclass_form").validate({
    rules: {
        select_class: { valueNotEquals: "default" }
    },
    messages: {
        select_class: { valueNotEquals: "Please select an item!" }
    }  
    });

//Sunmit publish to class.
$('#publish_submit').on('click', function(){
    $('#publish_cls').modal('hide');
    swal({
          title: $('#select_class option:selected').text() ,
          text: "@lang('exercisesets.sure_publish')",
          icon: "warning",
          buttons: [
            '@lang("exercisesets.cancel_it")',
            '@lang("exercisesets.sure")'
          ],
          dangerMode: true,
        }).then(function(isConfirm) {
            if (isConfirm != null) {
                    var selectedClass = $('#select_class').val();
                    //exerciseset to class and pins to class both are here
                    var publishType = $('#publish_type').val();
                    var formdata;
                    var ajaxurl;

                    if(publishType === 'pins'){
                        ajaxurl = site_url + "/exercisesets/pins/pusblish-to-class/";
                        formdata = {'pins':pinscheckboxValues , 'class': selectedClass };
                    } else { 
                        ajaxurl = site_url + "/exercisesets/pusblish-to-class/";
                        formdata = {'exercises':checkboxValues , 'class': selectedClass };        
                    }

                    $.ajax({
                            url: ajaxurl,
                            data: formdata,
                            type: 'GET',
                            success: function(result) {

                                if(result.type == 'pin'){
                                    if(result.message === 'success'){
                                        swal({
                                            title: '@lang("exercisesets.publish")!',
                                            text: '@lang("exercisesets.pins_published")',
                                            icon: 'success',
                                            button: {
                                                text: "@lang('exercisesets.ok')",
                                            }
                                            
                                        }).then(function() {

                                            if(publishType == 'pins'){
                                                var redirect = site_url + "/courseclasses/show/" + selectedClass + "?#resources#pills-pins";
                                                    window.location.href = redirect;
                                            } 

                                        });
                                    } else {
                                        $('#custom-jquery-msg').html('<div class="alert alert-warning"><i class="fa fa-check-square-o" aria-hidden="true"></i>@lang("exercisesets.pin_already_published")<button type="button" class="close" data-dismiss="alert" aria-label="close"><span aria-hidden="true">&times;</span></button></div>');
                                    }

                                } else {
                                    if(result.message === 'success'){
                                        swal({
                                            title: '@lang("exercisesets.publish")!',
                                            text: '@lang("exercisesets.exercises_published")',
                                            icon: 'success',
                                            button: {
                                                text: "@lang('exercisesets.ok')",
                                            }
                                            
                                        }).then(function() {
                                            if($('#class_id').val() !== ''){
                                                var redirect = site_url + "/courseclasses/show/" + selectedClass + "?#resources";
                                                window.location.href = redirect;
                                            } else {
                                                $('input[name="exerses[]').removeAttr('checked');
                                                location.reload();                                            
                                            }
                                        });

                                    } else {
                                        $('#custom-jquery-msg').html('<div class="alert alert-warning"><i class="fa fa-check-square-o" aria-hidden="true"></i>@lang("exercisesets.already_published")<button type="button" class="close" data-dismiss="alert" aria-label="close"><span aria-hidden="true">&times;</span></button></div>');
                                    }
                            }
                        }
                    });

          } else {
            $('input:checkbox').removeAttr('checked');
            // swal("Cancelled", "You have cancelled publish class", "error");
          }
        });
});

//Click on publish to class button.
$('#publish_to_gclass_btn').on('click',function () {
    var checkedNum = $('input[name="exerses[]"]:checked').length;
    if (checkedNum) {
        $('#gpublish_type').val('exercises');
        $('#publish_g_class').modal('show');

        $('input[name="exerses[]"]:checked').each(function(index, elem) {
            checkboxValues.push($(elem).val());
        });

    } else {
        $('#custom-jquery-msg').html('<div class="alert alert-danger"><i class="fa fa-check-square-o" aria-hidden="true"></i>@lang("exercisesets.please_select_exercise_first")<button type="button" class="close" data-dismiss="alert" aria-label="close"><span aria-hidden="true">&times;</span></button></div>');
    }
});

//Sunmit publish to class.
$('#gpublish_submit').on('click', function(){
    $('#publish_g_class').modal('hide');
    swal({
          title: $('#select_gclass option:selected').text() ,
          text: "@lang('exercisesets.sure_publish')",
          icon: "warning",
          buttons: [
            '@lang("exercisesets.cancel_it")',
            '@lang("exercisesets.sure")'
          ],
          dangerMode: true,
        }).then(function(isConfirm) {
            if (isConfirm != null) {
                    var selectedClass = $('#select_gclass').val();
                    //exerciseset to class and pins to class both are here
                    var publishType = $('#gpublish_type').val();
                    var formdata;
                    var ajaxurl;

                   ajaxurl = site_url + "/exercisesets/pusblish-to-googleclass/";
                   formdata = {'exercises':checkboxValues , 'class': selectedClass };        

                    $.ajax({
                            url: ajaxurl,
                            data: formdata,
                            type: 'GET',
                            success: function(result) {

                                if(result.message === 'success'){
                                    swal({
                                        title: '@lang("exercisesets.publish")!',
                                        text: '@lang("exercisesets.exercises_published")',
                                        icon: 'success',
                                        button: {
                                            text: "@lang('exercisesets.ok')",
                                        }
                                        
                                    }).then(function() {
                                        if($('#gclass_id').val() !== ''){
                                           // var redirect = site_url + "/google-classroom/show/";
                                            //window.location.href = redirect;
                                        } else {
                                            $('input[name="exerses[]').removeAttr('checked');
                                            location.reload();                                            
                                        }
                                    });

                                } else {
                                    $('#custom-jquery-msg').html('<div class="alert alert-warning"><i class="fa fa-check-square-o" aria-hidden="true"></i>@lang("exercisesets.already_published")<button type="button" class="close" data-dismiss="alert" aria-label="close"><span aria-hidden="true">&times;</span></button></div>');
                                }

                        }
                    });

          } else {
            $('input:checkbox').removeAttr('checked');
            // swal("Cancelled", "You have cancelled publish class", "error");
          }
        });
});


function confirmFunction(id) {
    swal({
      text: 'Are you sure to delete this?',
      icon: "warning",
      buttons: true,
      dangerMode: true,
    }).then((willDelete) => {
      if (willDelete) {
        $("#remove_exercise_from_"+id).submit();  
      }
    });   
}

$(document).ready(function(){
    @if(Session::has('error_message') || Session::has('success_message'))
        $('html, body').animate({
            scrollTop: $(".my_private_libray").offset().top
        }, 1000);
    @endif

    $("form").submit(function() {
        $(this).submit(function() {
            return false;
        });
        return true;
    });

    if (window.location.hash) {
        var hrf =  $('.private-lib-pills a[href="'+window.location.hash+'"]').tab('show');
    } else {
        //var hrf =  $('.summary-tbs a[href="#summary"]').tab('show');
    }
});
</script>
@endpush
