<ul>
    <li><a  @if( Request::segment(2) == 'private') class="active" @endif href="{{ route('exercisesets.exerciseset.private') }}">@lang('exercisesets.my_private_library')</a></li>
    <li><a  @if( Request::segment(2) == 'myclasses') class="active" @endif href="{{ route('courseclasses.courseclass.myclasses') }}">@lang('exercisesets.my_classes')</a></li>
    <li  @if( Request::segment(1) == 'my-task') class="active" @endif class="m3"><a href="{{ route('my-task') }}">@lang('exercisesets.my_tasks')</a></li>
    <li  @if( Request::segment(1) == 'exams') class="active" @endif class="m2"><a href="{{ route('exams.exam.index') }}">@lang('exercisesets.my_assignments')</a></li>
    <li><a @if( Request::segment(1) == 'reports') class="active" @endif href="{{route('reports')}}">@lang('exercisesets.my_reports')</a></li>
</ul>