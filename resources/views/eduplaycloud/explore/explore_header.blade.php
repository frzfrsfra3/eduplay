<ul class="tabs_menu nav nav-pills mb-3 mrgn_tbs_less" id="pills-tab" role="tablist">
    {{-- @if(!Auth::guest()) --}}
     <li class="nav-item">
        {{-- <a class="nav-link" id="pills-Libray-tab" data-toggle="pill" href="#pills-Libray" role="tab" aria-controls="pills-Libray" aria-selected="false" onclick="getPublicLibrary()">Public Library</a> --}}
        <a class="nav-link {{ Request::segment(2) === 'exerciseset' ||  Request::segment(3) === 'exercisesets' ? 'active' : null }}"  href="{{ route('explore.exerciseset') }}">@lang("explore.public library")</a>
    </li>
    <li class="nav-item">
        <a class="nav-link {{ Request::segment(2) === 'classes' || Request::segment(1) === 'courseclasses'  ||  Request::segment(3) === 'classes' ? 'active' : null }}" href="{{ route('explore.classes') }}">@lang("explore.classes")</a>
    </li>
    {{-- @endif --}}
    <li class="nav-item m2">
        <a class="nav-link {{ Request::segment(1) === 'topics' ? 'active' : null }}" href="{{ route('topics.topic.index') }}">@lang("explore.topics")</a>
    </li>
    {{-- @if(!Auth::guest()) --}}
    <li class="nav-item m2">
        <a class="nav-link {{ Request::segment(2) === 'disciplines' ? 'active' : null }}" id="pills-Curriculun-tab" href="{{ route('explore') }}" >@lang("explore.curriculum")</a>
    </li>
    {{-- @endif --}}
    <li class="nav-item">
        <a class="nav-link {{ Request::segment(1) === 'games' ? 'active' : null }}"  href="{{ route('games.game.index') }}"  >@lang('explore.games')</a>
    </li>
</ul>