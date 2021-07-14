@if( $answer->isanswered($classexam->id  )==true)

    @php ($isanswered="useranswerdiv" ) @endphp
    @else
    @php ($isanswered="" ) @endphp
@endif
<div  class="defaultdivanswer  {{$isanswered}}"   id="answerid{{$answer->id}}"  data-answerid="{{$answer->id}}"
       onclick="addanswer({{$answer->id}})"
       data-url="{{ route('takeexam.answer.clickedanswer',[ $answer->id  ,$classexam->id]) }}"
 >
    @if ($answer->answer_type=="text")
        <div
                @if ( strlen ($answer->details)<=200 )


                class="textanswer"
                @else
                class="textanswer200"
                @endif
        >
            <span>  {{$answer->details}}</span>
        </div>

    @elseif ($answer->answer_type=="image")

        <div class="divimg">
                                       <span>   <img class="imgestyle" src={{"/Images/".$answer->details}} alt="" >
                                       </span>
        </div>

    @elseif ($answer->answer_type=="video")

        <span>
                                        <iframe class="divvedio" src="https://www.youtube.com/embed/{{$answer->details}}">
                                        </iframe>
                                        </span>

    @elseif ($answer->answer_type=="audio")

        <span>
                                     <audio controls>

                                        <source src="/audio/{{$answer->details}}" type="audio/mpeg">

                                        </audio>

                                      </span>

    @elseif ($answer->answer_type=="richtext")

      <div  >
@php $m = new Mustache_Engine; @endphp
                <span>   {!! $m->render($answer->details, $excelques[1])!!}    </span>
                                            </div>


    @endif

</div>