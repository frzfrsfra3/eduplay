    <div class=" course-box-inline">
    <div class="col-12 exercise-box"><a href="{{ route('exercisesets.exerciseset.summary',[ $exerciseset->id  ,$ispublic=1] ) }}"> {{ $exerciseset->title }}</a></div>
    <div class="col-12 description-box">{{ strlen($exerciseset->description) > 39 ? substr($exerciseset->description,0,36)."..." : $exerciseset->description }}</div>
    <div class="col-lg-12 discipline" id="disciplines"><label class="discipline-box"> {{ optional($exerciseset->discipline)->discipline_name }}</label><label class="discipline-box" >{{ optional($exerciseset->owner)->name }}</label></div>
    <div class="clear-line"></div>
    <div class="col-lg-4 col-sm-4 col-xs-4 count-box">{{  $exerciseset->question->count() }} <br><span class="count-box-sub"> @lang('exercisesets.question')</span></div>
    <div class="col-lg-4 col-sm-4 col-xs-4 count-box">{{ ($exerciseset->question->groupby('skill_id')->count('skill_id')) }} <br> <span class="count-box-sub">@lang('exercisesets.skills')</span></div>
    <div class="col-lg-4 col-sm-4 col-xs-4   count-box">{{  gmdate("H:i:s",$exerciseset->question->sum('maxtime')) }} <br> <span class="count-box-sub">@lang('exercisesets.duration')</span></div>
    <div class="clear-line"></div> </div>