@if(isset($questions) && count($questions) > 0)
    <div class="col-xl-12 step-four-exam">
        <input type="hidden" id="question_id" name="question_id" value="{{ $questionsId }}" />
        <input type="hidden" id="skill_cat_id" name="skill_cat_id" value="{{ $skillCatIds }}" />
        <input type="hidden" id="exercise_id" name="exercise_id" value="{{ $exercisesIds }}" />
        <input type="hidden" id="skill_id" name="skill_id" value="{{ $array_of_skills }}" />

        <h5 class="gray-pannel">@lang('exam.select_question_s5') 
        </h5>
        {{--  <h6>@lang('exam.total_req_qustion') : {{ $totalReqQuestion }}</h6>  --}}
        @foreach($questions as $key => $question)
            @if(count((array)$question->json_details))
                <div class="exam_questions_list mrgn-bt-40">
                    <div class="form-group">
                        <div class="checkbox-sml custom-control custom-checkbox">
                            <input  value="1" id="selectallquestion" type="checkbox" class="custom-control-input">
                            <label class="custom-control-label" for="selectallquestion">@lang('exam.select_all')</label>
                        </div>
                    </div>
                </div>
                @break
            @endif
        @endforeach

        <div id="jsonDiv" data-json="{{ $finalJsonObj }}">
        </div>
        {{-- With Render Js --}}
        <div id="preview">
        </div>

        <script id="sample_template" type="text/html">
            @{{#.}}
              @{{#Questions}}

              <div class="exam_questions_list pdng_quesn mrgn-bt-40">
                    <div class="checkbx_abslt">
                        <div class="checkbox-sml custom-control custom-checkbox">
                            <input name="questions"  value="@{{question_id}}" id="que_@{{question_id}}" type="checkbox" class="custom-control-input selectedQuestion"
                                @{{#checked_id}}
                                    checked
                                @{{/checked_id}}
                            />
                            <label class="custom-control-label" for="que_@{{question_id}}"></label>
                        </div>
                    </div>
                    <div class="que_ans_test">
                        @{{#Question_Description.Sections}}
                        <p class="text-new-line">@{{& Value}}</p>
                        @{{/Question_Description.Sections}}
                        <div class="row">
                            <div class="col-11-rduce col-lg-9 col-xl-6">
                                <ul class="answer-sheet">
                                    @{{#Answers.Choices}}
                                    <li>
                                        {{-- <span class="optn_tx">A.</span> --}}
                                        <div class="tb_rt_cntnt">
                                            {{--  <label><span>A</span>  --}}
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
            @{{/Questions}}
            @{{/.}}
        </script>

        {{-- This script use for model in more question's display  --}}
        <script id="question_sample_template" type="text/html">
            @{{#.}}
              @{{#Questions}}
            <div class="ans_and_slct">
                <div class="text-right">
                  <button type="button" class="btn btn-success btn-xs pull-right question-select-btn" data-question-id="@{{question_id}}">Select</button>
                </div>
                <div class="qusn_list" id="question_div_@{{question_id}}">
                    <div class="exam_questions_list pdng_quesn mrgn-bt-40">
                        <div class="checkbx_abslt">
                            <div class="checkbox-sml custom-control custom-checkbox">
                            <input name="questions"  value="@{{question_id}}" id="que_@{{question_id}}" type="checkbox" class="custom-control-input">
                            <label class="custom-control-label" for="que_@{{question_id}}"></label>
                            </div>
                        </div>
                        <div class="que_ans_test">
                            @{{#Question_Description.Sections}}
                            <p class="text-new-line">@{{& Value}}</p>
                            @{{/Question_Description.Sections}}
                            <div class="row">
                                <div class="col-md-12">
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
                </div>
            </div>
            @{{/Questions}}
            @{{/.}}
        </script>
    </div>
@else
    <div class="row">
        <div class="col-md-12 cusmize-col">
            <input type="hidden" id="noquestions" name="" value="0" />
            <p>@lang('exam.no_question_available')</p>
            </br>
        </div>
    </div>
@endif

{{--   Model  --}}
    <div class="modal fade width-700-model default_modal wht_bg_mdl" data-backdrop="static" data-keyboard="false" id="question_modal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                    <button type="button" class="close" onclick="" data-dismiss="modal" aria-label="Close"></button>
                <div class="modal-body">
                    <h4 class="quest-title">More Question</h4>
                    <div class="row">
                        <div class="col-md-12">
                            <div id="model_qestion_preview" class="more_qustn_lst">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
{{--   model end  --}}

<script src="{{ asset('assets/eduplaycloud/customs/js/filter/exam-question-filter.js') }}"></script>
<!-- rendering the template -->
<script type='text/javascript'>
    function renderToHtml_E(Q) {
        var template = document.getElementById('sample_template').innerHTML;
        var output = Mustache.render(template, Q);
        return output;
    }

    function renderToHtml_EModal(Q) {
        var template = document.getElementById('question_sample_template').innerHTML;
        var output = Mustache.render(template, Q);
        return output;
    }
</script>

<!-- rendering the template -->
<script type='text/javascript'>
    $(document).on('click','#add_more_question_btn',function(){
        $('#question_modal').modal('show');
    });
    $('#question_modal').on('shown.bs.modal', function (e) {
        getMoreOtherQuestions();
    });
</script>


<script type="text/javascript">
    $(document).ajaxComplete(function () {
        //alert($('#question_id').val());
        var selquestionIds = <?php echo json_encode($questionsId); ?>;
        $('#selectedQuestionId').val(selquestionIds);
        //var json_details = $('#jsonDiv').attr('data-json');
        var json_details = $('#jsonDiv').data('json');

        pRun(json_details,document.getElementById('preview'),renderToHtml_E);

        // Onload checkbox checked on edit
        if($('.selectedQuestion').not(':checked').length == 0){
            $('#selectallquestion').attr( 'checked', true );
        }
        // Select all skillcat
        $(document).on('click', '#selectallquestion', function(){
            $('.selectedQuestion').prop('checked', this.checked);
        });

        $('.selectedQuestion').change(function () {
            var check = ($('.selectedQuestion').filter(":checked").length == $('.selectedQuestion').length);
            $('#selectallquestion').prop("checked", check);
        });
    });


    //Ajax Call for added more Questions.
    function getMoreOtherQuestions(){
        $.ajax({
            type: 'GET',
            data: {
                'question_id' : $('#question_id').val(),
                'skill_cat_id' : $('#skill_cat_id').val(),
                'exercise_id' : $('#exercise_id').val(),
                'skill_id' : $('#skill_id').val(),
            },
            url: site_url + '/exams/mero/question',
            success: function(questionsResponse){
                if (questionsResponse.length === 0) {
                    $('#question_modal').modal('hide');
                    swal ( "Oops" ,  "No Data Available !" ,  "error" )
                } else {
                    pRun(questionsResponse,document.getElementById('model_qestion_preview'),renderToHtml_EModal);
                    $('#model_qestion_preview .custom-checkbox').hide();
                }
            }
        });
    }

    // Add More Question on popup
    $(document).off("click", ".question-select-btn").on('click','.question-select-btn',function(){
        $('#question_id').val($('#question_id').val() +','+ $(this).attr('data-question-id'));
        var question_id = '#question_div_' + $(this).attr('data-question-id');
        $('#que_' + $(this).attr('data-question-id')).addClass('selectedQuestion');
        //alert($(this).attr('data-question-id'));
        var Selectedquestion= <?php echo json_encode($questionsId); ?>;
        $('#selectedQuestionId').val(Selectedquestion+','+$(this).attr('data-question-id'));
        var questionHtml = $(question_id).html();
        $('#preview').prepend(questionHtml);
        $('#preview .custom-checkbox').show();
        $(question_id).remove();
        $(this).remove();

        var button_count = $('#model_qestion_preview .question-select-btn').length;
        if(button_count == 0){
            $('#model_qestion_preview').html(message['no_question']);
        }
    });

</script>
<script src="{{ asset('assets/eduplaycloud/customs/js/filter/exam-question-filter.js') }}"></script>
