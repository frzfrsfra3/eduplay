@extends('authenticated.layouts.default')
@section('content')
    <div class="work_page mrgn_top_secn mrgn-bt-60 leran_cls text-ar-right">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-12">
                    <nav aria-label="tp-breadcm" class="tp-breadcm">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('reports')}}">@lang('reports.reports')</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('reports')}}">@lang('reports.learner_discipline_rerformance_report')</a></li>
                            <li class="breadcrumb-item active" aria-current="page">@lang('reports.skill_category_performance_report')</li>
                        </ol>
                    </nav>
                    {{--  <div class="main_detail_fltr">
                        <div class="title_with_shrtby">
                            <div class="float-sm-left filtr_with_titile">
                                <h4 class="reprt-title">Skill Category Performance Report</h4>
                                <a class="collps_fltr" data-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample"><span class="flr-i"></span></a>
                            </div>
                            <div class="float-sm-right short_by text-right">
                                <div class="short_by_select">
                                    <label>Sort By:</label>
                                    <select class="selectpicker">
                                        <option>Newest</option>
                                        <option>Newest1</option>
                                        <option>Newest2</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                        <div class="list_of_filter collapse" id="collapseExample">
                            <div class="card card-body">
                                <div class="mani_menu_list">
                                    <div class="float-left">
                                        <a class="open_filter" href="#"><i class="plus_icn"></i></a>
                                        <ul class="studnt_list_nm">
                                            <li>
                                                <span>Teacher </span>
                                                <span>is</span>
                                                <span class="bold_name">Craig Marshall</span>
                                                <button type="button" class="close_name"><i class="icn_cls_nm"></i></button>
                                            </li>
                                            <li>
                                                <span>Grade</span>
                                                <span>is</span>
                                                <span class="bold_name">Grade 1</span>
                                                <button type="button" class="close_name"><i class="icn_cls_nm"></i></button>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="float-right clear_all_cls">
                                        <a href="#" class="clear_all_btn">Clear All</a>
                                    </div>
                                </div>
                                <div class="slct_drop_box">
                                    <ul class="demo-accordion accordionjs " data-active-index="false">
                                        <li>
                                            <div class="section_cls">
                                                <h3>Teacher </h3>
                                            </div>
                                            <div class="class-detail">
                                                <form  class="def_form">
                                                    <div class="form-group">
                                                        <div class="df-select">
                                                            <select class="selectpicker">
                                                                <option>Select Operator</option>
                                                                <option>is</option>
                                                                <option>am</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <div class="df-select">
                                                            <select class="selectpicker">
                                                                <option>Enter Name</option>
                                                                <option>Craig Marshall</option>
                                                                <option>Grade 1</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <button type="button" class="btn btn-primary apply_sm_btn">Apply</button>
                                                </form>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="section_cls">
                                                <h3>Curriculum</h3>
                                            </div>
                                            <div class="class-detail">
                                                <p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit</p>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="section_cls">
                                                <h3>Grade</h3>
                                            </div>
                                            <div class="class-detail">
                                                <p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit</p>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="section_cls">
                                                <h3>Discipline </h3>
                                            </div>
                                            <div class="class-detail">
                                                <p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit</p>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="section_cls">
                                                <h3>Ratings </h3>
                                            </div>
                                            <div class="class-detail">
                                                <p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit</p>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="section_cls">
                                                <h3>Number of Questions </h3>
                                            </div>
                                            <div class="class-detail">
                                                <p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit</p>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="section_cls">
                                                <h3>Price Range</h3>
                                            </div>
                                            <div class="class-detail">
                                                <p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit</p>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>  --}}
                    <div class="student_reports">
                        <div class="mrgn-bt-10">
                            <div class="float-sm-left">
                                <h3 class="studnt_title">{{$user->name}}</h3>
                            </div>
                            @php
                                $urldata1 = Request::segment(7);
                                $urldata2 = Request::segment(8);
                                $urldata3 = 1;
                            @endphp
                            <div class="float-sm-right mrgn_rspnsv">
                                <div class="publist_list float-sm-right">
                                    <a href="{{ route('skillPerformance',[$urldata1,$urldata2])}}" class="publish_class_btn">@lang('reports.view_by_skill') </a>
                                </div>
                            </div>
                        </div>
                        <div class="clearfix"></div>

                        <div class="row">
                            @if (isset($skilldata->getClassExam) && !empty($skilldata->getClassExam))

                            <div class="student_table table-responsive">
                                <table class="table table-bordered" cellpadding="0" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th scope="col">Exam title</th>
                                            <th scope="col"> Class name</th>
                                        </tr>
                                    </thead>
                                    <tbody id="skill-performance-data">
                                        @foreach ($skilldata->getClassExam as $key => $examdata)
                                        <tr  class="clickable-row" data-href="{{ route('exerciseSetReportExam',[$urldata1,$urldata2,$examdata->exam->id])}}">
                                            <td>
                                                {{ $examdata->exam->title }}
                                            </td>
                                            <td>
                                                {{ $skilldata->courseclass->class_name }}
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            @else
                                <div class="col-lg-12"><center> @lang('reports.no_data') !!</center></div>
                            @endif
                        </div>
                        {{--  <div class="student_table table-responsive">
                            <table class="table table-bordered" cellpadding="0" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th scope="col">Class Name</th>
                                        <th scope="col">User Name</th>
                                        <th scope="col">Exam Name</th>
                                        {{--  <th scope="col" width="30%">Skill Category/Skill</th>
                                        <th scope="col" width="10%">No. of Quetion</th>
                                        <th scope="col" width="10%">Answere Correctly</th>
                                        <th scope="col" width="20%">Mastery Level</th>
                                        <th scope="col" width="30%">Distribution Over Class</th>  --}
                                    </tr>
                                </thead>
                                <tbody>
                                    @if (isset($skilldata->getClassExam) && !empty($skilldata->getClassExam))
                                    @foreach ($skilldata->getClassExam as $examdata)
                                        <tr class="clickable-row" data-href="{{ route('exerciseSetReportExam',[$urldata1,$urldata2,$examdata->id])}}">
                                            <td>{{ $skilldata->courseclass->class_name }}</td>
                                            <td>{{ $skilldata->user->name }}</td>
                                            <td>{{ $examdata->exam->title }}</td>
                                        </tr>
                                    @endforeach
                                    @else
                                        <tr>
                                            <td colspan="5">No data available !!</td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>  --}}
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
<script>
    /*accordian*/
    jQuery(document).ready(function($){
        $(".demo-accordion").accordionjs();

        $(".clickable-row").click(function() {
            window.location = $(this).data("href");
        });
    });
</script>
@endpush