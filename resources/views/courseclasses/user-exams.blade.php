
@if($error_date)

    <div class="alert alert-danger">
        <span class="glyphicon glyphicon-ok"></span>

        you have entered a wrong start or end exam date
        <button type="button" class="close" data-dismiss="alert" aria-label="close">
            <span aria-hidden="true">&times;</span>
        </button>

    </div>
@endif


<div class="col-12 class-head-box" >My Exams  </div>
<div class="col-12  class-scroll-list  class-scroll-style" >

        @php

    $user= Auth::user();
    $myexams=$user->myexams()->get();
    $courseclassexams= $courseclass->exams()->get();
    $myexams=$myexams->diff($courseclassexams);
    $myexams->unique();
        @endphp
     @if ($myexams->count()==0)
         No exams
         @else

    @foreach($myexams as $exam)
        <form method="get" id="exam-form" >
        <div style=" min-height: 30px;margin-top: 10px; margin-left: 10px">
            <span>{{$exam->title}}</span>
            {{--<input type ="datetime-local" id="exam_start_date" name ="exam_start_date" required style="width: 190px;line-height:normal;">--}}
            <br>Start date /time:
            <input type ="date" id="exam_s_date{{$exam->id}}" required style="width: 140px;line-height:normal;">
            <input type ="time" id="exam_s_time{{$exam->id}}" required style="width: 100px;line-height:normal;">
            {{--<input type ="datetime-local" id="exam_end_date" name ="exam_end_date" required style="width: 190px;line-height:normal;">--}}
            <br>End date / time :
            <input type ="date" id="exam_e_date{{$exam->id}}" required style="width: 140px;line-height:normal;">
            <input type ="time" id="exam_e_time{{$exam->id}}" required style="width: 100px;line-height:normal;">
            <a id="accept_btn"     onclick="add_exam( '{{ route('courseclasses.courseclass.addexam', [$courseclass->id  ,$exam->id ] ) }}','{!! $exam->id !!}')"
               class="fa fa-check-circle-o btn text-primary  fa-lg publishicon abtn"  style=" background-color: transparent;padding: -5px"  aria-hidden="true"  title="@lang('messages.Add')"
               ></a>

            <div id=""  style="border-top: 1px solid rgba(129,166,174,0.64)"></div>
        </div>
        </form>
    @endforeach
         @endif
</div>