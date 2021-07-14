                        <div class="col-xl-12 col-lg-12 col-sm-12 col-xs-12" id="nestable">
                            @if(count($questions) == 0)
                                <div class="panel-body text-center" id="noquestion">
                                    <h4>No Questions Available!</h4>
                                </div>
                            @else
                            @foreach($questions as $question)
                                <div id="que_ans{!!$question->id !!}" class="question">
                                            <div>


                                                  <a  style=" text-decoration: none;" data-toggle="collapse" href="#collapse{!!$question->id !!}"
                                                     role="button" aria-expanded="false" aria-controls="collapse{!!$question->id !!}"
                                                     id="ques{!!$question->id !!}"   class="question-details"  >{!! $question->details !!}</a>
                                         <span style="float: right"> Mark :
                                          <input type="number"  min="0" class="mark-value" id="mark[{{$question->id}}]"
                                                 name="mark[{{$question->id}}]" value="{{  optional($exam)->questionmark($question->id) }}" required style="width: 50px"> </input>
                                         </span>  </div>
                                                <div class="clear-line"></div>


                                    <div class="collapse multi-collapse que_ans_{!!$question->id !!}" id="collapse{!!$question->id !!}" >
                                        <div class="answer-title">Answers:</div>
                                            @if(count($question->answeroptions)!=0)


                                                    @php
                                                        $answeres= $question->answeroptions->sortBy('sort_order')
                                                    @endphp
                                                @foreach($answeres as $answer)
                                                        <div class="dd-handle nest-class" id="re_ans{!!$answer->id !!}"><div  class="answer" id="ans{!!$answer->id !!}">
                                                                @if($answer->iscorrect==1) <i class="fa fa-check" style="color: green"></i>
                                                                @else <i class="fa fa-times" style="color: red"></i>
                                                                @endif {!! $answer->details !!}</div>

                                                            <div style="float: right">
                                                               </div>
                                                            <div class="clear-line"></div></div>
                                                @endforeach

                                             @endif
                                    </div>

                                </div>


                            @endforeach
                            @endif
                    </div>


