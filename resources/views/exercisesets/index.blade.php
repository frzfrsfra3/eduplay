@extends('authenticated.layouts.default')
@section('content')
<div class="work_page mrgn_top_secn mrgn-bt-60 exercesi_block text-ar-right">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-12">
               @include('eduplaycloud.explore.explore_header')    
               <div id="custom-jquery-msg">
            </div>         
                <div class="my_exercise mrgn-tp-50 mrgn-bt-30">
                    <div class="main_detail_fltr">
                        <div class="title_with_shrtby">
                            <div class="float-sm-left filtr_with_titile">
                                <h4 class="exersc_title">@lang('exercisesets.exercise_set')</h4>
                                <a class="mrgn_lft_20 collps_fltr" data-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample"><span class="flr-i"></span></a>
                            </div>
                            <div class="float-sm-right short_by text-right">
                                @if (isset($class_id))
                                    @if (Auth::user()->hasRole('Teacher'))
                                        <a href="javascript:;" id="publish_to_class_btn" class="publish_class_btn">@lang('exercisesets.publish_to_class')</a>
                                    @endif
                                <br/><br/>
                                @endif
                                <div class="short_by_select">
                                    <label>@lang('filter.sort_by') : </label>
                                    <select class="selectpicker" id="filter-heading">
                                      <option value="Language">@lang('filter.language')</option>
                                      <option value="Topic">@lang('filter.topic')</option>
                                      <option value="Curriculum">@lang('filter.curriculum')</option>
                                      <option value="Grade">@lang('filter.grade')</option>
                                      <option value="Title">@lang('filter.title')</option>
                                      <option value="Number Of Questions">@lang('filter.number_of_questions')</option>
                                      <option value="Number Of Student">@lang('filter.number_of_student')</option>
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
                                <!--Filter Form Apply-->
                                <form id="filter-form" method="GET">
                                    <div class="mani_menu_list">
                                        <div class="float-left">
                                            <a class="open_filter" href="javascript:;"><i class="plus_icn"></i></a>
                                            <input type="hidden" name="class_id" id="class_id" value="{{ $class_id}}"/>
                                            @if(request()->has('discipline'))
                                            <input type="hidden" name="discipline_id" value="{{request('discipline')}}">
                                            <input type="hidden" name="language_id" value="{{request('language')}}">
                                            <input type="hidden" name="topic_id" value="{{request('topic')}}">
                                            @endif
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
                                                                <option value="0" selected disabled>@lang('filter.select_operator')</option>
                                                                <option value="=">=</option>
                                                                <option value="like">@lang('filter.like')</option>
                                                                <option value="na">@lang('filter.n/a')</option>
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
                                                <form class="def_form">
                                                    <div class="form-group">
                                                        <div class="df-select">
                                                            <select class="selectpicker" id="grade-operator">
                                                                <option value="0" selected disabled>@lang('filter.select_operator')</option>
                                                                <option value="=">=</option>
                                                                <option value="like">@lang('filter.like')</option>
                                                                <option value="na">@lang('filter.n/a')</option>
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
                                                <h3>@lang('filter.title') </h3>
                                            </div>
                                            <div class="class-detail">
                                                <form class="def_form">
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
                                                <h3>@lang('filter.teacher')</h3>
                                            </div>
                                            <div class="class-detail">
                                                <form class="def_form">
                                                    <div class="form-group">
                                                        <div class="df-select">
                                                            <select class="selectpicker" id="teacher-operator">
                                                                <option value="0" selected disabled>@lang('filter.select_operator')</option>
                                                                <option value="=">=</option>
                                                                <option value="like">@lang('filter.like')</option>
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
                                                <h3>@lang('filter.number_of_questions')</h3>
                                            </div>
                                            <div class="class-detail">
                                                <form  class="def_form">
                                                    <div class="form-group">
                                                        <div class="df-select">
                                                            <select class="selectpicker" id="question-operator">
                                                                <option value="0"  selected disabled>@lang('filter.select_operator')</option>
                                                                <option value="="> = </option>
                                                                <option value="<"> < </option>
                                                                <option value=">"> > </option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <div class="df-select">
                                                            <input type="text" id="question-name" class="form-control">
                                                        </div>
                                                    </div>
                                                    <button id="question-apply" type="button" class="btn btn-primary apply_sm_btn">@lang('filter.apply')</button>
                                                </form>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="section_cls">
                                                <h3>@lang('filter.number_of_student')</h3>
                                            </div>
                                            <div class="class-detail">
                                                <form  class="def_form">
                                                    <div class="form-group">
                                                        <div class="df-select">
                                                            <select class="selectpicker" id="buyer-operator">
                                                                <option value="0"  selected disabled>@lang('filter.select_operator')</option>
                                                                <option value="="> = </option>
                                                                <option value="<"> < </option>
                                                                <option value=">"> > </option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <div class="df-select">
                                                            <input type="text" id="buyer-name" class="form-control">
                                                        </div>
                                                    </div>
                                                    <button id="buyer-apply" type="button" class="btn btn-primary apply_sm_btn">@lang('filter.apply')</button>
                                                </form>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="section_cls">
                                                <h3>@lang('filter.rating')</h3>
                                            </div>
                                            <div class="class-detail">
                                                <form  class="def_form">
                                                    <div class="form-group">
                                                        <div class="df-select">
                                                            <select class="selectpicker" id="rating-name">
                                                                <option value="0"  selected disabled>@lang('filter.select_operator')</option>
                                                                <option data-content="&lt;i class=&#039;fa fa-star&#039;&gt;&lt;/i&gt;" value="1.0"></option>
                                                                <option data-content="&lt;i class=&#039;fa fa-star&#039;&gt;&lt;/i&gt;&lt;i class=&#039;fa fa-star&#039;&gt;&lt;/i&gt;" value="2.0"></option>
                                                                <option data-content="&lt;i class=&#039;fa fa-star&#039;&gt;&lt;/i&gt;&lt;i class=&#039;fa fa-star&#039;&gt;&lt;/i&gt;&lt;i class=&#039;fa fa-star&#039;&gt;&lt;/i&gt;" value="3.0"></option>
                                                                <option data-content="&lt;i class=&#039;fa fa-star&#039;&gt;&lt;/i&gt;&lt;i class=&#039;fa fa-star&#039;&gt;&lt;/i&gt;&lt;i class=&#039;fa fa-star&#039;&gt;&lt;/i&gt;&lt;i class=&#039;fa fa-star&#039;&gt;&lt;/i&gt;" value="4.0"></option>
                                                                <option data-content="&lt;i class=&#039;fa fa-star&#039;&gt;&lt;/i&gt;&lt;i class=&#039;fa fa-star&#039;&gt;&lt;/i&gt;&lt;i class=&#039;fa fa-star&#039;&gt;&lt;/i&gt;&lt;i class=&#039;fa fa-star&#039;&gt;&lt;/i&gt;&lt;i class=&#039;fa fa-star&#039;&gt;&lt;/i&gt;" value="5.0"></option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <button id="rating-apply" type="button" class="btn btn-primary apply_sm_btn">@lang('filter.apply')</button>
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
                                                            <input type="text" class="form-control" placeholder="@lang('filter.start_date')" id="startDate">
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <div class="df-select">
                                                            <input type="text" class="form-control" placeholder="@lang('filter.end_date')" id="endDate">
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
                    <div class="list_of_exercise mrgn-tp-30">
                        <div class="row" id="public_library_result"></div>
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
<script src="{{ asset('assets/eduplaycloud/customs/js/filter/public-library-filter.js') }}"></script>
<script src="{{ asset('assets/eduplaycloud/customs/js/filter/save-filter.js') }}"></script>
<script>
@if(\Request::segment(2) == 'publiclibrary')
    $('#pills-Libray-tab').trigger('click');
    // $('.nav-tabs a[href="#pills-Libray"]').tab('show')
    // $('#pills-Libray-tab').addClass('active');
@endif
</script>
<script>
    $(window).bind("pageshow", function() { // update hidden input field 
        //$('#formid')[0].reset(); 
        $("#sort-by").val(0).selectpicker("refresh");
    });

    

    // Accordion
    jQuery(document).ready(function($){
        $(".demo-accordion").accordionjs();
    });
</script>
<script>
    var checkboxValues = [];

    //Sunmit publish to class.
$('#publish_to_class_btn').on('click', function(){
    
    var checkedNum = $('input[name="exerses[]"]:checked').length;
        if (checkedNum) {
            $('#publish_cls').modal('show');

            $('input[name="exerses[]"]:checked').each(function(index, elem) {
                checkboxValues.push($(elem).val());
            });

      
    swal({
          text: "@lang('exercisesets.sure_publish')",
          icon: "warning",
          buttons: [
            '@lang("exercisesets.cancel_it")',
            '@lang("exercisesets.sure")'
          ],
          dangerMode: true,
        }).then(function(isConfirm) {
                if (isConfirm) {
                    var selectedClass = $('#class_id').val();
                    $.ajax({
                            url: site_url + "/exercisesets/pusblish-to-class/",
                            data: {'exercises':checkboxValues , 'class': selectedClass,'status' : 'public' },
                            type: 'GET',
                            success: function(result) {

                                if(result.message === 'success'){
                                    swal({
                                        title: '@lang("exercisesets.publish")!',
                                        text: '@lang("exercisesets.exercises_published")',
                                        icon: 'success',
                                        button: {
                                            text: "@lang('exercisesets.ok')",
                                        }
                                        
                                    }).then(function() {
                                        if($('#class_id').val() !== ''){
                                            var redirect = site_url + "/courseclasses/show/" + selectedClass + "?#resources";
                                            window.location.href = redirect;
                                        } else {
                                            $('input[name="exerses[]').removeAttr('checked');
                                            location.reload();
                                        }
                                    } );

                                } else {
                                    $('#custom-jquery-msg').html('<div class="alert alert-warning"><i class="fa fa-check-square-o" aria-hidden="true"></i>@lang("exercisesets.already_published")<button type="button" class="close" data-dismiss="alert" aria-label="close"><span aria-hidden="true">&times;</span></button></div>');
                                }
                        }
                    });

          } else {
            $('input:checkbox').removeAttr('checked');
            // swal("Cancelled", "You have cancelled publish class", "error");
          }
        });

    } else {
            $('#custom-jquery-msg').html('<div class="alert alert-danger"><i class="fa fa-check-square-o" aria-hidden="true"></i>@lang("exercisesets.please_select_exercise_first")<button type="button" class="close" data-dismiss="alert" aria-label="close"><span aria-hidden="true">&times;</span></button></div>');
        }
});

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

    $(document).ready(function () {
        if (window.location.hash) {
            var hrf =  $('.summary-tbs a[href="'+window.location.hash+'"]').tab('show');
        } 
    }); 
</script>
@endpush