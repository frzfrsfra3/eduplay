 @auth
 <ul class="dropdown-menu home-menu">
    @if(!Auth::user()->hasRole('Admin'))
    <li class="m3" id="step4">
        <a @if( Request::segment(1) == 'pendingtasks') class="active" @endif href="{{ route('pendingtasks.mypendingtasks') }}">@lang('exercisesets.my_tasks') </a>
    </li>
    @endif
    <li id="step5">
        <a class="{{ Request::segment(2) === 'private' ? 'active' : null }}" href="{{ route('exercisesets.exerciseset.private') }}">@if(!Auth::user()->hasRole('Admin')) @lang('exercisesets.my_library') @else @lang('exercisesets.exercises') @endif</a>
    </li>
    @if(!Auth::user()->hasRole('Admin'))
      <li id="step6">
          <a class="{{ Request::segment(2) === 'myclasses' ? 'active' : null }}" href="{{ route('courseclasses.courseclass.myclasses') }}">@lang('exercisesets.my_classes')</a>
      </li>
      @if(Auth::user()->hasRole('Teacher') || Auth::user()->hasRole('Learner'))
          <li class="m2" id="step7">
              <a class="{{ Request::segment(1) === 'exams' ? 'active' : null }}" href="{{ route('exams.exam.index') }}">@lang('exercisesets.my_assignments') </a>
          </li>
      @endif
      <li id="step8">
          <a @if( Request::segment(1) == 'reports') class="active" @endif href="{{route('reports')}}">@lang('exercisesets.my_reports') </a>
      </li>
      <li id="step9">
          <a @if( Request::segment(1) == 'my-assets') class="active" @endif href="{{route('myassets')}}">@lang('exercisesets.my_files') </a>
      </li>
       <li id="step9">
          <a @if( Request::segment(2) == 'my-codes') class="active" @endif href="{{route('games.my.codes')}}">@lang('exercisesets.my_codes') </a>
      </li>
    @endif
</ul>
 @endauth
