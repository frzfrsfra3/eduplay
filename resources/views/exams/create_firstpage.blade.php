@extends('authenticated.layouts.default')
<?php /*Load jquery to footer section*/ ?>
@push('inc_css')
    <link rel="stylesheet" href="{{ asset('assets/eduplaycloud/customs/jquery-steps/jquery.steps.css')}}" type="text/css" media="all">
@endpush
@section('content')
    <!---Content-->
    <div class="work_page mrgn_top_secn exercesi_block mrgn-bt-70 text-ar-right">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-12">
                    <nav aria-label="tp-breadcm" class="tp-breadcm">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('exams.exam.index') }}">@lang('exam.my_exams')</a></li>
                        <li class="breadcrumb-item active" aria-current="page">@lang('exam.create_exam')</li>
                    </ol>
                    </nav>
                    <div id="flashMsg"></div>
                    <div class="content mrgn-tp-20">
                        <!--Topics Filter Form Apply-->
                        <form id="topic-filter-form" method="GET">
                            <input type="hidden" name="id" id="descipline_id_1" value="">
                            <div id="topic_filter_input">

                            </div>
                        </form>
                        <!--Topics End filer form-->

                        <!-- curriculum Filter Form Apply-->
                        <form id="curriculum-filter-form" method="GET">
                            <input name="getexamId" class="examId" type="hidden" value="">
                            <input type="hidden" name="req_topic_id" id="req_topic_id" value="">
                            <div id="curriculum_filter_input">

                            </div>
                        </form>
                        <!-- curriculum Filter Form Apply-->

                        <!--Exercise Filter Form Apply-->
                        <form id="exercise-filter-form" method="GET">
                            <input type="hidden" name="id" id="descipline_id" value="">
                            <input name="getexamId" class="examId" type="hidden" value="">
                            <div id="exercise_filter_input">

                            </div>
                        </form>
                         <!--Exercise End filer form-->

                        <!--Skill Filter Form Apply-->
                        <form id="skill-filter-form" method="GET">
                            <input type="hidden" name="exercise_id" id="checked_exercise" value="">
                            <input name="getexamId" class="examId" type="hidden" value="">
                            <div id="skill_filter_input">

                            </div>
                        </form>
                        <!--Skill End filer form-->

                        <!--Question Filter Form Apply-->
                        <form id="question-filter-form" method="GET">
                            <input type="hidden" name="skillcat_id" id="skillcat_id" value="">
                            <input type="hidden" name="noofquestion" id="noofquestion" value="">
                            <input type="hidden" name="getexamId" class="examId" value="">
                            <input type="hidden" name="selectedQuestionId" id="selectedQuestionId" value="">
                            <div id="question_filter_input">

                            </div>
                        </form>
                        <!--Question End filer form-->


                        <form id="create_exam_form" action="{{ route('exams.exam.store',$classId) }}"  method="post" >
                            @csrf
                            <input name="_method" type="hidden" value="PUT">
                            {{--  @if($examID != 'class')
                                <input name="exam_id" class="examId" id="examId" type="hidden"
                                @if(isset($examID)) value="{{$examID}}" @else value="" @endif
                                />
                            @else
                                <input name="exam_id" class="examId" id="examId" type="hidden"
                             value="" />
                            @endif  --}}

                            <input name="exam_id" class="examId" id="examId" type="hidden"
                                @if(isset($examID)) value="{{$examID}}" @else value="" @endif
                                />

                            @if(isset($examID))
                            <input name="action" id="action" type="hidden" value="{{$examID}}">
                            @endif
                            <div>
                                <h3>@lang("exam.select_topic_s1")</h3>
                                <section>
                                    <!--Filter part-->
                                    <div class="main_detail_fltr pad_lfsd_15">
                                        <div class="title_with_shrtby">
                                            <div class="float-sm-left filtr_with_titile">
                                                <a class="mrgn_lft_20 collps_fltr" data-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample"><span class="flr-i"></span></a>
                                            </div>
                                            <div class="float-sm-right short_by text-right">
                                                <div class="short_by_select">
                                                    <label> @lang('filter.sort_by') : </label>
                                                    <select class="selectpicker" id="sort-by">
                                                        <option value="Ascending">@lang("filter.ascending") </option>
                                                        <option value="Descending">@lang("filter.descending") </option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="clearfix"></div>
                                        <div class="list_of_filter collapse" id="collapseExample">
                                            <div class="card card-body">

                                                <div class="mani_menu_list">
                                                    <div class="float-left">
                                                        <a class="open_filter" href="javascript:;"><i class="plus_icn"></i></a>
                                                        <ul class="studnt_list_nm" id="topic-fltered-text-list">
                                                            <!--Filter text append here-->
                                                        </ul>
                                                    </div>
                                                    <div class="float-right clear_all_cls">
                                                        <a href="javascript:;" id="exam_clear_all_btn" class="clear_all_btn">@lang('filter.clear_all')</a>
                                                    </div>
                                                </div>

                                                <div class="slct_drop_box">
                                                    <ul class="demo-accordion accordionjs " data-active-index="false">
                                                        <li>
                                                            <div class="section_cls">
                                                                <h3>@lang("filter.title")</h3>
                                                            </div>
                                                            <div class="class-detail">
                                                                <div class="def_form">
                                                                    <div class="form-group">
                                                                        <div class="df-select">
                                                                            <select class="selectpicker" id="title-operator">
                                                                                <option value="0" selected disabled>@lang("filter.select_operator")</option>
                                                                                <option value="=">@lang("filter.equal")</option>
                                                                                <option value="like">@lang("filter.contains")</option>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group ">
                                                                        <div class="df-select">
                                                                            <input type="text" id="title-name" class="form-control">
                                                                        </div>
                                                                    </div>
                                                                    <button id="title-apply" type="button" class="btn btn-primary apply_sm_btn">@lang("filter.apply")</button>
                                                                </div>
                                                            </div>
                                                        </li>
                                                        {{--  <li>
                                                            <div class="section_cls">
                                                                <h3>@lang('filter.language')</h3>
                                                            </div>
                                                            <div class="class-detail">
                                                                <div class="def_form">
                                                                    <div class="form-group">
                                                                        <div class="df-select">
                                                                            <select class="selectpicker" id="language-name">
                                                                                <option value="0" selected disabled>@lang('filter.select_language')</option>
                                                                                @foreach ($languages as $language)
                                                                                    <option value="{{$language->id}}"> {{$language->language}} </option>
                                                                                @endforeach
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                    <button id="language-apply" type="button" class="btn btn-primary apply_sm_btn">@lang('filter.apply')</button>
                                                                </div>
                                                            </div>
                                                        </li>  --}}
                                                        <li>
                                                            <div class="section_cls">
                                                                <h3>@lang('filter.number_of_exercise_set')</h3>
                                                            </div>
                                                            <div class="class-detail">
                                                                <div class="def_form">
                                                                    <div class="form-group">
                                                                        <div class="df-select">
                                                                            <select class="selectpicker" id="exercisesets-operator">
                                                                                <option value="0"  selected disabled>@lang('filter.select_operator')</option>
                                                                                <option value="="> = </option>
                                                                                <option value="<"> < </option>
                                                                                <option value=">"> > </option>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <div class="df-select">
                                                                            <input type="text" id="exercisesets-name" class="form-control">
                                                                        </div>
                                                                    </div>
                                                                    <button id="exercisesets-apply" type="button" class="btn btn-primary apply_sm_btn">@lang('filter.apply')</button>
                                                                </div>
                                                            </div>
                                                        </li>
                                                        <li>
                                                            <div class="section_cls">
                                                                <h3>@lang('filter.number_of_curriculum')</h3>
                                                            </div>
                                                            <div class="class-detail">
                                                                <div  class="def_form">
                                                                    <div class="form-group">
                                                                        <div class="df-select">
                                                                            <select class="selectpicker" id="curriculum-operator">
                                                                                <option value="0"  selected disabled>@lang('filter.select_operator')</option>
                                                                                <option value="="> = </option>
                                                                                <option value="<"> < </option>
                                                                                <option value=">"> > </option>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <div class="df-select">
                                                                            <input type="text" id="topic_curriculum_name" class="form-control">
                                                                        </div>
                                                                    </div>
                                                                    <button id="curriculum-apply" type="button" class="btn btn-primary apply_sm_btn">@lang('filter.apply')</button>
                                                                </div>
                                                            </div>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!--End Filter Section-->
                                    @include('exams.disciplines')
                                </section>
                                <h3>@lang("exam.select_discipline_s2")</h3>
                                <section>
                                    <!--Filter part-->
                                    <div class="main_detail_fltr pad_lfsd_15">
                                        <div class="title_with_shrtby">
                                            <div class="float-sm-left filtr_with_titile">
                                                <a class="mrgn_lft_20 collps_fltr" data-toggle="collapse" href="#discipline_collapseExample" role="button" aria-expanded="false" aria-controls="discipline_collapseExample"><span class="flr-i"></span></a>
                                            </div>
                                            <div class="float-sm-right short_by text-right">
                                                <div class="short_by_select">
                                                    <label> @lang('filter.sort_by') : </label>
                                                    <select class="selectpicker" id="curriculum-sort-by">
                                                        <option value="Ascending">@lang("filter.ascending") </option>
                                                        <option value="Descending">@lang("filter.descending") </option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="clearfix"></div>
                                        <div class="list_of_filter collapse" id="discipline_collapseExample">
                                            <div class="card card-body">
                                                <div class="mani_menu_list">
                                                    <div class="float-left">
                                                        <a class="open_filter" href="javascript:;"><i class="plus_icn"></i></a>
                                                        <ul class="studnt_list_nm" id="curriculum-fltered-text-list">
                                                            <!--Filter text append here-->
                                                        </ul>
                                                    </div>
                                                    <div class="float-right clear_all_cls">
                                                        <a href="javascript:;" id="curriculum_exam_clear_all_btn" class="clear_all_btn">@lang('filter.clear_all')</a>
                                                    </div>
                                                </div>

                                                <div class="slct_drop_box">
                                                    <ul class="demo-accordion accordionjs " data-active-index="false">
                                                        <li>
                                                            <div class="section_cls">
                                                                <h3>@lang('filter.name')</h3>
                                                            </div>
                                                            <div class="class-detail">
                                                                <div class="def_form">
                                                                    <div class="form-group">
                                                                        <div class="df-select">
                                                                            <select class="selectpicker" id="name-operator">
                                                                                <option value="0">@lang('filter.select_operator')</option>
                                                                                <option value="=" >@lang('filter.equal')</option>
                                                                                <option value="like">@lang('filter.contains')</option>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <div class="df-select">
                                                                            <input type="text" id="name" class="form-control">
                                                                        </div>
                                                                    </div>
                                                                    <button id="name-apply" type="button" class="btn btn-primary apply_sm_btn">@lang('filter.apply')</button>
                                                                </div>
                                                            </div>
                                                        </li>
                                                        {{--  <li>
                                                            <div class="section_cls">
                                                                <h3>@lang('filter.language')</h3>
                                                            </div>
                                                            <div class="class-detail">
                                                                <div class="def_form">
                                                                    <div class="form-group">
                                                                        <div class="df-select">
                                                                            <select class="selectpicker" id="curriculum-language-name">
                                                                                <option value="0" selected disabled>@lang('filter.select_language')</option>
                                                                                @foreach ($languages as $language)
                                                                                    <option value="{{$language->id}}"> {{$language->language}} </option>
                                                                                @endforeach
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                    <button id="curriculul-language-apply" type="button" class="btn btn-primary apply_sm_btn">@lang('filter.apply')</button>
                                                                </div>
                                                            </div>
                                                        </li>  --}}
                                                        <li>
                                                            <div class="section_cls">
                                                                <h3>@lang('filter.topic')</h3>
                                                            </div>
                                                            <div class="class-detail">
                                                                <div class="def_form">
                                                                    <div class="form-group">
                                                                        <div class="df-select">
                                                                            <select class="selectpicker" id="topic-operator">
                                                                                <option value="0"  selected disabled>@lang('filter.select_operator')</option>
                                                                                <option value="=">=</option>
                                                                                <option value="like">@lang('filter.like')</option>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <div class="df-select">
                                                                            <input type="text" id="topic-name" class="form-control">
                                                                        </div>
                                                                    </div>
                                                                    <button id="topic-apply" type="button" class="btn btn-primary apply_sm_btn">@lang('filter.apply')</button>
                                                                </div>
                                                            </div>
                                                        </li>
                                                        <li>
                                                            <div class="section_cls">
                                                                <h3>@lang('filter.number_of_exercise_set')</h3>
                                                            </div>
                                                            <div class="class-detail">
                                                                <div  class="def_form">
                                                                    <div class="form-group">
                                                                        <div class="df-select">
                                                                            <select class="selectpicker" id="curriculum-exercisesets-operator">
                                                                                <option value="0"  selected disabled>@lang('filter.select_operator')</option>
                                                                                <option value="="> = </option>
                                                                                <option value="<"> < </option>
                                                                                <option value=">"> > </option>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <div class="df-select">
                                                                            <input type="text" id="curriculum-exercisesets-name" class="form-control">
                                                                        </div>
                                                                    </div>
                                                                    <button id="curriculum-exercisesets-apply" type="button" class="btn btn-primary apply_sm_btn">@lang('filter.apply')</button>
                                                                </div>
                                                            </div>
                                                        </li>
                                                        <li>
                                                            <div class="section_cls">
                                                                <h3>@lang('filter.number_of_classes')</h3>
                                                            </div>
                                                            <div class="class-detail">
                                                                <div class="def_form">
                                                                    <div class="form-group">
                                                                        <div class="df-select">
                                                                            <select class="selectpicker" id="classes-operator">
                                                                                <option value="0"  selected disabled>@lang('filter.select_operator')</option>
                                                                                <option value="="> = </option>
                                                                                <option value="<"> < </option>
                                                                                <option value=">"> > </option>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <div class="df-select">
                                                                            <input type="text" id="classes-name" class="form-control">
                                                                        </div>
                                                                    </div>
                                                                    <button id="classes-apply" type="button" class="btn btn-primary apply_sm_btn">@lang('filter.apply')</button>
                                                                </div>
                                                            </div>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!--End Filter Section-->
                                    <div class="clearfix"></div>
                                    <div id="DisciplinesHTML">

                                    </div>
                                </section>
                                <h3>@lang('exam.select_Exercisesets_s3')</h3>
                                <section>
                                     <!--Filter Form Apply-->
                                        <div class="main_detail_fltr">
                                            <div class="title_with_shrtby">
                                                <div class="float-sm-left filtr_with_titile">
                                                    <a class="mrgn_lft_20 collps_fltr" data-toggle="collapse" href="#exerciseCollapseExample" role="button" aria-expanded="false" aria-controls="exerciseCollapseExample"><span class="flr-i"></span></a>
                                                </div>
                                                <div class="float-sm-right short_by text-right">
                                                    <div class="short_by_select">
                                                        <label>@lang('filter.sort_by_title') :</label>
                                                        <select class="selectpicker" id="exercise-sort-by">
                                                            <option value="Ascending">@lang('filter.ascending')</option>
                                                            <option value="Descending">@lang('filter.descending')</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="clearfix"></div>
                                            <div class="list_of_filter collapse" id="exerciseCollapseExample">
                                                <div class="card card-body">

                                                <div class="mani_menu_list">
                                                    <div class="float-left">
                                                        <a class="open_filter" href="javascript:;"><i class="plus_icn"></i></a>
                                                        <ul class="studnt_list_nm" id="exercise-fltered-text-list">
                                                            <!--Filter text append here-->
                                                        </ul>
                                                    </div>
                                                    <div class="float-right clear_all_cls">
                                                        <a href="javascript:;" id="exercise_clear_all_btn" class="clear_all_btn">@lang('filter.clear_all')</a>
                                                    </div>
                                                </div>
                                                <div class="slct_drop_box">
                                                    <ul class="demo-accordion accordionjs " data-active-index="false">
                                                        <li>
                                                            <div class="section_cls">
                                                                <h3>@lang('filter.title')</h3>
                                                            </div>
                                                            <div class="class-detail">
                                                                <div class="def_form">
                                                                    <div class="form-group">
                                                                        <div class="df-select">
                                                                            <select class="selectpicker" id="exercise-title-operator">
                                                                                <option value="0" selected disabled>@lang('filter.select_operator')</option>
                                                                                <option value="=" >@lang('filter.equal')</option>
                                                                                <option value="like">@lang('filter.contains')</option>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <div class="df-select">
                                                                            <input type="text" id="exercise-title-name" class="form-control">
                                                                        </div>
                                                                    </div>
                                                                    <button id="exercise-title-apply" type="button" class="btn btn-primary apply_sm_btn">@lang('filter.apply')</button>
                                                                </div>
                                                            </div>
                                                        </li>
                                                        <li>
                                                            <div class="section_cls">
                                                                <h3>@lang('filter.publish_date')</h3>
                                                            </div>
                                                            <div class="class-detail">
                                                                <div  class="def_form">
                                                                    <div class="form-group">
                                                                        <div class="df-select">
                                                                            <input type="text" class="form-control" placeholder="@lang('filter.start_date')" name="startDate" id="exercise-startDate">
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <div class="df-select">
                                                                            <input type="text" class="form-control" placeholder="@lang('filter.end_date')" name="endDate" id="exercise-endDate">
                                                                        </div>
                                                                    </div>
                                                                    <button id="exercise-created-date-apply" type="button" class="btn btn-primary apply_sm_btn">@lang('filter.apply')</button>
                                                                </div>
                                                            </div>
                                                        </li>
                                                        {{-- <li>
                                                            <div class="section_cls">
                                                                <h3>@lang('filter.curriculum')</h3>
                                                            </div>
                                                            <div class="class-detail">
                                                                <div  class="def_form">
                                                                    <div class="form-group">
                                                                        <div class="df-select">
                                                                            <select class="selectpicker" id="exercise-disicipline-operator">
                                                                                <option value="0"  selected disabled>@lang('filter.select_operator')</option>
                                                                                <option value="=">=</option>
                                                                                <option value="like">@lang('filter.like')</option>
                                                                                <option value="na">@lang('filter.n/a')</option>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <div class="df-select">
                                                                            <input type="text" id="exercise-disicipline-name" class="form-control">
                                                                        </div>
                                                                    </div>
                                                                    <button id="exercise-disicipline-apply" type="button" class="btn btn-primary apply_sm_btn">@lang('filter.apply')</button>
                                                                </div>
                                                            </div>
                                                        </li> --}}
                                                        <li>
                                                            <div class="section_cls">
                                                                <h3>@lang('filter.grade')</h3>
                                                            </div>
                                                            <div class="class-detail">
                                                                <div  class="def_form">
                                                                    <div class="form-group">
                                                                        <div class="df-select">
                                                                            <select class="selectpicker" id="exercise-grade-operator">
                                                                                <option value="0"  selected disabled>@lang('filter.select_operator')</option>
                                                                                <option>=</option>
                                                                                <option value="like">@lang('filter.like')</option>
                                                                                <option value="na">@lang('filter.n/a')</option>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <div class="df-select">
                                                                            <input type="text" id="exercise-grade-name" class="form-control">
                                                                        </div>
                                                                    </div>
                                                                    <button id="exercise-grade-apply" type="button" class="btn btn-primary apply_sm_btn">@lang('filter.apply')</button>
                                                                </div>
                                                            </div>
                                                        </li>
                                                        <li>
                                                            <div class="section_cls">
                                                                <h3>@lang('filter.number_of_questions')</h3>
                                                            </div>
                                                            <div class="class-detail">
                                                                <div  class="def_form">
                                                                    <div class="form-group">
                                                                        <div class="df-select">
                                                                            <select class="selectpicker" id="exercise-question-operator">
                                                                                <option value="0"  selected disabled>@lang('filter.select_operator')</option>
                                                                                <option value="="> = </option>
                                                                                <option value="<"> < </option>
                                                                                <option value=">"> > </option>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <div class="df-select">
                                                                            <input type="text" id="exercise-question-name" class="form-control">
                                                                        </div>
                                                                    </div>
                                                                    <button id="exercise-question-apply" type="button" class="btn btn-primary apply_sm_btn">@lang('filter.apply')</button>
                                                                </div>
                                                            </div>
                                                        </li>
                                                        <li>
                                                            <div class="section_cls">
                                                                <h3>@lang('filter.number_of_student')</h3>
                                                            </div>
                                                            <div class="class-detail">
                                                                <div class="def_form">
                                                                    <div class="form-group">
                                                                        <div class="df-select">
                                                                            <select class="selectpicker" id="exercise-buyer-operator">
                                                                                <option value="0"  selected disabled>@lang('filter.select_operator')</option>
                                                                                <option value="="> = </option>
                                                                                <option value="<"> < </option>
                                                                                <option value=">"> > </option>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <div class="df-select">
                                                                            <input type="text" id="exercise-buyer-name" class="form-control">
                                                                        </div>
                                                                    </div>
                                                                    <button id="exercise-buyer-apply" type="button" class="btn btn-primary apply_sm_btn">@lang('filter.apply')</button>
                                                                </div>
                                                            </div>
                                                        </li>
                                                        <li>
                                                            <div class="section_cls">
                                                                <h3>@lang('filter.rating')</h3>
                                                            </div>
                                                            <div class="class-detail">
                                                                <div  class="def_form">
                                                                    <div class="form-group">
                                                                        <div class="df-select">
                                                                            <select class="selectpicker" id="exercise-rating-name">
                                                                                <option value="0"  selected disabled>@lang('filter.select_operator')</option>
                                                                                <option data-content="&lt;i class=&#039;fa fa-star&#039;&gt;&lt;/i&gt;" value="1.0"></option>
                                                                                <option data-content="&lt;i class=&#039;fa fa-star&#039;&gt;&lt;/i&gt;&lt;i class=&#039;fa fa-star&#039;&gt;&lt;/i&gt;" value="2.0"></option>
                                                                                <option data-content="&lt;i class=&#039;fa fa-star&#039;&gt;&lt;/i&gt;&lt;i class=&#039;fa fa-star&#039;&gt;&lt;/i&gt;&lt;i class=&#039;fa fa-star&#039;&gt;&lt;/i&gt;" value="3.0"></option>
                                                                                <option data-content="&lt;i class=&#039;fa fa-star&#039;&gt;&lt;/i&gt;&lt;i class=&#039;fa fa-star&#039;&gt;&lt;/i&gt;&lt;i class=&#039;fa fa-star&#039;&gt;&lt;/i&gt;&lt;i class=&#039;fa fa-star&#039;&gt;&lt;/i&gt;" value="4.0"></option>
                                                                                <option data-content="&lt;i class=&#039;fa fa-star&#039;&gt;&lt;/i&gt;&lt;i class=&#039;fa fa-star&#039;&gt;&lt;/i&gt;&lt;i class=&#039;fa fa-star&#039;&gt;&lt;/i&gt;&lt;i class=&#039;fa fa-star&#039;&gt;&lt;/i&gt;&lt;i class=&#039;fa fa-star&#039;&gt;&lt;/i&gt;" value="5.0"></option>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                    <button id="exercise-rating-apply" type="button" class="btn btn-primary apply_sm_btn">@lang('filter.apply')</button>
                                                                </div>
                                                            </div>
                                                        </li>    
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="clearfix"></div>
                                    <div class="list_of_exercise mrgn-tp-30">
                                        <div class="row" id="ExercisessetsHTML">

                                        </div>
                                    </div>
                                </section>
                                <h3>@lang("exam.select_skill_categories_s4")</h3>
                                <section>
                                    <!--Filter Form Apply-->
                                    <div class="main_detail_fltr">
                                        <div class="title_with_shrtby">
                                            <div class="float-sm-left filtr_with_titile">
                                                <a class="mrgn_lft_20 collps_fltr" data-toggle="collapse" href="#skill_collapseExample" role="button" aria-expanded="false" aria-controls="skill_collapseExample"><span class="flr-i"></span></a>
                                            </div>
                                            <div class="float-sm-right short_by text-right">
                                                <div class="short_by_select">
                                                    <label>@lang('filter.sort_by_title') :</label>
                                                    <select class="selectpicker" id="skill_sort-by">
                                                        <option value="Ascending">@lang('filter.ascending')</option>
                                                        <option value="Descending">@lang('filter.descending')</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="clearfix"></div>
                                        <div class="list_of_filter collapse" id="skill_collapseExample">
                                            <div class="card card-body">

                                                <div class="mani_menu_list">
                                                    <div class="float-left">
                                                        <a class="open_filter" href="javascript:;"><i class="plus_icn"></i></a>
                                                        <ul class="studnt_list_nm" id="fltered-text-list">
                                                            <!--Filter text append here-->
                                                        </ul>
                                                    </div>
                                                    <div class="float-right clear_all_cls">
                                                        <a href="javascript:;" id="clear_all_btn" class="skill_clear_all_btn clear_all_btn">@lang('filter.clear_all')</a>
                                                    </div>
                                                </div>
                                            

                                                <div class="slct_drop_box">
                                                    <ul class="demo-accordion accordionjs " data-active-index="false">
                                                        <li>
                                                            <div class="section_cls">
                                                                <h3>@lang('filter.title')</h3>
                                                            </div>
                                                            <div class="class-detail">
                                                                <div class="def_form">
                                                                    <div class="form-group">
                                                                        <div class="df-select">
                                                                            <select class="selectpicker" id="skill-title-operator">
                                                                                <option value="0" selected disabled>@lang('filter.select_operator')</option>
                                                                                <option value="=" >@lang('filter.equal')</option>
                                                                                <option value="like">@lang('filter.contains')</option>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <div class="df-select">
                                                                            <input type="text" id="skill-title-name" class="form-control">
                                                                        </div>
                                                                    </div>
                                                                    <button id="skill-title-apply" type="button" class="btn btn-primary apply_sm_btn">@lang('filter.apply')</button>
                                                                </div>
                                                            </div>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="clearfix"></div>
                                    <div class="" id="skillCatListHTML">

                                    </div>
                                </section>
                                <h3>@lang("exam.select_question_s5")</h3>
                                <section>
                                    <div class="main_detail_fltr">
                                        <div class="title_with_shrtby">
                                            <div class="float-sm-left filtr_with_titile">
                                                {{-- <a class="creat_new" data-toggle="modal" data-target="#question_modal">Add More Questions</a> --}}
                                                <button type="button" id="add_more_question_btn" class="creat_new">Add More Questions</button>
                                                <a class="mrgn_lft_20 collps_fltr" data-toggle="collapse" href="#question_collapseExample" role="button" aria-expanded="false" aria-controls="question_collapseExample"><span class="flr-i"></span></a>
                                            </div>
                                            <div class="float-sm-right short_by text-right">
                                                <div class="short_by_select">
                                                    <label>@lang('filter.sort_by_title') :</label>
                                                    <select class="selectpicker" id="question-sort-by">
                                                        <option value="Ascending">@lang('filter.ascending')</option>
                                                        <option value="Descending">@lang('filter.descending')</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="clearfix"></div>
                                        <div class="list_of_filter collapse" id="question_collapseExample">
                                            <div class="card card-body">

                                                <div class="mani_menu_list">
                                                    <div class="float-left">
                                                        <a class="open_filter" href="javascript:;"><i class="plus_icn"></i></a>
                                                        <ul class="studnt_list_nm" id="question-fltered-text-list">
                                                            <!--Filter text append here-->
                                                        </ul>
                                                    </div>
                                                    <div class="float-right clear_all_cls">
                                                        <a href="javascript:;" id="question_clear_all_btn" class="clear_all_btn">@lang('filter.clear_all')</a>
                                                    </div>
                                                </div>

                                                <div class="slct_drop_box">
                                                        <ul class="demo-accordion accordionjs " data-active-index="false">
                                                        <li>
                                                            <div class="section_cls">
                                                                <h3>@lang('filter.title')</h3>
                                                            </div>
                                                            <div class="class-detail">
                                                                <div  class="def_form">
                                                                    <div class="form-group">
                                                                        <div class="df-select">
                                                                            <select class="selectpicker" id="question-details-operator">
                                                                                <option value="0" selected disabled>@lang('filter.select_operator')</option>
                                                                                <option value="=" >@lang('filter.equal')</option>
                                                                                <option value="like">@lang('filter.contains')</option>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <div class="df-select">
                                                                            <input type="text" id="question-details-name" class="form-control">
                                                                        </div>
                                                                    </div>
                                                                    <button id="question-details-apply" type="button" class="btn btn-primary apply_sm_btn">@lang('filter.apply')</button>
                                                                </div>
                                                            </div>
                                                        </li>
                                                        <li>
                                                            <div class="section_cls">
                                                                <h3>@lang('filter.minimum_time')</h3>
                                                            </div>
                                                            <div class="class-detail">
                                                                <div  class="def_form">
                                                                    <div class="form-group">
                                                                        <div class="df-select">
                                                                            <select class="selectpicker" id="question-min-time-operator">
                                                                                <option value="0"  selected disabled>@lang('filter.select_operator')</option>
                                                                                <option value="="> = </option>
                                                                                <option value=">"> > </option>
                                                                                <option value="<"> < </option>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <div class="df-select">
                                                                            <input type="text" id="question-min-time-name" class="form-control">
                                                                        </div>
                                                                    </div>
                                                                    <button id="question-min-time-apply" type="button" class="btn btn-primary apply_sm_btn">@lang('filter.apply')</button>
                                                                </div>
                                                            </div>
                                                        </li>
                                                        <li>
                                                            <div class="section_cls">
                                                                <h3>@lang('filter.maximum_time')</h3>
                                                            </div>
                                                            <div class="class-detail">
                                                                <div  class="def_form">
                                                                    <div class="form-group">
                                                                        <div class="df-select">
                                                                            <select class="selectpicker" id="question-max-time-operator">
                                                                                <option value="0"  selected disabled>@lang('filter.select_operator')</option>
                                                                                <option value="="> = </option>
                                                                                <option value=">"> > </option>
                                                                                <option value="<"> < </option>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <div class="df-select">
                                                                            <input type="text" id="question-max-time-name" class="form-control">
                                                                        </div>
                                                                    </div>
                                                                    <button id="question-max-time-apply" type="button" class="btn btn-primary apply_sm_btn">@lang('filter.apply')</button>
                                                                </div>
                                                            </div>
                                                        </li>
                                                        <li>
                                                            <div class="section_cls">
                                                                <h3>@lang('filter.difficulty_level')</h3>
                                                            </div>
                                                            <div class="class-detail">
                                                                <div  class="def_form">
                                                                    <div class="form-group">
                                                                        <div class="df-select">
                                                                            <select class="selectpicker" id="question-difficuly-name">
                                                                                <option value="0"  selected disabled>@lang('filter.select_operator')</option>
                                                                                <option value="easy"> @lang('filter.easy') </option>
                                                                                <option value="medium">  @lang('filter.medium') </option>
                                                                                <option value="hard">  @lang('filter.hard') </option>
                                                                            </select>
                                                                        </div>
                                                                    </div>

                                                                    <button id="question-difficuly-apply" type="button" class="btn btn-primary apply_sm_btn">@lang('filter.apply')</button>
                                                                </div>
                                                            </div>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="clearfix"></div>
                                    <div class="row" id="questionListHTML">

                                    </div>
                                </section>
                                <h3>@lang('exam.exam_details')</h3>
                                <section>
                                    <div id="selQuestionListHTML">

                                    </div>
                                </section>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!---End Content-->
@endsection

<?php /*Load jquery to footer section*/ ?>
@push('inc_script')
    <script src="{{ asset('assets/eduplaycloud/customs/js/filter/exam-topic-filter.js') }}"></script>
    <script src="{{ asset('assets/eduplaycloud/js/accordion.js') }}"></script>
    <script src="{{ asset('assets/eduplaycloud/customs/jquery-steps/jquery.steps.min.js') }}"></script>
    @include('authenticated.includes.render_script')
@endpush

<?php /*Load jquery to footer section*/ ?>
@push('inc_jquery')
<script type="text/javascript">

    $(document).ready(function () {
        // Onload checkbox checked on edit
        if($('.selectedTopic').not(':checked').length == 0){
            $('#selectallTopic').attr( 'checked', true );
        }
        // Select all Topic
        $(document).on('click','#selectallTopic',function(){
            $('.selectedTopic').prop('checked', this.checked);
        });
        // Select all discipline
        $('#selectallDiscipline').click(function () {
            $('.selectedDiscipline').prop('checked', this.checked);
        });

        $(document).on('click','.selectedTopic',function(){
            var check = ($('.selectedTopic').filter(":checked").length == $('.selectedTopic').length);
            $('#selectallTopic').prop("checked", check);
        });

    // Multi steps
    var form = $("#create_exam_form");
    form.validate({
        errorPlacement: function errorPlacement(error, element) { element.before(error); },
        rules: {
            selectedId: {
                required: true,
            },
            /*disciplineId: {
                required: true,
            },*/
            exercisesId: {
                required: true,
            },
            skillCatLists: {
                required: true,
            },
            questions: {
                required: true,
            },
            examtype: {
                required: true,
            },
            title: {
                required: true,
                maxlength: 30,
            },
        },
        messages: {
            selectedId:  "",
            //disciplineId:  "",
            exercisesId:  "",
            skillCatLists:  "",
            questions:  "",
        },
        errorPlacement: function(error, element) {
            if (element.attr("type") == "checkbox") {
                error.insertBefore($(element).parents('.desipline_list'));
            }
             else {
                error.insertAfter(element);
            }
            if(element.attr("name") == "exercisesId"){
                error.insertBefore($(element).parents('#ExercisessetsHTML'));
            }
            if(element.attr("name") == "skillCatLists"){
                error.insertBefore($(element).parents('#skillCatListHTML'));
            }
            if(element.attr("name") == "questions"){
                error.insertBefore($(element).parents('#questionListHTML'));
            }
        },
    });
    form.children("div").steps({
        headerTag: "h3",
        bodyTag: "section",
        transitionEffect: "slideLeft",
        onStepChanging: function (event, currentIndex, newIndex)
        {
            //console.log('cI: '+currentIndex+', nI: '+newIndex);

            if(currentIndex === 0 & newIndex === 1){
                var chkTopicAvl = $('#notopic').val();
                if(chkTopicAvl != 0){
                    // custome validation
                    if ($('.selectedTopic').not(":checked")){
                        var msg = message['please_select_at_least_one_topic'];
                        customMsg(msg);
                    }
                    var checkboxValues = [];
                    $('input[name="selectedId"]:checked').each(function(index, elem) {
                        $('#flashMsg').html('');
                        checkboxValues.push($(elem).val());
                    });
                    $('#req_topic_id').val(checkboxValues)
                    getCurriculam(checkboxValues);
                } else {
                    $('#flashMsg').html('');
                    $('#flashMsg').html('<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert">&times;</button>Selected discipline do not have any Curriculums.</div>');
                    return false;
                }
            }
            if(currentIndex === 1 & newIndex === 2){
                var chkExeAvl = $('#nodiscipline').val();
                if(chkExeAvl != 0){
                    // custome validation - comment due to skip step 2
                    {{--  if ($('.selectedDiscipline').not(":checked")){
                        var msg = message['please_select_at_least_one_discipline'];
                        customMsg(msg);
                    }  --}}
                    var checkboxValues = [];
                    $('input[name="disciplineId"]:checked').each(function(index, elem) {
                        $('#flashMsg').html('');
                        checkboxValues.push($(elem).val());
                    });
                    $('#descipline_id').val(checkboxValues);
                    getExerciseSets(checkboxValues);

                } else {
                    $('#flashMsg').html('');
                    $('#flashMsg').html('<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert">&times;</button>Selected discipline do not have any Curriculums.</div>');
                    return false;
                }
                {{--  var checkboxValues = [];
                $('input[name="selectedId"]:checked').each(function(index, elem) {
                    checkboxValues.push($(elem).val());
                    $('#flashMsg').html('');
                });

                $('#descipline_id').val(checkboxValues);
                getExerciseSets(checkboxValues);  --}}
            }
            if(currentIndex === 2 && newIndex === 3){
                var chkExeAvl = $('#noexercisesset').val();
                if(chkExeAvl != 0){
                    // custome validation
                    if ($('.selectedexercises').not(":checked")){
                        var msg = message['please_select_at_least_one_exercisesset'];
                        customMsg(msg);
                    }
                    var execheckboxValues = [];
                    $('input[name="exercisesId"]:checked').each(function(index, elem) {
                        //$('.close').trigger("click");
                        $('#flashMsg').html('');
                        execheckboxValues.push($(elem).val());
                    });

                    $('#checked_exercise').val(execheckboxValues);

                    getSkillCategories(execheckboxValues);

                } else {
                    $('#flashMsg').html('');
                    $('#flashMsg').html('<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert">&times;</button>'+'@lang('exam.discipline_not_exercises')'+'</div>');
                    return false;
                }
            }
            if(currentIndex === 3 && newIndex === 4){
                var chkSkillCatAvl = $('#noSkillCat').val();
                //if(chkSkillCatAvl != 0){
                    // custome validation
                    {{--  if ($('.selectedskillCat').not(":checked")){
                        var msg = message['please_select_at_least_one_skill_categories'];
                        customMsg(msg);
                    }  --}}
                    var skillcatcheckboxValues = [];
                    var skillcatTxtValues = [];
                    $('input[name="skillCatLists"]:checked').each(function(index, elem) {
                        //$('.close').trigger("click");
                        $('#flashMsg').html('');
                        var skillCat_id = $(elem).val();
                        skillcatcheckboxValues.push($(elem).val());
                        skillcatTxtValues.push($('#max_que_' + skillCat_id).val());
                    });

                    $('#skillcat_id').val(skillcatcheckboxValues);
                    $('#noofquestion').val(skillcatTxtValues);

                    getQuestionList(skillcatcheckboxValues,skillcatTxtValues);

               // } 
                {{--  else {
                    $('#flashMsg').html('');
                    $('#flashMsg').html('<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert">&times;</button>'+'@lang('exam.exercises_not_skillcategories')'+'</div>');
                    return false;
                }  --}}
            }
            if(currentIndex === 4 && newIndex === 5){
                var chkQuestionAvl = $('#noquestions').val();
                if(chkQuestionAvl != 0){
                    // custome validation
                    if ($('.selectedQuestion').not(":checked")){
                        var msg = message['please_select_at_least_one_question'];
                        customMsg(msg);
                    }
                    var questioncheckboxValues = [];
                    $('input:checkbox[name=questions]:checked').each(function(index, elem) {
                        //$('.close').trigger("click");
                        $('#flashMsg').html('');
                        questioncheckboxValues.push($(elem).val());
                    });
                    getSelectedQuestionList(questioncheckboxValues);

                } else {
                    $('#flashMsg').html('');
                    $('#flashMsg').html('<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert">&times;</button>'+'@lang('exam.exercises_not_skillcategories')'+'</div>');
                    return false;
                }
            }

            if(currentIndex > newIndex){
                return true;
            }
            else{
                form.validate().settings.ignore = ":disabled,:hidden";
                return form.valid();
            }
            form.validate().settings.ignore = ":disabled,:hidden";
            return form.valid();
        },
        onFinishing: function (event, currentIndex)
        {
            form.validate().settings.ignore = ":disabled";
            return form.valid();
        },
        onFinished: function (event, currentIndex)
        {
            $("#create_exam_form").submit();
        }
    });

    // custome message
    function customMsg(msg){
        // custome validation
        $('#flashMsg').html('');
        $('#flashMsg').html('<div class="alert alert-danger alert-dismissible"><button id="closeBtn" type="button" class="close" data-dismiss="alert">&times;</button>'+ msg +'</div>');
    }

    // Ajex Functions - checkboxValues
    function getCurriculam(checkboxValues){
        var getExamID =$('#examId').val();
        $.ajax({
            method: "post",
            url: '{{route ('Exams.exam.getCurriculam')}}',
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            data: {
                id: checkboxValues,
                getExamID:getExamID,
            },
            success: function (response) {
                $("html").animate({ scrollTop: 0 }, "fast");
                $('#DisciplinesHTML').html(response.html);
                $('.examId').val(response.exam_id);
            }
        });
    }

    // Ajex Functions - checkboxValues
    function getExerciseSets(checkboxValues){
        var getExamID =$('#examId').val();
        $.ajax({
            method: "post",
            url: '{{route ('Exams.exam.getExercisesset')}}',
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            data: {
                id: checkboxValues,
                getExamID:getExamID,
            },
            success: function (response) {
                $("html").animate({ scrollTop: 0 }, "fast");
                $('#ExercisessetsHTML').html(response);
            }
        });
    }
    // Ajex Functions - execheckboxValues
    function getSkillCategories(execheckboxValues){
        var getExamID =$('#examId').val();
        if (execheckboxValues.length > 0) { // Check if atleat one option is selected or not
            $.ajax({
                method: "post",
                url: '{{route ('Exams.exam.getSkillCategories')}}',
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                data: {
                    id: execheckboxValues,
                    getExamID:getExamID,
                },
                success: function (response) {
                    $("html").animate({ scrollTop: 0 }, "fast");
                    $('#skillCatListHTML').html(response);
                }
            });
        }
    }

    // Ajex Functions - Get Question list
    function getQuestionList(skillcatcheckboxValues,skillcatTxtValues){
        var getExamID =$('#examId').val();
        if (skillcatcheckboxValues.length > 0) { // Check if atleat one option is selected or not
            $.ajax({
                method: "post",
                url: '{{route ('Exams.exam.getQuestions')}}',
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                data: {
                    skillcat_id: skillcatcheckboxValues,
                    noofquestion:skillcatTxtValues,
                    getExamID:getExamID,
                },
                success: function (response) {
                    if(response != 'true'){
                        $("html").animate({ scrollTop: 0 }, "fast");
                        $('#questionListHTML').html(response);
                    }
                    else{
                        swal({
                            text: "Exam process successfully done !!",
                            type: "success",
                            closeOnClickOutside: false,
                            closeOnEsc: false,
                            allowOutsideClick: false,
                        }).then(function(){
                            window.location.href = site_url+"/exams";
                        });
                    }
                },
            });
        }
    }

    // Ajex Functions - Get Question list
    function getSelectedQuestionList(questioncheckboxValues){
        var getExamID =$('#examId').val();
        if (questioncheckboxValues.length > 0) { // Check if atleat one option is selected or not
            $.ajax({
                method: "post",
                url: '{{route ('Exams.exam.getSelectedQuestions')}}',
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                data: {
                    id: questioncheckboxValues,
                    getExamID:getExamID,
                },
                success: function (response) {
                    $("html").animate({ scrollTop: 0 }, "fast");
                    $('#selQuestionListHTML').html(response);
                }
            });
        }
    }

    // for skill cat validation on textbox
    function skillTextVal(id){
        var skill_id = $('#' + id).attr('data-skill-cat-id');
        if($('#' + id).is(":checked")){
            if($('#max_que_' + skill_id).val() === ''){
                $('#max_que_' + skill_id).attr('required',true);
                return false;
            }
        }
        else{
            
        }
    }
});
</script>
<script>
    /*accordian*/
    jQuery(document).ready(function($){
        $(".demo-accordion").accordionjs();
    });

     ////select js////
     $('.cstm-drpdwn').click(function () {
                $menu.toggle();
            });
            $(document).on("click",".open_filter", function(e){
                $('.slct_drop_box').toggleClass('show-menu');
                e.stopPropagation();
            });
            $('body,html').click(function (e) {

                var menusect = $(".slct_drop_box");

                if (!menusect.is(e.target) && menusect.has(e.target).length === 0) {
                    menusect.removeClass('show-menu');

                }
            });
</script>
<script src="{{ asset('assets/eduplaycloud/customs/js/filter/exam-exersice.js') }}"></script>
<script src="{{ asset('assets/eduplaycloud/customs/js/filter/exam-skill-filter.js') }}"></script>
<script src="{{ asset('assets/eduplaycloud/customs/js/filter/exam-question-filter.js') }}"></script>
<script src="{{ asset('assets/eduplaycloud/customs/js/filter/save-filter.js') }}"></script>

@endpush