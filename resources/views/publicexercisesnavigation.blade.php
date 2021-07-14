<div class="panel-heading clearfix">
    <div class="container">
        <div class="tabbable-line">
            <ul class="nav nav-tabs ">
                <li >
                    <a href="/exercisesets/private" >
                     Public library : exercises  </a>
                </li>
                <li>
                    <a>  <i class="fa fa-caret-right " aria-hidden="true"></i></a>
                </li>
                <li >
                    <a href="" >
                        {{ isset($exerciseset->title) ? $exerciseset->title : 'Exerciseset' }} </a>
                </li>
            </ul>
        </div>
    </div>
</div>