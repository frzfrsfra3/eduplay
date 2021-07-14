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
                            <br />
                        @endif
                        <div class="clearfix"></div>
                        <div class="tbs_of_report tbs_of_report-as">
                            <div class="dropdown">
                                <ul class="tabs_menu nav nav-pills mb-3 classes_tabs mrgn_tbs_less" id="pills-tab" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link active" id="summary-tab" data-toggle="pill" href="#summary" role="tab" aria-controls="summary" aria-selected="true">@lang('classcourse.summary')</a>
                                    </li>


                                    @auth
                                        @php $user=Auth::user();
                                            $islearner = $courseclass->learners()->where('user_id','=',$user->id)->first();
                                        @endphp
                                        @if( $islearner )
                                                @if ($islearner->pivot->status=='Accepted')
                                                    <li class="nav-item">
                                                        <a class="nav-link" id="assignments-tab" data-toggle="pill" href="#assignments" role="tab" aria-controls="assignments" aria-selected="false" onclick="getClassesAssignment()">@lang('classcourse.assignments')</a>
                                                    </li>
                                                    <li class="nav-item">
                                                        <a class="nav-link" id="resources-tab" data-toggle="pill" href="#resources" role="tab" aria-controls="resources" aria-selected="false">@lang('classcourse.resources')</a>
                                                    </li>
                                                @endif

                                        @endif                                        
                                    @endAuth
                                </ul>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                            
                        <div class="tab-content">
                        <div class="tab-pane fade show active" id="summary" role="tabpanel" aria-labelledby="summary-tab">
                        <div class="main_summery_earth pd_lf_25">
                            <div class="earth_publish mrgn-tp-30 mrgn-bt-10">
                                <div class="name_list float-left">
                                    <h4>{{ $courseclass->class_name }}</h4>
                                </div>
                                <div class="publist_list float-right">
                                    <input id="route_name" type="hidden" value="{{Route::current()->getName()}}">
                                @Auth
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
                                            onclick="requestjoin('{{route('courseclasses.courseclass.requestjpoin' ,$courseclass->id)}}');">@lang('messages.RequesttoJoin')</a>
                                        @endif                                        
                                    @EndAuth
                                    @guest
                                        <a href="{{route('courseclasses.courseclass.requestjpoin' ,[$courseclass->id ,1])}}" data-toggle="modal" data-target="#okay_mdl" data-dismiss="modal" 
                                            class="practice_btn btn enroll_green requestjoin"
                                            >@lang('messages.RequesttoJoin')</a>
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
                                            <li>@lang('classcourse.curriculum'): <span>{{ optional($courseclass->discipline)->discipline_name }} </span></li>
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
                            <!-- About class-->
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="discription_block mrgn-tp-20 mrgn-bt-20">
                                            <h4>@lang('classcourse.about_class')</h4>
                                            <p>{{ $courseclass->class_description }}</p>
                                        </div>
                                    </div>
                                </div>
                            <!---End about class--->
                            {{-- @if(  $learner->status=='Accepted')
                                <!-- Exam secion-->
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="discription_block bg-white mrgn-bt-20">
                                            <h4>@lang('classcourse.exams')</h4>
                                            <table class="table">
                                            @foreach($courseclass->exams()->get() as $exam)
                                                @php
                                                    $classexam=\App\Models\Classexam::findorfail($exam->pivot->id)  ;
                                                @endphp                                            
                                                <tr>
                                                    <td>
                                                        <a href="{{route('takeexam.index', [$exam->id  ,$courseclass->id ] )}}" style="color: inherit;" >
                                                            {{$exam->title}}                
                                                        </a> 
                                                    </td>
                                            
                    
                                                <td>
                                                    <label>@lang('filter.start_date')</label>    {{ $exam->pivot->exam_start_date}}
                                                </td>
                                                <td>
                                                    <label>@lang('filter.start_date')</label>  {{ $exam->pivot->exam_end_date}}
                                                </td>
                                                <td>            
                                                    @can ('takeexam' ,$classexam)
                                                        <a href="{{route('takeexam.index' ,[$exam->id , $exam->pivot->class_id , $isexam="1"])}}" class="creat_new" >@lang('classcourse.take_exam')</a>
                                                    @endcan
                                                    @can ('getresult' ,$classexam)
                                                        <a href="{{route('takeexam.score',[$exam->pivot->id ,$isexam="1"])}}" class="btn submit_btn" >@lang('classcourse.show_result')</a>        
                                                    @endcan
                                                </td>
                                                </tr>
                                            @endforeach
                                            </table>
                                        </div>
                                    </div>
                                </div> --}}
                                <!--End exam section-->
                                {{-- @endif --}}
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
                                                                    <div class="rew_prfl_sectin view_more">
                                                                        <a href="javascript:;" id="view_more_link" class="view_more_btn">@lang('classcourse.view_more')</a>
                                                                        <a href="javascript:;" id="view_less_link" class="view_more_btn" style="display:none;">@lang('classcourse.view_less')</a>
                                                                    </div>
                                                                    <div class="write_review mrgn-tp-20">
                                                                        <div class="accordion write_accordion" id="accordionExample">
                                                                            <div class="card">
                                                                                <button class="btn btn-link write_rivw_bnt" type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                                                                    @lang('classcourse.write_a_review')
                                                                                </button>
                                                                                <div id="collapseOne" class="collapse" aria-labelledby="headingOne" data-parent="#accordionExample">
                                                                                    <div class="card-body">
                                                                                        <form class="def_form riew_frm" id="review_form" method="POST">
                                                                                            @csrf
                                                                                            <div class="form-group">
                                                                                                <div class="text-right text-ar-left posted_list">
                                                                                                    <a href="#">@lang('classcourse.posted_as'){{Auth::user()->name}} </a>
                                                                                                    <a href="javascript:;" id="clear_review">@lang('classcourse.clear')</a>
                                                                                                </div>
                                                                                                <input type="hidden" name="id" id="exerciseset_id" value="{{$courseclass->id}}">
                                                                                                <textarea class="form-control" name="comment" id="comment" placeholder="@lang('classcourse.write_a_review')"></textarea>
                                                                                            </div>
                                                                                            <ul class="star_wth_user">
                                                                                                <li>
                                                                                                    <div id="give_rate"></div>
                                                                                                    <span class="rtng blue-clr">@lang('classcourse.overall_rating')</span>
                                                                                                </li>
                                                                                            </ul>
                                                                                            <div class="form-group">
                                                                                                <button type="button" class="submit_btn" id="submit_review">@lang('classcourse.submit')</button>
                                                                                                <button type="button" class="cancel-gry-btn" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">@lang('classcourse.cancel')</button>
                                                                                            </div>
                                                                                        </form>
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
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @auth
                        @if( $islearner )
                                @if ($islearner->pivot->status=='Accepted')
                                    <div class="tab-pane fade" id="assignments" role="tabpanel" aria-labelledby="assignments-tab">
                                        @include('courseclasses.class_exams',$courseclass)
                                    </div>
                                    {{-- <div class="tab-pane fade" id="Learners" role="tabpanel" aria-labelledby="learners-tab">
                                            Learner
                                    </div>  --}}
                                    <div class="tab-pane fade" id="resources" role="tabpanel" aria-labelledby="resources-tab">
                                        <input type="hidden" id="class_id" value="{{ $courseclass->id }}">   
                                        @include('courseclasses.class_exercises',$courseclass)
                                    </div>
                                @endif
                        @endif                                        
                    @endAuth
                        
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
<script src="{{ asset('assets/eduplaycloud/customs/js/filter/assignment-filter.js') }}"></script>
{{-- <script type="text/javascript" src="{{ asset('assets/eduplaycloud/customs/js/pages/private-library/simple-editor.js') }}"></script> --}}
<script src="{{ asset('assets/eduplaycloud/customs/js/filter/pins-class-filter.js') }}"></script>
<script src="{{asset('assets/eduplaycloud/customs/js/raty-master/lib/jquery.raty.js')}}"></script>
<script src="{{ asset('assets/eduplaycloud/js/accordion.js') }}"></script>
<script src="{{ asset('assets/eduplaycloud/customs/js/filter/save-filter.js') }}"></script>
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

$('#give_rate').on('click',function() {
    $('#rating_err').html('');
});
    $('#give_rate').raty({
    starOff: "{{asset('assets/eduplaycloud/customs/js/raty-master/lib/images/star-off.png')}}",
    starOn: "{{asset('assets/eduplaycloud/customs/js/raty-master/lib/images/star-on.png')}}",
    hints: ['bad', 'poor', 'regular', 'good', 'gorgeous'],
});

$("#submit_review").click( function()
{
    $.ajax({
        url: "{{route('courseclasses.courseclass.addclassreview')}}",
        type: "post",
        dataType: 'json',
        data: $('#review_form').serialize(),
        success: function(response){ // What to do if we succeed
            if (response == 'fail') {
                $('#rating_err').html('@lang("exercisesets.select_rating")');
            }
            if(response == 'success')
                location.reload();
        },
        error: function(response){
            console.log('Error'+response);
        }
    });
});

$('#clear_review').click(function()
{
    $('#comment').val('');
    $('#give_rate').raty('reload'); 
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
    getClassesAssignment();
    if (location.hash) {
        $("a[href='" + location.hash + "']").tab("show");
    }
    $(document.body).on("click", "a[data-toggle]", function(event) {
        location.hash = this.getAttribute("href");
    });
});
{{--  $(window).on("popstate", function() {
    $("a[href='" + anchor + "']").tab("show");
});  --}}

</script>
@endpush