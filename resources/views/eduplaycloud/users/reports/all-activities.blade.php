@extends('authenticated.layouts.default')
@section('content')
<div class="work_page mrgn_top_secn">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-12">
                <nav aria-label="tp-breadcm" class="tp-breadcm">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="{{ route('reports') }}">@lang('reports.reports')</a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">@lang('reports.activities')</li>
                    </ol>
                </nav>
                <div class="title_with_shrtby">
                    <h4 class=" float-sm-left reprt-title">@lang('reports.activities_done_so_far')</h4>
                    {{--  <div class="float-sm-right short_by text-right">
                        <div class="short_by_select">
                            <label>Sort By:</label>
                            <select class="selectpicker">
                                <option>Newest</option>
                                <option>Newest1</option>
                                <option>Newest2</option>
                            </select>
                        </div>
                        <div class="filter">
                            <div class="cstm-drpdwn">
                                <span class="flr-i">Filters</span>
                            </div>
                            <div class="slct_drop_box">
                                <ul class="demo-accordion accordionjs " data-active-index="false">
                                    <li>
                                        <div class="section_cls">
                                            <h3>Class</h3>
                                        </div>
                                        <div class="class-detail">
                                            <ul class="teacher-action">
                                                <li>
                                                    <div class="custom-control custom-checkbox">
                                                        <input name="techer_tpe" value="1" id="Class1" type="checkbox" class="custom-control-input" checked>
                                                        <label class="custom-control-label" for="Class1">Class1</label>
                                                    </div>
                                                </li>
                                                <li>
                                                    <div class="custom-control custom-checkbox">
                                                        <input name="techer_tpe" value="1" id="Class2" type="checkbox" class="custom-control-input">
                                                        <label class="custom-control-label" for="Class2">Class2</label>
                                                    </div>
                                                </li>
                                                <li>
                                                    <div class="custom-control custom-checkbox">
                                                        <input name="techer_tpe" value="1" id="Class3" type="checkbox" class="custom-control-input">
                                                        <label class="custom-control-label" for="Class3">Class3</label>
                                                    </div>
                                                </li>
                                            </ul>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="section_cls">
                                            <h3>Teacher </h3>
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
                                            <h3>Date</h3>
                                        </div>
                                        <div class="class-detail">
                                            <p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit</p>
                                        </div>
                                    </li>
                                </ul>
                                <button type="button" class="btn btn-primary apply_sm_btn">Apply</button>
                            </div>
                        </div>
                        <div class="clear_all_cls">
                            <a href="javascript:;" class="clear_all_btn">Clear All</a>
                        </div>
                    </div>  --}}
                    <div class="clearfix"></div>
                </div>
                <div class="clearfix"></div>
                <div class="mdl_space text-ar-right">
                    @if (Auth::user()->hasRole('Parent'))
                        @if (count($childArr) > 0)
                        <div class="df-select">
                            <select class="selectpicker" id="chielddata">
                                {{--  <option>Select Any Child</option>  --}}
                                <option value="{{ Auth::user()->id }}" selected="selected">Own Activity</option>
                                @forelse($childArr as $child)
                                    @if(Request::segment(4) == $child['id'])
                                    <option value="{{ $child['id'] }}" selected="selected">{{ $child['name'] }}</option>
                                    @else
                                    <option value="{{ $child['id'] }}">{{ $child['name'] }}</option>
                                    @endif
                                @empty
                                    <p>@lang('reports.no_child_avaible') !!!</p>
                                @endforelse
                            </select>
                        </div>
                        @endif
                    @endif
                    @if (count($childArr) > 0)
                    <h4>{{ $user->name }}</h4>
                    @endif
                    <div class="clearfix"></div>
                </div>
                <div class="heatmap_grap">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="all-calender">
                                @for ($mo = 11; $mo >= 0; $mo--)
                                    @php
                                        $month=date("m", strtotime( date( 'Y-m-01' )." -$mo months"));
                                        $year=date("Y", strtotime( date( 'Y-m-01' )." -$mo months"));
                                        $daysArr = array('Mon','Tue','Wed','Thu','Fri','Sat','Sun');
                                        $monthtotdays= cal_days_in_month(CAL_GREGORIAN,$month ,$year);
                                        $currdays=jddayofweek (cal_to_jd(CAL_GREGORIAN, $month ,1, $year) , 2 );
                                        $currdaysval = 0;
                                        $count = '';
                                    @endphp
                                    <div class="month_list">
                                        <h5 id="{{ date('m-Y', strtotime( date( 'Y-m-01' )." -$mo months")) }}">{{ date('M y', strtotime( date( 'Y-m-01' )." -$mo months")) }}</h5>
                                        <div class="border_cls">
                                        <table class="table table-bordered" id="tbl{{$mo}}" style="text-align: center;">
                                            <tr  class="head_main">
                                                @for($d=0;$d<=6;$d++)
                                                    <td>{{ $daysArr[$d][0] }}</td>
                                                    @if($daysArr[$d]==$currdays)
                                                    @php $currdaysval = $d @endphp
                                                    @endif 
                                                @endfor
                                            </tr>
                                            <tr style='background-color:#FFFFFF;'>
                                                @if($currdaysval > 0 )
                                                    <td class="noclick" colspan="{{ $currdaysval }}">&nbsp;</td>
                                                @endif
                                                @for($i=1;$i<=$monthtotdays;$i++)
                                                    @php
                                                    if($i <10){
                                                        $currDate = date('Y-m-0'.$i, strtotime( date( 'Y-m-01' )." -$mo months"));
                                                    }else{
                                                        $currDate = date('Y-m-'.$i, strtotime( date( 'Y-m-01' )." -$mo months"));
                                                    }
                                                    //echo $currDate = date('Y').'-'.date('m', strtotime( date( 'Y-m-01' )." -$mo months")).'-'.$i;
                                                    //echo " | ".date('Y-m-'.$i, strtotime( date( 'Y-m-01' )." -$mo months"))."<br>";
                                                    //echo date('Y').'-'.date('m', strtotime( date( 'Y-m-01' )." -$mo months")).'-'.$i."<br>";
                                                    //echo date("m",strtotime("-$mo Months")) ,date("Y"); 
                                                    //exit;
                                                    if (count($childArr) > 0){
                                                        $userId=$user->id;
                                                    }else{
                                                        $userId=Auth::user()->id;
                                                    }
                                                    $count = QueryHelper::userDaysActivities($userId, $currDate);
                                                    $today = date('Y-m-d');
                                                    $cd=date('Y-m-d', strtotime( date( 'Y-m-'.$i )." -$mo months"))
                                                    @endphp
                                                    <td  data-month="{{ date('Y-m', strtotime( date( 'Y-m-01' )." -$mo months")) }}"
                                                    
                                                    @if ($count === 0)
                                                        class="wt_clr_bx {{ ( $today == $cd ) ? 'current' : null }}"
                                                    @elseif ($count === 1)
                                                        class="drkpnk_clr_bx {{ ( $today == $cd ) ? 'current' : null }}"
                                                    @elseif ($count === 2)
                                                        class="pink_clr_bx {{ ( $today == $cd ) ? 'current' : null }}"
                                                    @elseif ($count === 3)
                                                        class="brwn_clr_bx {{ ( $today == $cd ) ? 'current' : null }}"
                                                    @elseif ($count === 4)
                                                        class="orng_clr_bx {{ ( $today == $cd ) ? 'current' : null }}"
                                                    @elseif ($count === 5)
                                                        class="yelw_clr_bx {{ ( $today == $cd ) ? 'current' : null }}"
                                                    @elseif ($count >= 6 )
                                                        class="grn_clr_bx {{ ( $today == $cd ) ? 'current' : null }}"
                                                    @else
                                                        style='background-color:#fff'
                                                    @endif
                                                    >{{ $i }} </td>
                                                    @if(($i+$currdaysval )%7 <= 0 )
                                                        </tr>
                                                        <tr>
                                                    @endif
                                                @endfor
                                            </tr>
                                        </table>
                                        </div>
                                    </div>
                                @endfor
                            </div>
                            <div class="color_code_select">
                                <ul>
                                    <li>
                                        <span class="color_bx grn_clr_bx"></span>
                                        <span class="counter_clr_swt">6</span>
                                    </li>
                                    <li>
                                        <span class="color_bx yelw_clr_bx"></span>
                                        <span class="counter_clr_swt">5</span>
                                    </li>
                                    <li>
                                        <span class="color_bx orng_clr_bx"></span>
                                        <span class="counter_clr_swt">4</span>
                                    </li>
                                    <li>
                                        <span class="color_bx brwn_clr_bx"></span>
                                        <span class="counter_clr_swt">3</span>
                                    </li>
                                    <li>
                                        <span class="color_bx pink_clr_bx"></span>
                                        <span class="counter_clr_swt">2</span>
                                    </li>
                                    <li>
                                        <span class="color_bx drkpnk_clr_bx"></span>
                                        <span class="counter_clr_swt">1</span>
                                    </li>
                                    <li>
                                        <span class="color_bx wt_clr_bx"></span>
                                        <span class="counter_clr_swt">0</span>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="bottm_Activits" id="bottm_Activits">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
<?php /*Load jquery to footer section*/ ?>
@push('inc_script')

@endpush

<?php /*Load jquery to footer section*/ ?>
@push('inc_jquery')

<script>
    @php
       // $cdate=date("Y-m-d");
    @endphp
    $('select.selectpicker').on('change', function(){
        var selected = $('#chielddata option:selected').val();
        window.location =site_url+'/reports/recent/activities/'+ selected;
    });

    $(function(){
        $(".current").click();
    });

    // Calender Task
    for (var mo = 11; mo >= 0; mo--){
        $('.noclick').on("click", function() {
            return false;
        });

        $('.head_main td').on("click", function() {
            return false;
        });

        $("#tbl"+ mo).on("click", "td", function() {
            //var text =$( this ).text();
            if($( this ).text() < 10){
            var text = 0 +$( this ).text();
            } else {
            var text = $( this ).text();
            }
            //alert($( this ).attr('data-month')+'-'+$( this ).text());
            var date = $( this ).attr('data-month')+'-'+text;
            var id = <?php echo Request::segment(4); ?>;
            var url = site_url + '/reports/recent/activities/'+id+'?date=' + date;
            {{--  var url = "{{route('allActivities', '".id."')}}"+'?date=' + date;  --}}
            $.ajax({
                url: url,
                type: 'get',
                dataType: 'html',
            }).done(function (data) {
                $(".bottm_Activits").empty().html(data);
            }).fail(function (jqXHR, ajaxOptions, thrownError) {
                $.unblockUI();

                swal('Oops! Something went wrong, Please try again.', {
                    closeOnClickOutside: false,
                    icon: 'info',
                }).then(function () {

                });
            });
        });
    }
 
</script>
@endpush
