@extends('authenticated.layouts.default')
<?php /*Load jquery to footer section*/ ?>
@push('inc_css')
    <link rel="stylesheet" href="{{ asset('assets/eduplaycloud/customs/jquery-steps/jquery.steps.css')}}" type="text/css" media="all">

    <style>
        .node circle, .node ellipse, .node polygon, .node rect{
            fill: #cde498 !important;
            stroke: #13540c !important;
        }
    </style>
@endpush
@section('content')
    <!---Content-->
    <div class="work_page mrgn_top_secn exercesi_block mrgn-bt-70 text-ar-right">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-12">
                    <nav aria-label="tp-breadcm" class="tp-breadcm">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('exams.exam.index') }}">@lang('exam.my_exam')</a></li>
                        <li class="breadcrumb-item active" aria-current="page">@lang('exam.update_exam')</li>
                    </ol>
                    </nav>
                    @if(Session::has('success_message'))
                        <div class="alert alert-success">
                            <span class="glyphicon glyphicon-ok"></span>
                            {!! session('success_message') !!}
                            <button type="button" class="close" data-dismiss="alert" aria-label="close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif
                    <div class="content mrgn-tp-20">
                        <div class="main_summery_earth mrgn-tp-30">
                            <div class="name_list mrgn-bt-30">
                                <h4>@lang('exam.exam_details')</h4>
                            </div>
                            <form id="editExam" method="POST" action="{{ route('exams.exam.update' ,$exam->id) }}">
                                @csrf
                            <input name="page" value="{{ $page }}" type="hidden"/>
                                <div class="exam-dtil-lst def_form full_def_frm">
                                    <div class="row">
                                        <div class="col-8-reduce col-xl-8">
                                            <div class="row">
                                                <div class="col-md-4 col-xl-5">
                                                    <div class="form-group">
                                                        <div class="df-select">
                                                            <select name="examtype" class="selectpicker">
                                                                <option value="test" @if($exam->examtype === 'test') ? selected : '' @endif >@lang("exam.test")</option>
                                                                <option value="practice"  @if($exam->examtype === 'practice') ? selected : '' @endif >@lang("exam.practice")</option>
                                                                <option value="homework"  @if($exam->examtype === 'homework') ? selected : '' @endif >@lang("exam.home_work")</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-4 col-xl-5">
                                                    <div class="form-group">
                                                        <input name="title" type="text" value="{{ $exam->title }}" class="form-control" placeholder="@lang('filter.title')">
                                                    </div>
                                                </div>
                                                <div class="col-md-4 col-xl-2">
                                                    <div class="form-group mrgn-bt-30">
                                                        <div class="custum-checkbox-tp custom-control custom-checkbox">
                                                            <input name="isavailable" value="1"
                                                            @if($exam->isavailable === 'Y') ? checked : '' @endif id="Learner" type="checkbox" class="custom-control-input">
                                                            <label class="custom-control-label" for="Learner">@lang('exam.is_available')</label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-6-reduce col-xl-6">
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <div class="total_ans_lt">
                                                        <h4>@lang('exam.total_question') : <span>{{count($questions)}}</span></h4>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="total_ans_lt">
                                                        @php
                                                        $sum=0;
                                                        foreach($questions as $key => $question){
                                                        $sum+=$question->maxtime;
                                                        }
                                                        @endphp
                                                        <h4>@lang('exam.total_duration') : <span>{{ gmdate("H:i:s", $sum) }}</span></h4>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="total_ans_lt">
                                                        <h4>@lang('exam.total_marks') : <span id="totalMarks">00</span></h4>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-xl-12">
                                            <div class="mark_with_ans">
                                                <div id="jsonDivExamDetails" data-json="{{ $finalJsonObjSelQue}}">
                                                </div>
                                                {{-- With Render Js --}}
                                                <div id="previewExamDetails">
                                                </div>
                                                <script id="sample_template_ExamDetails" type="text/html">
                                                    @{{#.}}
                                                        @{{#Questions}}
                                                        <div class="exam_questions_list circl_list pdng_quesn">
                                                            <div class="row">
                                                                <div class="col-md-8 col-xl-10">
                                                                    <div class="que_ans_test symbol_black">
                                                                        @{{#Question_Description.Sections}}
                                                                            <p class="text-new-line">@{{& Value}}</p>
                                                                        @{{/Question_Description.Sections}}
                                                                        <div class="row">
                                                                            <div class="col-11-rduce col-lg-9 col-xl-6">
                                                                                <ul class="answer-sheet edit">
                                                                                    @{{#Answers.Choices}}
                                                                                    <li>
                                                                                        {{-- <span class="optn_tx">A.</span> --}}
                                                                                        <div class="tb_rt_cntnt">
                                                                                            @{{#Sections}}
                                                                                            @{{& Value}}
                                                                                            @{{/Sections}} 
                                                                                            </label>
                                                                                        </div>
                                                                                    </li>
                                                                                    @{{/Answers.Choices}}
                                                                                </ul>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-4 col-xl-2 text-right-def">
                                                                    <div class="max-questn">
                                                                        <label class="questn_lbl">@lang('exam.marks') :</label>
                                                                        <input type="number" name="mark[@{{question_id}}]" class="form-control markClass" data-mark="@{{question_id}}" id="@{{question_id}}" value="@{{ mark }}" min="1">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @{{/Questions}}
                                                    @{{/.}}
                                                </script>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group mrgn-bt-40 mrgn-tp-50">
                                        <a href="{{ route('exams.exam.index','page='.$page) }}" class="btn btn-primary cancel-btn">@lang('exam.cancel')</a>
                                        <input type="submit" name="Update" value="@lang('exam.update')" class="btn btn-primary add_btn" />
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!---End Content-->
@endsection

<?php /*Load jquery to footer section*/ ?>
@push('inc_script')
    @include('authenticated.includes.render_script')
@endpush

<?php /*Load jquery to footer section*/ ?>
@push('inc_jquery')
    <!-- rendering the template -->
    <script type='text/javascript'>

        // render code
        function renderToHtml_E(Q) {
            var template = document.getElementById('sample_template_ExamDetails').innerHTML;
            var output = Mustache.render(template, Q);
            return output;
        }

        var json_details_exam = $('#jsonDivExamDetails').data('json');
        setTimeout(function(){
            pRunExamDetailsEdit(json_details_exam);
        }, 100);

        // form Validation
        var form = $("#editExam");
        form.validate({
            errorPlacement: function errorPlacement(error, element) { element.before(error); },
            rules: {
                examtype: {
                    required: true,
                },
                title: {
                    required: true,
                    maxlength: 30,
                },
            },
            messages: {
            },
            errorPlacement: function(error, element) {
                error.insertAfter(element);
            },
        });

        // total mark logic
        $(document).ready(function(){
            total();    // call below function
        });
        $(document).on( "change", ".markClass", function(){
            total();    // call below function
        });

        // Total Points
        function total() {
            var sum = 0;
            $(".markClass").each(function(){
                sum += +$(this).val();
            });
            $("#totalMarks").text(sum);
        }

        // mark require validation
        $(".markClass").each(function() {
            var element = $(this);
            if (element.val() == "") {
                $(this).attr('required',true);
            }
            else{
                $(this).attr('required',false);
            }
        });
    </script>
@endpush