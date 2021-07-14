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
@php
$optionName = range('A', 'Z');
@endphp

<div   class=" {{$classvalue}}" id="answerid{{$answer['id']}}"  data-answerid="{{$answer['id']}}" data-url="{{ route('practice.answer.clickedanswer', $answer['id']) }}"  >
<li>
    {{-- <span class="@if($ans->Attributes->IsCorrect) right_answr @else wrong_answr @endif"></span> --}}   
    <input type="radio" name="ans_rdo">
    <label> 
        {{-- <span class="optn_tx">{{$optionName[$akey]}}.</span> --}}
        
        @if($answer['answer_type'] === 'text')
            {{$answer['details']}}
        @else
            {{-- @if($asection['answer_type'] === "Plugin") --}}
                @if($answer['answer_type'] == 'image')
                    <img src="{{$url.'/'.$answer['details']}}" width="350" height="200">
                @elseif($answer['answer_type'] == 'video')
                    <iframe width="350" height="200" src="{{$answer['details']}}" frameborder="0" allowfullscreen></iframe>
                @elseif($answer['answer_type'] == 'audio')
                    <audio width="350" height="60" controls>
                        <source src="{{$url.'/'.$answer['details']}}">
                    </audio>
                @else
                    <p></p>
                @endif
            {{-- @endif --}}
        @endif
    </label>
</li>


