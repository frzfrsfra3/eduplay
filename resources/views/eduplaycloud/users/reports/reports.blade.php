@extends('authenticated.layouts.default')
@section('content')
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

<div class="work_page mrgn_top_secn text-ar-right reports">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-12">
                <div class="pdng_reports_work">
                    <div class="tbs_of_report tbs_of_report-as">
                        <div class="dropdown">
                            <button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown">@lang('reports.title')
                                <span class="caret"></span>
                            </button>
                            @include('eduplaycloud.users.private-library.menu')
                        </div>
                    </div>
                    <div class="clearfix"></div>
                    <div class="short_by text-right">
                        <div class="short_by_select"></div>
                    </div>
                    <div class="detail_of_report">
                        @if(count($userRoles) > 0)
                        <ul class="teacher_tbs nav nav-pills mb-3" id="pills-tab" role="tablist">
                            @for ($r=0; $r < count($userRoles); $r++)
                            <li class="nav-item">
                                <a class="nav-link" id="pills-{{strtolower($userRoles[$r]['name'])}}-tab" data-toggle="pill" href="#pills-{{strtolower($userRoles[$r]['name'])}}" role="tab" aria-controls="pills-{{strtolower($userRoles[$r]['name'])}}" aria-selected="true">{{ $userRoles[$r]['name'] }}</a>
                            </li>
                            @endfor
                        </ul>
                        @endif
                        <div class="tab-content" id="pills-tabContent">
                            <div class="tab-pane fade" id="pills-teacher" role="tabpanel" aria-labelledby="pills-teacher-tab">
                                <div class="avrege_perfomance mrgn-bt-10">
                                    <div class="row">
                                        <div class="col-lg-6 pdng_right_rprt">
                                            <div class="right_avrge_perfmnce">
                                                <h4 class="reprt-title">@lang('reports.avg_perfomance')</h4>
                                                @if(count($userAvgPerformance) > 0)
                                                <div class="chart_perfomnce">
                                                    <div id="barchart_values" style="width: auto; height: auto;"></div>
                                                    <div id="myValueHolder"></div>
                                                </div>
                                                @else
                                                <div class="chart_perfomnce">
                                                    <div id="barchart_values" style="width: auto; height: auto;">
                                                        <img src="{{ url('assets/eduplaycloud/image') }}/no_data_found.jpg" class="img-fluid" />
                                                        {{-- <img src="https://place-hold.it/522x434/eeeeee?text=@lang('reports.img_text')&fontsize=13" alt="@lang('reports.img_text')"> --}}
                                                    </div>
                                                    <div id="myValueHolder"></div>
                                                </div>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-lg-6 pdng_lft_rprt">
                                            <div class="left_avrge_perfmnce">
                                                <div class="row">
                                                    <div class="col-7 col-sm-8">
                                                        <h4 class="reprt-title">@lang('reports.lerner_performance')</h4>
                                                    </div>
                                                    <div class="col-5 col-sm-4">
                                                        @if(count($classObj) > 0)
                                                        <div class="class_drop def_form">
                                                            <div class="df-select">
                                                                <select id="class-select-picker" class="selectpicker">
                                                                    @foreach($classObj as $classes)
                                                                    <option value="{{ $classes->id }}">{{ $classes->class_name }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="performance_line_chart">
                                                @include('eduplaycloud.users.reports.learner-performance')
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="recent_activites mrgn-bt-20">
                                    <div class="row">
                                        <div class="col-lg-6 pdng_right_rprt">
                                            <div class="today_activites">
                                                <h4 class="reprt-title brdr_rprt">@lang('reports.recent_activities')</h4>

                                                <a href="{{ route('allActivities', $user->id ) }}" class="view_all_link">@lang('reports.view_all')</a>
                                                @if(count($recentActivity) > 0)
                                                <div class="list_of_activies">
                                                    <h6>@lang('reports.today')</h6>
                                                    <ul class="activities_all">
                                                        @foreach($recentActivity as $activities)
                                                        <li>
                                                            <i class="ic_td_red"></i>
                                                            {{ $activities->activity->activity_description }}
                                                        </li>
                                                        @endforeach
                                                    </ul>
                                                </div>
                                                @else
                                                <p>
                                                    @lang('reports.img_text')
                                                </p>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-lg-6 pdng_lft_rprt">
                                            <div class="earned">
                                                <h4 class="reprt-title"> @lang('reports.earned')</h4>
                                                <div class="earned_point">
                                                    <div class="top_arned">
                                                        <ul>
                                                            <li>
                                                                @if(isset($totalPoints->accumulated_points))
                                                                    <h4 class="counter" data-counter="{{ $totalPoints->accumulated_points }}">{{ $totalPoints->accumulated_points }}</h4>
                                                                @endif
                                                                <p>@lang('reports.points')</p>
                                                            </li>
                                                            <li>
                                                                <h4 class="counter" data-counter="{{ $totalExercise }}">{{ $totalExercise }}</h4>
                                                                <p>@lang('reports.exercise')</p>
                                                            </li>
                                                            <li>
                                                                <h4 class="counter" data-counter="{{ $totalBadges }}">{{ $totalBadges }}</h4>
                                                                <p>@lang('reports.badges')</p>
                                                            </li>
                                                            <li>
                                                                <h4 class="counter" data-counter="{{ $totalClasses }}">{{ $totalClasses }}</h4>
                                                                <p>@lang('reports.classes')</p>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                    <div class="divider"></div>
                                                    <div class="below_earned">
                                                        @php
                                                            $lastBadges = $user->badges()->orderBy('userbadges.id', 'desc')->take(4)->get();
                                                            if (count($lastBadges) > 0):
                                                        @endphp
                                                        <ul>
                                                            @foreach($lastBadges as $badge)
                                                            <li>
                                                                @php
                                                                    if (strlen($badge->badgeimageurl) > 0 && File::exists(public_path()."\assets\images\badges\\".$badge->badgeimageurl)) {
                                                                        $badgeImage= $badge->badgeimageurl;
                                                                    } else {
                                                                        $userImage = '';
                                                                        $badgeImage = 'default.png';
                                                                    }
                                                                @endphp
                                                                <img id="badge-div" class="cbadge-div" src="{{ asset('assets/images/badges') }}/{{ $badgeImage }}" alt="{{ $badge->badgetitle }}" title="{{ $badge->badgetitle }}" height="80" width="80">
                                                                <p>{{ $badge->badgetitle }}</p>
                                                            </li>
                                                            @endforeach
                                                            <div class="clearfix"></div>
                                                        </ul>
                                                        @php
                                                            else:
                                                        @endphp
                                                            <p><center>@lang('reports.img_text')</center></p>
                                                        @php
                                                            endif;
                                                        @endphp
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="pills-learner" role="tabpanel" aria-labelledby="pills-learner-tab">
                                <div class="avrege_perfomance mrgn-bt-30">
                                    <div class="row">
                                        <div class="col-lg-6 pdng_right_rprt">
                                            <div class="right_avrge_perfmnce">
                                                <h4 class="reprt-title">@lang('reports.average_performance_by_classes')</h4>
                                                @if(count($userAvgByClass) > 0)
                                                <div class="chart_perfomnce">
                                                    <div id="barchart_values_learner" style="width: auto; height: auto;"></div>
                                                </div>
                                                @else
                                                <div class="chart_perfomnce">
                                                    <div id="barchart_values_learner" style="width: auto; height: auto;">
                                                        <img src="{{ url('assets/eduplaycloud/image') }}/no_data_found.jpg" class="img-fluid" />
                                                        {{-- <img src="https://place-hold.it/522x434/eeeeee?text=Woops! Looks like there's no data.&fontsize=13" alt="Woops! Looks like there's no data."> --}}
                                                    </div>
                                                    <div id="myValueHolder"></div>
                                                </div>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-lg-6 pdng_lft_rprt">
                                            <div class="left_avrge_perfmnce dount_chrt">
                                                <div class="select_prgs progress_for_class">
                                                    <h4>@lang('reports.progress_in'):</h4>
                                                    @if(count($averagePerformanceClasses) > 0)
                                                        <div class="df-select">
                                                            <select id="progress-class-select-picker" class="selectpicker">
                                                                @foreach($averagePerformanceClasses as $classes)
                                                                    <option value="{{ $classes['class_id'] }}">{{ $classes['courseclass']['class_name'] }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    @endif
                                                    <div class="progress_chart">
                                                        @include('eduplaycloud.users.reports.learner-progress')
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="recent_activites  mrgn-bt-50">
                                    <div class="row">
                                        <div class="col-lg-6 pdng_right_rprt">
                                            <div class="today_activites">
                                                <h4 class="reprt-title brdr_rprt">@lang('reports.recent_activities') </h4>
                                                <a href="{{ route('allActivities', $user->id ) }}" class="view_all_link">View All</a>
                                                @if(count($recentActivity) > 0)
                                                <div class="list_of_activies">
                                                    <h6>@lang('reports.today')</h6>
                                                    <ul class="activities_all">
                                                        @foreach($recentActivity as $activites)
                                                        <li>
                                                            <i class="ic_td_red"></i>
                                                            {{ $activites->activity->activity_description }}
                                                        </li>
                                                        @endforeach
                                                    </ul>
                                                </div>
                                                @else
                                                <p>
                                                    @lang('reports.img_text')
                                                </p>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-lg-6 pdng_lft_rprt">
                                            <div class="earned">
                                                <h4 class="reprt-title">@lang('reports.earned')</h4>
                                                <div class="earned_point">
                                                    <div class="top_arned">
                                                        <ul>
                                                            <li>
                                                                @if(isset($totalPoints->accumulated_points))
                                                                <h4 class="counter" data-counter="{{ $totalPoints->accumulated_points }}">{{ $totalPoints->accumulated_points }}</h4>
                                                                @endif
                                                                <p>@lang('reports.points')</p>
                                                            </li>
                                                            <li>
                                                                <h4 class="counter" data-counter="{{ $totalExercise }}">{{ $totalExercise }}</h4>
                                                                <p>@lang('reports.exercise')</p>
                                                            </li>
                                                            <li>
                                                                <h4 class="counter" data-counter="{{ $totalBadges }}">{{ $totalBadges }}</h4>
                                                                <p>@lang('reports.badges')</p>
                                                            </li>
                                                            <li>
                                                                <h4 class="counter" data-counter="{{ $totalClasses }}">{{ $totalClasses }}</h4>
                                                                <p>@lang('reports.classes')</p>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                    <div class="divider"></div>
                                                    <div class="below_earned">
                                                        @php
                                                            if (count($lastBadges) > 0):
                                                        @endphp
                                                        <ul>
                                                            @foreach($lastBadges as $badge)
                                                            <li>
                                                                @php
                                                                    if (strlen($badge->badgeimageurl) > 0 && File::exists(public_path()."\assets\images\badges\\".$badge->badgeimageurl)) {
                                                                        $badgeImage= $badge->badgeimageurl;
                                                                    } else {
                                                                        $userImage = '';
                                                                        $badgeImage = 'default.png';
                                                                    }
                                                                @endphp
                                                                <img id="badge-div" class="cbadge-div" src="{{ asset('assets/images/badges') }}/{{ $badgeImage }}" alt="{{ $badge->badgetitle }}" title="{{ $badge->badgetitle }}" height="80" width="80">
                                                                <p>{{ $badge->badgetitle }}</p>
                                                            </li>
                                                            @endforeach
                                                            <div class="clearfix"></div>
                                                        </ul>
                                                        @php
                                                            else:
                                                        @endphp
                                                            <p><center>@lang('reports.img_text')</center></p>
                                                        @php
                                                            endif;
                                                        @endphp
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="pills-parent" role="tabpanel" aria-labelledby="pills-parent-tab">
                                <div class="avrege_perfomance mrgn-bt-30">
                                    <div class="row">
                                        @if(count($parentChildsArr) > 0)
                                            @for($c=0; $c < count($parentChildsArr); $c++)
                                            @php
                                                $childData = LogicHelper::childAvgPerformance($parentChildsArr[$c]['id']);
                                                $childJsonData = json_encode($childData);
                                                $childNumber = 'child_'.($c+1);
                                            @endphp
                                            <div class="col-lg-6 pdng_right_chrtles">
                                                <div class="right_avrge_perfmnce">
                                                    <h5 class="small_child">@lang('reports.child') - {{ $c+1 }}</h5>
                                                    <h3 class="studnt_title">{{ $parentChildsArr[$c]['name'] }}</h3>
                                                    <h4 class="reprt-title">@lang('reports.avg_perfomance_by_discpline')</h4>
                                                    @if(count($childData) > 0)
                                                        <div class="chart_perfomnce">
                                                            <div id="{{ $childNumber }}" style="width: auto; height: auto;"></div>
                                                        </div>
                                                    @else
                                                        <div id="barchart_values" style="width: auto; height: auto;">
                                                            <img src="{{ url('assets/eduplaycloud/image') }}/no_data_found.jpg" class="img-fluid" />
                                                            {{-- <img src="https://place-hold.it/522x434/eeeeee?text=Woops! Looks like there's no data.&fontsize=13" alt="Woops! Looks like there's no data."> --}}
                                                        </div>
                                                    @endif
                                                </div>
                                                <div class="clearfix"></div>
                                                <div class="recent_activites mrgn-bt-50">
                                                    <div class="row">
                                                        <div class="col-lg-6 pdng_right_chrtles">
                                                            <div class="today_activites">
                                                                <h4 class="reprt-title brdr_rprt">Recent Activities </h4>
                                                                <a href="{{ route('allActivities', $parentChildsArr[$c]['id']) }}" class="view_all_link">View All</a>
                                                                @php
                                                                    $recentActivitiesObj = QueryHelper::recentActivities($parentChildsArr[$c]['id']);
                                                                    if (count($recentActivitiesObj) > 0):
                                                                @endphp
                                                                <div class="list_of_activies">
                                                                    <h6>@lang('reports.today')</h6>
                                                                    <ul class="activities_all">
                                                                        @foreach($recentActivitiesObj as $activites)
                                                                        <li>
                                                                            <i class="ic_td_red"></i>
                                                                            {{ $activites->activity->activity_description }}
                                                                        </li>
                                                                        @endforeach
                                                                    </ul>
                                                                </div>
                                                                @php
                                                                    else:
                                                                @endphp
                                                                <p>
                                                                    @lang('reports.img_text')
                                                                </p>
                                                                @php
                                                                    endif;
                                                                @endphp
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <script type="text/javascript">

                                                google.charts.load('current', {packages: ['corechart', 'bar']});
                                                google.charts.setOnLoadCallback({{ $childNumber }});

                                                function {{ $childNumber }}() {
                                                    try {
                                                        var data = google.visualization.arrayToDataTable(<?php echo $childJsonData; ?>);

                                                        var view = new google.visualization.DataView(data);
                                                        view.setColumns([0, 1,
                                                            {
                                                                calc: "stringify",
                                                                sourceColumn: 1,
                                                                type: "string",
                                                                role: "annotation"
                                                            },
                                                            2
                                                        ]);

                                                        var options = {
                                                            title: "",
                                                            width: "100%",
                                                            height: 500,
                                                            bar: {
                                                                groupWidth: "40%"
                                                            },
                                                            legend: {
                                                                position: "none"
                                                            },
                                                        };
                                                        var chart = new google.visualization.ColumnChart(document.getElementById('<?php echo $childNumber; ?>'));
                                                        google.visualization.events.addListener(chart, 'select', function() {
                                                            var selection = chart.getSelection();
                                                            if (selection.length) {
                                                                // Get column label
                                                                var row = selection[0].row;
                                                                var colLabel = data.getColumnLabel(selection[0].column);
                                                                var mydata = data.getValue(selection[0].row,0);

                                                                $.each(allClassJson, function(i, v) {
                                                                    if (v.class_name == mydata) {
                                                                        var userId = {{ $parentChildsArr[$c]['id'] }};
                                                                        var classId = v.id;
                                                                        if (classId == undefined) {
                                                                            var classId = 0;
                                                                        }
                                                                        window.location.href = site_url + '/reports/skill/performance/' + classId + '/' + userId;
                                                                        return;
                                                                    }
                                                                });
                                                            }
                                                        });
                                                        chart.draw(view, options);
                                                    } catch(e) {
                                                        return;
                                                    }
                                                }
                                            </script>
                                            @endfor
                                        @else
                                            <div class="col-lg-12 noData">
                                                <p style="display:block;text-align:center">@lang('reports.img_text')</p>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                                <div class="clearfix"></div>
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
<script type="text/javascript" src="{{ asset('assets/eduplaycloud/customs/js/jquery-cookie/jquery.cookie.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/eduplaycloud/customs/js/pages/reports/learner-bar-chart.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/eduplaycloud/customs/js/pages/reports/learner-donut-chart.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/eduplaycloud/customs/js/peity/jquery.peity.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/eduplaycloud/customs/js/pages/reports/learner-performance-line-chart.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/eduplaycloud/customs/js/pages/reports/teacher-bar-chart.js') }}"></script>
@endpush

<?php /*Load jquery to footer section*/ ?>
@push('inc_jquery')
<script type="text/javascript">
setTimeout(() => {
    var activeTab = $('.teacher_tbs .nav-item').find('a.active').text();
    $.cookie('reportRole', activeTab, { expires: 7, path: '/' });
}, 500);

$(".teacher_tbs .nav-item a").on("click", function() {
    var activeTab = $(this).text();
    $.cookie('reportRole', activeTab, { expires: 7, path: '/' });
});

<?php if (count($userAvgPerformance) > 0): ?>
var userAvgPerformance = <?php echo json_encode($userAvgPerformance); ?>;
<?php else: ?>
var userAvgPerformance = '';
<?php endif; ?>

<?php if (count($classObj) > 0): ?>
var classJson = <?php echo json_encode($classObj); ?>;
<?php else: ?>
var classJson = '';
<?php endif; ?>

<?php if (count($userAvgByClass) > 0): ?>
var userAvgByClass = <?php echo json_encode($userAvgByClass); ?>;
<?php else: ?>
var userAvgByClass = '';
<?php endif; ?>

<?php if (count($learnerProgress) > 0): ?>
var learnerProgress = <?php echo json_encode($learnerProgress); ?>;
<?php else: ?>
var learnerProgress = '';
<?php endif; ?>

<?php if (count(LogicHelper::getAllClasses()) > 0): ?>
var allClassJson = <?php echo json_encode(LogicHelper::getAllClasses()); ?>;
<?php else: ?>
var allClassJson = '';
<?php endif; ?>

$('#myList a').on('click', function (e) {
    e.preventDefault();
    $(this).tab('show');
});

$('.detail_of_report .teacher_tbs li').first().find('a').trigger('click');
</script>

<script>
$(document).ready(function() {
    $("#labelOverlay p").on("click", function() {
        var userId = $('.header').attr('id');
        var classId = $('#progress-class-select-picker').find('option:selected').val();
        if (classId == undefined) {
            var classId = 0;
        }
        window.location.href = site_url + '/reports/skill/performance/' + classId + '/' + userId;
    });
});
</script>
@endpush