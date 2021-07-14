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
                    <div class="main_detail_fltr">
                        <div class="title_with_shrtby">
                            <div class="float-sm-left filtr_with_titile">
                                <h4 class="exersc_title">@lang('reports.skill_category_performance_report')</h4>
                                <a class="mrgn_lft_20 collps_fltr" data-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample"><span class="flr-i"></span></a>
                            </div>
                            {{--  <div class="float-sm-right short_by text-right">
                                <div class="short_by_select">
                                    <label>@lang('filter.sort_by_title'):</label>
                                    <select class="selectpicker" id="sort-by">
                                        <option value="Ascending">@lang('filter.ascending')</option>
                                        <option value="Descending">@lang('filter.descending')</option>
                                    </select>
                                </div>
                            </div>  --}}
                        </div>
                        <div class="clearfix"></div>
                        <div class="list_of_filter collapse" id="collapseExample">
                            <div class="card card-body">
                            <!--Filter Form Apply-->
                            <form id="filter-form" method="GET">
                                <input type="hidden" name="user_id" value="{{$userId}}">
                                <input type="hidden" name="class_id" value="{{$classId}}">
                                <div class="mani_menu_list">
                                    <div class="float-left">
                                        <a class="open_filter" href="#"><i class="plus_icn"></i></a>
                                        <ul class="studnt_list_nm" id="fltered-text-list">
                                            <!--Filter text append here-->
                                        </ul>
                                    </div>
                                    <div class="float-right clear_all_cls">
                                        <a href="#" id="clear_all_btn" class="clear_all_btn">@lang('filter.clear_all')</a>
                                    </div>
                                </div>
                            </form>
                            <!--End filer form-->
                                <div class="slct_drop_box">
                                    <ul class="demo-accordion accordionjs " data-active-index="false">
                                        <li>
                                            <div class="section_cls">
                                                <h3>@lang('filter.title')</h3>
                                            </div>
                                            <div class="class-detail">
                                                <form  class="def_form">
                                                    <div class="form-group">
                                                        <div class="df-select">
                                                            <select class="selectpicker" id="name-operator">
                                                                <option>@lang('filter.select_operator')</option>
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
                                                </form>
                                            </div>
                                        </li>
                                        {{-- <li>
                                            <div class="section_cls">
                                                <h3>Mastery Level</h3>
                                            </div>
                                            <div class="class-detail">
                                                <form  class="def_form">
                                                    <div class="form-group">
                                                        <div class="df-select">
                                                            <select class="selectpicker" id="mastery-level-operator">
                                                                <option>Select Operator</option>
                                                                <option value="=">equal</option>
                                                                <option value="like">contains</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <div class="df-select">
                                                            <input type="text" id="mastery-level-name" class="form-control">
                                                        </div>
                                                    </div>
                                                    <button id="mastery-level-apply" type="button" class="btn btn-primary apply_sm_btn">Apply</button>
                                                </form>
                                            </div>
                                        </li> --}}
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="student_reports">
                        <div class="earth_publish mrgn-bt-10">
                            <div class="float-sm-left">
                                <h3 class="studnt_title">{{$user->name}}</h3>
                            </div>
                            @php
                                $urldata1 = Request::segment(4);
                                $urldata2 = Request::segment(5);
                                $urldata3 = 1;
                            @endphp
                            <div class="float-sm-right mrgn_rspnsv">
                                <div class="publist_list float-sm-right">
                                    <a href="{{ route('skillPerformanceViewbyTest',[$urldata1,$urldata2])}}" class="publish_class_btn">@lang('reports.view_by_assignment') </a>
                                </div>
                            </div>
                        </div>
                        <ul class="disipline_set">
                            <li>
                                @if (isset($skilldata) && !empty($skilldata))
                                    <p>{{ optional($skilldata->courseclass->discipline)->discipline_name }} - {{ $skilldata->courseclass->class_name }}</p>
                                @endif
                            </li>
                        </ul>
                        <div class="alert alert-light"><i class="fa fa-info-circle"></i> Game data of `{{$user->name}}` inclusive </div>
                        <div class="student_table table-responsive">
                            <table class="table table-bordered" cellpadding="0" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th scope="col" width="30%">@lang('reports.skill_category')</th>
                                        <th scope="col" width="10%">@lang('reports.no_of_quetion')</th>
                                        <th scope="col" width="10%">@lang('reports.answere_correctly')</th>
                                        <th scope="col" width="20%">@lang('reports.mastery_level')</th>
                                        <th scope="col" width="30%">@lang('reports.distribution_over_class')</th>
                                    </tr>
                                </thead>
                                <tbody id="skill-performance-data">
                                    @if (isset($skilldata) && !empty($skilldata))
                                        @foreach ($skilldata->courseclass->skillCategory as $sckey => $scskill)
                                            @if (isset($scskill->skill) && !empty($scskill->skill))
                                                @foreach ($scskill->skill as $key => $skill)
                                                    @php
                                                        $skillId = $skill->id;

                                                        if (isset($skill->exam->classexam) && !empty($skill->exam->classexam)):
                                                            $classExam = $skill->exam->classexam;
                                                        else:
                                                            $classExam = '';
                                                        endif;
                                                    @endphp
                                                    <tr class="clickable-row" data-href="{{ route('exerciseSetReport',[$urldata1,$urldata2,$skillId])}}">
                                                        <td>
                                                            <div
                                                                @if (isset($classExam) && !empty($classExam))
                                                                    @foreach ($classExam as $classexam)
                                                                        @php
                                                                            $classExamId=$classexam->id;
                                                                            $level = QueryHelper::userSkillMasterylevel($user->id,$skillId,$classExamId);
                                                                        @endphp
                                                                        @if(!empty($level->skillmasterylevel))
                                                                            @if ($levelname=$level->skillmasterylevel->id === 5)
                                                                                class="switches_bx swc_green"
                                                                            @elseif ($levelname=$level->skillmasterylevel->id === 4)
                                                                                class="switches_bx swc_blue"
                                                                            @elseif ($levelname=$level->skillmasterylevel->id === 3)
                                                                                class="switches_bx swc_light_yellow"
                                                                            @elseif ($levelname=$level->skillmasterylevel->id === 2)
                                                                                class="switches_bx swc_yellow"
                                                                            @else
                                                                                class="switches_bx swc_red"
                                                                            @endif
                                                                        @else
                                                                            class="switches_bx swc_red"
                                                                        @endif
                                                                    @endforeach
                                                                @endif
                                                            ></div>
                                                            {{$scskill->skill_category_name}} / {{ $skill->skill_name }}
                                                        </td>
                                                        <td>
                                                            @if (isset($skill->skillQuestion) && !empty($skill->skillQuestion))
                                                                @php $que=1;$c=1; @endphp
                                                                    @foreach ($skill->skillQuestion as $question)
                                                                        @php $c=$que++; @endphp
                                                                    @endforeach
                                                                {{ $c }}
                                                            @else
                                                                <p>@lang('reports.no_data')</p>
                                                            @endif
                                                        </td>
                                                        <td>
                                                            @if (isset($skill->skillQuestion) && !empty($skill->skillQuestion))
                                                                @php $ans=0; @endphp
                                                                @foreach ($skill->skillQuestion as $question)
                                                                    @foreach($question->getUserExamAnswere as $answer)
                                                                        @if($answer->iscorrect == 1)
                                                                            @php $a=$ans++; @endphp
                                                                        @endif
                                                                    @endforeach
                                                                @endforeach
                                                                {{ $ans }}
                                                            @else
                                                                <p>@lang('reports.no_data')</p>
                                                            @endif
                                                        </td>
                                                        <td>
                                                            @php $classExamId=''; @endphp
                                                            @php $level = QueryHelper::userSkillMasterylevel($user->id,$skillId,$classExamId);
                                                            if(!empty($level->skillmasterylevel)){
                                                                echo $levelname=$level->skillmasterylevel->levelname;
                                                            }else{
                                                                echo "Not available";
                                                            }
                                                            @endphp
                                                            {{--  @if (isset($skill->exam->classexam) && !empty($skill->exam->classexam))
                                                                @foreach ($skill->exam->classexam as $classexam)
                                                                    @php
                                                                        $classExamId=$classexam->id;
                                                                        $level = QueryHelper::userSkillMasterylevel($user->id,$skillId,$classExamId);
                                                                        if(!empty($level->skillmasterylevel)){
                                                                            echo $levelname=$level->skillmasterylevel->levelname;
                                                                        }else{
                                                                            echo "Not available";
                                                                        }
                                                                    @endphp
                                                                @endforeach
                                                            @else
                                                                <p>@lang('reports.no_data')</p>
                                                            @endif  --}}
                                                        </td>
                                                        <td>
                                                            @php
                                                                $learnerCount;
                                                                $allLevel = QueryHelper::allSkillMasterylevel($skillId,$classExamId);
                                                            @endphp
                                                            @if (count($allLevel) > 0)
                                                                <div class="progress tp_bar_prgress">
                                                                @php
                                                                    $notStarted =0;
                                                                    $needsMorePractice =0;
                                                                    $underAcquisition =0;
                                                                    $acquired =0;
                                                                    $mastered =0;
                                                                @endphp
                                                                @foreach ($allLevel as $levels)
                                                                    @if($levels->masteryLevel == 5)
                                                                        @if($levels->masteryLevel == 5)
                                                                            @php $mastered++; @endphp
                                                                        @else
                                                                            @php $mastered=0; @endphp
                                                                        @endif
                                                                    @endif

                                                                    @if($levels->masteryLevel == 4)
                                                                        @if($levels->masteryLevel == 4)
                                                                            @php $acquired++; @endphp
                                                                        @else
                                                                            @php $acquired=0; @endphp
                                                                        @endif
                                                                    @endif

                                                                    @if($levels->masteryLevel == 3)
                                                                        @if($levels->masteryLevel == 3)
                                                                            @php $underAcquisition++; @endphp
                                                                        @else
                                                                            @php $underAcquisition=0; @endphp
                                                                        @endif
                                                                    @endif

                                                                    @if($levels->masteryLevel == 2)
                                                                        @if($levels->masteryLevel == 2)
                                                                            @php $needsMorePractice++; @endphp
                                                                        @else
                                                                            @php $needsMorePractice=0; @endphp
                                                                        @endif
                                                                    @endif

                                                                    @if($levels->masteryLevel == 1)
                                                                        @if($levels->masteryLevel == 1)
                                                                            @php $notStarted++; @endphp
                                                                        @else
                                                                            @php $notStarted=0; @endphp
                                                                        @endif
                                                                    @endif
                                                                @endforeach

                                                                {{--  {{ round(($mastered/$learnerCount)*100)}}
                                                                {{ round(($acquired/$learnerCount)*100)}}
                                                                {{ round(($underAcquisition/$learnerCount)*100)}}
                                                                {{ round(($needsMorePractice/$learnerCount)*100)}}
                                                                {{ round(($notStarted/$learnerCount)*100)}}  --}}
                                                                <div class="progress-bar bg-success" role="progressbar" style="width: {{ round(($mastered/$learnerCount)*100) }}%" aria-valuenow="30" aria-valuemin="0" aria-valuemax="100"></div>
                                                                <div class="progress-bar bg-confirm" role="progressbar" style="width: {{ round(($acquired/$learnerCount)*100) }}%" aria-valuenow="30" aria-valuemin="0" aria-valuemax="100"></div>
                                                                <div class="progress-bar bg-info" role="progressbar" style="width: {{ round(($underAcquisition/$learnerCount)*100) }}%" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100"></div>

                                                                <div class="progress-bar" role="progressbar" style="width: {{ round(($needsMorePractice/$learnerCount)*100) }}%" aria-valuenow="15" aria-valuemin="0" aria-valuemax="100"></div>

                                                                <div class="progress-bar progress_unscces" role="progressbar" style="width: {{ round(($notStarted/$learnerCount)*100) }}%" aria-valuenow="15" aria-valuemin="0" aria-valuemax="100"></div>
                                                            </div>
                                                            @else
                                                                <p>@lang('reports.no_data')</p>
                                                            @endif
                                                            
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            @else
                                                <tr>
                                                    <td colspan="5">@lang('reports.no_data') !!</td>
                                                </tr>
                                            @endif
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="5">@lang('reports.no_data') !!</td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                            {{--  @php
                            echo "<pre>";
                            print_r($allLevel = QueryHelper::allSkillMasterylevel($skillId,$classExamId));
                            @endphp  --}}
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
<script src="{{ asset('assets/eduplaycloud/customs/js/filter/skill-performance-filter.js') }}"></script>
<script src="{{ asset('assets/eduplaycloud/customs/js/filter/save-filter.js') }}"></script>
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