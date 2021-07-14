<div class="panel-heading clearfix">
    <div class="container">
        <div class="tabbable-line">
            <ul class="nav nav-tabs ">
                <li >
                    <a href="/exams" >
                     Private library : My exams  </a>
                </li>
                <li>
                    <a>  <i class="fa fa-caret-right " aria-hidden="true"></i></a>
                </li>
                <li >
                    <a href="" >
                        {{ isset($exam->title) ? $exam->title : 'New Exam' }} </a>
                </li>
            </ul>
        </div>
    </div>
</div>