@extends('guest.layouts.default')
@section('content')
<div class="work_page mrgn_top_secn mrgn-bt-60 exercesi_block text-ar-right">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-12">
                @include('eduplaycloud.explore.explore_header')
                <!--Filter part-->
                <div class="main_detail_fltr pad_lfsd_15">
                    <div class="title_with_shrtby"> 
                        <div class="float-sm-left filtr_with_titile">
                            <h4 class="exersc_title">@lang("explore.topics")</h4>
                            @if(!Auth::guest())
                            <a href="javascript:;" class="creat_new  " data-toggle="modal"
                            data-target="#New_Disciplines" data-dismiss="modal">@lang("messages.request_new")</a>
                            @endif
                            <a class="mrgn_lft_20 collps_fltr" data-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample"><span class="flr-i"></span></a>
                        </div>
                        <div class="float-sm-right short_by text-right">
                            <div class="short_by_select">
                                <label> @lang('filter.sort_by') : </label>
                                <select class="selectpicker" id="filter-heading">
                                  <option value="Language">@lang('filter.language')</option>
                                  <option value="Number Of Exercise Set">@lang('filter.number_of_exercise_set')</option>
                                  <option value="Number Of Curriculum">@lang('filter.number_of_curriculum')</option>                                 
                                </select>
                                <select class="selectpicker" id="sort-by">
                                    <option value="Ascending">@lang("filter.ascending") </option>
                                    <option value="Descending">@lang("filter.descending") </option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                    <div class="list_of_filter collapse" id="collapseExample">
                        <div class="card card-body">
                        <!--Filter Form Apply-->
                        <form id="filter-form" method="GET">
                            <input id="base_path" type="hidden" value="{{ url('/') }}">
                            <div class="mani_menu_list">
                                <div class="float-left">
                                    <a class="open_filter" href="javascript:;"><i class="plus_icn"></i></a>
                                    <ul class="studnt_list_nm" id="fltered-text-list">
                                        <!--Filter text append here-->
                                    </ul>
                                </div>
                                <div class="float-right clear_all_cls">
                                    <a href="javascript:;" id="clear_all_btn" class="clear_all_btn">@lang("filter.clear_all")</a>
                                </div>
                            </div>
                        </form>
                        <!--End filer form-->
                            <div class="slct_drop_box">
                                <ul class="demo-accordion accordionjs " data-active-index="false">
                                    {{-- <li>
                                        <div class="section_cls">
                                            <h3>@lang("filter.title")</h3>
                                        </div>
                                        <div class="class-detail">
                                            <form  class="def_form">
                                                <div class="form-group">
                                                    <div class="df-select">
                                                        <select class="selectpicker" id="title-operator">
                                                            <option value="0" selected disabled>@lang("filter.select_operator")</option>
                                                            <option value="=">@lang("filter.equal")</option>
                                                            <option value="like">@lang("filter.contains")</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="df-select">
                                                        <input type="text" id="title-name" class="form-control">
                                                    </div>
                                                </div>
                                                <button id="title-apply" type="button" class="btn btn-primary apply_sm_btn">@lang("filter.apply")</button>
                                            </form>
                                        </div>
                                    </li> --}}
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
                                            <h3>@lang('filter.number_of_exercise_set')</h3>
                                        </div>
                                        <div class="class-detail">
                                            <form  class="def_form">
                                                <div class="form-group">
                                                    <div class="df-select">
                                                        <select class="selectpicker" id="exercisesets-operator">
                                                            <option value="0"  selected disabled>@lang('filter.select_operator')</option>
                                                            <option value="="> = </option>
                                                            <option value="<"> < </option>
                                                            <option value=">"> > </option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="df-select">
                                                        <input type="text" id="exercisesets-name" class="form-control">
                                                    </div>
                                                </div>
                                                <button id="exercisesets-apply" type="button" class="btn btn-primary apply_sm_btn">@lang('filter.apply')</button>
                                            </form>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="section_cls">
                                            <h3>@lang('filter.number_of_curriculum')</h3>
                                        </div>
                                        <div class="class-detail">
                                            <form  class="def_form">
                                                <div class="form-group">
                                                    <div class="df-select">
                                                        <select class="selectpicker" id="curriculum-operator">
                                                            <option value="0"  selected disabled>@lang('filter.select_operator')</option>
                                                            <option value="="> = </option>
                                                            <option value="<"> < </option>
                                                            <option value=">"> > </option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="df-select">
                                                        <input type="text" id="curriculum-name" class="form-control">
                                                    </div>
                                                </div>
                                                <button id="curriculum-apply" type="button" class="btn btn-primary apply_sm_btn">@lang('filter.apply')</button>
                                            </form>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <!--End Filter Section-->
                <div class="disciplines_main pad_lfsd_15" id="topics-result"></div>
            </div>
        </div>
    </div>
</div>
<!-- Maths Modal-->
<div class="modal fade default_modal maths_modal" id="Maths_Modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="right_contnt text-ar-right">
                            <div class="row">
                                {{-- @include('topics.auth-settings') --}}
                                <div class="col-md-7 pddng_llf">
                                        <h3>
                                            @php
                                                if (isset($topic_id) && !empty($topic_id)):
                                                    $topic_id;
                                                else:
                                                    $topic_id = 0;
                                                endif;
                                    
                                                if (isset($topic_name) && !empty($topic_name)):
                                                    echo $topic_name;
                                                endif;
                                            @endphp
                                        </h3>
                                        <form name="frmSettings" id="frmSettings" class="def_form next-{{ $topic_id }} " method="post" action="#">
                                            @csrf
                                            <div class="form-group {{ $errors->has('language_id') ? 'has-error' : '' }}">
                                                <label class="fm_label">@lang('topic.select_language')</label>
                                                <div class="df-select">
                                                    <select class="selectpicker" id="language_id" name="language_id" data-topic="{{ $topic_id }}">
                                                        <option value="" style="display: block;" {{ old('language_id', optional($userinterest)->language_id ?: '') == '' ? 'selected' : '' }} disabled selected>@lang('topic.select_language')</option>
                                                        @foreach ($languages as $key => $language)
                                                        <option value="{{ $language->id }}"
                                                            @if (old('language_id', optional($userinterest)->language_id) == $language->id)
                                                                selected="selected"
                                                            {{--  @else
                                                                @if ($language->id ==1)
                                                                    selected="selected"
                                                                @endif  --}}
                                                            @endif
                                                                    >
                                                            {{ $language->language }}
                                                        </option>
                                                        @endforeach
                                                    </select>
                                                    {!! $errors->first('language_id', '<p class="help-block">:message</p>') !!}
                                                </div>
                                            </div>
                                            <div class="form-group {{ $errors->has('discipline_id') ? 'has-error' : '' }}">
                                                <label class="fm_label">@lang('topic.select_curriculum')</label>
                                                <div class="df-select">
                                                    <select class="selectpicker" id="discipline_id" name="discipline_id">
                                                        {{-- <option value="" style="display: none;" {{ old('discipline_id', optional($userinterest)->discipline_id ?: '') == '' ? 'selected' : '' }} disabled selected>@lang('topic.select_discipline_curriculum')</option> --}}
                                                        {{-- <option value="0">@lang('topic.not_linked_to_skill')</option> --}}
                                                        <option value="">@lang('topic.not_linked_to_skill')</option>
                                                        @foreach ($disciplines as $key => $discipline)
                                                        <option value="{{ $discipline->id }}" {{ old('discipline_id', optional($userinterest)->discipline_id) == $discipline->id ? 'selected' : '' }}>
                                                        {{ $discipline->discipline_name }}
                                                        </option>
                                                        @endforeach
                                                    </select>
                                                    {!! $errors->first('discipline_id', '<p class="help-block">:message</p>') !!}
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="fm_label">@lang('topic.select_grade')</label>
                                                <div class="df-select">
                                                    <select class="selectpicker" id="grade_id" name="grade_id">
                                                        <option value="" style="display: block;" {{ old('grade_id', optional($userinterest)->grade_id ?: '') == '' ? 'selected' : '' }} >@lang('topic.select_grade')</option>
                                                        @foreach ($grades as $key => $grade)
                                                            <option value="{{ $grade->id }}" {{ old('grade_id', optional($userinterest)->grade_id) == $grade->id ? 'selected' : '' }}>
                                                                {{ $grade->grade_name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                    {!! $errors->first('grade_id', '<p class="help-block">:message</p>') !!}
                                                </div>
                                            </div>
                                            <div class="form-group publis_mrgn">
                                                <button type="submit" class="btn btn-primary btn-login">@lang('topic.next')</button>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="col-md-5 frm_rt_cntnt">
                                        <div class="form_txt_info">
                                            @lang('topic.details')
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


 <!--thank_you_model-->
 <div class="modal fade default_modal wht_bg_mdl" id="okay_mdl" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <button type="button"  class="close" data-dismiss="modal" aria-label="Close"></button>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="right_contnt text-ar-right">
                            <h3>@lang('classcourse.thank_you')</h3>
                            <p class="enter_youremil">@lang('classcourse.request_sent_to_admin')</p> 
                            <div class="form-group">
                                <button type="button" data-dismiss="modal"  class=" btn btn-primary btn-login drk_bg_btn">@lang('classcourse.okay')</button>
                            </div>                               
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

 <!-- Add New Descipline -->
 <div class="modal fade default_modal wht_bg_mdl" id="New_Disciplines" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <button type="button" onclick="location.reload();" class="close" data-dismiss="modal" aria-label="Close"></button>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="right_contnt text-ar-right">
                            <h3>@lang('classcourse.new_dicipline')</h3>
                            <form class="def_form">
                                <div class="form-group">
                                    <input type="text" class="form-control" id="displine_name" placeholder="@lang('classcourse.name')" required/>
                                </div>
                                <p id="errMsg"></p>
                                <br>
                                <div class="form-group">
                                    <button type="button" onclick="saveDiscipline();" class="btn btn-primary btn-login drk_bg_btn">@lang('classcourse.send_request')</button>
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
<script src="{{ asset('assets/eduplaycloud/js/accordion.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/eduplaycloud/customs/js/filter/topics-filter.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/eduplaycloud/customs/js/filter/save-filter.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/eduplaycloud/js/functions.js') }}" type="text/javascript"></script>
@endpush

<?php /*Load jquery to footer section*/ ?>
@push('inc_jquery')
<script>
    // Accordion
    $(window).bind("pageshow", function() { // update hidden input field $('#formid')[0].reset(); });
        $("#sort-by").val(0).selectpicker("refresh");
    });
    $(document).ready(function($) {

        /**
         * New code as per requirments
         * */

         $.extend(jQuery.validator.messages, {
            required: message['validator_required'],
            remote: message['validator_remote'],
            email: message['validator_email'],
            url: message['validator_url'],
            date: message['validator_date'],
            number: message['validator_number'],
            digits: message['validator_digits'],
            equalTo: message['validator_equalTo'],
            maxlength: jQuery.validator.format(message['validator_maxlength']),
            minlength: jQuery.validator.format(message['validator_minlength']),
            rangelength: jQuery.validator.format(message['validator_rangelength']),
            range: jQuery.validator.format(message['validator_range']),
            max: jQuery.validator.format(message['validator_max']),
            min: jQuery.validator.format(message['validator_min'])
        });

        $("#frmSettings").validate({
            rules: {
                language_id: {
                    required: true
                },
                discipline_id: {
                    required: true
                }
            },
            messages: {

            },
            ignore: [],
            errorPlacement: function (error, element) {
                error.insertAfter(element);
            },
            submitHandler: function (form) {
                var desciplineId = 0;
                if ($("#frmSettings #discipline_id option:selected").val() != "") {
                    desciplineId = $("#frmSettings #discipline_id option:selected").val();
                }

            

                
                
                var userInterestId = $('#topics-result .discipline_'+'<?php echo $topic_id; ?>').attr('data-interested-id');
                $.ajax({
                    type: "get",
                    url: "<?php echo route('userinterests.userinterest.updateinterests'); ?>",
                    data: {
                        "_token": $('meta[name="csrf-token"]').attr('content'),
                        "id": $(".discipline_"+"{{ $topic_id }}").attr('data-interested-id'),
                        "discipline_id": desciplineId,
                        "topic_id": '{{ $topic_id }}',
                        "language_id": $("#frmSettings #language_id option:selected").val(),
                        "grade_id": $("#frmSettings #grade_id option:selected").val(),
                        "exercise_type": 1,
                        "user_id": $('header').attr('id'),
                        "_method": 'put',
                    },
                    beforeSend: function () {
                        showLoader();
                    },
                    success: function (response) {
                        // console.log(response);
                        hideLoader();
                        if (response.status !== false) {
                            window.location.href = "<?php echo route('topics.topic.exercisesets'); ?>";
                        }
                    },
                    error: function (err) {
                        hideLoader();
                        swal('No response from the server.', {
                            closeOnClickOutside: false,
                            icon: 'info',
                            button: {
                                text: message['ok'],
                            },
                        }).then(function() {
                            // location.reload();
                        });
                    }
                });

                return false;
            }
        });


        /* dynamic grades - Client code  */
        $('#language_id').on('change', function(){
            var topic_id = $(this).data('topic');
            var url=site_url+'/exercisesets/getdisciplies/'+$(this).val()+'/'+topic_id;
            $.get(url,
            function(data) {
                var discipline = $('#discipline_id');
                $('#discipline_id').empty();
                $('#discipline_id').append("<option value=''>" + "@lang('topic.select_discipline_curriculum')" + "</option>");
                $.each(data, function(index, discipline) {
                    $('#discipline_id').append("<option value='"+ discipline.id +"'>" + discipline.discipline_name + "</option>");
                });
                $('.selectpicker').selectpicker('refresh');
            });
        });


        /* dynamic grades - Client code  */
        $('#discipline_id').on('change', function(){
            var language_id = $("#frmSettings #language_id option:selected").val();
            var url=site_url+'/exercisesets/getgrades/'+$(this).val()+'/'+language_id;
            $.get(url,
            function(data) {
                var grades = $('#grade_id');
                $('#grade_id').empty();
                $('#grade_id').append("<option value=''>" + "@lang('topic.select_grade')" + "</option>");
                $.each(data, function(index, element) {
                    // console.log(element.id);
                    $('#grade_id').append("<option value='"+ element.id +"'>" + element.grade_name + "</option>");
                });

                $('.selectpicker').selectpicker('refresh');
            });
        });
        // Ends Here
        $(".demo-accordion").accordionjs();

        $(document).on("click", '.stngs_btn', function(event) {
            var topicId = $(this).attr('data-topic-id');
            var topicName = $(this).attr('data-topic-name');
            var exeCount = $(this).attr('data-exe-count');

            // Exercise Set count is 0 then display alert message.
            if(exeCount == 0){
                swal("@lang('topic.no_exerciseset_created')", {
                    closeOnClickOutside: false,
                    icon: 'warning',
                    button: {
                        text: message['ok'],
                    },
                })
            } else {
            // Exercise Set count is not 0 then display Popup.
            $.ajax({
                type: "post",
                url: site_url + "/topics/settings",
                data: {
                    "_token": "{{ csrf_token() }}",
                    topic_id: topicId,
                    topic_name: topicName
                },
                datatype: "html",
                beforeSend: function(xhr) {
                    showLoader();
                }
            }).done(function(data) {
                hideLoader();
                if (data.status !== false) {
                    $('.maths_modal').modal('show');
                    $('.maths_modal .right_contnt .row').empty().html(data);
                    $('.selectpicker').selectpicker('refresh');
                } else {
                    swal(data.message, {
                        closeOnClickOutside: false,
                        icon: data.icon,
                    }).then(function() {
                        // location.reload();
                    });
                }
            }).fail(function(jqXHR, ajaxOptions, thrownError) {
                hideLoader();
                swal('@lang("topic.no_response_from_the_server")', {
                    closeOnClickOutside: false,
                    icon: 'info',
                    button: {
                        text: message['ok'],
                    },
                }).then(function() {
                    // location.reload();
                });
            });
            }
        });

        $(document).on("click", '.dcpln_a', function(event) {
            if ($(this).hasClass('dcpln_btn')) {
                $(this).closest('.discipline_bx').find('.stngs_btn').trigger('click');
            } else {
                var user_intrest = $(this).closest('.discipline_bx').find('.stngs_btn').attr('data-interested-id'); 
                getUserInterstWithRedirectToSelectExercise(user_intrest);
            }
        });
    });
    
    
    //Function call for existing userIntrest find and return redirect to select exercise.
    function getUserInterstWithRedirectToSelectExercise(user_intrest){
        $.ajax({
            url: site_url + '/topics/get/userintrested',
            type: 'GET',
            data: { 'user_intrest' : user_intrest },
            success: function (response) {
                // console.log(response);
                if (response.status !== false) {
                    window.location.href = "<?php echo route('topics.topic.exercisesets'); ?>";
                }
            },

        });
    }

    $('#displine_name').on('keyup',function() {
        $('#errMsg').html('');
    });
    // New Descipline
    function saveDiscipline() {
        var name = $('#displine_name').val().trim();
        if (name == '') {
            $('#errMsg').html('<font color="red" style="font-size:12px;">@lang("classcourse.please_enter_name")</font>');
            return false;
        } else {
            $.ajax({
                type: "post",
                url: site_url + "/topics/add",
                data: {
                    "_token": "{{ csrf_token() }}",
                    name: name
                },
                success : function(response) {
                    $('#New_Disciplines').modal('hide');
                    $('#okay_mdl').modal('show');
                }
            })
        }
    }
</script>
@if (!Auth::guest())
<script>
    $(document).ready(function($) {
        $(document).on("click", '.str-hvr-push', function(event) {
            var topicId = $(this).attr('data-topic-id');

            $.ajax({
                type: "post",
                url: site_url + "/userinterests/updateusertopic",
                data: {
                    "_token": "{{ csrf_token() }}",
                    topic_id: topicId,
                    user_id: "{{ Auth::user()->id }}"
                },
                dataType: "json",
                beforeSend: function() {
                    showLoader();
                },
                success: function (response) {
                    hideLoader();

                    swal(response.message, {
                        closeOnClickOutside: false,
                        icon: (response.icon),
                        button: {
                            text: "@lang('topic.ok')",
                        },
                    }).then(function() {
                        if (response.action == 'delete') {
                            $('.topic_'+topicId).removeClass('selected_star');
                        } else {
                            $('.topic_'+topicId).addClass('selected_star');
                        }
                        location.reload();
                    });
                },
                error: function (jqXHR) {
                    hideLoader();
                }
            });
        });
    });
</script>
@endif
@endpush