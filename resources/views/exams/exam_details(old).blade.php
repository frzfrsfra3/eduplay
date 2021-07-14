@if(isset($questions) && count($questions) > 0)
    <div class="main_summery_earth mrgn-tp-30">
        <div class="name_list mrgn-bt-30">
            <h4>Exam Details</h4>
        </div>
        <div class="exam-dtil-lst def_form full_def_frm">
            <div class="row">
                <div class="col-8-reduce col-xl-8">
                    <div class="row">
                        <div class="col-md-4 col-xl-5">
                            <div class="form-group">
                                <div class="df-select">
                                    <select name="examtype" class="selectpicker">
                                        <option value="test">Test</option>
                                        <option value="practice">Practice</option>
                                        <option value="homework">Home Work</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 col-xl-5">
                            <div class="form-group">
                                <input name="title" type="text" class="form-control" placeholder="Title">
                            </div>
                        </div>
                        <div class="col-md-4 col-xl-2">
                            <div class="form-group mrgn-bt-30">
                                <div class="custum-checkbox-tp custom-control custom-checkbox">
                                    <input name="isavailable" value="1" id="Learner" type="checkbox" class="custom-control-input">
                                    <label class="custom-control-label" for="Learner">Is Available</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    </div>
                <div class="col-6-reduce col-xl-6">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="total_ans_lt">
                                <h4>Total Question : <span>{{count($questions)}}</span></h4>
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
                                <h4>Total Duration : <span>{{ gmdate("H:i:s", $sum) }}</span></h4>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="total_ans_lt">
                                <h4>Total Marks  : <span id="totalMarks">00</span></h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xl-12">
                    <div class="mark_with_ans">
                        @foreach($questions as $key => $question)
                            <div class="exam_questions_list circl_list pdng_quesn">
                                @if(count((array)$question->json_details))
                                    @php
                                        $json = json_decode($question->json_details);
                                        $url = asset("/assets/eduplaycloud/question/user-".\Auth::user()->id."/ex-$question->exercise_id/que-$question->id");
                                        $optionName = range('A', 'Z');
                                    @endphp
                                    @if(count((array)$json))
                                        @foreach($json->Questions as $qkey => $item)
                                            {{--  <div class="checkbx_abslt">
                                                <div class="checkbox-sml custom-control custom-checkbox">
                                                    <input name="questions"  value="{{$question->id}}" id="que_{{$question->id}}" type="checkbox" class="custom-control-input selectedQuestion">
                                                    <label class="custom-control-label" for="que_{{$question->id}}"></label>
                                                </div>
                                            </div>  --}}
                                            @if($item->Question_Description)
                                            <div class="row">
                                                @foreach($item->Question_Description->Sections as $qsection)
                                                    <div class="col-md-8 col-xl-10">
                                                        <div class="que_ans_test symbol_black">
                                                            @if($qsection->SectionType === 'text')
                                                                <p>{{$qsection->Value}}</p>
                                                            @else
                                                                @if($qsection->SectionType === "Plugin")
                                                                    @if($qsection->Plugin == 'image')
                                                                        <img src="{{$url.'/'.$qsection->Value}}" width="350" height="200">
                                                                    @elseif($qsection->Plugin == 'video')
                                                                        <iframe width="350" height="200" src="{{$qsection->Value}}" frameborder="0" allowfullscreen></iframe>
                                                                    @elseif($qsection->Plugin == 'audio')
                                                                        <audio width="350" height="60" controls>
                                                                            <source src="{{$url.'/'.$qsection->Value}}">
                                                                        </audio>
                                                                    @else
                                                                        <p></p>
                                                                    @endif
                                                                @endif
                                                            @endif
                                                            <div class="row">
                                                                <div class="col-11-rduce col-lg-9 col-xl-6">
                                                                    @if($item->Answers->Choices)
                                                                        <ul class="answer-sheet">
                                                                            @foreach($item->Answers->Choices as $akey => $ans)
                                                                                <li>
                                                                                    <span class="optn_tx">{{$optionName[$akey]}}.</span>
                                                                                    <div class="tb_rt_cntnt">
                                                                                        @foreach ($ans->Sections as $asection)
                                                                                            @if($asection->SectionType === 'text')
                                                                                                <span class="text-new-line">{{$asection->Value}}</span>
                                                                                            @else
                                                                                                @if($asection->SectionType === "Plugin")
                                                                                                    @if($asection->Plugin == 'image')
                                                                                                        <img src="{{$url.'/'.$asection->Value}}" width="350" height="200">
                                                                                                    @elseif($asection->Plugin == 'video')
                                                                                                        <iframe width="350" height="200" src="{{$asection->Value}}" frameborder="0" allowfullscreen></iframe>
                                                                                                    @elseif($asection->Plugin == 'audio')
                                                                                                        <audio width="350" height="60" controls>
                                                                                                            <source src="{{$url.'/'.$asection->Value}}">
                                                                                                        </audio>
                                                                                                    @else
                                                                                                        <p></p>
                                                                                                    @endif
                                                                                                @endif
                                                                                            @endif
                                                                                        @endforeach
                                                                                    </div>
                                                                                </li>
                                                                            @endforeach
                                                                            @endif
                                                                        </ul>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    @endforeach
                                                    <div class="col-md-4 col-xl-2 text-right-def">
                                                        <div class="max-questn">
                                                            <label class="questn_lbl">Marks :</label>
                                                            <input type="number" name="mark[{{$question->id}}]" class="form-control markClass" min="0">
                                                        </div>
                                                    </div>
                                            </div>
                                            @endif
                                        @endforeach
                                        <input type="hidden" id="noquestions" name="" value="1" />
                                    @else
                                        <div class="exam_questions_list mrgn-bt-40">
                                            <p>No Questions Available !!</p>
                                            <input type="hidden" id="noquestions" name="" value="0" />
                                        </div>
                                        @break
                                    @endif
                                @else
                                    <div class="exam_questions_list mrgn-bt-40">
                                        <p>No Questions Available !!</p>
                                        <input type="hidden" id="noquestions" name="" value="0" />
                                    </div>
                                    @break
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
@else
<div class="row">
    <div class="col-md-12 cusmize-col">
        <input type="hidden" id="noSkillCat" name="" value="0" />
        <span>No Question Availablae !!</span>
    </div>
</div>
@endif
<script>
    $('.selectpicker').selectpicker('refresh');

    $('.markClass').on('change', function() {
        var sum = 0;
        $(".markClass").each(function(){
            sum += +$(this).val();
        });
        $("#totalMarks").text(sum);
    });

    {{--  $('.markClass').each(function() {
        var element = $(this);
        if(element.val() === ''){
            $(element).attr('required',true);
        }
    })  --}}

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