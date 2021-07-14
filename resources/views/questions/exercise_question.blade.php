<div class="all_editor_cls summery_private_lib">
        <div class="repns_text mrgn_cls_curm text-right-def">            
            @auth
            <form id="link_to_skill_form" action="{{route('questions.question.curriculum')}}" method="post">
                {{ csrf_field() }}
                @method('POST')
                <input type="hidden" name="exerciseId" id="exerciseId" value="">
                <input type="hidden" name="questionsIds" id="questionsIds" value="">
            </form>
            @endAuth
        </div>
        <div id="flash_msg"></div>
        {{--<h4 class="simple_editor">Details</h4>--}}
        <div class="exercise_reprt center-block">
            <div class="deatil_panneel_privt pannel_exercise panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                @if(count($questions) > 0)
                <div class="checkbox-sml custom-control custom-checkbox mrgn-bt-15">
                    <input name="allquestions" id="question_all_check" type="checkbox" class="custom-control-input">
                    <label class="custom-control-label" for="question_all_check">Select All</label>
                </div>
                @endif
                @if(count($questions) <= 0)
                    <p class="pd_3">@lang('filter.no_questions_available')!</p>
                @else

                
                <div class="clearfix"></div>
                    
                <div id="question_list_preview">
                </div>
                    @foreach($questions as $key => $question)
                        @php
                            $activePanel = ($loop->first) ? 'active' : '';
                            $showPanel = ($loop->first) ? 'show' : '';
                        @endphp
                        {{-- <input type="hidden" data-active="{{$activePanel}}" class="json_question" value="{{$question->json_details}}"> --}}
                        <input type="hidden" data-active="{{$activePanel}}" class="json_question" value="{{$question->paramRenderQuestion()}}">
                        
                    @endforeach
                @endif
            </div>
        </div>
    </div>
    <div class="col-md-12 cstm-pgntn">
        <nav aria-label="Page navigation example" class="float-right">
            {{ @$questions->links() }}
        </nav>
    </div>
    

    <script id="question_list_template" type="text/html">
        @{{#.}}
        @{{#Questions}}
        
        <div class="deatil_panneel_privt inner_pannel panel panel-default">
            <div class="panel-heading @{{^key}} active @{{/key}}" role="tab" id="headingOne">
                <div class="panel-title">
                    <div class="quesn_abl_ckbx">
                        <div class="checkbox-sml custom-control custom-checkbox">
                            <input name="questions[]" value="@{{&question_id}}" id="question_@{{&question_id}}" type="checkbox" class="custom-control-input question_checkbox">
                            <label class="custom-control-label" for="question_@{{&question_id}}"></label>
                        </div>
                    </div>
                    <a role="button" data-toggle="collapse"  data-parent="#accordion" href="#collapse_@{{&question_id}}" aria-expanded="true" aria-controls="collapse_@{{&question_id}}">
                            <div class=" ">
                            @{{#Question_Description.Sections}}
                                <p>@{{& Value}}</p>
                            @{{/Question_Description.Sections}}
                            </div>
                    </a>
                      <p class="question-info"> 
                                    Skill name : 
                                        @{{#Attributes.SkillName}}
                                            @{{ &Attributes.SkillName }}
                                        @{{/Attributes.SkillName}}
                                        @{{^Attributes.SkillName}}
                                            N/A
                                        @{{/Attributes.SkillName}}
                                        | 
                                    Difficulty level:  
                                        @{{#Attributes.Difficulty}}
                                            @{{ &Attributes.Difficulty }}
                                        @{{/Attributes.Difficulty}}
                                        @{{^Attributes.Difficulty}}
                                            N/A
                                        @{{/Attributes.Difficulty}} |
                                    Max Time: @{{ &Attributes.MaxTime }} | 
                                    Min Time: @{{ &Attributes.MinTime }}
                                </p>
                    <div class="right_btn_secn">
                        @{{# Parameters}}
                            @{{#value}}
                                @{{#filepath}}
                                <a href="@{{&filepath}}"  class="gray_download_btn"></a>
                                @{{/filepath}}
                            @{{/value}}
                        @{{/ Parameters}}
                        
                        <?php if(Auth::user() && Auth::user()->id === $exerciseset->createdby){ ?>
                        <a href="javascript:;" class="gray_edit_btn" id="edit_que_btn_@{{&question_id}}" data-queid="@{{&question_id}}" onclick="editQuestion(this.id)"></a>
                        <form method="POST" id="delete_que_form" action="{!!url('/questions/question')!!}/@{{&question_id}}" accept-charset="UTF-8" class="dlt_clss">
                            <input name="_method" value="DELETE" type="hidden">
                            @csrf
                            <a href="javascript:;" class="gray_delete_btn" id="delete_que_btn_@{{&question_id}}" data-queid="@{{&question_id}}" onclick="deleteQuestion(this.id)"></a>
                        </form>
                        <?php } ?>
                        <?php if(Auth::user() && Auth::user()->hasRole('Admin')){ ?>
                        <form method="POST" id="delete_que_form" action="{!!url('/questions/question')!!}/@{{&question_id}}" accept-charset="UTF-8" class="dlt_clss">
                            <input name="_method" value="DELETE" type="hidden">
                            @csrf
                            <a href="javascript:;" class="gray_delete_btn" id="delete_que_btn_@{{&question_id}}" data-queid="@{{&question_id}}" onclick="deleteQuestion(this.id)"></a>
                        </form>
                        <?php } ?>
                    </div>
                </div>
            </div>
            <div id="collapse_@{{&question_id}}" class="panel-collapse collapse @{{^key}} show @{{/key}}" role="tabpanel" aria-labelledby="headingOne">
                <div class="panel-body">
                    <div id="preview_ans_option_div">
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
                                    <div class="nw_p ash_pr">@{{& Value}}</div>
                                    @{{/Sections}} 
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