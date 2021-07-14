
<div class="panel-heading clearfix">
    <div class="container">
        <div class="tabbable-line">
            <ul class="nav nav-tabs ">
                <li >
                    <a href="/courseclasses/myclasses" >
                        Private library : MY CLASSES  </a>
                </li>
                <li>
                    <a>  <i class="fa fa-chevron-right" aria-hidden="true"></i></a>
                </li>
                <li >

                    <a href="/courseclasses/show/{{$classexam->class_id}}" >

                        {{ isset($classexam->class->class_name) ? $classexam->class->class_name : 'No class name' }} </a>
                </li>

                <li>
                    <a>  <i class="fa fa-chevron-right" aria-hidden="true"></i></a>

                </li>


                <li>
                    <a href="" >

                        {{ isset($exam->title) ? $exam->title : 'No Exam name' }} </a>

                </li>
            </ul>
        </div>
    </div>
</div>

