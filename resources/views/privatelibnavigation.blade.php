<div class="tabbable-line">
    <ul class="nav nav-tabs ">
        @if($active ==1)
            <li class="active">
        @else
            <li>
        @endif
                <a href="{{ route('exercisesets.exerciseset.private') }}">@lang('messages.MyExercises')</a>
            </li>

        @if($active ==2)
            <li class="active">
        @else
            <li>
        @endif
                <a href="{{ route('exams.exam.index') }}">@lang('messages.MyExams')</a>
             </li>
        @if($active ==3)
             <li class="active">
        @else
              <li>
        @endif
                <a href="{{route('courseclasses.courseclass.myclasses')}}">@lang('messages.Myclasses')</a>
              </li>

    </ul>
</div>
