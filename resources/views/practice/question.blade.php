@php
    $excelques=$question->renderQuestion($question->id);

@endphp


<div id="Question" data-questionid="{{$question->id}}">
    <div id="mainboxdiv" clas=" mainbox" >
        @if(Session::has('qisanswered'.$question->id))
            <input id="userhasanswer" value="1" type="hidden" >
            @php 
                $useranswer='qisanswered'.$question->id 
            @endphp
        @else
            <input id="userhasanswer" value="0" type="hidden" >
        @endif

        @if(Session::has('questionischecked'.$question->id))
            @php 
                $ischecked=1 
            @endphp
        @else
            @php 
                $ischecked=0 
            @endphp
        @endif

        @if(Session::has('useranswer'.$question->id))
            @php 
                $useranswer='useranswer'.$question->id 
            @endphp
            <input id="useranswer" value="{!! session(''.$useranswer.'') !!}" type="hidden" >
        @else
            <input id="useranswer" value="0" type="hidden" >
        @endif
    
        
        @if(count((array)$question->json_details))
            @php
                $json = json_decode($question->json_details);
                $optionName = range('A', 'Z');
                
            @endphp
        @endif

        
        
        @if(count((array)$json))
        @foreach($json->Questions as $qkey => $item)
        <div class="practice_bx">
            <div id="clock_wrapper" class="clock_wrapper">
                <canvas id="clock" width="60" height="60" class="clock"></canvas>
                <div id="timer" data-timer="{{$question->maxtime}}" ></div>
            </div>
            
            <!--Question part-->
            @include ('practice.questiondiv', [ $item ])
            <!--End Question part-->
                
            <input id="passageid" value="{{	$question->passage_id}}" type="hidden" data-link="{{route ('takeexam.passage' ,$question->passage_id)}}">
            </br>
            <ul class="optn_list">
                <!--Answare part-->
                @if($question->answeroptions)
                    @foreach ( $question->answeroptions as $akey => $answer)
                        @include ('practice.oneanswer', [ $akey, $answer,$excelques  ])
                    @endforeach        
                @endif
                <!--End Answare part-->
            </ul>

            <!--Hint Section-->
            @if($item->Hints->HintList)                             
                @include ('practice.hint', [ $item  ])
            @endif
            <!--End Hint Section-->
            <a href="javascript:void(0);" class="rprt_prblm_btn" data-toggle="modal" data-target="#Report_A_Problem" data-dismiss="modal">Report A Problem</a>
            <div class="col-xl-12 col-lg-12 col-sm-12 col-xs-12 all-padding" >
                    <!-- <div class="button-position">
                        @if ($ischecked==0 )

                            <button id="checkanswerbtn{{$question->id}}" data-ischecked="{{$ischecked}}"
                                    data-checkurl="{{ route('practice.question.correctanswer', $question->id) }}"
                                    class="checkanswer btn btn-edubtn" title="check"  onclick="checkanswer('checkanswerbtn{{$question->id}}')"
                                    value="" type="button">
                                @if(Session::has('questionischecked'.$question->id))
                                    Checked
                                @else
                                    Check
                                @endif
                            </button>

                            <button type="button" id="nextbtn{{$question->id}}"  data-nextquestionid="{{$nextquestionid}}"
                                    @if($userinterest_id ==0)
                                    data-nextquestionurl="{{ route('practice.question.nextquestion', $nextquestionid) }}"
                                    @else
                                    data-nextquestionurl="{{ route('practice.question.nextquestion_interset', [$nextquestionid ,$userinterest_id ]) }}"
                                            @endif
                                    data-result="{{ route('practice.question.result',  [$exerciseset->id ,$userinterest_id]) }}"
                                    class="nextquestion btn btn-edubtn" title="check" onclick="nextquestion('nextbtn{{$question->id}}')"
                                    style="visibility: hidden"    >
                                Next
                            </button>

                        @else
                            <button type="button" id="checkanswerbtn{{$question->id}}" data-ischecked="{{$ischecked}}"
                                    data-checkurl="{{ route('practice.question.correctanswer', $question->id) }}"
                                    class="checkanswer btn btn-edubtn" title="check"  onclick="checkanswer('checkanswerbtn{{$question->id}}')"
                                    style="visibility: hidden" >
                                @if(Session::has('questionischecked'.$question->id))
                                    Checked
                                @else
                                    Check
                                @endif
                            </button>


                            <button type="button" id="nextbtn{{$question->id}}"  data-nextquestionid="{{$nextquestionid}}"
                                    @if($userinterest_id ==0)
                                    data-nextquestionurl="{{ route('practice.question.nextquestion', $nextquestionid) }}"
                                    @else
                                    data-nextquestionurl="{{ route('practice.question.nextquestion_interset',[$nextquestionid ,$userinterest_id ]) }}"
                                    @endif
                                    data-result="{{ route('practice.question.result',  [ $exerciseset->id ,$userinterest_id ]) }}"
                                    class="nextquestion btn btn-edubtn" title="check" onclick="nextquestion('nextbtn{{$question->id}}')"
                            >
                                Next
                            </button>

                        @endif
                    </div> -->
                </div>
            <div class="form-group mrgn-bt-70 mrgn-tp-30">
                <button type="button" class="btn btn-primary cancel-btn">Back</button>
                <button type="button" id="nextbtn{{$question->id}}"  data-nextquestionid="{{$nextquestionid}}"
                    @if($userinterest_id ==0)
                    data-nextquestionurl="{{ route('practice.question.nextquestion', $nextquestionid) }}"
                    @else
                    data-nextquestionurl="{{ route('practice.question.nextquestion_interset',[$nextquestionid ,$userinterest_id ]) }}"
                    @endif
                    data-result="{{ route('practice.question.result',  [ $exerciseset->id ,$userinterest_id ]) }}"
                    class="btn btn-primary add_btn mrg-right-15" data-checkurl="{{ route('practice.question.correctanswer', $question->id) }}" title="Next" onclick="nextquestion('nextbtn{{$question->id}}')"
                >Next</button>
                <button type="button" class="btn btn-primary add_btn orgng_btn">Finish</button>
            </div>
            <div class="clearfix"></div>
        </div>
        @endforeach
        @endif
    </div>
</div>
<script type="text/javascript" src="{{ asset('assets/eduplaycloud/js/index.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/eduplaycloud/customs/js/new-practice.js') }}"></script>
<script>
    document.getElementById("hideAll").style.display = "block";
</script>