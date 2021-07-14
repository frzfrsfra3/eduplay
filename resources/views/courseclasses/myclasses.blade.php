@extends('authenticated.layouts.default')

@section('content')
    <div class="work_page mrgn_top_secn text-ar-right">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-12">
                 @if(Session::has('success_message'))
                    <div class="alert alert-success">
                        <i class="fa fa-check-square-o" aria-hidden="true"></i>
                        {!! session('success_message') !!}
                        <button type="button" class="close" data-dismiss="alert" aria-label="close">
                            <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif
                    <div id="getmsg"></div>
                    <div class="my_private_libray">
                        <div class="tbs_of_report tbs_of_report-as">
                            <div class="dropdown">
                                <button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown">@lang('classcourse.Myclasses')
                                    <span class="caret"></span>
                                </button>
                                @include('eduplaycloud.users.private-library.menu')
                            </div>
                        </div>
                        <div class="clearfix"></div>
                         <div class="row">
                            <div class="col-sm-6 col-md-8">
                                <ul class="exe_tbs nav private-lib-pills nav-pills mb-3" id="pills-tab" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link active" id="pills-classes-tab" data-toggle="pill" href="#pills-classes" role="tab" aria-controls="pills-classes" aria-selected="true">@lang('classcourse.classes')</a>
                                    </li>
                                    <li class="nav-item ">
                                        <a class="nav-link" id="pills-gclass-tab" data-toggle="pill" href="#pills-gclass" role="tab" aria-controls="pills-gclass" aria-selected="false">@lang('classcourse.google_classes')</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                        <div class="tab-content" id="pills-tabContent">
                            <div class="tab-pane fade show active" id="pills-classes" role="tabpanel" aria-labelledby="pills-classes-tab">
                                <div class="my_exercise mrgn-tp-50 mrgn-bt-30 my_exercise20">
                                    @if(Auth::user()->hasRole('Teacher'))
                                        <!--Filter part-->
                                        <div class="main_detail_fltr">
                                            <div class="title_with_shrtby">
                                                <div class="float-sm-left filtr_with_titile">
                                                    <h4 class="exersc_title">@lang('classcourse.classes_you_teach')</h4>
                                                    @if(Auth::user()->hasRole('Teacher') || Auth::user()->hasRole('Parent'))
                                                    <a href="{{route('courseclasses.courseclass.create')}}" class="creat_new ">@lang('classcourse.create_new')</a>
                                                    @endif
                                                    <a class="mrgn_lft_20 collps_fltr" data-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample"><span class="flr-i"></span></a>
                                                </div>
                                                <div class="float-sm-right short_by text-right">
                                                    <div class="short_by_select">
                                                        <label>@lang('filter.sort_by'):</label>
                                                        <select class="selectpicker" id="filter-heading">
                                                          <option value="Topic">@lang('filter.topic')</option>
                                                          <option value="Curriculum">@lang('classcourse.curriculum')</option>
                                                          <option value="Grade">@lang('filter.grade')</option>
                                                          <option value="Title">@lang('classcourse.title')</option>
                                                          <option value="CourseId">@lang('classcourse.course_id')</option>
                                                          <option value="Number of learners">@lang('filter.number_of_learners')</option>
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
                                                <input id="route_name" type="hidden" value="{{Route::current()->getName()}}">
                                                <!--Filter Form Apply-->
                                                <form id="filter-form" method="GET">
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
                                                        <ul class="demo-accordion accordionjs " data-active-index="false">
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
                                                                    <h3>@lang('classcourse.curriculum')</h3>
                                                                </div>
                                                                <div class="class-detail">
                                                                    <form  class="def_form">
                                                                        <div class="form-group">
                                                                            <div class="df-select">
                                                                                <select class="selectpicker" id="disicipline-operator">
                                                                                    <option value="0"  selected disabled>@lang('filter.select_operator')</option>
                                                                                    <option value="=">=</option>
                                                                                    <option value="like">@lang('filter.like')</option>
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
                                                                    <h3>@lang('classcourse.title') </h3>
                                                                </div>
                                                                <div class="class-detail">
                                                                    <form  class="def_form">
                                                                        <div class="form-group">
                                                                            <div class="df-select">
                                                                                <select class="selectpicker" id="title-operator">
                                                                                    <option value="0" selected disabled>@lang('filter.select_operator')</option>
                                                                                    <option value="=" >@lang('filter.equal')</option>
                                                                                    <option value="like">@lang('filter.like')</option>
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
                                                                    <h3>@lang('classcourse.course_id') </h3>
                                                                </div>
                                                                <div class="class-detail">
                                                                    <form  class="def_form">
                                                                        <div class="form-group">
                                                                            <div class="df-select">
                                                                                <input type="number" id="course_id" class="form-control">
                                                                            </div>
                                                                        </div>
                                                                        <button id="course-apply" type="button" class="btn btn-primary apply_sm_btn">@lang('filter.apply')</button>
                                                                    </form>
                                                                </div>
                                                            </li>
                                                            <li>
                                                                <div class="section_cls">
                                                                    <h3>@lang('filter.number_of_learners')</h3>
                                                                </div>
                                                                <div class="class-detail">
                                                                    <form  class="def_form">
                                                                        <div class="form-group">
                                                                            <div class="df-select">
                                                                                <select class="selectpicker" id="learner-operator">
                                                                                    <option value="0"  selected disabled>@lang('filter.select_operator')</option>
                                                                                    <option value="="> = </option>
                                                                                    <option value="<"> < </option>
                                                                                    <option value=">"> > </option>
                                                                                </select>
                                                                            </div>
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <div class="df-select">
                                                                                <input type="text" id="learner-name" class="form-control">
                                                                            </div>
                                                                        </div>
                                                                        <button id="learner-apply" type="button" class="btn btn-primary apply_sm_btn">@lang('filter.apply')</button>
                                                                    </form>
                                                                </div>
                                                            </li>
                                                            <li>
                                                                <div class="section_cls">
                                                                    <h3>@lang('filter.creation_date')</h3>
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
                                        <!--End Filter Section-->
                                    @endif
                                    <div class="list_of_exercise mrgn-tp-30">
                                    <!--new content will be displayed in here-->
                                        @if(Auth::user()->hasRole('Teacher'))
                                            <div class="row"  id="course-classes"></div>
                                        @endif
                                        <div class="list_of_exercise add_nw_exrsc">
                                            <h4 class="exersc_title">@lang('classcourse.classes_enrolled_in')</h4>
                                                <a href="{{ route('explore.classes') }}" class="creat_new">@lang('classcourse.add_new')</a>
                                                {{--  <a href="{{ route('courseclasses.courseclass.index') }}" class="creat_new">Add New</a>  --}}
                                                <div class="row">
                                                    @if(count($enroledclasses))
                                                          
                                                        @foreach($enroledclasses as $enrolledclass)
                                                        <div class="col-md-6 col-lg-6 col-xl-3 cusmize-col">
                                                            <div class="main_info">
                                                                <a href="{{ route('courseclasses.courseclass.show', [ $enrolledclass->id ])}}">
                                                                    <div class="pstn_rltv">
                                                                        <div  class="info_exercise">
                                                                            @php
                                                                                if (strlen($enrolledclass->iconurl) >0 && File::exists(public_path('assets/images/'.$enrolledclass->iconurl))) 
                                                                                    {$uimg= $enrolledclass->iconurl;}
                                                                                else
                                                                                    {$uimg= 'class_emt_img.png';}
                                                                            @endphp
                                                                            <img src="{{ asset('assets/images') }}/{{$uimg}}" class="img-fluid" dd="{{ asset('assets/images/'.$enrolledclass->iconurl)}}">
                                                                            <div class="whit_checbx">
                                                                                <div class="profile_name">
                                                                                    @if(isset($enrolledclass->teacher->user_image) && !empty($enrolledclass->teacher->user_image))
                                                                                        @if (strlen($enrolledclass->teacher->user_image) > 0 && File::exists(public_path()."/assets/images/profiles/".$enrolledclass->teacher->user_image))
                                                                                            <img  src="{{ asset('assets/images/profiles') }}/{{  $enrolledclass->teacher->user_image }}" alt="{{ $enrolledclass->teacher->name }}">
                                                                                        @else
                                                                                            <img  src="{{ asset('uploads/profile') }}/profile_img.jpg" alt="{{ $enrolledclass->teacher->name }}">
                                                                                        @endif
                                                                                    @else
                                                                                        <img  src="{{ asset('uploads/profile') }}/profile_img.jpg" alt="{{ $enrolledclass->teacher->name }}">
                                                                                    @endif
                                                                                    <p>{{$enrolledclass->teacher->name}}</p>
                                                                                </div>
                                                                            </div>
                                                                            <div class="right_gnrl_info">
                                                                                <ul class="gnrl_info float-right">
                                                                                    <li  data-toggle="tooltip" title="@lang('messages.exam')" class="check_lst_i">{{$enrolledclass->exams->count()}}</li>
                                                                                    <li  data-toggle="tooltip" title="@lang('messages.exercises')" class="list_i">{{$enrolledclass->exercises->count()}}</li>
                                                                                    <li data-toggle="tooltip" title="@lang('messages.learner')" class="user_i_i">{{$enrolledclass->learners->count()}}</li>
                                                                                </ul>
                                                                            </div>
                                                                        </div>
                                                                        <div class="request_add add_clrbl abslt_set_add">
                                                                            @Auth
                                                                                @php $user=Auth::user();
                                                                                    $islearner =$enrolledclass->learners()->where('user_id','=',$user->id)->first();
                                                                                @endphp
                                                                                @if( $islearner )
                                                                                        @if ($islearner->pivot->status=='Pending')
                                                                                            <button class="btn rqst_btn">@lang('messages.requested')</button>
                                                                                        @elseif ($islearner->pivot->status=='Accepted')
                                                                                            <button type="button" class="collbr_btn icon_approvd">@lang('messages.added')</button>

                                                                                        @elseif ($islearner->pivot->status=='Rejected')
                                                                                            <button type="button" class="btn btn-danger">@lang('messages.enrolled')</button>
                                                                                    @endif
                                                                                @else
                                                                                    <a href="#" class="requestjoin text-requestjoin btn btn-primary" onclick="requestjoin('{{route('courseclasses.courseclass.requestjpoin' ,$enrolledclass->id)}}');"><span>@lang('messages.RequesttoJoin')</span></a>
                                                                                @endif
                                                                            @endAuth
                                                                        </div>
                                                                        @guest
                                                                            <a href="{{route('courseclasses.courseclass.requestjpoin' ,[$enrolledclass->id ,1])}}" class="requestjoin text-requestjoin  btn btn-primary" ><span>@lang('messages.RequesttoJoin')</span></a>
                                                                        @endGuest
                                                                    </div>
                                                                    <ul class="title_cmbo text-ar-right">
                                                                        <li><a href="javascript:;">{{ $enrolledclass->class_name }}</a></li>
                                                                        @if (isset($enrolledclass->discipline->discipline_name))
                                                                            <li>
                                                                                <p>{{ optional($enrolledclass->discipline)->discipline_name }}</p>
                                                                            </li>
                                                                        @else
                                                                            <li>
                                                                                <span>N/A</span>
                                                                            </li>
                                                                        @endif
                                                                        @if (isset($enrolledclass->discipline->discipline_name))
                                                                            <li>
                                                                                <p>{{ optional($enrolledclass->discipline)->discipline_name }}</p>
                                                                            </li>
                                                                        @else
                                                                            <li>
                                                                                <span>N/A</span>
                                                                            </li>
                                                                        @endif

                                                                    </ul>
                                                                    <ul class="star_wth_user text-ar-right">

                                                                        <li>
                                                                            <div class="gray_star">
                                                                                <div class="orng_star" style="width: {{(@$enrolledclass->averageRating(1)[0]) * 100 / 5}}%;"></div>
                                                                            </div>
                                                                            <span class="rtng">{{@$enrolledclass->averageRating(1)[0]}}</span>
                                                                        </li>
                                                                        @if (isset($enrolledclass->grade->grade_name))
                                                                            <li>
                                                                                <span>
                                                                                        {{ str_limit(optional($enrolledclass->grade)->grade_name , '18') }}
                                                                                </span>
                                                                            </li>
                                                                        @else
                                                                            <li>
                                                                                <span>N/A</span>
                                                                            </li>
                                                                        @endif
                                                                        <li><small>{{ $enrolledclass->created_at }}</small></li>
                                                                    </ul>
                                                                </a>
                                                            </div>
                                                        </div>
                                                        @endforeach
                                                    @else
                                                    <div class="col-md-12">
                                                            <p {{--class="no_dt_title"--}}>@lang('classcourse.no_courseclasses_available')</p>
                                                            <div class="clearfix"></div><br/>
                                                            <div class="clearfix"></div><br/>
                                                    </div>
                                                    @endif
                                                </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="pills-gclass" role="tabpanel" aria-labelledby="pills-gclass-tab">
                             <div class="my_exercise mrgn-tp-50 mrgn-bt-30 my_exercise20">
                              <div class="main_detail_fltr">
                                <div class="title_with_shrtby mrgn-bt-20">
                                    <h4 class="exersc_title">@lang('classcourse.class_rooms')</h4>
                                     <!-- Google classroom--->
                                      <button id="import" class="btn btn-success imprt_google_btn">@lang('classcourse.import_gclass_btn')</button>                                                                      
                                      <button id="create" class="btn btn-primary creat_new" onclick="createCourse()">@lang('classcourse.create')</button>
                                      </div>
                                      </div>
                                      <div class="row">
                                        @if(count($googleClasses))                                              
                                            @foreach($googleClasses as $googleClass)
                                            <div class="col-md-6 col-lg-6 col-xl-3 cusmize-col">
                                                <div class="main_info">
                                                    <a href="{{ route('google.classroom.details',[$googleClass->classid]) }}" >
                                                        <div class="pstn_rltv">
                                                            <div  class="info_exercise">
                                                                {{-- <img src="{{ asset('assets/images/google/google-classroom.jpg') }}" class="img-fluid"> --}}
                                                                <img src="{{ asset('assets/images/google/googleclassroom.png') }}" class="img-fluid">
                                                                <div class="whit_checbx">
                                                                    <div class="profile_name">
                                                                        @if(isset($googleClass->teacher->user_image) && !empty($googleClass->teacher->user_image))
                                                                            @if (strlen($googleClass->teacher->user_image) > 0 && File::exists(public_path()."/assets/images/profiles/".$googleClass->teacher->user_image))
                                                                                <img  src="{{ asset('assets/images/profiles') }}/{{  $googleClass->teacher->user_image }}" alt="{{ $googleClass->teacher->name }}">
                                                                            @else
                                                                                <img  src="{{ asset('uploads/profile') }}/profile_img.jpg" alt="{{ $googleClass->teacher->name }}">
                                                                            @endif
                                                                        @else
                                                                            <img  src="{{ asset('uploads/profile') }}/profile_img.jpg" alt="{{ $googleClass->teacher->name }}">
                                                                        @endif
                                                                        <p>{{$googleClass->teacher->name}}</p>
                                                                    </div>
                                                                </div>
                                                                <div class="right_gnrl_info">
                                                                    <ul class="gnrl_info float-right">
                                                                        {{-- <li  data-toggle="tooltip" title="@lang('messages.exam')" class="check_lst_i">0</li> --}}
                                                                        <li  data-toggle="tooltip" title="Enrollment Code" class="list_i">{{$googleClass->enrollmentCode}}</li>
                                                                        {{-- <li data-toggle="tooltip" title="@lang('messages.learner')" class="user_i_i">0</li> --}}
                                                                    </ul>
                                                                    {{-- <ul class="gnrl_info float-right">
                                                                      <li data-toggle="tooltip" title="{{$googleClass->enrollmentCode}}" class=""></li>
                                                                    </ul> --}}
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <ul class="title_cmbo text-ar-right">
                                                            <li><a href="javascript:;">{{ title_case($googleClass->name) }}</a></li>
                                                            <li>{{$googleClass->section}}</li>
                                                            <li>{{$googleClass->courseState}}</li>
                                                        </ul>
                                                        <ul class="star_wth_user text-ar-right">
                                                            <li><small>{{ str_limit($googleClass->descriptionHeading, '18') }}</small></li>
                                                            <li><small>{{ str_limit($googleClass->description, '18') }}</small></li>
                                                        </ul>
                                                    </a>
                                                </div>
                                                <form id="remove_gclass_from_{{$googleClass->id}}" method="POST" action="{{route('courseclasses.google.destroy', [$googleClass->id])}}">
                                                    {{ csrf_field() }}
                                                    {{ method_field('DELETE') }}
                                                    <button class="btn my_exercises_delete" onclick="deleteconfirmFunction({{$googleClass->id}})" type="button"></button>
                                                </form>
                                            </div>
                                            @endforeach
                                        @else
                                        <div class="col-md-12">
                                                <p {{--class="no_dt_title"--}}>@lang('classcourse.no_google_available')</p>
                                                <div class="clearfix"></div><br/>
                                                <div class="clearfix"></div><br/>
                                        </div>
                                        @endif
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

  
<!-- Google classroom model-->
<div class="modal fade default_modal wht_bg_mdl" id="gclass_model" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <button type="button" id="gclasslistclose" class="close" data-dismiss="modal" aria-label="Close"></button>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="right_contnt text-ar-right">
                        <h3 id="title">@lang('classcourse.google_classroom_list')</h3>
                        <form class="def_form" id="gclass_form" method="POST" action="{{ route('courseclasses.google.import') }}">
                            {{ csrf_field() }}
                            <div class="form-group">
                                <select id="gclass_select" class="form-control">

                                </select>
                            </div>
                            <input type="hidden" id="gclass_selected" name="gclass_selected">
                            <div class="form-group">
                                <button type="submit" id="create_gclass_btn" class="btn btn-primary btn-login drk_bg_btn">@lang('classcourse.import')</button>
                            </div>
                        </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<!-- Create Google classroom model-->
<div class="modal fade default_modal wht_bg_mdl" id="gclass_create_model" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <button type="button" id="gclassclose" class="close" data-dismiss="modal" aria-label="Close"></button>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="right_contnt text-ar-right">
                        <h3>@lang('classcourse.create_google_classroom')</h3>
                        <form class="def_form" id="gclass_create_form" method="POST" action="" enctype='multipart/form-data'>
                            {{ csrf_field() }}
                            <div class="form-group">                            
                              <label>@lang('classcourse.class_name')</label>
                              <input type="text" id="classname" name="classname" class="form-control">
                            </div>
                            <div class="form-group">
                              <label>@lang('classcourse.section')</label>
                              <input type="text" id="section" name="section" class="form-control">
                            </div>
                            <div class="form-group">
                              <label>@lang('classcourse.description_heading')</label>
                              <input type="text" id="descriptionHeading" name="descriptionHeading" class="form-control">
                            </div>
                            <div class="form-group">                            
                              <label>@lang('classcourse.description')</label>
                              <textarea class="form-control" id="description" name="description"></textarea>
                            </div>
                            <div class="form-group">
                              <label>@lang('classcourse.room')</label>
                              <input type="number" id="room" name="room" class="form-control">
                            </div>
                            <div class="form-group">
                                <button type="submit" id="create_gclass_submit" class="btn btn-primary btn-login drk_bg_btn">@lang('classcourse.create')</button>
                            </div>
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
<script src="{{ asset('assets/eduplaycloud/js/accordion.js') }}"></script>
@endpush

<?php /*Load jquery to footer section*/ ?>
@push('inc_jquery')
<script src="{{ asset('assets/eduplaycloud/customs/js/block-ui/jquery.blockUI.js') }}"></script>
<script src="{{ asset('assets/eduplaycloud/customs/js/filter/classes-filter.js') }}"></script>
<script src="{{ asset('assets/eduplaycloud/customs/js/filter/save-filter.js') }}"></script>

<script src="https://apis.google.com/js/api.js"></script>
<script src="{{ asset('assets/eduplaycloud/customs/js/pages/courseclass/google-config.js') }}"></script>
<script src="{{ asset('assets/eduplaycloud/customs/js/pages/courseclass/google-class.js') }}"></script>

{{-- <script async defer src="https://apis.google.com/js/api.js"
  onload="this.onload=function(){};handleClientLoad()"
  onreadystatechange="if (this.readyState === 'complete') this.onload()">
</script> --}}


<script>
     $(window).bind("pageshow", function() { // update hidden input field 
        //$('#formid')[0].reset(); 
        $("#sort-by").val(0).selectpicker("refresh");
    });
    /*accordian*/
    jQuery(document).ready(function($){
        $(".demo-accordion").accordionjs();
    });
</script>
<script>
   $(function () {
       $('#startDate').datetimepicker({
           format: 'DD-MM-YYYY',
           maxDate: 'now'
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


   $(document).ready(function(){
    if (window.location.hash) {
        var hrf =  $('.private-lib-pills a[href="'+window.location.hash+'"]').tab('show');
    } else {
        //var hrf =  $('.summary-tbs a[href="#summary"]').tab('show');
    }
   });

   function deleteconfirmFunction(id) {
    swal({
      text: 'Are you sure to delete this?',
      icon: "warning",
      buttons: true,
      dangerMode: true,
    }).then((willDelete) => {
      if (willDelete) {
        $("#remove_gclass_from_"+id).submit();  
      }
    });   
  }

</script>
@endpush
