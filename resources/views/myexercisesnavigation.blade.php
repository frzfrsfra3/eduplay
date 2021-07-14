<div class="panel-heading clearfix">
    <div class="container">
        <div class="tabbable-line">
            <ul class="nav nav-tabs ">
                <li >


                        @if($ispublic==1)
                        <a href="/exercisesets/" >
                     Public library : My exercises
                        </a>
                        @else
                        <a href="/exercisesets/private" >
                            Private library : My exercises
                        </a>
                        @endif

                </li>
                <li>
                    <a>  <i class="fa fa-caret-right " aria-hidden="true"></i></a>
                </li>
                <li >
                    @if($exerciseset)
                    <a href="/exercisesets/show/{{$exerciseset->id}}/0" >
                        {{ isset($exerciseset->title) ? $exerciseset->title : 'Exerciseset' }} </a>
                        @else
                        <a href="/exercisesets/private" >
                           New  Exerciseset</a>
                        @endif
                </li>
            </ul>
        </div>
    </div>
</div>