<div id="que_ans{!!$question->id !!}">
    <div class="dd-handle" >
        <div  class="col-xl-10 col-lg-10 col-sm-10 col-xs-12 quest-display"   id="q-{!!$question->id !!}"> <a class="" data-toggle="collapse" href="#collapse{!!$question->id !!}" role="button" aria-expanded="false" aria-controls="collapse{!!$question->id !!}" id="ques{!!$question->id !!}"><div  class="col-xl-12 col-lg-12 col-sm-12 col-xs-12 " >{!! $question->details !!}</div> </a></div>
        <div class="col-xl-2 col-lg-2 col-sm-2 col-xs-12" style="text-align: right;padding: 0"><a href="javascript:void(0)" id="delete{{ $question->id }}"  class="btn btn-primary delete_botton"      data-link-title="{{ route('questions.question.destroy', $question->id) }}"><i class="fa fa-trash-o" aria-hidden="true" ></i></a>
         <a href="javascript:void(0)" id="spanbuton{{ $question->id }}"   data-toggle="modal" class="edit-button btn btn-primary"  onclick="addrecords('{!!$question->exercise_id !!}','{{ route('questions.question.edit_question', $question->id) }}','Edit Question','1')" data-target="#editskillModal" style="z-index: 0"><i class="fa fa-pencil" aria-hidden="true"></i></a>
                                   <a href="javascript:void(0)" id="spanbuton{{ $question->id }}"   data-toggle="modal" class="addanswer btn btn-primary"  onclick="addrecords('{!!$question->id !!}','{{ route('answeroptions.answeroption.create_answer') }}','Add Answer','2')"  data-target="#editskillModal" style="z-index: 0; border-radius: 0 12px 12px 0"><span> <i class="fa fa-font" aria-hidden="true">+</i></span></a></div>
        <div class="clear-line"></div></div>





        <div class="collapse multi-collapse que_ans{!!$question->id !!}" id="collapse{!!$question->id !!}" >

        </div>



</div>

