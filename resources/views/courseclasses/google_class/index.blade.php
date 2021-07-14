@extends('authenticated.layouts.default')
@section('content')
<div class="work_page mrgn_top_secn mrgn-bt-60 exercesi_block text-ar-right">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-12">
                @include('eduplaycloud.explore.explore_header')
                <!--Filter part-->
                <div class="my_exercise mrgn-tp-50 mrgn-bt-30">
                    <div class="main_detail_fltr">
                        <div class="title_with_shrtby">
                            <div class="float-sm-left filtr_with_titile">
                                <h4 class="exersc_title">@lang('filter.classes')</h4>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <div class="main_dashboard mrgn-tp-10 aaa">
                        <div class="list_of_exercise mrgn-tp-20">
                          <div class="row">
                            @if(count($googleClasses))
                              @foreach($googleClasses as $courseclass)
                              <div class="col-md-6 col-lg-6 col-xl-3 cusmize-col">
                                  <a href="{{ route('google.classroom.details', [ $courseclass->classid ])}}">
                                  <div class="main_info pstn_rltv">
                                      <div  class="info_exercise">
                                          @php
                                              if (strlen($courseclass->iconurl) >0 && File::exists(public_path()."/assets/images/".$courseclass->iconurl)) {$uimg= $courseclass->iconurl;}
                                              else{$uimg= 'class_emt_img.png';}
                                          @endphp
                                          <img src="{{ asset('assets/images') }}/{{$uimg}}" class="img-fluid">
                                          <div class="whit_checbx">
                                              <div class="profile_name">
                                                  @if(isset($courseclass->teacher->user_image) && !empty($courseclass->teacher->user_image))
                                                      @if (strlen($courseclass->teacher->user_image) > 0 && File::exists(public_path()."/assets/images/profiles/".$courseclass->teacher->user_image))
                                                          <img  src="{{ asset('assets/images/profiles') }}{{  '/'.$courseclass->teacher->user_image }}">
                                                      @else
                                                          <img  src="{{ asset('uploads/profile') }}/profile_img.jpg" alt="{{ $courseclass->teacher->name }}">
                                                      @endif
                                                  @else
                                                      <img  src="{{ asset('uploads/profile') }}/profile_img.jpg" alt="">
                                                  @endif
                                                  <p>{{optional($courseclass->teacher)->name}}</p>
                                              </div>
                                          </div>
                                          <div class="right_gnrl_info">
                                              <ul class="gnrl_info float-right">
                                                  <li data-toggle="tooltip" title="@lang('classcourse.exam')" class="check_lst_i">{{$courseclass->exams->count()}}</li>
                                                  <li data-toggle="tooltip" title="@lang('classcourse.exercises')" class="list_i">{{$courseclass->exercises->count()}}</li>
                                                  <li  data-toggle="tooltip" title="@lang('classcourse.learner')" class="user_i_i">{{$courseclass->learners->count()}}</li>
                                              </ul>
                                          </div>
                                      </div>
                                      <div class="request_add add_clrbl abslt_set_add" >
                                      @Auth
                                          @php $user=Auth::user();
                                              $routeName = Route::current()->getName();
                                              $islearner =$courseclass->learners()->where('user_id','=',$user->id)->first();
                                          @endphp
                                          @if($routeName == 'explore.classes')
                                              @if( $islearner )
                                                  @if ($islearner->pivot->status=='Pending')
                                                      <button class="requestjoin btn rqst_btn">@lang('messages.requested')</button>
                                                  @elseif ($islearner->pivot->status=='Accepted')
                                                      <button type="button" class="requestjoin collbr_btn icon_approvd">@lang('messages.enrolled')</button>
                                                  @elseif ($islearner->pivot->status=='Rejected')
                                                      <button type="button" class="requestjoin btn rd_rqst_btn">@lang('messages.rejected')</button>
                                                  @endif
                                              @else
                                                  <div id="request-btn-change{{ $courseclass->id}}">
                                                      <a href="#" class="requestjoin collbr_btn icon_clrbl" onclick="requestjoin('{{route('courseclasses.courseclass.requestjpoin' ,$courseclass->id)}}',{{ $courseclass->id }},'{{ route('courseclasses.courseclass.show', [ $courseclass->id ])}}');">
                                                          <span>@lang('messages.RequesttoJoin')</span>
                                                      </a>
                                                  </div>
                                              @endif
                                          @endif

                                      @EndAuth
                                      @guest
                                          {{-- <a href="{{route('courseclasses.courseclass.requestjpoin' ,[$courseclass->id ,1])}}" class="requestjoin text-requestjoin  btn btn-primary" >
                                              <span>@lang('messages.RequesttoJoin')</span>
                                          </a> --}}
                                          <a class="requestjoin collbr_btn icon_clrbl" href="javascript:void(0)" data-toggle="modal" data-target="#login_btn"> <span>@lang('messages.RequesttoJoin')</span></a>
                                      @endGuest
                                      </div>
                                      <ul class="title_cmbo text-ar-right">
                                        <li><a href="javascript:;">{{ $courseclass->name }} </a></li>
                                    </ul>
                                      <ul class="editable_list edit_date_avai">
                                        <li>
                                            <div class="availble">
                                                @if($courseclass->courseState === 'ACTIVE')
                                                    <p>@lang('classcourse.Availble')</p>
                                                @else 
                                                    <p>@lang('classcourse.Not Availble')</p>
                                                @endif
                                            </div>
                                        </li>
                                      </ul>
                                  </div>
                                  </a>
                              </div>
                              @endforeach
                              <div class="col-md-12 cstm-pgntn">
                                  <nav aria-label="Page navigation example" class="float-right">
                                      {{ $googleClasses->links() }}
                                  </nav>
                              </div>
                          @else
                          <div class="clearfix"></div><br/>
                          <div class="col-md-12">
                              <p {{--class="no_dt_title"--}} style="margin-top: -10px;">@lang('classcourse.no_courseclasses_available')</p>
                              <div class="clearfix"></div><br/>
                              <div class="clearfix"></div><br/>
                          </div>
                          <div class="clearfix"></div><br/>
                          @endif
                         
                            </div>
                        </div>
                    </div>
                </div>

                <!--End Filter Section-->                  

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
<script src="{{ asset('assets/eduplaycloud/customs/js/class-request.js') }}"></script>
<script>
@if(\Request::segment(2) == 'publiclibrary')
    $('#pills-Libray-tab').trigger('click');
    // $('.nav-tabs a[href="#pills-Libray"]').tab('show')
    // $('#pills-Libray-tab').addClass('active');
@endif
</script>
<script>
    $(window).bind("pageshow", function() { // update hidden input field $('#formid')[0].reset(); });
        $("#sort-by").val(0).selectpicker("refresh");
    });
    // Accordion
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
    
</script>
<script>
  if ($('body li #homeMenu').hasClass('active')) {

  } else {
    $('body li #exploreMenu').addClass('active');
  }
  
</script>

@endpush