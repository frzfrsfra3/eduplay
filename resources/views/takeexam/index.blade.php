@extends('authenticated.layouts.default')

<!---Css-->
@section('header_styles')
<link href="https://www.jqueryscript.net/css/jquerysctipttop.css" rel="stylesheet" type="text/css">
<link rel="stylesheet" href="{{ asset('assets/eduplaycloud/customs/js/pratctice/jquery.pajinatify.css') }}"/>
@endsection

@section('content')

<!---Content-->

<div class="work_page @if (!isset($HideNavBars)) mrgn_top_secn @endif mrgn-bt-60 exercesi_block text-ar-right">
    <div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-12">
            <div class="pdng_60_lft">
                <nav aria-label="tp-breadcm" class="tp-breadcm">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route ('courseclasses.courseclass.show', $classid . '#assignments') }}">@lang('classcourse.assignments')</a></li>
                        <li class="breadcrumb-item active"  aria-current="page">{{ $exam->title }}</li>
                    </ol>
                </nav>
                <div  id="message">
                                     
                </div>
                @if($questionCount > 0)
                <div id="hideAll">
                    <div class="main_summery_earth dcspln_inner_main main_sprl_pr pd_lf_25">
                        <div id="flash_msg"></div>
                            <div class="row">
                                <div class="col-xl-3"><h3 class="font_30_sb">{{ $exam->title }}</h3></div>
                                <div class="col-xl-6 srl-col-md-6 text-right-def">
                                    <ul class="sprl_tp_info">
                                        <li>
                                            <i class="exm_i"></i>
                                            <p>{{ $exam->examtype }}</p>
                                        </li>
                                        {{-- <li>
                                            <h3><span id='consecutive_ans_count'>0</span></h3>
                                            <p>@lang('practice.consecutive_right_answers')</p>
                                        </li>
                                        <li>
                                            <h3><span id='right_ans_count'>0</span>/{{$questionCount}}</h3>
                                            <p>@lang('practice.right_answers')</p>
                                        </li> --}}
                                        <li>
                                            <h3 id='countdown'>00:00</h3>
                                            <p>@lang('practice.minutes')</p>
                                        </li>
                                    </ul>
                                </div>
                                <div class="col-lg-8 col-xl-9 sp_lp_parent bbbb">
                                    <h6 class="sm_title">@lang('exam.exam')</h6>
                                        <input type="hidden" id="max_time_append" value="">
                                        <div id="timespent" style="display: none">0</div>
                                    
                                    <div class="practice_bx">
                                        <div id="clock_wrapper" class="clock_wrapper">
                                            <canvas id="clock" width="60" height="60" class="clock1"></canvas>
                                            <div id="timer"></div>
                                        </div>
                                        <div>
                                            <div id="examQuestionpreview">
                                            </div> 
                                        </div>
                                        <script src="{{ asset('assets/eduplaycloud/customs/js/editor-playground/app-js/plugins-Render-Client.js') }}"></script>
                                        <script id="sample_template" type="text/html">
                                            @{{#.}}
                                            @{{#Questions}}
                                            <div class="clock_time hide" id="clock_time" data-max_time="@{{& Attributes.MaxTime}}"></div>
                                            <p class="tmr_p"> @{{#Question_Description.Sections}}
                                                    @{{& Value}}
                                                @{{/Question_Description.Sections}}   </p>
                                            <ul class="optn_list" id="parent">
                                                @{{#Answers.Choices}}
                                                    
                                                <li>
                                                    @{{#Attributes}}
                                                        <input type="radio" name="ans_rdo" value="@{{& id}}" id="ans_@{{& id}}" class="answer_option" data-classexam-id="{{ $classexam->id }}" @{{& checked}}>
                                                        @{{#Sections}}
                                                        <label for="ans_@{{& id}}"><span></span>
                                                            @{{& Value}}
                                                        </label>
                                                        @{{/Sections}}
                                                    @{{/Attributes}}
                                                </li>
                                                @{{/Answers.Choices}}                                                
                                            </ul>
                                       
                                      
                                        @{{/Questions}}
                                        @{{/.}} 
                                        </script>
                                        <script src="https://cdnjs.cloudflare.com/ajax/libs/mustache.js/3.0.1/mustache.min.js"></script>

                                        <a href="javascript:void(0);" class="rprt_prblm_btn" data-toggle="modal" data-target="#Report_A_Problem" data-dismiss="modal">@lang('practice.report_a_problem')</a>
                                        @include('practice.report_a_problem')
                                        <div class="clearfix"></div>
                                    </div>
                                </div>
                                {{-- Display Skiped question --}}
                                <div class="col-lg-4 col-xl-3">
                                    <div class="practice_bx prctice_skip_sqn">
                                        <div class="skip_questn_scn">
                                            <h4 class="qusn_title">Questions</h4>
                                            <p>@lang('exerciseset_show.skiped_question')</p>
                                            <div id="skip_result" class="scroll_skip">

                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="practice_bx form-group mrgn-bt-70 mrgn-tp-20">
                                        <!--get quesiton index by this hidden field--->
                                        <input type="hidden" id="spen_time" value="">
                                        <input type="hidden" id="question_index" value="0">
                                        <input type="hidden" name="totalQuestion" id="totalQuestion" value="{{$questionCount}}">
                                        <input type="hidden" id="hidden_que_id" />
                                        <!--get quesiton index by this hidden field--->

                                        <!--Question navigation--->
                                        <div class='pagination aspgntn_pr'
                                             data-total-count={{$questionCount}}
                                                     data-take='1'
                                             data-checked=''
                                                >
                                        </div>
                                        <input type="hidden" id="examtype" value="{{$examFrom}}">
                                        <button type="button"  id="back_button" onclick="questionBack()" class="btn btn-primary cancel-btn hide">@lang('practice.previous')</button>
                                        <button type="button" id="next_button" class="btn btn-primary add_btn mrg-right-15 next-btn">@lang('practice.next')</button>
                                        <button type="button" id="skip_button" class="btn btn-primary add_btn mrg-right-15">@lang('practice.skip')</button>
                                       	<a data-url="{{route('takeexam.score' ,[$classexam->id, 'examType' => $examFrom ])}}" class="btn btn-primary add_btn orgng_btn finsh-btn" id="finish_button">@lang('practice.finish')</a>
                                    </div>
                                </div>
                            </div>
                            </div>
                        <div class="clearfix"></div>
                    </div>
                @else 
                    <div class="panel-body ">
                        <h4>@lang('practice.no_questions_available')</h4>
                    </div>

                @endif
                </div>
            </div>
        </div>
    </div>
    </div>
</div>
<!---End Content-->
@endsection

@push('inc_script')
@include('authenticated.includes.pugin-footer')
<script>
 var last_remind_page = 1;

</script>
<!---Navigation js-->
<script src="{{ asset('assets/eduplaycloud/customs/js/pratctice/jquery.pajinatify.js') }}"></script>
<!-- rendering the template -->
<script src="{{ asset('assets/eduplaycloud/customs/js/tack-exam.js') }}"></script>
<script src="{{ asset('assets/eduplaycloud/customs/js/finish-practice.js') }}"></script>
<script type='text/javascript'>

    function renderToHtml_E(Q) 
    {
        var template = document.getElementById('sample_template').innerHTML;
        var output = Mustache.render(template, Q);
        
        return output;
    }


    //Bradcumps in click on skill categories name and redirect to that page.
      $(document).on('click','.skill-name',function(){
        $('#exercise_form').submit();
    });

    $('.rprt_prblm_btn').on('click',function() {
        $('#description').val('');
        $('#message').html('');
    });
</script>


@endpush