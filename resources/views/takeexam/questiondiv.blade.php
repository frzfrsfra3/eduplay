@if ($question->questiontype=="text")

    <div class="floating-box questiontxt">
        <span>  <b>  {{$question->details}}  </b> </span>
    </div>
@elseif   ($question->questiontype=="richtext")

    <div class="floating-box questiontxt">
    <span>    {!! $excelques[0] !!}   </span>
    </div>

@elseif   ($question->questiontype=="image")

    <div class="floating-box  divimg">
        <span>
            <img class="imgestyle" src={{"/Images/".$question->details}} alt="">
            </span>
    </div>

@elseif   ($question->questiontype=="audio")
    <div class="floating-box  ">
    <span>
        <audio controls>
            <source src="/audio/{{$question->details}}" type="audio/mpeg">
        </audio>
    </span>
    </div>



@elseif   ($question->questiontype=="video")

    <div class="floating-box  ">
    <span>
           <iframe class="divquestionvedio"  src="https://www.youtube.com/embed/{{$question->details}}">
            </iframe>
              </span>
    </div>



@endif




