@php
    $excelques=$question->renderQuestion($question->id)
@endphp

<div id="Question" class="col-xl-12 col-lg-12 col-sm-12 col-xs-12 all-padding" data-questionid="{{$question->id}}" >
    <div class="col-xl-2 col-lg-2 col-sm-2 col-xs-12 "></div>
    <div id="mainboxdiv" class="col-xl-8 col-lg-8 col-sm-8 col-xs-12  mainbox" >
        @if(Session::has('qisanswered'.$question->id))
            <input id="userhasanswer" value="1" type="hidden" >
            @php $useranswer='qisanswered'.$question->id @endphp

        @else
            <input id="userhasanswer" value="0" type="hidden" >

        @endif
        @if(Session::has('questionischecked'.$question->id))
            @php $ischecked=1 @endphp
        @else
            @php $ischecked=0 @endphp
        @endif


        @if(Session::has('useranswer'.$question->id))
            @php $useranswer='useranswer'.$question->id @endphp
            <input id="useranswer" value="{!! session(''.$useranswer.'') !!}" type="hidden" >
        @else
            <input id="useranswer" value="0" type="hidden" >
        @endif



        <div id="divquestion"  class=" col-xl-12 col-lg-12 col-sm-12 col-xs-12 all-padding "  style="">
            <div  class="counter-box "  >
                <div  id="countdown" data-timer="{{$question->maxtime}}"  >
                </div>
            </div>

            <div class="correctanswers" ><i style="padding: 2px 10px 0 10px;font-size: 18px " class="fa fa-check"></i><span class="correctnumber" id="correctanswer" data-correctanswer="{{$countcorrectanswer}}"> {{ $countcorrectanswer}} </span></div>
            <div class="badanswers" ><i style="padding: 2px 10px 0 10px;font-size: 18px " class="fa fa-times"></i><span class="badnumber" id="badanswer" data-badanswer="{{$countbadanswer}}"> {{ $countbadanswer}} </span></div>

            @include ('guestpractice.questiondiv', [ $question,$excelques ])
        </div>
        @php  $answers= $question->answeroptions->sortBy('sort_order');
                                $i=0;
        @endphp
            <input id="passageid" value="{{	$question->passage_id}}" type="hidden" data-link="{{route ('takeexam.passage' ,$question->passage_id)}}">
        <div class="col-xl-12 col-lg-12 col-sm-12 col-xs-12 all-padding">
            @foreach ( $answers as $answer)

                @include ('guestpractice.oneanswer', [ $answer ,$excelques  ])
            @endforeach
        </div>



        <div class="col-xl-12 col-lg-12 col-sm-12 col-xs-12 all-padding" >
            <div class="button-position">
                @if ($ischecked==0 )

                    <button id="checkanswerbtn{{$question->id}}" data-ischecked="{{$ischecked}}"
                            data-checkurl="{{ route('guestpractice.question.correctanswer', $question->id) }}"
                            class="checkanswer btn btn-edubtn" title="check"  onclick="checkanswer('checkanswerbtn{{$question->id}}')"
                            value="">
                        @if(Session::has('questionischecked'.$question->id))
                            Checked
                        @else
                            Check
                        @endif
                    </button>

                    <button id="nextbtn{{$question->id}}"  data-nextquestionid="{{$nextquestionid}}"

                            data-nextquestionurl="{{ route('guestpractice.question.nextquestion', [$nextquestionid  ,$questionindex]) }}"

                            data-result="{{ route('guestpractice.question.result', $exerciseset->id) }}"
                            class="nextquestion btn btn-edubtn" title="check" onclick="nextquestion('nextbtn{{$question->id}}')"
                            style="visibility: hidden"    >
                        Next
                    </button>

                @else
                    <button id="checkanswerbtn{{$question->id}}" data-ischecked="{{$ischecked}}"
                            data-checkurl="{{ route('guestpractice.question.correctanswer', $question->id) }}"
                            class="checkanswer btn btn-edubtn" title="check"  onclick="checkanswer('checkanswerbtn{{$question->id}}')"
                            style="visibility: hidden" >
                        @if(Session::has('questionischecked'.$question->id))
                            Checked
                        @else
                            Check
                        @endif
                    </button>


                    <button id="nextbtn{{$question->id}}"  data-nextquestionid="{{$nextquestionid}}"

                            data-nextquestionurl="{{ route('guestpractice.question.nextquestion',[$nextquestionid  ,$questionindex]) }}"

                            data-result="{{ route('guestpractice.question.result', $exerciseset->id) }}"
                            class="nextquestion btn btn-edubtn" title="check" onclick="nextquestion('nextbtn{{$question->id}}')"
                    >
                        Next
                    </button>

                @endif
            </div>
        </div>
    </div>
</div>



    <script type="text/javascript" src="{{ asset('assets/js/jquery.countdown360.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/js/practice.js') }}"></script>

    <script>

        document.getElementById("hideAll").style.display = "block";
    </script>





