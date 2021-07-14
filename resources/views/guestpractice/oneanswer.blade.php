<!--Client Code start-->
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

<!--Client Code end -->

<ul class="optn_list">
    @foreach($item->Answers->Choices as $akey => $ans)
    <li>
        {{-- <span class="@if($ans->Attributes->IsCorrect) right_answr @else wrong_answr @endif"></span> --}}

        @foreach ($ans->Sections as $asection)
        <input type="radio" name="ans_rdo" id="answerid{{$asection->id}}"  data-answerid="{{$asection->id}}" data-url="{{ route('guestpractice.answer.clickedanswer', $asection->id) }}" >
        <label> <span class="optn_tx">{{$optionName[$akey]}}.</span>
            
            @if($asection->SectionType === 'text')
                {{$asection->Value}}
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
        </label>
        @endforeach
        
    </li>
    @endforeach
</ul>

<!--Client Code start-->

<!--Client Code end-->