@foreach($questions as $question)

    @php
        $excelques=$question->renderQuestion($question->id)
    @endphp
    <div id="timespent" style="display: none">0</div>
    <div id="Question" class="col-xl-12 col-lg-12 col-sm-12 col-xs-12 all-padding" data-questionid="{{$question->id}}">
        <div class="col-xl-1 col-lg-1 col-sm-1 col-xs-12 "></div>
        <div  class="col-xl-8 col-lg-8 col-sm-8 col-xs-12  mainbox">
            @if(Session::has('qisanswered'.$question->id))
                <input id="userhasanswer" value="1" type="hidden">
                @php $useranswer='qisanswered'.$question->id @endphp

            @else
                <input id="userhasanswer" value="0" type="hidden">

            @endif

            <div id="divquestion" class=" col-xl-12 col-lg-12 col-sm-12 col-xs-12 all-padding " style="">
                <div class="counter-box ">
                    <div id="countdown" data-timer="{{$question->maxtime}}">
                    </div>
                </div>

                @include ('takeexam.questiondiv', [ $question ])
            </div>
                <input id="passageid" value="{{	$question->passage_id}}" type="hidden" data-link="{{route ('takeexam.passage' ,$question->passage_id)}}">
            @php  $answers= $question->answeroptions->sortBy('sort_order');
                                $i=0;
            @endphp
            <div class="col-xl-12 col-lg-12 col-sm-12 col-xs-12 all-padding">
                @foreach ( $answers as $answer)

                    @include ('takeexam.oneanswer', [ $answer ,$classexam  ])
                @endforeach
            </div>


        </div>
    </div>
@endforeach

<div id="Question" class="col-xl-12 col-lg-12 col-sm-12 col-xs-12 ">
    <div class="col-xl-3 col-lg-3 col-sm-3 col-xs-12 "></div>
    <div class="col-xl-6 col-lg-6 col-sm-6 col-xs-12  ">

        {!! $questions->render() !!}
    </div>
</div>


<script>
    document.getElementById("hideAll").style.display = "block";
</script>






