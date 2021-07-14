<div class="main_summery_earth pd_lf_25">
    <div class="clearfix"></div>
    <div class="name_list mrgn-bt-30">
        <h4>{{ $courseclass->class_name }}</h4>
    </div>
    <div class="row">
        <div class="col-md-12">
            <ul class="exe_tbs nav nav-pills sub-tabs class_exercises mb-3" id="pills-tab" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" id="pills-exersice-tab" data-toggle="pill" href="#pills-exersice" role="tab" aria-controls="pills-exersice" aria-selected="true">@lang('classcourse.exercise_set')</a>
                </li>
                <li class="nav-item ">
                    <a class="nav-link" id="pills-pins-tab" data-toggle="pill" href="#pills-pins" role="tab" aria-controls="pills-pins" aria-selected="false">@lang('classcourse.pins')</a>
                </li>
                {{--  <li class="nav-item m3">
                    <a class="nav-link" id="pills-study-tab" data-toggle="pill" href="#pills-study" role="tab" aria-controls="pills-study" aria-selected="false">@lang('classcourse.study_set')</a>
                </li>  --}}
            </ul>
        </div>
    </div>
    
    <div class="tab-content" id="pills-tabContent">
        <div class="tab-pane fade show active" id="pills-exersice" role="tabpanel" aria-labelledby="pills-exersice-tab">
            <div class="my_exercise mrgn-tp-20 mrgn-bt-30 tabs_publish_lf_00">
                <div class="row">
                    <div class="col-sm-12">
                        <h4 class="exersc_title">@lang('classcourse.my_exercises')</h4>
                        @if(Auth::user()->id == $courseclass->teacher_userid)
                        <a href="{{ route('exercisesets.exerciseset.private',['class_id' => $courseclass->id]) }}" class="creat_new pdng_add_btn">@lang('classcourse.Add')</a>
                        @endif
                    </div>
                </div>
                <div class="list_of_exercise mrgn-tp-20 aaa">
                    <div class="row">
                        @php

                        $courseclassexercises= $courseclass->exercises()->where([['createdby', '=', $courseclass->teacher_userid]])->get();
                        //$courseclassexercises= $courseclass->exercises()->where([['createdby', '=', Auth::user()->id]])->get();
                        @endphp
                        @if (count($courseclassexercises))
                            @foreach($courseclassexercises as $myexercise)
                                @include('courseclasses.exercise' ,$myexercise)
                            @endforeach
                        @else
                            <div class="col-md-12">
                                <p {{--class="no_dt_title"--}}>@lang('classcourse.no_library_available')</p>
                                <div class="clearfix"></div><br/>
                                <div class="clearfix"></div><br/>
                            </div>
                        @endif
                    </div>
                </div>
                <div class="list_of_exercise add_nw_exrsc">
                    <h4 class="exersc_title ">@lang('classcourse.recommended_from_public_library')</h4>
                    @if(Auth::user()->id == $courseclass->teacher_userid)
                    <a href="{{ route('explore.exerciseset',['class_id' => $courseclass->id ]) }}" class="creat_new m2">@lang('classcourse.add_recommendation')</a>
                    @endif
                        <div class="row">
                            @php
                                $courseclassPublicExercises= $courseclass->exercises()->where([['publish_status', 'like', 'public'],['createdby', '!=', $courseclass->teacher_userid]])->get();
                                //$courseclassPublicExercises= $courseclass->exercises()->where([['publish_status', 'like', 'public'],['createdby', '!=', Auth::user()->id]])->get();
                            @endphp
                            @if (count($courseclassPublicExercises))
                                @foreach($courseclassPublicExercises as $publicExercise)
                                    @include('courseclasses.public_exercies' ,$publicExercise)
                                @endforeach
                            @else
                                <div class="col-md-12">
                                    <p {{-- class="no_dt_title" --}}>@lang('classcourse.no_public_library_available')</p>
                                    <div class="clearfix"></div><br/>
                                    <div class="clearfix"></div><br/>
                                </div>
                            @endif
                        </div>
                </div>
            </div>
        </div>
        <div class="tab-pane fade" id="pills-pins" role="tabpanel" aria-labelledby="pills-pins-tab">
            <div class="my_exercise mrgn-tp-20 mrgn-bt-30 tabs_publish_lf_00">
                <div class="row">
                    <div class="col-sm-12">
                        {{--  Filter code started  --}}
                        <div class="main_detail_fltr">
                            <div class="title_with_shrtby">
                                <div class="float-sm-left filtr_with_titile">
                                        <h4 class="exersc_title">@lang('classcourse.pins')</h4>
                                        @if(Auth::user()->id == $courseclass->teacher_userid)
                                        <a href="#"  data-toggle="modal"
                                        data-target="#create_pin" data-dismiss="modal" class="creat_new"> @lang('exercisesets.create_new')</a>
                                        @endif
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
                                        <input type="hidden" name="classId" value="{{ $courseclass->id }}">
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
                        {{--  Filter code end  --}}
                        @include('eduplaycloud.users.private-library.pins')
                        {{--  <div style="float: right;">{{ $pins->links() }}</div>  --}}
                    </div>
                </div>
            </div>
            {{--  <div class="tab-pane fade" id="pills-study" role="tabpanel" aria-labelledby="pills-study-tab">
                Study Set
            </div>  --}}
        </div>
        @include("eduplaycloud.pin_form",$courseclass)
    </div>
</div>