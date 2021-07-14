<div class="panel-heading clearfix">
    <div class="container">
        <div class="tabbable-line">
            <ul class="nav nav-tabs ">
                <li >
                    <a href="/courseclasses/myclasses" >
                     Private library : My classes  </a>
                </li>
                <li>
                    <a>  <i class="fa fa-caret-right " aria-hidden="true"></i></a>
                </li>
                <li >
                    <a href="" >
                        {{ isset($courseclass->class_name) ? $courseclass->class_name : 'New Class' }} </a>
                </li>
            </ul>
        </div>
    </div>
</div>