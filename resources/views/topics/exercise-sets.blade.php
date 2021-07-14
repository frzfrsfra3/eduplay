@extends('authenticated.layouts.default')
@section('content')
<div class="work_page mrgn_top_secn mrgn-bt-60 exercesi_block text-ar-right">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-12">
                <div class="disciplines_main text-ar-right">
                    <div class="col-sm-121"><p class="rlw_mdm">@lang('topic.please_select_preferred_exercise')</p></div>
                        <div id="flash_message"></div>
                        <div class="main_detail_fltr">
                            <div class="title_with_shrtby">
                                <div class="float-sm-left filtr_with_titile">                                   
                                        <a href="{{ route('topics.topic.index') }}" class="btn btn-primary cancel-btn cncle-prfct">@lang('topic.cancel')</a>
                                        <a href="javascript:;" class="btn btn-primary add_btn add-prfct practice_start_btn" >@lang('topic.next')</a>                
                                        <a class="mrgn_lft_20 collps_fltr" data-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample"><span class="flr-i"></span></a>
                                </div>
                                <div class="float-sm-right short_by text-right">
                                    <div class="short_by_select">
                                        <label>@lang('filter.sort_by_title') :</label>
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
                                <!--Filter Form Apply-->
                                <form id="filter-form" method="GET">
                                    <input id="base_path" type="hidden" value="{{url('/')}}">
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
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="list_of_exercise">
                                <div class="row" id="topic-exercise">
                                    @include('topics.filter-exercise',['exercisets' => $exercisets])
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 mrgn-bt-20">
                            <a href="{{ route('topics.topic.index') }}" class="btn btn-primary cancel-btn cncle-prfct">@lang('topic.cancel')</a>
                            <a href="javascript:;" class="btn btn-primary add_btn add-prfct practice_start_btn">@lang('topic.next')</a>
                        </div>
                        <!---Selected exercise sets submit form start-->
                        <form id="exercise_form" action="{{route('topics.exercisesets.skill')}}" method="GET">
                            @csrf
                            <div id="selected-exercises"></div>

                        </form>
                        <!---Selected exercise sets submit form end-->
                        <!---Selected exercise sets submit form for practice start-->
                        <form id="exercise_form_for_practice" action="{{route('topics.exercisesets.practice')}}" method="GET">
                            @csrf
                            <div id="selected-exercises-for-practice"></div>

                        </form>
                        <!---Selected exercise sets submit for practice form end-->
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
<script src="{{ asset('assets/eduplaycloud/customs/js/filter/topics-exercise-filter.js') }}" type="text/javascript"></script>
<script>
    /*accordian*/
    jQuery(document).ready(function($){
        $(".demo-accordion").accordionjs();
    });
</script>
@endpush

<?php /*Load jquery to footer section*/ ?>
@push('inc_jquery')

<script>

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
   
//Check box checked for public to class

var ExerciseCheckboxValues = [];
$('.practice_start_btn').on('click',function () {
    var checkedNum = $('input[name="topic_exercise[]"]:checked').length;
    if (checkedNum) {
        $('input[name="topic_exercise[]"]:checked').each(function(index, elem) {
            ExerciseCheckboxValues.push($(elem).val());
        });
        // Function call
        appendSelectedExercisesAndSubmitForm(ExerciseCheckboxValues)
    } else { 
          var checkedNumNoCurriculum = $('input[name="topic_exercise_no_grate[]"]:checked').length;
          if (checkedNumNoCurriculum) {
            $('input[name="topic_exercise_no_grate[]"]:checked').each(function(index, elem) {
                ExerciseCheckboxValues.push($(elem).val());
            });
            // Function call
            appendSelectedExercisesAndSubmitFormForDirectPractice(ExerciseCheckboxValues)
           } else {

              var message = '<div class="alert alert-warning alert-dismissible fade show" role="alert">'
                          + '<strong>@lang("topic.warning") !</strong>@lang("topic.select_minimum_one")'
                          + '<button type="button" class="close" data-dismiss="alert" aria-label="Close">'
                          + '<span aria-hidden="true">&times;</span>'
                          +'</button>'
                          +'</div>';
              
              $('#flash_message').html(message);
           } 
        
        
    }
});

// Redirect to select skill categories page with selected exercise ids.
function appendSelectedExercisesAndSubmitForm(ExerciseCheckboxValues){
        
        $('#selected-exercises').html("<input type='hidden' name='exercises' value='" + ExerciseCheckboxValues + "' >");
        $('#exercise_form').submit();
}

// Redirect to direct practice page with selected exercise ids.
function appendSelectedExercisesAndSubmitFormForDirectPractice(ExerciseCheckboxValues){
        
        $('#selected-exercises-for-practice').html("<input type='hidden' name='exercises' value='" + ExerciseCheckboxValues + "' >");
        $('#exercise_form_for_practice').submit();
}

</script>

@endpush