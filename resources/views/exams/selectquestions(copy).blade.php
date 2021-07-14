@if(isset($questions) && count($questions) > 0)
    <div class="col-xl-12">
        <h5 class="gray-pannel">Step 4: Select Questions</h5>
        @foreach($questions as $key => $question)
            @if(count((array)$question->json_details))
                <div class="exam_questions_list mrgn-bt-40">
                    <div class="form-group">
                        <div class="checkbox-sml custom-control custom-checkbox">
                            <input  value="1" id="selectallquestion" type="checkbox" class="custom-control-input">
                            <label class="custom-control-label" for="selectallquestion">Select All</label>
                        </div>
                    </div>
                </div>
                @break
            @endif
        @endforeach
        @foreach($questions as $key => $question)
            @if(count((array)$question->json_details))
                @php
                    $json = json_decode($question->json_details);
                    $url = asset("/assets/eduplaycloud/question/user-".\Auth::user()->id."/ex-$question->exercise_id/que-$question->id");
                    $optionName = range('A', 'Z');
                @endphp
                @if(count((array)$json))
                    @foreach($json->Questions as $qkey => $item)
                        <div class="exam_questions_list pdng_quesn mrgn-bt-40">
                            <div class="checkbx_abslt">
                                <div class="checkbox-sml custom-control custom-checkbox">
                                    <input name="questions"  value="{{$question->id}}" id="que_{{$question->id}}" type="checkbox" class="custom-control-input selectedQuestion">
                                    <label class="custom-control-label" for="que_{{$question->id}}"></label>
                                </div>
                            </div>
                            @if($item->Question_Description)
                                <div class="que_ans_test">
                                    @foreach($item->Question_Description->Sections as $qsection)
                                        @if($qsection->SectionType === 'text')
                                            <p class="text-new-line">{{$qsection->Value}}</p>
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
                                    @endforeach
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
                            @endif
                        </div>
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
        @endforeach
    </div>
@else
<div class="row">
    <div class="col-md-12 cusmize-col">
        <input type="hidden" id="noquestions" name="" value="0" />
        <span>No Questions Available !!</span>
    </div>
</div>
@endif
<script type="text/javascript">
$(document).ready(function () {
    // Select all skillcat
    $('#selectallquestion').click(function () {
        $('.selectedQuestion').prop('checked', this.checked);
    });

    $('.selectedQuestion').change(function () {
        var check = ($('.selectedQuestion').filter(":checked").length == $('.selectedQuestion').length);
        $('#selectallquestion').prop("checked", check);
    });
});
</script>