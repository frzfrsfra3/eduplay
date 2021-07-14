@php
    $excelques=$question->renderQuestion($question->id)
@endphp
<div  id="Question" data-questionid="{{$question->id}}">
    <div class="row">
        <div class="col-xl-3"><h3 class="font_30_sb">{{$question->skill->skill_name}}</h3>
        </div>
        <div class="col-xl-6 srl-col-md-6 text-right-def">
            <ul class="sprl_tp_info">
                <li>
                    <i class="exm_i"></i>
                    <p>Mastered</p>
                </li>
                <li>
                    <h3>5</h3>
                    <p>Consecutive Right Answers</p>
                </li>
                <li>
                    <h3>{{ $countcorrectanswer }}/{{$countbadanswer}}</h3>
                    <p>Right Answers</p>
                </li>
                <li>
                    <h3>10:25</h3>
                    <p>Minutes</p>
                </li>
            </ul>
        </div>

        <div class="col-xl-9 sp_lp_parent aaa">
            <h6 class="sm_title">Practice</h6>

            <!--Client Code-->
            <div id="mainboxdiv" class="mainbox" >
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
            </div>
            <!--End Client Code-->

            @if(count((array)$question->json_details))
                @php
                    $json = json_decode($question->json_details);
                    $optionName = range('A', 'Z');
                @endphp
                @if(count((array)$json))
                    @foreach($json->Questions as $qkey => $item)
                        <!--Question-->
                        @if($item->Question_Description)

                           <div class="practice_bx">
                                <div id="clock_wrapper" class="clock_wrapper">
                                    <canvas id="clock" width="60" height="60" class="clock"></canvas>
                                    <div id="timer" id="countdown" data-timer="{{$question->maxtime}}" ></div>
                                </div>

                                <!--Question part-->
                                    @include ('guestpractice.questiondiv', [ $item ])
                                <!--End Question part-->

                                <!--Answare part-->
                                @if($item->Answers->Choices)
                                    @include ('guestpractice.oneanswer', [ $item  ])
                                @endif
                                <!--End Answare part-->
                                    
                                <!--Hint Section-->
                                @if($item->Hints->HintList)                             
                                    @include ('guestpractice.hints', [ $item  ])
                                @endif
                                <!--End Hint Section-->
                               
                                <a href="javascript:void(0);" class="rprt_prblm_btn" data-toggle="modal" data-target="#Report_A_Problem" data-dismiss="modal">Report A Problem</a>
                                <div class="form-group mrgn-bt-70 mrgn-tp-30">
                                    <button type="button" class="btn btn-primary cancel-btn">Back</button>
                                    <a href="spirals_and_loops-done.html" class="btn btn-primary add_btn mrg-right-15">Next</a>
                                    <button type="button" class="btn btn-primary add_btn orgng_btn">Finish</button>
                                </div>
                            </div>
                                   
                    @endif

                        <!--End question-->
                    @endforeach
                @else 
                <strong>No data question</strong>

                @endif

            @else 
                <strong>No data</strong>
            @endif
        </div>
    </div>
</div>