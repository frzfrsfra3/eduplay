<div id="load nestable" style="position: relative;" class="col-xl-12 col-lg-12 col-sm-12 col-xs-12 " >

    @if(count($questions) == 0)
        <div class="panel-body text-center">
            <h4>No Questions Available!</h4>
        </div>
    @else


                        @foreach($questions as $question)
                            <div id="que_ans{!!$question->id !!}">
                                <div class="dd-handle" >
                                    <div  class="quest-display"  id="q-{!!$question->id !!}"> <a class="" data-toggle="collapse"
                                 href="#collapse{!!$question->id !!}" role="button" aria-expanded="false" aria-controls="collapse{!!$question->id !!}" id="ques{!!$question->id !!}">{!! $question->details !!}</a></div>
                                    <div style="float: right">
                                       </div>
                                    <div class="clear-line"></div></div>
                                <div class="collapse multi-collapse que_ans{!!$question->id !!}" id="collapse{!!$question->id !!}" >
                                    @if(count($question->answeroptions)!=0)
                                        @php
                                            $answeres= $question->answeroptions->sortBy('sort_order')
                                        @endphp
                                        @foreach($answeres as $answer)
                                            <div class="dd-handle nest-class" style="margin-right: 20px"><div  class="quest-display" id="ans{!!$answer->id !!}">{!! $answer->details !!}</div>
                                                <div style="float: right"> </div>
                                                <div class="clear-line"></div></div>
                                        @endforeach
                                    @endif
                                </div>
                            </div>
                        @endforeach




            <div id="pagination" class="col-xl-12 col-lg-12 col-sm-12 col-xs-12 " >
                {!! $questions->render() !!}

            </div>
    @endif

</div>
