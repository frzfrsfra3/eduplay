@extends('authenticated.layouts.default')
@section('content')
<div class="page-content">

@if($practice_type == 'exerciseset')
<input type="hidden" id="exercise_id" value="{{$exerciseset->id}}">
<input type="hidden" id="topic_id" value="{{$exerciseset->topics->id}}">
@elseif($practice_type == 'assignment')
<input type="hidden" id="exercise_id" value="">
<input type="hidden" id="topic_id" value="">
@elseif($practice_type == 'disciplines_no_curriculum')
<input type="hidden" id="exercise_id" value="">
<input type="hidden" id="topic_id" value="">
@else
<form id="exercise_form" action="{{route('topics.exercisesets.skill')}}" method="GET">
    @csrf
    <input type='hidden' name='exercises' value='{{$exerciseid}}'>
</form>
<input type="hidden" id="exercise_id" value="">
<input type="hidden" id="topic_id" value="">
@endif

<style>
    body {
        margin: 0;
        padding: 0;
        font-family: 'Raleway', sans-serif;
        min-height: 101vh;
        min-width: 101vw;
    }

    .key-value-item {
        padding: 0;
        padding-top: 5px;
        text-align: center;
    }

    .key-value-item:first-child {
        border-left: 2px solid transparent;
    }

    .key-value-item h3 {
        font-size: 10px;
        text-transform: uppercase;
        margin: 0;
        padding: 0;
        letter-spacing: 1.5px;
    }

    .key-value-item span {
        font-size: 25px;
        color: #ff9028;
        font-weight: bold;
    }

    .key-value-item .button-container {
        display: flex;
        align-items: center;
        justify-content: center;
        height: 80%;
    }

    hr {
        color: #eee;
    }

    .clock-container .clock_wrapper {
        top: inherit;
        left: inherit;

    }

    .practice-header {
        padding-top: 6px;
        background-color: #fff;
        box-shadow: 3px 3px 27px 0 rgb(0 0 0 / 20%);
    }

    .practice-header-title {
        display: flex;
        align-items: center;
        justify-content: center;
        min-height: 60px;
    }

    .exam-pagination {
        list-style: none;
        padding: 0;
        margin: 20px;
        display: inline;
    }

    .exam-pagination li {
        display: inline-block;
    }

    .exam-pagination li button {
        display: block;
        padding: 5px 20px;
        background-color: #00b2f0;
        border: 0;
        color: #fff;
        cursor: pointer;
        border-radius: 5px;
        outline: 0 !important;
        box-shadow: 0 !important;
        transition: all 0.2s ease 0s;
    }

    .exam-pagination li button:focus {
        background-color: #0592c5;
    }

    .exam-pagination li button:hover {
        background-color: #027ca8;
    }

    .exam-pagination li button:disabled {
        background-color: #507f91;
        color: #fff;
        cursor: default;
    }

    button.navigation-btn {
        display: inline-block;
        padding: 5px 20px;
        border: 0;
        cursor: pointer;
        border-radius: 5px;
        outline: 0 !important;
        box-shadow: 0 !important;
        transition: all 0.2s ease 0s;
        background-color: #00b2f0;
        color: #fff;
        max-width: 100%;
    }

    .practice-nav {
        position: fixed; 
        top:0;
        left: 0;
        width: 100%;
        z-index: 9999;
    }

    .practice_bx{
        margin-top: 100px;
        margin-bottom: 300px;
    }

    .practice-footer {
        position: fixed;
        bottom:0;
        left:0;
        z-index: 9999;
        width: 100%;
        padding: 16px;
        background-color: #fff;
        box-shadow: -3px -3px 27px 0 rgb(0 0 0 / 20%);
    }

    @media only screen and (max-width: 768px) {
        .practice_bx {
            margin-top: 250px;
            margin-bottom: 300px;
        }
    }
</style>


<div class="full-width practice-nav">
    {{-- Header --}}
    <div class="row practice-header">
        <div class="col-md-3 col-xs-5 col-sm-5">
            <a class="navbar-brand" href="{{route('exercisesets.exerciseset.private')}}">
                <img src="{{ asset('assets/eduplaycloud/image/logo.svg') }}" alt="" class="logo">
            </a>
        </div>
        <div class="col-md-3 col-xs-5 col-sm-5 practice-header-title">
            <h3>
                @if($practice_type == 'exerciseset')
                {{ $exerciseset->title }}
                @elseif($practice_type == 'assignment')
                {{ $exam->title }}
                @elseif($practice_type == 'disciplines_no_curriculum')
                {{ $topic_name }}
                @else
                {{ $skill_categories->skill_category_name }}
                @endif
            </h3>
        </div>
        <div class="col-md-6 col-xs-12 col-sm-12">
            <div class="row">
                <div class="col-2 key-value-item clock-container">
                    <div id="clock_wrapper" class="clock_wrapper">
                        <canvas id="clock" width="60" height="60" class="clock1"></canvas>
                        <div id="timer"></div>
                    </div>
                </div>
                <div class="col-2 key-value-item">
                    <h3>Concutive</h3>
                    <span id='consecutive_ans_count'>0</span>
                </div>
                <div class="col-2 key-value-item">
                    <h3>Correct</h3>
                    <span><span id="right_ans_count">0</span>/{{$questionCount}}</span>
                </div>
                <div class="col-3 key-value-item">
                    <h3>Minutes</h3>
                    <span id='countdown'>00:00</span>
                </div>
                <div class="col-3 key-value-item">
                    <div class="button-container">
                        <button type="button" class="navigation-btn finsh-btn" id="finish_button">
                            @lang('practice.finish')
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@if($questionCount > 0)
<div class="col-xl-9 sp_lp_parent bbbb">
    <div class="practice_bx">
        
        {{-- Message --}}
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div id="flash_msg">

                    </div>
                </div>
            </div>
        </div>

        <div id="preview"></div>
        <script
            src="{{ asset('assets/eduplaycloud/customs/js/editor-playground/app-js/plugins-Render-Client.js') }}">
        </script>
        <script id="sample_template" type="text/html">
            @{{#.}}
            @{{#Questions}}
            <div class="clock_time hide" id="clock_time">@{{& Attributes.MaxTime}}</div>
            <div class="tmr_p">
                <div class="row">
                    @{{#Question_Description.Sections}}
                    <div class="col-md-12">@{{& Value}}</div>
                    @{{/Question_Description.Sections}}
                </div>
            </div>
            <ul class="optn_list" id="parent">
                @{{#Answers.Choices}}
                <li>
                    @{{# Attributes}}
                    <input type="radio" name="ans_rdo" value="@{{& id}}" id="ans_@{{& id}}" class="answer_option"
                        data-question-id="@{{& question_id}}">
                    @{{/ Attributes}}
                    <label for="ans_@{{& id}}"><span></span>
                        @{{#Sections}}

                        @{{& Value}}
                        @{{/Sections}}
                    </label>
                </li>
                @{{/Answers.Choices}}
            </ul>
            <p class="hint_p">
                @lang('practice.not_sure_about_the_ans') <a href="#" data-toggle="collapse"
                    data-target="#collapseHint" aria-expanded="false"
                    aria-controls="collapseHint">@lang('practice.hint')</a>
            </p>
            <div class="collapse hint_clps" id="collapseHint">
                <div class="card card-body">
                    <div class="hint-card">
                        <div class="row">
                            <div class="col-md-7">
                                <div class="rltv_hint">
                                    <div class="">
                                        <h5>@lang('practice.hint')</h5>
                                        <ul>
                                            @{{#Hints.HintList}}
                                            <li class="hint" id="hint_li_@{{& index}}">

                                                <div class="lang-dir">
                                                    @{{#Sections}}
                                                    <div class="nw_p">@{{& Value}}</div>
                                                    @{{/Sections}}
                                                </div>
                                            </li>
                                            @{{/Hints.HintList}}
                                            <a href="javascript:;" id="view_more_link" class="view_more_btn">View
                                                More</a>
                                            <a href="javascript:;" id="view_less_link" class="view_more_btn"
                                                style="display:none;">View Less</a>
                                            <div class="clearfix"></div>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-5"><img src="{{ asset('assets/eduplaycloud/image/hint_img.png') }}"
                                    align="" class="img-fluid"></div>
                        </div>
                    </div>
                </div>
            </div>
            @{{/Questions}}
            @{{/.}}
        </script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/mustache.js/3.0.1/mustache.min.js"></script>
        <div class="clearfix"></div>
    </div>
</div>



</div>
</div>
<div class="clearfix"></div>
</div>
@else
<div class="panel-body ">
    <p>@lang('practice.no_questions_available')</p>
</div>
@endif
</div>
</div>
</div>
</div>
</div>
</div>

<div class="practice-footer">

    {{-- Report Problem  --}}
    @include('practice.report_a_problem')

    {{-- Non-visible Part --}}
    <input type="hidden" id="hidden_que_id" />
    <form id="finishForm" >
        <input type="hidden" name="totalQuestion" id="totalQuestion" value="{{$questionCount}}">
        <input type="hidden" name="totalMinutes" id="totalMinutes">
        <input type="hidden" id="spen_time" value="">
        <input type="hidden" name="exerciseid" id="exerciseid" value="{{ $exerciseid }}">
        <input type="hidden" name="rightanscount" id="rightanscount" value="0" />
        <input type="hidden" name="exerciseset_url" id="exerciseset_url" value="{{$exerciseset_url}}" />
        <input type="hidden" name="practice_token" id="practice_token" value="{{str_random()}}">
        <meta name="csrf-token" content="{{ csrf_token() }}" />
    </form>
    <input type="hidden" id="question_index" value="0"><!--get quesiton index by this hidden field--->

    {{-- Visual Part --}}
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <ul class="exam-pagination">
                    @if (isset($IsExam))
                    @foreach (Session()->get('jsonQuesions') as $key => $question)
                    <li>
                        <button type="button" @if( $key==0) disabled='disabled' @endif question-index="{{ $key }}"
                            class="assignment-pagination-btn">{{ $key + 1 }}</button>
                    </li>
                    @endforeach
                    @endif
                </ul>
    
                {{-- Report Link --}}
                <a href="javascript:void(0);" class="rprt_prblm_btn" data-toggle="modal" data-target="#Report_A_Problem"
                    data-dismiss="modal">
                    @lang('practice.report_a_problem')
                </a>
    
            </div>
            <div class="col-md-6 text-right">
                <button type="button" id="check_button" class=" navigation-btn check-btn">
                    Check
                </button>
                <button type="button" id="next_button" class=" navigation-btn next-btn">
                    @lang('practice.next')
                </button>
            </div>
        </div>
    </div>

</>

<!---End Content-->
</div>
@endsection

@push('inc_script')
@include('authenticated.includes.pugin-footer')
<script type="text/javascript"
    src="{{ asset('assets/eduplaycloud/customs/js/jquery-validate/jquery.validate.min.js') }}"></script>
<script src="{{ asset('assets/eduplaycloud/customs/js/questions-answare.js') }}"></script>
<script src="{{ asset('assets/eduplaycloud/customs/js/finish-practice.js') }}"></script>
<!-- rendering the template -->
<script type='text/javascript'>

    $(document).ready(function () {
        setTimeout(function () {
            hideAllMorehint();
        }, 500);
    });

    //Hide all more hint.
    function hideAllMorehint() {
        hint = $('.hint').length;
        if (hint > 1) {
            $('.hint').each(function (hint, val) {
                if (val.id != 'hint_li_1') {
                    $('#' + val.id).hide();
                }
            });
        } else {
            $('#view_more_link').hide();
        }
    }


    //More hint show.
    $(document).on('click', '#view_more_link', function () {
        hintCount += 1
        if (hintCount <= hint) {
            $('#hint_li_' + hintCount).slideDown();
        }

        if (hintCount == hint) {
            $('#view_more_link').hide();
        }

    });


    function renderToHtml_E(Q) {
        var template = document.getElementById('sample_template').innerHTML;
        var output = Mustache.render(template, Q);

        return output;
    }


    //Bradcumps in click on skill categories name and redirect to that page.
    $(document).on('click', '.skill-name', function () {
        $('#exercise_form').submit();
    });

    $('.rprt_prblm_btn').on('click', function () {
        $('#description').val('');
        $('#message').html('');
    });
</script>
@endpush