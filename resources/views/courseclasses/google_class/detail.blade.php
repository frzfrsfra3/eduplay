@extends('authenticated.layouts.default')

@section('content')
<!---Content-->
<div class="work_page mrgn_top_secn exercesi_block text-ar-right">
    <div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-11">
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
            <nav aria-label="tp-breadcm" class="tp-breadcm">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{route('courseclasses.courseclass.myclasses', ['#pills-gclass'])}}">Google Classes</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{ $googleclass->name }}</li>
                </ol>
            </nav>
            <div class="tbs_of_report tbs_of_report-as">
                <div class="dropdown">
                    {{--<button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown">My Reports
                        <span class="caret"></span></button>--}}
                    <ul class="tabs_menu nav nav-pills main-tabs mb-3 classes_tabs mrgn_tbs_less" id="pills-tab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="summary-tab" data-toggle="pill" href="#summary" role="tab" aria-controls="summary" aria-selected="true">@lang('classcourse.summary')</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="assignments-tab" data-toggle="pill" href="#assignments" role="tab" aria-controls="assignments" aria-selected="false" onclick="authenticate().then(loadClient)">@lang('classcourse.assignments')</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link " id="learners-tab" data-toggle="pill" href="#Learners" role="tab" aria-controls="learners" aria-selected="false" onclick="authenticate().then(loadClient)">@lang('classcourse.learners')</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="resources-tab" data-toggle="pill" href="#resources" role="tab" aria-controls="resources" aria-selected="false">@lang('classcourse.resources')</a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="clearfix"></div>
              <div class="tab-content">
                <div class="main_summery_earth tab-pane fade show active" id="summary" role="tabpanel" aria-labelledby="summary-tab">
                    <div class="earth_publish mrgn-tp-30 mrgn-bt-10">
                        <div class="name_list float-left">
                            <h4>{{ title_case($googleclass->name) }}</h4>
                        </div>
                        <div class="publist_list float-right">
                            <a onclick="editClass()" class="edit_btn"></a>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                    <div class="row">
                        <div class="col-lg-5 col-xl-4">
                            <div class="inner_summery">
                                <div class="summery_title">
                                    <h3>@lang('classcourse.summary')</h3>
                                </div>
                               <ul class="gnrl_info chnge_blue_icn mrgn-bt-20">
                                    <li data-toggle="tooltip" title="@lang('classcourse.exam')" class="check_lst_i">0</li>
                                    <li data-toggle="tooltip" title="@lang('classcourse.exercises')" class="list_i">0</li>
                                    <li data-toggle="tooltip" title="@lang('classcourse.learner')" class="user_i_i">0</li>
                                </ul>
                                <ul class="excersie_list practice_list">
                                    <li>@lang('classcourse.course_id') : <span>{{ $googleclass->classid }}</span></li>
                                </ul>
                                <ul class="excersie_list practice_list">
                                    <li>@lang('classcourse.status') : <span>{{ $googleclass->courseState }}</span></li>
                                </ul>
                                <ul class="excersie_list practice_list">
                                    <li>Section : <span> {{ $googleclass->section }} </span></li>
                                </ul>
                                <ul class="excersie_list practice_list">
                                    <li>Enrollment Code : <span> {{ $googleclass->enrollmentCode }}</span></li>
                                </ul>
                            </div>
                        </div>
                        <div class="col-lg-7 col-xl-8">
                          <div class="about_teacher_block">
                              <div class="edit_text text-right text-ar-left">
                                  {{-- <a href="javascript:void(0)" data-toggle="modal" data-target="#about_teacher">@lang('classcourse.edit')</a> --}}
                              </div>
                              <h3>@lang('classcourse.about_teacher')</h3>
                                  <div class="techer_detail">
                                  @if(isset($googleclass->teacher->user_image) && !empty($googleclass->teacher->user_image))
                                      @if (strlen($googleclass->teacher->user_image) > 0 && File::exists(public_path()."/assets/images/profiles/".$googleclass->teacher->user_image))
                                          <img  src="{{ asset('assets/images/profiles') }}/{{  $googleclass->teacher->user_image }}" alt="{{ $googleclass->teacher->name }}">
                                      @else
                                          <img  src="{{ asset('uploads/profile') }}/profile_img.jpg" alt="{{ $googleclass->teacher->name }}">
                                      @endif
                                  @else
                                      <img  src="{{ asset('uploads/profile') }}/profile_img.jpg" alt="{{ $googleclass->teacher->name }}">
                                  @endif
                                  <h4>{{ ($googleclass->teacher)->name}}</h4>
                                  <p> {{ ($googleclass->teacher)->aboutme }}</p>
                              </div>
                          </div>
                      </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="discription_block mrgn-tp-20 mrgn-bt-20">
                                <h4>{{ $googleclass->descriptionHeading }}</h4>
                                <p>{{  $googleclass->description }} </p>
                            </div>
                        </div>
                    </div>
                    {{-- <div class="row">
                        <div class="col-md-12">
                            <div class="discription_block bg-white mrgn-bt-20">
                                <h4>Description</h4>
                                <p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat. Ut wisi enim ad minim veniam, quis nostrud exerci tation ullamcorper suscipit lobortis nisl ut aliquip ex ea commodo consequat. Duis autem vel eum iriure dolor in hendrerit in vulputate velit esse molestie consequat, vel illum dolore eu feugiat nulla facilisis at vero eros et accumsan et iusto odio dignissim qui blandit praesent luptatum zzril delenit augue duis dolore te feugait nulla facilisi.
                                </p>  
                            </div>
                        </div>
                    </div> --}}
                </div>
                 <div class="tab-pane fade" id="assignments" role="tabpanel" aria-labelledby="assignments-tab">
                        @include('courseclasses.google_class.class_exams',$googleclass)
                  </div>
                  <div class="tab-pane fade" id="Learners" role="tabpanel" aria-labelledby="learners-tab">
                  
                          <input type="hidden" id="gclass_data_id" value="{{ $googleclass->id }}">
                          {{-- <button class="btn btn-primary" onclick="importLearner({{$googleclass->classid}});">Learner</button> --}}

                          {{-- <button onclick="authenticate().then(loadClient)">authorize and load</button> --}}
                          {{-- <button onclick="execute()">execute</button> --}}
                           @include('courseclasses.google_class.learners',$googleclass)
                   
                  </div>
                  <div class="tab-pane fade" id="resources" role="tabpanel" aria-labelledby="resources-tab">
                            @include('courseclasses.google_class.class_exercises',$googleclass)                   
                  </div>
                  <input type="hidden" id="gclass_id" value="{{$googleclass->classid}}">
              </div>
        </div>
    </div>
    </div>
</div>
  

<!-- Edit Google classroom model-->
<div class="modal fade default_modal wht_bg_mdl" id="gclass_edit_model" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <button type="button" id="gclassclose" class="close" data-dismiss="modal" aria-label="Close"></button>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="right_contnt text-ar-right">
                        <h3>@lang('classcourse.edit_google_classroom')</h3>
                        <form class="def_form" id="gclass_edit_form" method="POST" action="{{route('google.classroom.update',[ $googleclass->classid ])}}" enctype='multipart/form-data'>
                            {{ csrf_field() }}
                            <div class="form-group">                            
                              <label>@lang('classcourse.class_name')</label>
                              <input type="text" id="classname" name="classname" class="form-control" value="{{ $googleclass->name }}">
                            </div>
                            <div class="form-group">
                              <label>@lang('classcourse.section')</label>
                              <input type="text" id="section" name="section" class="form-control" value="{{ $googleclass->section }}">
                            </div>
                            <div class="form-group">
                              <label>@lang('classcourse.description_heading')</label>
                              <input type="text" id="descriptionHeading" name="descriptionHeading" class="form-control" value="{{ $googleclass->descriptionHeading }}">
                            </div>
                            <div class="form-group">                            
                              <label>@lang('classcourse.description')</label>
                              <textarea class="form-control" id="description" name="description">{{ $googleclass->description }}</textarea>
                            </div>
                            <div class="form-group">
                              <label>@lang('classcourse.room')</label>
                              <input type="number" id="room" name="room" class="form-control" value="{{ $googleclass->room }}"  >
                            </div>
                            <div class="form-group">
                                <button type="submit" id="edit_gclass_submit" class="btn btn-primary btn-login drk_bg_btn">@lang('classcourse.update')</button>
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
<script src="https://apis.google.com/js/api.js"></script>
{{-- <script src="{{ asset('assets/eduplaycloud/customs/js/pages/courseclass/google-api.js') }}"></script> --}}
<script src="{{ asset('assets/eduplaycloud/customs/js/pages/courseclass/google-config.js') }}"></script>
<script src="{{ asset('assets/eduplaycloud/customs/js/pages/courseclass/google-class.js') }}"></script>
<script src="{{ asset('assets/eduplaycloud/customs/js/pages/courseclass/google-student.js') }}"></script>
<script>
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
          url: site_url + '/google-classroom/learner/remove',
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
              window.location.replace(site_url + "/google-classroom/" + classId + "/show?#Learners");
          },

      })
  } else {
      $('input:checkbox').removeAttr('checked');
      // swal("Cancelled", "Process has cancelled!");
      }
  });
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
                      if (type =='add') {
                          $('#list-exercises').find("#myexercise"+id).remove();
                          $( "#added-exercises" ).prepend( response );
                      }
                  else {
                      
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

// Tab selected code
$(document).ready(function() {
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

</script>
<script>
  $(document).ready(function(){
      $('[data-toggle="tooltip"]').tooltip(); 
  });



//This script for exam delete functionality
var anchor = '';
function examDelete(classId,examId){
    $.ajax({
        //url: site_url + "/courseclasses/assignments/" + examId,
        url: site_url + "/google-classroom/removeexam/" + classId +'/' + examId,
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
</script>
@endpush