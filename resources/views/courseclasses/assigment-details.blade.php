@extends('authenticated.layouts.default')
@section('content')
<!---Content-->
<div class="work_page mrgn_top_secn text-ar-right mrgn-bt-40">
    <div class="container">
        <div class="row justify-content-center">
        <div class="col-lg-12">
            <nav aria-label="tp-breadcm" class="tp-breadcm">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{route('courseclasses.courseclass.show', ['id' => $class_id, '#assignments'])}}">@lang('classcourse.assignments')</a></li>
                    <li class="breadcrumb-item active" aria-current="page">@lang('classcourse.assignment_details')</li>
                </ol>
            </nav>
            <div class="clearfix"></div>
            <div class="mdl_space text-ar-right">
                <h4 class="mrgn-bt-10"></h4>
                <div class="clearfix"></div>
            </div>
            <div class="exercise_reprt center-block">
            @if(count($questions) > 0)
              @foreach($questions as $key => $question)
                    <input type="hidden" class="json_question" value="{{$question->paramRenderQuestion()}}" data-answerId="{{$question->answer_id}}">
              @endforeach
            @else
              <p class="pd_3">@lang('filter.no_questions_available')!</p>
            @endif
                <div id="pratice_ques_list_preview">
                </div>
                <script id="practice_question_list_template" type="text/html">
                    @{{#.}}
                    @{{#Questions}}        
                <div class="pannel_exercise panel-group" id="accordion_@{{&question_id}}" role="tablist" aria-multiselectable="true">
                    <div class="inner_pannel panel panel-default">
                        <div class="panel-heading @{{^key}} active @{{/key}}" role="tab" id="headingOne">
                            <div class="panel-title">
                                <a role="button" data-toggle="collapse" data-parent="#accordion_@{{&question_id}}" href="#collapse_question_@{{&question_id}}" aria-expanded="true" aria-controls="collapseOne">
                                  @{{#Question_Description.Sections}}
                                  <p>@{{& Value}}</p>
                                   @{{/Question_Description.Sections}}
                                </a>
                            </div>
                        </div>
                        <div id="collapse_question_@{{&question_id}}" class="panel-collapse collapse @{{^key}} show @{{/key}}" role="tabpanel" aria-labelledby="headingOne">
                            <div class="panel-body">
                                <ul class="detil-pg-ans ans_list optn_list">
                                @{{#Answers.Choices}}
                                <li > @{{#Attributes}}
                                        @{{#IsCorrect}}
                                            <span class="right_answr"></span>
                                        @{{/IsCorrect}}
                                        @{{^IsCorrect}}
                                            <span class="wrong_answr"></span>
                                        @{{/IsCorrect}}
                                    @{{/Attributes}}
                                    <div class="lang-dir tb_rt_cntnt " >     
                                        @{{#Sections}}
                                        <div class="nw_p ash_pr">
                                          @{{& Value}}
                                            @{{#useranswer}}
                                            <span class="orng_tx">{{Auth::user()->name}}</span>
                                            @{{/useranswer}}
                                        </div>
                                        @{{/Sections}} 
                                    </div>
                                </li>
                                @{{/Answers.Choices}}
                                </ul>
                            </div>
                        </div>
                    </div>
                    @{{/Questions}}
                    @{{/.}}
                </div>
            </div>
          </script>
        </div>
    </div>
</div>
</div>
<!---End Content-->
@endsection
@push('inc_script')
@include('authenticated.includes.render_script')
<script>
//-------------------------------Question display with render js plug in-----------------------------------------------

$(document).ready(function(){
  getQuestionListJsonByInput();
});

function getQuestionListJsonByInput(){
    var json_question = [];            
        $('.json_question').each(function(key){
            if($(this).val() != ''){
                var question = jQuery.parseJSON($(this).val());
                var answerId = $(this).attr('data-answerId');
                if(question.Questions[0].Answers.Choices){
                  $(question.Questions[0].Answers.Choices).each(function(anskey){
                    if(question.Questions[0].Answers.Choices[anskey].Attributes.id == answerId){
                        question.Questions[0].Answers.Choices[anskey].Sections[0].useranswer = true;
                    } else {
                        question.Questions[0].Answers.Choices[anskey].Sections[0].useranswer = false;
                    }
                  });
                }

                json_question.push(question);
                var setkey = true;
                if(key == 0) {
                  setkey = false;
                }
                json_question[key]['key'] = setkey;
            }

        });

        console.log('json_question',json_question);
    pRunQuestionListPreview(json_question);
    
}

function renderToHtml_qList(Q) {
    var template = document.getElementById('practice_question_list_template').innerHTML;
    var output = Mustache.render(template, Q);
    // console.log(output);
    return output;
}

function pRunQuestionListPreview(list) {
    
    var data = list;    
    var previewFrame = document.getElementById('pratice_ques_list_preview');

    // var static_parserOutputObj = get through api;
    var static_parserOutputObjExamDetail = data;
    var static_plugin_parserOutputObj = renderPluginsinObj(static_parserOutputObjExamDetail);
    var finalObj = static_plugin_parserOutputObj;
    if(previewFrame != undefined) {
        previewFrame.innerHTML = renderToHtml_qList(finalObj);
    }
    
    // reInitiate();
}

function reInitiate() {
    plugIns.forEach(function (plugIn) {
      if (plugIn.init) {
        eval(plugIn.init);
      };
    })
  }
//-------------------------------End Question display with render js plug in-----------------------------------------------
</script>
@endpush
