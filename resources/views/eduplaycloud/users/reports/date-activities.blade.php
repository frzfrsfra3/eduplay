<div class="row">
    <div class="col-md-6 col-lg-5">
        @php
            $reqDate=strtotime($selDate);
            $month=date("m",$reqDate);
            $year=date("Y",$reqDate);

            $daysArr = array('Mon','Tue','Wed','Thu','Fri','Sat','Sun');
            $monthtotdays= cal_days_in_month(CAL_GREGORIAN,$month ,$year);
            $currdays=jddayofweek (cal_to_jd(CAL_GREGORIAN, $month,1, $year) , 2 );
            $currdaysval = 0;
        @endphp
        <div class="month_list">
            <h5>{{ date('F Y',$reqDate) }}</h5>
            <div class="border_cls">
                <table class="table table-bordered" id="tblmain" style="text-align: center;">
                    <tr class="head_main" style='background-color:#FFFFFF;'>
                        @for($d=0;$d<=6;$d++)
                            <td>{{ $daysArr[$d] }}</td>
                            @if($daysArr[$d]==$currdays)
                                @php $currdaysval = $d @endphp
                            @endif
                        @endfor
                    </tr>
                    <tr style='background-color:#FFFFFF;'>
                        @if($currdaysval > 0 )
                            <td  class="noclick" colspan="{{ $currdaysval }}">&nbsp;</td>
                        @endif
                        @for($i=1;$i<=$monthtotdays;$i++)
                            @php
                                if($i <10){
                                    $currDate = $year.'-'.$month.'-0'.$i;
                                }else{
                                    $currDate = $year.'-'.$month.'-'.$i;
                                }
                                $count = QueryHelper::userDaysActivities($user->id, $currDate);
                            @endphp
                            <td data-month="{{ date('Y-m',$reqDate) }}"
                            @if ($count === 0)
                                class="wt_clr_bx"
                            @elseif ($count === 1)
                                class="drkpnk_clr_bx"
                            @elseif ($count === 2)
                                class="pink_clr_bx"
                            @elseif ($count === 3)
                                class="brwn_clr_bx"
                            @elseif ($count === 4)
                                class="orng_clr_bx"
                            @elseif ($count === 5)
                                class="yelw_clr_bx"
                            @elseif ($count >= 6 )
                                class="grn_clr_bx"
                            @else
                                style='background-color:#fff'
                            @endif
                            >{{ $i }}</td>
                            @if(($i+$currdaysval )%7 <= 0 )
                        </tr>
                        <tr>
                            @endif
                        @endfor
                    </tr>
                </table>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-lg-7 rsnt_acvt">
        <h5>@lang('reports.recent_activities')</h5>
        {{--  <h6>Today</h6>  --}}
        @if(count($activity) > 0)
        <ul class="actvt_list">
            @foreach($activity as $activities)
                <li>
                    <span class="time_blk">
                        {{ date('h:i A',strtotime(str_replace('/','-',$activities->created_at))) }}
                    </span>
                    {{ $activities->activity->activity_description }}
                </li>
            @endforeach
        </ul>
        @else
            <p>
                @lang('reports.img_text')
            </p>
        @endif
    </div>
</div>

<script>
    $('.noclick').on("click", function() {
        return false;
    });
    $('.head_main td').on("click", function() {
        return false;
    });

// Calender Task - Single( ajex )
 $("#tblmain").on("click", "td", function() {
    if($( this ).text() < 10){
        var text = 0 +$( this ).text();
     } else {
        var text = $( this ).text();
     }
     var date = $( this ).attr('data-month')+'-'+text;
     var id = <?php echo Request::segment(4); ?>;
     var url = site_url + '/reports/recent/activities/'+id+'?date=' + date;
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

</script>