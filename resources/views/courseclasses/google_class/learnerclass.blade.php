@extends('authenticated.layouts.default')

@section('content')
<div class="work_page mrgn_top_secn mrgn-bt-60 exercesi_block text-ar-right">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-xl-12">
                    <div class="mrgn-tp-30 text-ar-right">
                        <nav aria-label="tp-breadcm" class="tp-breadcm">
                            <ol class="breadcrumb">
                                @if( str_replace(url('/'), '', url()->previous()) == '/courseclasses/myclasses')
                                    <li class="breadcrumb-item"><a href="{{route('courseclasses.courseclass.myclasses')}}">@lang('classcourse.Myclasses')</a></li>
                                @else
                                    <li class="breadcrumb-item"><a href="{{route('explore.classes')}}">@lang('classcourse.classes')</a></li>
                                @endif
                                <li class="breadcrumb-item active" aria-current="page">{{ $googleclass->name }}</li>
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
                            <br />
                        @endif
                        <div class="clearfix"></div>
                        <div class="tbs_of_report tbs_of_report-as">
                            <div class="dropdown">
                                <ul class="tabs_menu nav nav-pills mb-3 classes_tabs mrgn_tbs_less" id="pills-tab" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link active" id="summary-tab" data-toggle="pill" href="#summary" role="tab" aria-controls="summary" aria-selected="true">@lang('classcourse.summary')</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="assignments-tab" data-toggle="pill" href="#assignments" role="tab" aria-controls="assignments" aria-selected="false">@lang('classcourse.assignments')</a>
                                    </li>
                                    {{-- <li class="nav-item">
                                        <a class="nav-link " id="learners-tab" data-toggle="pill" href="#Learners" role="tab" aria-controls="learners" aria-selected="false">@lang('classcourse.learners')</a>
                                    </li>  --}}
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
                            <div class="earth_publish mrgn-tp-30 mrgn-bt-10">
                                <div class="name_list float-left">
                                    <h4>{{ $googleclass->name }}</h4>
                                </div>
                                <div class="publist_list float-right">
                                    <input id="route_name" type="hidden" value="{{Route::current()->getName()}}">
                                @Auth
                                    {{-- @php $user=Auth::user();
                                        $islearner =$googleclass->learners()->where('user_id','=',$user->id)->first();
                                    @endphp
                                    @if( $islearner )
                                            @if ($islearner->pivot->status=='Pending')
                                                <a href="javascript:void(0)" class="practice_btn requestjoin" style="cursor:default !important;">@lang('messages.requested')</a> 
                                            @elseif ($islearner->pivot->status=='Accepted')
                                                <a href="javascript:void(0)" class="btn practice_btn acsepted_btn icon_approvd" style="cursor:default !important;">@lang('messages.enrolled')</a> 
                                            @elseif ($islearner->pivot->status=='Rejected')                                               
                                                <a href="javascript:void(0)" class="practice_btn rejected_btn requestjoin" style="cursor:default !important;">@lang('messages.rejected')</a> 
                                            @endif
                                        @else                                        
                                            <a href="javascript:void(0)" data-toggle="modal" data-target="#okay_mdl" data-dismiss="modal" class="practice_btn btn enroll_green"
                                            onclick="requestjoin('{{route('courseclasses.courseclass.requestjpoin' ,$googleclass->id)}}');">@lang('messages.RequesttoJoin')</a>
                                        @endif                                         --}}
                                    @EndAuth
                                    @guest
                                          {{-- <a href="{{route('courseclasses.courseclass.requestjpoin' ,[$googleclass->id ,1])}}" data-toggle="modal" data-target="#okay_mdl" data-dismiss="modal" 
                                              class="practice_btn btn enroll_green requestjoin"
                                              >@lang('messages.RequesttoJoin')</a> --}}
                                    @endGuest
                                </div>
                            </div>
                                <div class="clearfix"></div>
                                <div class="summery_title">
                                <h3>@lang('classcourse.summary')</h3>
                                </div>
                            <div class="row">
                                <div class="col-lg-5 col-xl-4">
                                    <div class="inner_summery">
                                        
                                        <ul class="gnrl_info chnge_blue_icn mrgn-bt-20">
                                            <li data-toggle="tooltip" title="@lang('classcourse.exam')" class="check_lst_i">{{$googleclass->exams->count()}}</li>
                                            <li data-toggle="tooltip" title="@lang('classcourse.exercises')" class="list_i">{{$googleclass->exercises->count()}}</li>
                                            <li data-toggle="tooltip" title="@lang('classcourse.learner')" class="user_i_i">{{$googleclass->learners->count()}}</li>
                                        </ul>
                                        <ul class="excersie_list practice_list">
                                            <li>@lang('classcourse.course_id') : <span>{{ $googleclass->id }}</span></li>
                                        </ul>
                                        <ul class="status-action excersie_list practice_list">
                                            <li><label>@lang('classcourse.status') :</label>
                                                @if(!empty($learner))
                                                <label>
                                                @if($learner->status=='Invited')
    
    
                                                <a id="reject_btn"  class="cancel-request publishicon abtn"  style="background-color: transparent;padding: 0 " aria-hidden="true"  title="@lang('messages.Reject')"
                                                    onclick="accept_reject_learner( '{{ route('courseclasses.courseclass.reject', $learner->id) }}','{!! $learner->id !!}')">
                                                    </a>
                                                <a id="accept_btn"  class="accept-request publishicon abtn"
                                                    style="background-color: transparent;padding: 0" aria-hidden="true"  title="@lang('messages.Accept')"
                                                    onclick="accept_reject_learner( '{{ route('courseclasses.courseclass.accept', $learner->id) }}','{!! $learner->id !!}')">
                                                    </a>
                                                    @else
                                                        <b>{{$learner->status}}</b>
                                                    @endif</span>
                                                @else 
                                                    @lang('messages.not_available')
                                                @endif
                                                </label>
                                            </li>
                                        </ul>
                                        <ul class="excersie_list practice_list">
                                            <li>@lang('classcourse.curriculum'): <span>{{ optional($googleclass->discipline)->discipline_name }} </span></li>
                                        </ul>
                                        <ul class="excersie_list practice_list">
                                            <li>@lang('classcourse.Language') <span>{{ optional($googleclass->language)->language }}</span></li>
                                        </ul>
                                        <ul class="excersie_list practice_list">
                                            <li>@lang('classcourse.StartDate') <span> {{ date('d/m/Y', strtotime( $googleclass->start_date ))}}</span></li>
                                            <li>@lang('classcourse.EndDate') <span>{{ date('d/m/Y', strtotime( $googleclass->end_date ))}}</span></li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="col-lg-7 col-xl-8">
                                    <div class="about_teacher_block">
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
                            <!-- About class-->
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="discription_block mrgn-tp-20 mrgn-bt-20">
                                            <h4>{{ $googleclass->descriptionHeading }}</h4>
                                            <p>{{ $googleclass->description }}</p>
                                        </div>
                                    </div>
                                </div>
                            <!---End about class--->
                            </div>
                        </div>
                        <div class="tab-pane fade" id="assignments" role="tabpanel" aria-labelledby="assignments-tab">
                            @include('courseclasses.google_class.class_exams',$googleclass)
                        </div>
                        {{-- <div class="tab-pane fade" id="Learners" role="tabpanel" aria-labelledby="learners-tab">
                                Learner
                        </div>  --}}
                        <div class="tab-pane fade" id="resources" role="tabpanel" aria-labelledby="resources-tab">
                            <input type="hidden" id="class_id" value="{{ $googleclass->id }}">   
                             @include('courseclasses.google_class.class_exercises',$googleclass) 
                        </div>
                </div>
                                       
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

  <!--thank_you_model-->
  <div class="modal fade default_modal wht_bg_mdl" id="okay_mdl" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <button type="button" onclick="location.reload();" class="close" data-dismiss="modal" aria-label="Close"></button>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="right_contnt text-ar-right">
                                <h3>@lang('classcourse.thank_you')</h3>
                                <p class="enter_youremil">@lang('classcourse.request_sent_to_admin')</p> 
                                <div class="form-group">
                                    <button type="button" onclick="location.reload();" class="btn btn-primary btn-login drk_bg_btn">@lang('classcourse.okay')</button>
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
<script src="{{ asset('assets/eduplaycloud/js/accordion.js') }}"></script>
@endpush

<?php /*Load jquery to footer section*/ ?>
@push('inc_jquery')
<script src="{{ asset('assets/eduplaycloud/customs/js/class-request.js') }}"></script>
<script>
/*accordian*/
jQuery(document).ready(function($){
    $(".demo-accordion").accordionjs();    
});

var numItems = 0;
$(document).ready(function()
{
    $('body li #homeMenu').removeClass('active');
    $('body li #exploreMenu').addClass('active');
    numItems = $('.rew_prfl_sectin').nextUntil('.view_more').length;

    if(numItems >= 3) {
        $('div.after_1').nextUntil('.view_more').hide();
    }
    else {
        $('#view_more_link').hide();
    }
});

$('#view_more_link').click(function()
{
    if(numItems >= 3)
    {
        $('div.after_1').nextAll().show();
        $(this).hide();
        $('#view_less_link').show();
    }
});

$('#create_que_btn').click(function(e){
    e.preventDefault();
    $('#pills-tab > li > a[href="#simple_editor"]').tab('show');
})
</script>
<script>

  
function accept_reject_learner(url, id) {

    $.ajax({
        type: "GET",
        dataType: "html",
        url: url,
        data: {
            "_token": "{{ csrf_token() }}",
        },
        success: function (response) {
            // $('#classlearner_id' + id).empty();
            $('#request_'+id).remove();
            $('#classlearner_id').append(response);
            location.reload();
        },
        error: function (err) {
            console.log("AJAX error in request: " + JSON.stringify(err, null, 2));

        }
    })
}

// Tab selected code
$(document).ready(function() {
    if (location.hash) {
        $("a[href='" + location.hash + "']").tab("show");
    }
    $(document.body).on("click", "a[data-toggle]", function(event) {
        location.hash = this.getAttribute("href");
    });
});

</script>
@endpush