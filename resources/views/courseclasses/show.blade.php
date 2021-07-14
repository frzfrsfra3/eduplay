@extends('authenticated.layouts.default')

@section('content')
<div class="work_page mrgn_top_secn exercesi_block text-ar-right">
        <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-12">
                <nav aria-label="tp-breadcm" class="tp-breadcm">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{route('courseclasses.courseclass.myclasses')}}">@lang('classcourse.Myclasses')</a></li>
                        <li class="breadcrumb-item active" aria-current="page">{{ $courseclass->class_name }}</li>
                    </ol>
                </nav>
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
                <div class="tbs_of_report tbs_of_report-as">
                    <div class="dropdown">
                        {{--<button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown">My Reports
                            <span class="caret"></span></button>--}}
                        <ul class="tabs_menu nav nav-pills main-tabs mb-3 classes_tabs mrgn_tbs_less" id="pills-tab" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" id="summary-tab" data-toggle="pill" href="#summary" role="tab" aria-controls="summary" aria-selected="true">@lang('classcourse.summary')</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="assignments-tab" data-toggle="pill" href="#assignments" role="tab" aria-controls="assignments" aria-selected="false" onclick="getClassesAssignment()">@lang('classcourse.assignments')</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link " id="learners-tab" data-toggle="pill" href="#Learners" role="tab" aria-controls="learners" aria-selected="false">@lang('classcourse.learners')</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="resources-tab" data-toggle="pill" href="#resources" role="tab" aria-controls="resources" aria-selected="false">@lang('classcourse.resources')</a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="clearfix"></div>
                <div class="tab-content">
                        <div class="tab-pane fade show active" id="summary" role="tabpanel" aria-labelledby="summary-tab">
                            <div class="main_summery_earth pd_lf_25">
                                <div class="earth_publish mrgn-tp-0 mrgn-bt-10">
                                    <div class="name_list float-left">
                                        <h4>{{ $courseclass->class_name }}</h4>
                                    </div>
                                    <div class="publist_list float-right">
                                      <a href="{{ route('courseclasses.courseclass.edit', $courseclass->id ) }}" class="edit_btn"></a>
                                    </div>
                                </div>
                                <div class="clearfix"></div>
                                <div class="row">
                                    <div class="col-lg-5 col-xl-4">
                                        <div class="inner_summery">
                                            <div class="summery_title">
                                                <h3>@lang('classcourse.summary')</h3>
                                            </div>
                                            <ul class="star_wth_user medium_star_user">
                                                <li>
                                                    <div class="gray_star">
                                                        <div class="orng_star" style="width: {{(@$courseclass->averageRating(1)[0]) * 100 / 5}}%;"></div>
                                                    </div>
                                                    <span class="rtng">{{@$courseclass->averageRating(1)[0]}}</span>
                                                </li>
                                            </ul>
                                            <ul class="gnrl_info chnge_blue_icn mrgn-bt-20">
                                                <li data-toggle="tooltip" title="@lang('classcourse.exam')" class="check_lst_i">{{$courseclass->exams->count()}}</li>
                                                <li data-toggle="tooltip" title="@lang('classcourse.exercises')" class="list_i">{{$courseclass->exercises->count()}}</li>
                                                <li data-toggle="tooltip" title="@lang('classcourse.learner')" class="user_i_i">{{$courseclass->learners->count()}}</li>
                                            </ul>
                                            <ul class="excersie_list practice_list">
                                                <li>@lang('classcourse.course_id') : <span>{{ $courseclass->id }}</span></li>
                                            </ul>
                                            <ul class="excersie_list practice_list">
                                                <li>@lang('classcourse.status') : <span>{{ $courseclass->isavailable === 'Y' ? 'Available' : 'Not Available' }}</span></li>
                                            </ul>
                                            <ul class="excersie_list practice_list">
                                                <li>@lang('classcourse.curriculum') <span>{{ optional($courseclass->discipline)->discipline_name }} </span></li>
                                            </ul>
                                            <ul class="excersie_list practice_list">
                                                <li>@lang('classcourse.Language') <span>{{ optional($courseclass->language)->language }}</span></li>
                                            </ul>
                                            <ul class="excersie_list practice_list">
                                                <li>@lang('classcourse.StartDate') <span> {{ date('d/m/Y', strtotime( $courseclass->start_date ))}}</span></li>
                                                <li>@lang('classcourse.EndDate') <span>{{ date('d/m/Y', strtotime( $courseclass->end_date ))}}</span></li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="col-lg-7 col-xl-8">
                                        <div class="about_teacher_block">
                                            <div class="edit_text text-right text-ar-left">
                                                <a href="javascript:void(0)" data-toggle="modal" data-target="#about_teacher">@lang('classcourse.edit')</a>
                                            </div>
                                            <h3>@lang('classcourse.about_teacher')</h3>
                                                <div class="techer_detail">
                                                @if(isset($courseclass->teacher->user_image) && !empty($courseclass->teacher->user_image))
                                                    @if (strlen($courseclass->teacher->user_image) > 0 && File::exists(public_path()."/assets/images/profiles/".$courseclass->teacher->user_image))
                                                        <img  src="{{ asset('assets/images/profiles') }}/{{  $courseclass->teacher->user_image }}" alt="{{ $courseclass->teacher->name }}">
                                                    @else
                                                        <img  src="{{ asset('uploads/profile') }}/profile_img.jpg" alt="{{ $courseclass->teacher->name }}">
                                                    @endif
                                                @else
                                                    <img  src="{{ asset('uploads/profile') }}/profile_img.jpg" alt="{{ $courseclass->teacher->name }}">
                                                @endif
                                                <h4>{{ ($courseclass->teacher)->name}}</h4>
                                                <p> {{ ($courseclass->teacher)->aboutme }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="discription_block mrgn-tp-20 mrgn-bt-20">
                                            <h4>@lang('classcourse.about_class') </h4>
                                            <p>{{ $courseclass->class_description }}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="review_section">
                                            <div class="row">
                                                <div class="col-xl-11">
                                                    <div class="inner_review_section">
                                                        <h3>@lang('classcourse.review_ratings')</h3>
                                                        <div class="row">
                                                            <div class="col-lg-5 col-xl-4">
                                                                <ul class="star_wth_user big_star_user">
                                                                    <li>
                                                                        <div class="gray_star">
                                                                            <div class="orng_star" style="width: {{(@$courseclass->averageRating(1)[0]) * 100 / 5}}%;"></div>
                                                                        </div>
                                                                        <span class="rtng">{{@$courseclass->averageRating(1)[0]}}</span>
                                                                    </li>
                                                                </ul>
                                                                <div class="rating_graph mrgn-tp-20">
                                                                    <div class="row_rating">
                                                                        @for($i = 5; $i >= 1; $i--)
                                                                            <div class="rtng_bbx">
                                                                            <div class="side">
                                                                                <div>{{$i}}</div>
                                                                            </div>
                                                                            <div class="middle">
                                                                                <div class="bar-container">
                                                                                    @php $total = 0; 
                                                                                        foreach($userrate as $ratekey => $item) {
                                                                                            if($item->rate == $i)
                                                                                                $total += 1;
                                                                                        }
                                                                                        $avg = 0;
                                                                                        if(count($userrate))
                                                                                            $avg = (@$total) * 100 / count(@$userrate)
                                                                                    @endphp
                                                                                    <div class="bar-{{$i}}" style="width: {{$avg}}%;"></div>
                                                                                </div>
                                                                                <small class="pull-right" style="color:blue;">{{$total}}</small>
                                                                            </div>
                                                                            </div>
                                                                        @endfor
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-7 col-xl-8">
                                                                <div class="rating_view_detail">
                                                                @foreach($userrate as $ratekey => $item)
                                                                    <div class="rew_prfl_sectin after_{{$ratekey}}">
                                                                        <div class="prfl_img">

                                                                            @if(isset($user->user_image) && !empty($user->user_image))
                                                                                @if (strlen($user->user_image) > 0 && File::exists(public_path()."/assets/images/profiles/".$user->user_image))
                                                                                    <img  src="{{ asset('assets/images/profiles') }}/{{  $user->user_image }}" alt="{{$user->name }}">
                                                                                @else
                                                                                    <img  src="{{ asset('uploads/profile') }}/profile_img.jpg" alt="{{$user->name }}">
                                                                                @endif
                                                                            @else
                                                                                <img  src="{{ asset('uploads/profile') }}/profile_img.jpg" alt="{{$user->name }}">
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
                                                                @endforeach
                                                                    
                                                                    
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
                        <div class="tab-pane fade" id="assignments" role="tabpanel" aria-labelledby="assignments-tab">
                                @include('courseclasses.class_exams',$courseclass)
                        </div>
                        <div class="tab-pane fade" id="Learners" role="tabpanel" aria-labelledby="learners-tab">
                                @include('courseclasses.class_learners',$courseclass)
                        </div>
                        <div class="tab-pane fade" id="resources" role="tabpanel" aria-labelledby="resources-tab">
                            <input type="hidden" id="class_id" value="{{ $courseclass->id }}">   
                            @include('courseclasses.class_exercises',$courseclass)
                        </div>
                  </div>
                
            </div>
        </div>
        </div>
    </div>

<!--About Teacher Model-->
<div class="modal fade default_modal wht_bg_mdl" id="about_teacher" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="right_contnt text-ar-right">
                            <h3>@lang('classcourse.about_teacher')</h3>
                            <form class="def_form" action="{{route('courseclasses.courseclass.teacher')}}" method="POST">
                                {{ csrf_field() }}
                                <div class="form-group">
                                <input type="hidden" name="user_id" value="{{($courseclass->teacher)->id}}">
                                <input type="hidden" name="class_id" value="{{$courseclass->id}}">
                                    <textarea name="aboutme" class="form-control" placeholder="@lang('classcourse.Description')">{{($courseclass->teacher)->aboutme}}</textarea>
                                </div>
                                <div class="form-group mrgn-tp-30">
                                    <button type="submit" class="btn btn-primary btn-login drk_bg_btn">@lang('classcourse.update')</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!--invite_model-->
<div class="modal fade default_modal wht_bg_mdl" id="invite_model" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="right_contnt invite_mdl text-ar-right">
                                <h3>@lang('classcourse.enter_email_address')</h3>
                                <form class="def_form" method='post' action>
                                    <div class="form-group">
                                        <input type="email" type="text" autocomplete value="" id="addlearner" name="addlearner" class="form-control" placeholder="@lang('classcourse.email_address')">
                                        <label for="email" id='email-err' generated="true" class="error"></label>
                                    </div>
                                    <div>
                                        <div id="result">
                                            
                                        </div>
                                    </div>
                                    {{-- <div class="form-group mrgn-tp-30">
                                        <button type="button" data-toggle="modal" data-target="#okay_mdl" data-dismiss="modal" class="btn btn-primary btn-login drk_bg_btn">@lang('classcourse.send_request')</button>
                                    </div> --}}
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!--okay_model-->
    <div class="modal fade default_modal wht_bg_mdl" id="okay_mdl" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="right_contnt text-ar-right">
                                <h3>@lang('classcourse.thank_you')</h3>
                                <p class="enter_youremil">@lang('classcourse.request_has_sent')</p>
                                <form class="def_form">
                                    <div class="form-group">
                                        <button type="button" onclick="okayreload()" data-dismiss="modal"  class="btn btn-primary btn-login drk_bg_btn">@lang('classcourse.okay')</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!--Edit Exam time Model-->
    <div class="modal fade default_modal wht_bg_mdl" id="edit_date_assignment" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="right_contnt text-ar-right">
                                <h3>@lang('classcourse.edit_exam_date')</h3>
                                <form class="def_form" method="POST" action="{{route('courseclasses.edit.examdate')}}">
                                    @csrf
                                    <div class="row">
                                        <div class="col-md-12 errors">
                                            <ul class="subject_list_hieghlt edit_exam_date">
                                                <li>
                                                    <input type="hidden" name="pivot_id" id="pivot_id">
                                                    <input type="hidden" name="exam_class_id" id="exam_class_id">
                                                    <div class="form-group mrgn-bt-20">
                                                        <label>@lang('classcourse.start_date')</label>
                                                        <input type="text" name="exam_startDate" id="exam_startDate" class="startDate dttmpckr form-control" placeholder="@lang('filter.start_date')" readonly>
                                                    </div>
                                                </li>
                                                <li>
                                                    <div class="form-group mrgn-bt-20">
                                                        <label>@lang('classcourse.end_date')</label>
                                                        <input type="text" name="exam_endDate" id="exam_endDate" class="endDate dttmpckr form-control" placeholder="@lang('filter.end_date')">
                                                    </div>
                                                </li>
                                            </ul>
                                        </div>                                   
                                    </div>
                                    <div class="form-group">
                                        <button type="submit"  class="btn btn-primary btn-login drk_bg_btn">@lang('classcourse.update')</button>
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
<script type="text/javascript" src="{{ asset('assets/eduplaycloud/customs/js/jquery-validate/jquery.validate.min.js') }}"></script>
<script type="text/javascript" src="https://ajax.aspnetcdn.com/ajax/jquery.validate/1.11.1/additional-methods.min.js"></script>
<script src="{{ asset('assets/eduplaycloud/customs/js/filter/assignment-filter.js') }}"></script>
<script src="{{ asset('assets/eduplaycloud/customs/js/filter/pins-class-filter.js') }}"></script>
<script src="{{ asset('assets/eduplaycloud/customs/js/filter/save-filter.js') }}"></script>

<script>
    $('.modal').on('hidden.bs.modal', function(){
    $(this).find('form')[0].reset();
    $('#result').empty();
});
    /*accordian*/
    jQuery(document).ready(function($){
        $(".demo-accordion").accordionjs();
    });


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
   

</script>
<script>

    //Pins in pagination event click
    $(document).on('click', '.pagination a',function(event)
    {
        event.preventDefault();

        $('li').removeClass('active');
        $(this).parent('li').addClass('active');

        var myurl = $(this).attr('href');
        // var page=$(this).attr('href').split('page=')[1];

        window.location = myurl + '#resources#pills-pins';
    });

    // Add class id inside pin form
    $('#pin_class_id').val("{{ $courseclass->id }}");
    $('#edit_pin_class_id').val("{{ $courseclass->id }}");

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
          title: '@lang("exam.pin")' ,
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
    });
    
        function accept_reject_learner(url, id) {
            $.ajax({
                type: "GET",
                dataType: "html",
                url: url,
                data: {
                    "_token": "{{ csrf_token() }}",
                },
                success: function (response) {
                    // console.log('change');
                    // $('#classlearner_id' + id).empty();
                    $('#request_'+id).remove();
                    $('#classlearner_id').append(response);

                    //Remove Heading if no record found
                    var rowCount = $('#requestTable >tbody >tr').length;
                    if (rowCount == 0 ) {
                        $("#requestLabel").html("");
                    }
                },
                error: function (err) {
                    // console.log("AJAX error in request: " + JSON.stringify(err, null, 2));

                }
            })
        }

        function add_remove_exercise_to_class(url, id,type) {
            if(type == 'remove'){
                swal({
                    text: 'Are you sure to delete this?',
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                    })
                    .then((willDelete) => {
                    if (willDelete) {
                        $.ajax({
                            type: "POST",
                            dataType: "html",
                            url: url,
                            data: {
                                "_token": "{{ csrf_token() }}",
                            },
                            success: function (response) {
                                // console.log('change');
                                if (type =='add') {
                                //   alert (url);

                                    $('#list-exercises').find("#myexercise"+id).remove();
                                    $( "#added-exercises" ).prepend( response );



                                }
                            else {
                                //  alert (url);
                                    // $('#added-exercises').find("#myexercise" + id).remove();
                                    // if ( $( "#list-exercises" ).length ) {
                                    //     $('#list-exercises').find("#myexercise"+id).remove();
                                    //     $("#list-exercises").prepend(response);
                                    // }
                                    // swal('Exercise deleted from class successfully.', {
                                    //     closeOnClickOutside: false,
                                    //     icon: 'success',
                                    // }).then(function() {
                                    //     window.location.replace(site_url + "/courseclasses/show/" + $('#class_id').val() + "?#resources");
                                    //      location.reload();
                                    // });
                                    $('#getmsg').html('<div class="alert alert-success"><i class="fa fa-check-square-o" aria-hidden="true"></i>@lang("controller.exercise_deleted") !!<button type="button" class="close" data-dismiss="alert" aria-label="close"><span aria-hidden="true">&times;</span></button></div>');
                                    setTimeout(function() {
                                        window.location.replace(site_url + "/courseclasses/show/" + $('#class_id').val() + "?#resources");
                                        location.reload();
                                    }, 2000);
                                        
                                }
                            },
                            error: function (err) {
                                // console.log("AJAX error in request: " + JSON.stringify(err, null, 2));

                            }
                        })
                    }
                    });
            }            
        }

        function CompareDate(start_date) {

            var todayDate = new Date(); //Today Date
            var dateOne = new Date(start_date);
            alert(dateOne)
            if (todayDate > dateOne) {

                return false;

            }else {

               return true;

            }

        }

        function add_exam(url, id) {
           var s_date=    $('#exam_s_date'+id).val();
            var s_time=    $('#exam_s_time'+id).val();

            var e_date=    $('#exam_e_date'+id).val();
            var e_time=    $('#exam_e_time'+id).val();
            s_date_time=s_date+s_time;
            e_date_time=e_date+e_time;
            var s_date_time = new Date(s_date+"T"+s_time);
            var e_date_time = new Date(e_date+"T"+e_time);

            var exam_url=$('#class_exams').data('exames');

            var start_date=s_date_time
            var end_date=e_date_time
            if (start_date< end_date  &&  CompareDate(start_date) ==true ){
                // console.log('ajax')
            $.ajax({

                type: "POST",
                dataType: "html",
                url: url,

                data: {
                    "_token": "{{ csrf_token() }}",
                    "start_date": start_date,
                    "end_date": end_date
                },
                success: function (response) {
                    // console.log('change');
                    $('#user-exercises').empty();
                    $('#user-exercises').html(response);
                },
                error: function (err) {
                    // console.log("AJAX error in request: " + JSON.stringify(err, null, 2));

                }
            })


                $.ajax({

                    type: "get",
                    dataType: "html",
                    url: exam_url,

                    data: {
                        "_token": "{{ csrf_token() }}",


                    },
                    success: function (response) {
                        // console.log('change');
                        $('#class_exams_view').empty();
                        $('#class_exams_view').html(response);

                    },
                    error: function (err) {
                        // console.log("AJAX error in request: " + JSON.stringify(err, null, 2));

                    }
                })
        }
        else {
                alert ('you entered wrong dates')
            }
        }

        function remove_exam(url, id) {

            // alert(url);
            $.ajax({

                type: "GET",
                dataType: "text",
                url: url,

                data: {
                    "_token": "{{ csrf_token() }}",


                },
                success: function (response) {
                    // console.log('change = ');
                    // console.log(response);
                    $("#exam"+id).remove();

                },
                error: function (err) {
                    // console.log("AJAX error in request: " + JSON.stringify(err, null, 2));

                }
            })
        }


    </script>



    <script>
        $('#add-exercises').on("click", function () {

            var url = $(this).data("url");

            $.ajax({
                type: "GET",
                dataType: "html",
                url: url,
                data: {
                    "_token": "{{ csrf_token() }}",
                },
                success: function (response) {
                    // console.log('change');
                    $('#user-exercises').empty();
                    $('#user-exercises').html(response);
                },
                error: function (err) {
                    // console.log("AJAX error in request: " + JSON.stringify(err, null, 2));

                }
            })

        })


    </script>


    <script>
        $('#add-exams').on("click", function () {

            var url = $(this).data("url");

            $.ajax({
                type: "GET",
                dataType: "html",
                url: url,
                data: {
                    "_token": "{{ csrf_token() }}",
                },
                success: function (response) {
                    // console.log('change');
                    $('#user-exercises').empty();
                    $('#user-exercises').html(response);
                },
                error: function (err) {
                    // console.log("AJAX error in request: " + JSON.stringify(err, null, 2));

                }
            })

        })


    </script>

    <script>
        $(function () {
            $('#toggle-event').change(function () {
                var url = $(this).data("url");
                $.ajax({
                    type: "POST",
                    dataType: "text",
                    url: url,
                    data: {
                        "_token": "{{ csrf_token() }}",
                    },
                    success: function (response) {
                        // console.log(response);
                    },
                    error: function (err) {
                        // console.log("AJAX error in request: " + JSON.stringify(err, null, 2));
                    }
                })

            })
        })

        $('#filter').on('click', function () {
            $('#exampleModalLongTitle').text("Invite Learner");
            
            $.ajax({
                type: "GET",
                dataType: "html",
                url: $('#filter').data('edit-link'),
                data: {
                    "_token": "{{ csrf_token() }}",

                    "ad": "2",
                },
                success: function (response) {
                    $('#htmlid').html(response);
                }
            })
        });


    $(document).ready(function(){
        $('#addlearner').keyup(function(){
            $('#addlearner').removeClass('error');
            $('#email-err').text('');
            var name = $('#addlearner').val();
            if (!ValidateEmail($("#addlearner").val())) {
                $('#addlearner').addClass('error');
                $('#email-err').text('@lang("messages.enter_valid_email")');
                return false;
            } else {
                $.ajax({
                    type: 'GET',
                    dataType: "html",
                    url: "{{ route('CourseclassesController.classlearner.addlearner',$courseclass->id) }}",
                    data: {ajax: 1, name: name},
                    success: function (response) {
                        // console.log(response);
                        $('#result').html(response);
                    },
                    error: function (response) {
                        // console.log(response)
                    }
                });
                }
            });
        });

    function ValidateEmail(email) {
        var expr = /^([\w-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([\w-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$/;
        return expr.test(email);
    };
  

    function invitenonlearner() {
        var email = $('#addlearner').val();
        if (!ValidateEmail($("#addlearner").val())) {
            $('#addlearner').addClass('error');
            $('#email-err').text('@lang("messages.enter_valid_email")');
            return false;
        } else {
            $('#invite_model').modal('hide');
            $('#okay_mdl').modal('show');
            var classId = $('#courseclass_id').val();
            var class_url = site_url + "/courseclasses/show/" + classId;
            var register_url = site_url;
            $.ajax({
                type: "POST",
                dataType: "html",
                url: $('.invitelearner').data('edit-link'),
                data: {
                    "_token": "{{ csrf_token() }}",
                    "email": email,
                    "class_id" : classId,
                    "class_url" : class_url,
                    "register_url" : register_url

                },
                success: function (response) {
                    window.location.replace(site_url + "/courseclasses/show/" + classId + "?#Learners");
                },
            })
        }
    }

    function invitelearner(id){
            var classId = "{{ $courseclass->id }}";
            var class_url = site_url + "/courseclasses/show/" + classId;

            $.ajax({
                type: "POST",
                dataType: "html",
                url: $('.invitelearner').data('edit-link'),
                data: {
                    "_token": "{{ csrf_token() }}",
                    "user_id":id,
                    "class_url" : class_url

                },
                success: function (response) {
                    $('#invitelearner'+id).remove();
                    window.location.replace(site_url + "/courseclasses/show/" + classId + "?#Learners");
                },

            })
    }


    function okayreload() {
        location.reload();
    }

    //Remove learner from class.
    function removeFromClass(id,classId) {
        //alert(classId);return false;
        swal({
            title: "@lang('exam.are_you_sure')",
            text: "@lang('exam.cancel_invitation')",
            icon: "warning",
            buttons: [
              '@lang("exam.cancel_it")',
              '@lang("exam.im_sure")'
            ],
            dangerMode: true,
        }).then(function(isConfirm) {
        if (isConfirm) {
            var classId = $('#'+id).attr('data-class-id');
            var learnerId = $('#'+id).attr('data-lerner-id');
            $.ajax({
                type: "POST",
                dataType: "html",
                url: site_url + '/courseclasses/learner/remove',
                data: {
                    "_token": "{{ csrf_token() }}",
                    "user_id":learnerId,
                    "class_id":classId,
                },
                success: function (response) {
                    $('#remove_'+learnerId).remove();
                    swal("@lang('exam.cancelled')", {
                        icon: "success",
                        button: {
                          text: "@lang('exercisesets.ok')",
                        },    
                    });
                    window.location.replace(site_url + "/courseclasses/show/" + classId + "?#Learners");
                },

            })
        } else {
            $('input:checkbox').removeAttr('checked');
            // swal("Cancelled", "Process has cancelled!");
            }
        });
    }

</script>

<!-- Develop by Wc -->
<!-- Search for learner-->
<script>
$(document).ready(function(){
    $("#search").keyup(function(){

        // Retrieve the input field text.
        var filter = $(this).val();

        // Loop through the comment list
        $("table tbody tr").each(function(){

            // If the list item does not contain the text phrase fade it out
            if ($(this).text().search(new RegExp(filter, "i")) < 0) {
                $(this).fadeOut();

                $('.border-right').attr('style','border-right:0px !important');
                $('#requestLabel').html('');

            // Show the list item if the phrase matches and increase the count by 1
            } else {
                $('#requestLabel').html('Requests');
                $('.border-right').attr('style','border-right:1px solid #dee2e6!important');

                $(this).show();
            }
        });
    });
});

//This script for exam delete functionality
var anchor = '';
function examDelete(classId,examId){
    $.ajax({
        //url: site_url + "/courseclasses/assignments/" + examId,
        url: site_url + "/courseclasses/removeexam/" + classId +'/' + examId,
        type: 'get',
        success: function(data) {

            if(data == 'success' ){
                swal({
                    text: "@lang('controller.exam_deleted')", 
                    type: "success",
                    button: {
                        text: "@lang('messages.ok')"
                    }
                }).then(function(){ 
                    anchor = location.hash || $("a[data-toggle='tab']").first().attr("href");
                    //location.reload();
                    getClassesAssignment();
                });
                //$('#getmsg').html('');
                //$('.alert-success').html('Exam delete from your class !!');
                //$('#getmsg').html('<div class="alert alert-success col-ssm-12" >Exam delete from your class !!<button type="button" onclick="location.reload();" class="close" data-dismiss="alert" aria-label="close"><span aria-hidden="true">&times;</span></button></div>');
            } if(data == 'useranswer') {
                swal("@lang('exam.user_answered_exam')");
            } else {
                swal("@lang('exam.something_wrong')");
                //$('#getmsg').html('');
                //$('#getmsg').html('<div class="alert alert-danger col-ssm-12" >Something wrong !!<button type="button" onclick="location.reload();" class="close" data-dismiss="alert" aria-label="close"><span aria-hidden="true">&times;</span></button></div>');
            }
        }
    });
}
//Tab display.
{{-- $(document).ready(function () {
    if (window.location.hash) {
        var hrf =  $('.classes_tabs a[href="'+window.location.hash+'"]').tab('show');
    } else {
        console.log(window.location.hash);
        var hrf =  $('.classes_tabs a[href="#summary"]').tab('show');
    }
}); --}}

// Tab selected code
$(document).ready(function() {
    getClassesAssignment();
    if (location.hash) {
        var data = location.hash.split('#');

        // console.log(data[1]);
        // console.log(data.length);
        // $("a[href='" + location.hash + "']").tab("show");
        $(".main-tabs a[href='#" + data[1] + "']").tab("show");
        if(data.length > 2){
            $(".sub-tabs a[href='#" + data[2] + "']").tab("show");
        }
    }
    $(document.body).on("click", "a[data-toggle]", function(event) {
        location.hash = this.getAttribute("href");
    });
});
$(window).on("popstate", function() {
    $("a[href='" + anchor + "']").tab("show");
});

//Edit Exam date
function openEditDateModal(id){

     $('#exam_startDate').datetimepicker({
        minDate:new Date().setHours(0,0,0,0),
        format: 'DD-MM-YYYY LT',
        /*maxDate: 'now'*/
    });

    $('#exam_endDate').datetimepicker({
        minDate:new Date().setHours(0,0,0,0),
        format: 'DD-MM-YYYY LT',
        useCurrent: false
    });
    $("#exam_startDate").on("dp.change", function (e) {
        $('#exam_endDate').data("DateTimePicker").minDate(e.date);
    });
    $("#exam_endDate").on("dp.change", function (e) {
        $('#exam_startDate').data("DateTimePicker").maxDate(e.date);
    });

    //Set Data for input.
    $('#exam_startDate').val($('#'+id).attr('data-start_date'));
    
    var editable = $('#'+id).attr('data-is_edit'); 
    if(editable === "true"){
        $("#exam_startDate").removeAttr("readonly",false);
    } else {
        $("#exam_startDate").attr("readonly",true);
    }

    $('#exam_endDate').val($('#'+id).attr('data-end_date'));
    $('#pivot_id').val($('#'+id).attr('data-pivot_id'))
    $('#exam_class_id').val($('#'+id).attr('data-class_id'))

    $('#edit_date_assignment').modal('show');
}

</script>
@endpush