@extends('authenticated.layouts.default')
@section('content')

<!--Share By Mail Model-->
<div class="modal fade default_modal wht_bg_mdl" id="share_mail" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="right_contnt text-ar-right">
                            <h3>@lang('exercisesets.mail')</h3>
                            <form class="def_form" action="{{route('mail.assignment')}}" id="share_email_form" method="POST">
                                {{ csrf_field() }}
                                <div class="form-group">
                                    <input type="hidden" id="url" name="url" value=""  class="form-control">
                                </div>
                                <div class="form-group">
                                    <label>@lang('exercisesets.enter_email'): </label>
                                   <input type="email" id="email" name="email" value=""  class="form-control" required>
                                </div>
                                <div class="form-group mrgn-tp-30">
                                    <button type="submit" class="btn btn-primary btn-login drk_bg_btn">@lang('exercisesets.send')</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

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
                                <a class="mrgn_lft_20 collps_fltr" data-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample"><span class="flr-i"></span></a>
                            </div>
                            <div class="float-sm-right short_by text-right">
                                <div class="short_by_select">
                                    <label>@lang('filter.sort_by'):</label>
                                    <select class="selectpicker" id="filter-heading">
                                      <option value="Topic">@lang('filter.topic')</option>
                                      <option value="Curriculum">@lang('classcourse.curriculum')</option>
                                      <option value="Grade">@lang('filter.grade')</option>
                                      <option value="Title">@lang('classcourse.title')</option>
                                      <option value="CourseId">@lang('classcourse.course_id')</option>
                                      <option value="Number of learners">@lang('filter.number_of_learners')</option>
                                    </select>
                                    <select class="selectpicker" id="sort-by">
                                        <option value="Ascending">@lang('filter.ascending')</option>
                                        <option value="Descending">@lang('filter.descending')</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                        <div class="list_of_filter collapse" id="collapseExample">
                            <div class="card card-body">
                                <input id="route_name" type="hidden" value="{{Route::current()->getName()}}">
                                <!--Filter Form Apply-->
                                <form id="filter-form" method="GET">
                                        @if(request()->has('discipline'))
                                            <input type="hidden" name="discipline_id" value="{{request('discipline')}}">
                                            <input type="hidden" name="language_id" value="{{request('language')}}">
                                        @endif
                                    <div class="mani_menu_list">
                                        <div class="float-left">
                                            <a class="open_filter" href="javascript:;"><i class="plus_icn"></i></a>
                                            <ul class="studnt_list_nm" id="fltered-text-list">
                                                <!--Filter text append here-->
                                            </ul>
                                        </div>
                                        <div class="float-right clear_all_cls">
                                            <a href="javascript:;" id="clear_all_btn" class="clear_all_btn">@lang('filter.clear_all')</a>
                                        </div>
                                    </div>
                                </form>
                                <!--End filer form-->
                                <div class="slct_drop_box">
                                    <ul class="demo-accordion accordionjs " data-active-index="false">
                                      <li>
                                          <div class="section_cls">
                                                <h3>@lang('filter.language')</h3>
                                            </div>
                                            <div class="class-detail">
                                                <form  class="def_form">
                                                    <div class="form-group">
                                                        <div class="df-select">
                                                            <select class="selectpicker" id="language-name">
                                                                <option value="0" selected disabled>@lang('filter.select_language')</option>
                                                                @foreach ($languages as $language)
                                                                    <option value="{{$language->id}}"> {{$language->language}} </option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <button id="language-apply" type="button" class="btn btn-primary apply_sm_btn">@lang('filter.apply')</button>
                                                </form>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="section_cls">
                                                <h3>@lang('filter.topic')</h3>
                                            </div>
                                            <div class="class-detail">
                                                <form  class="def_form">
                                                    <div class="form-group">
                                                        <div class="df-select">
                                                            <select class="selectpicker" id="topic-operator">
                                                                <option value="0"  selected disabled>@lang('filter.select_operator')</option>
                                                                <option value="=">=</option>
                                                                <option value="like">@lang('filter.like')</option>
                                                                {{-- <option value="na">@lang('filter.n/a')</option> --}}
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <div class="df-select">
                                                            <input type="text" id="topic-name" class="form-control">
                                                        </div>
                                                    </div>
                                                    <button id="topic-apply" type="button" class="btn btn-primary apply_sm_btn">@lang('filter.apply')</button>
                                                </form>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="section_cls">
                                                <h3>@lang('filter.curriculum')</h3>
                                            </div>
                                            <div class="class-detail">
                                                <form  class="def_form">
                                                    <div class="form-group">
                                                        <div class="df-select">
                                                            <select class="selectpicker" id="disicipline-operator">
                                                                <option value="0"  selected disabled>@lang('filter.select_operator')</option>
                                                                <option value="=">=</option>
                                                                <option value="like">@lang('filter.like')</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <div class="df-select">
                                                            <input type="text" id="disicipline-name" class="form-control">
                                                        </div>
                                                    </div>
                                                    <button id="disicipline-apply" type="button" class="btn btn-primary apply_sm_btn">@lang('filter.apply')</button>
                                                </form>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="section_cls">
                                                <h3>@lang('filter.grade')</h3>
                                            </div>
                                            <div class="class-detail">
                                                <form  class="def_form">
                                                    <div class="form-group">
                                                        <div class="df-select">
                                                            <select class="selectpicker" id="grade-operator">
                                                                <option value="0"  selected disabled>@lang('filter.select_operator')</option>
                                                                <option>=</option>
                                                                <option value="like">@lang('filter.like')</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <div class="df-select">
                                                            <input type="text" id="grade-name" class="form-control">
                                                        </div>
                                                    </div>
                                                    <button id="grade-apply" type="button" class="btn btn-primary apply_sm_btn">@lang('filter.apply')</button>
                                                </form>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="section_cls">
                                                <h3>@lang('filter.title')</h3>
                                            </div>
                                            <div class="class-detail">
                                                <form  class="def_form">
                                                    <div class="form-group">
                                                        <div class="df-select">
                                                            <select class="selectpicker" id="title-operator">
                                                                <option value="0" selected disabled>@lang('filter.select_operator')</option>
                                                                <option value="=" >@lang('filter.equal')</option>
                                                                <option value="like">@lang('filter.contains')</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <div class="df-select">
                                                            <input type="text" id="title-name" class="form-control">
                                                        </div>
                                                    </div>
                                                    <button id="title-apply" type="button" class="btn btn-primary apply_sm_btn">@lang('filter.apply')</button>
                                                </form>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="section_cls">
                                                <h3>@lang('classcourse.course_id') </h3>
                                            </div>
                                            <div class="class-detail">
                                                <form  class="def_form">
                                                    <div class="form-group">
                                                        <div class="df-select">
                                                            <input type="number" id="course_id" class="form-control">
                                                        </div>
                                                    </div>
                                                    <button id="course-apply" type="button" class="btn btn-primary apply_sm_btn">@lang('filter.apply')</button>
                                                </form>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="section_cls">
                                                <h3>@lang('filter.teacher') </h3>
                                            </div>
                                            <div class="class-detail">
                                                <form  class="def_form">
                                                    <div class="form-group">
                                                        <div class="df-select">
                                                            <select class="selectpicker" id="teacher-operator">
                                                                <option value="0" selected disabled>@lang('filter.select_operator') </option>
                                                                <option value="=" >@lang('filter.equal') </option>
                                                                <option value="like">@lang('filter.contains') </option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <div class="df-select">
                                                            <input type="text" id="teacher-name" class="form-control">
                                                        </div>
                                                    </div>
                                                    <button id="teacher-apply" type="button" class="btn btn-primary apply_sm_btn">@lang('filter.apply')</button>
                                                </form>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="section_cls">
                                                <h3>@lang('filter.number_of_learners')</h3>
                                            </div>
                                            <div class="class-detail">
                                                <form  class="def_form">
                                                    <div class="form-group">
                                                        <div class="df-select">
                                                            <select class="selectpicker" id="learner-operator">
                                                                <option value="0"  selected disabled>@lang('filter.select_operator')</option>
                                                                <option value="="> = </option>
                                                                <option value="<"> < </option>
                                                                <option value=">"> > </option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <div class="df-select">
                                                            <input type="text" id="learner-name" class="form-control">
                                                        </div> 
                                                    </div>
                                                    <button id="learner-apply" type="button" class="btn btn-primary apply_sm_btn">@lang('filter.apply')</button>
                                                </form>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="section_cls">
                                                <h3>@lang('filter.publish_date')</h3>
                                            </div>
                                            <div class="class-detail">
                                                <form  class="def_form">
                                                    <div class="form-group">
                                                        <div class="df-select">
                                                            <input type="text" class="form-control" placeholder="@lang('filter.start_date')" name="startDate" id="startDate">
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <div class="df-select">
                                                            <input type="text" class="form-control" placeholder="@lang('filter.end_date')" name="endDate" id="endDate">
                                                        </div>
                                                    </div>
                                                    <button id="created-date-apply" type="button" class="btn btn-primary apply_sm_btn">@lang('filter.apply')</button>
                                                </form>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="main_dashboard mrgn-tp-10 aaa">
                        <div class="list_of_exercise mrgn-tp-20">
                            <div class="row" id="course-classes">

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
<script src="{{ asset('assets/eduplaycloud/customs/js/filter/classes-filter.js') }}"></script>
<script src="{{ asset('assets/eduplaycloud/customs/js/filter/save-filter.js') }}"></script>
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
    //Email send in exersice id get.
    function generateEmailUrl(id){
    $('#url').val($('#'+id).attr('data-exerciseset'));
    $('#share_mail').modal('show');
}

//Develop by WC
$(document).ready(function(){

    $("#share_email_form").validate({
        rules: {
            email: {
                required: true,
                email: true
            },
        },
        messages: {

        }
    });
})

</script>
@endpush