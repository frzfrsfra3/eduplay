@if (isset($_GET['up']) && $_GET['up']==1)
    @if($answer->iscorrect==1) <i class="fa fa-check" style="color: green"></i>
    @else <i class="fa fa-times" style="color: red"></i>
    @endif
    {!! $answer->details !!}

@else
<div class="dd-handle nest-class"  id="re_ans{!!$answer->id !!}"><div  class="quest-display" id="ans{!!$answer->id !!}">
        @if($answer->iscorrect==1) <i class="fa fa-check" style="color: green"></i>
        @else <i class="fa fa-times" style="color: red"></i>
        @endif
            {!! $answer->details !!} </div>
    <div style="float: right"><a href="javascript:void(0)" id="spanbuton{{ $answer->id }}"  data-toggle="modal" class="edit_answer btn btn-primary " data-backdrop="static" data-keyboard="false" onclick="addrecords('{!!$answer->question_id !!}','{{ route('answeroptions.answeroption.edit_answer', $answer->id) }}','Edit Answer','1')"  data-target="#editskillModal" style="z-index: 0; border-radius: 0 12px 12px 0"><span> <i class="fa fa-pencil" aria-hidden="true"></i></span></a></div>
    <div class="clear-line"></div></div>
    @endif