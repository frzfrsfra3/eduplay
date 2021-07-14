@auth()
    <div class="tabbable-line">
        <ul class="nav nav-tabs ">

            @if($active ==4)
                <li class="active">
            @else
                <li>
                    @endif
                    <a href="javascript:void(0);"
                       onclick="javascript:gotoSection('{{ route('topics.topic.index') }}');"
                       data-toggle="tab">
                        @lang('explore.topics') </a>
                </li>

            @if($active==2)
                <li class="active">
            @else
                <li>
                    @endif
                    <a href="javascript:void(0);"
                       onclick="javascript:gotoSection('{{ route('exercisesets.exerciseset.index') }}');"
                       data-toggle="tab">
                        @lang('explore.public library') </a>
                </li>
                @if($active==3)
                    <li class="active">
                @else
                    <li>
                        @endif <a href="javascript:void(0);"
                                  onclick="javascript:gotoSection('{{ route('courseclasses.courseclass.index') }}');"
                                  data-toggle="tab">
                            @lang('explore.classes')</a>
                    </li>
                    @if($active ==1)
                        <li class="active">
                    @else
                        <li>
                            @endif
                            <a href="javascript:void(0);"
                               onclick="javascript:gotoSection('{{ route('disciplines.discipline.index') }}');"
                               data-toggle="tab">
                                @lang('explore.disciplines') </a>
                        </li>

        </ul>

    </div>
@endauth
@guest()
    <div class="tabbable-line">
        <ul class="nav nav-tabs ">

            @if($active ==4)
                <li class="active">
            @else
                <li>
                    @endif
                    <a href="javascript:void(0);"
                       onclick="javascript:gotoSection('{{ route('topics.topic.index') }}');"
                       data-toggle="tab">
                        @lang('explore.topics') </a>
                </li>

                @if($active==2)
                    <li class="active">
                @else
                    <li>
                        @endif
                        <a href="javascript:void(0);"
                           onclick="javascript:gotoSection('{{ route('explore.exerciseset') }}');" data-toggle="tab">
                            @lang('explore.public library') </a>
                    </li>
                    @if($active==3)
                        <li class="active">
                    @else
                        <li>
                            @endif <a href="javascript:void(0);"
                                      onclick="javascript:gotoSection('{{ route('explore.classes') }}');"
                                      data-toggle="tab">
                                @lang('explore.classes')</a>
                        </li>
                    @if($active ==1)
                        <li class="active">
                    @else
                        <li>
                            @endif
                            <a href="javascript:void(0);" onclick="javascript:gotoSection('{{ route('explore.discipline') }}');"
                               data-toggle="tab">
                                @lang('explore.disciplines') </a>
                        </li>

        </ul>

    </div>
@endguest