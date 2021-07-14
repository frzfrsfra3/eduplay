<div class="panel-heading clearfix">
    <div class="container">
        <div class="tabbable-line">
            <ul class="nav nav-tabs ">
                <li >
                    <a href="{{ route('disciplines.discipline.index') }}" >
                        Explore </a>

                </li>
                <li><a>  <i class="fa fa-caret-right" aria-hidden="true"></i></a></li>
                <li>  <a> {{ $discipline->discipline_name}}:   published v.{{$lastversion}}</a></li>
                               @foreach($discipline->disciplinecollaborators as $collaborator  )
                            <li style="float: right"><img src="{{ Avatar::create($collaborator->name)->toBase64() }}" data-toggle="tooltip" title="{{$collaborator->name}}" height="30" width="30" /></li>
                        @endforeach
                    </ul>

        </div>
    </div>
</div>