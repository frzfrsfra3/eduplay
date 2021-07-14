@if(isset($questions) && count($questions) > 0)
    <div class="main_summery_earth mrgn-tp-30">
        <div class="name_list mrgn-bt-30">
            <h4>@lang('exam.exam_details')</h4>
        </div>
        <div class="exam-dtil-lst def_form full_def_frm">
            <div class="row">
                <div class="col-8-reduce col-xl-8">
                    <div class="row">
                        <div class="col-md-4 col-xl-5">
                            <div class="form-group">
                                <div class="df-select">
                                    <select name="examtype" class="selectpicker">
                                        <option value="test"
                                        @if($exam->examtype == 'test') selected @endif
                                        >@lang("exam.test")</option>
                                        <option value="practice"
                                        @if($exam->examtype == 'practice') selected @endif
                                        >@lang("exam.practice")</option>
                                        <option value="homework"
                                        @if($exam->examtype == 'homework') selected @endif
                                        >@lang("exam.home_work")</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 col-xl-5">
                            <div class="form-group">
                                <input name="title" type="text" class="form-control" placeholder="@lang('filter.title')" value="{{ $exam->title }}">
                            </div>
                        </div>
                        <div class="col-md-4 col-xl-2">
                            <div class="form-group mrgn-bt-30">
                                <div class="custum-checkbox-tp custom-control custom-checkbox">
                                    <input name="isavailable" value="1" id="Learner" type="checkbox" class="custom-control-input"
                                    @if($exam->isavailable == 'Y') checked @endif
                                    >
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
                                <h4>@lang('exam.total_marks')  : <span id="totalMarks">00</span></h4>
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
                                                        <ul class="answer-sheet">
                                                            @{{#Answers.Choices}}
                                                            <li>
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
                                                <input type="number" name="mark[@{{question_id}}]" class="form-control markClass" min="1" value="@{{ mark }}">
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
    </div>
@else
<div class="row">
    <div class="col-md-12 cusmize-col">
        <input type="hidden" id="noSkillCat" name="" value="0" />
        <p>@lang('exam.no_question_available')</p>
        </br>
    </div>
</div>
@endif

<!-- rendering the template -->
<script type='text/javascript'>
    // render script
    function renderToHtml_E5(Q) {
        var template = document.getElementById('sample_template_ExamDetails').innerHTML;
        var output = Mustache.render(template, Q);
        return output;
    }

    var json_details_exam = $('#jsonDivExamDetails').data('json');
    pRun(json_details_exam,document.getElementById('previewExamDetails'),renderToHtml_E5);

    $('.selectpicker').selectpicker('refresh');

    // total code
    $('.markClass').on('change', function() {
        var sum = 0;
        $(".markClass").each(function(){
            sum += +$(this).val();
        });
        $("#totalMarks").text(sum);
    });

    // Validation all mark
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