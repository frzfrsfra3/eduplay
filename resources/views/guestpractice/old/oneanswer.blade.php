@if(Session::has('useranswer'.$question->id))
   @php
       $useranswer=1;
       $slectedanswerid= session('useranswer'.$question->id);
       if ($slectedanswerid == $answer->id)  {
            if(Session::has('correctanswer'.$question->id))
                {

                 $thecorrectanswer=session('correctanswer'.$question->id);

                 if($thecorrectanswer == $slectedanswerid ) { $classvalue=" defaultdivanswer useranswerdiv";

                 }
                 else {
                 $classvalue=" defaultdivanswer badanswer";

                 }
                }
                else         $classvalue=" defaultdivanswer useranswerdiv";
       }
       else  $classvalue="defaultdivanswer ";
   @endphp
   @else
    @php $useranswer=0 ;
    $classvalue="defaultdivanswer ";
    @endphp
@endif

@if(Session::has('correctanswer'.$question->id))

    @php $useranswer=1;

    $thecorrectanswer=session('correctanswer'.$question->id);

    if ($thecorrectanswer == $answer->id)  {
    $classvalue= $classvalue . "defaultdivanswer correctanswer";
    }
    @endphp
@else
    @php $useranswer=0 @endphp
@endif



<div   class=" {{$classvalue}}" id="answerid{{$answer->id}}"  data-answerid="{{$answer->id}}" data-url="{{ route('guestpractice.answer.clickedanswer', $answer->id) }}"  >


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