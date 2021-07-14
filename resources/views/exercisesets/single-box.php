<div class=" col-xl-4 col-lg-4 col-sm-4 col-xs-12  course_box">
    <div class=" course-box-inline" onclick="location.href='{{ route('exercisesets.exerciseset.show', $exerciseset->id) }}'">
        <div class="col-12 exercise-box">@can ('update', $exerciseset)<a href="{{ route('exercisesets.exerciseset.show', $exerciseset->id) }}"> {{ $exerciseset->title }}</a>@endcan
            @cannot ('update', $exerciseset)<a href="{{ route('exercisesets.exerciseset.summary', $exerciseset->id) }}"> {{ $exerciseset->title }}</a>@endcannot

        </div>

        <div class="col-12 description-box">{{ strlen($exerciseset->description) > 40 ? substr($exerciseset->description,0,37)."..." : $exerciseset->description }}</div>
        <div class="col-lg-12 discipline" id="disciplines"><label class="discipline-box"> {{ optional($exerciseset->discipline)->discipline_name }}</label><label class="discipline-box" >{{ optional($exerciseset->owner)->name }}</label></div>
        <div class="clear-line"></div>
        <div class="col-lg-4 col-sm-4 col-xs-4 count-box">{{  $exerciseset->question->count() }} <br><span class="count-box-sub"> @lang('exercisesets.question')</span></div>
        <div class="col-lg-4 col-sm-4 col-xs-4 count-box">{{ ($exerciseset->question->groupby('skill_id')->count('skill_id')) }} <br> <span class="count-box-sub">@lang('exercisesets.skills')</span></div>
        <div class="col-lg-4 col-sm-4 col-xs-4   count-box">{{  gmdate("H:i:s",$exerciseset->question->sum('maxtime')) }} <br> <span class="count-box-sub">@lang('exercisesets.duration')</span></div>
        <div class="clear-line"></div> </div>

</div>







@php $rn=rand(1,3) @endphp
<div class="exercise-box-inline exercise-box-right-{{$rn}}  row-eq-height "  onclick="location.href='{{ route('exercisesets.exerciseset.show', $exerciseset->id) }}'" style="cursor: pointer">

    <div class=" col-xl-6 col-lg-6 col-sm-6 col-xs-12 exercise-box-left-{{$rn}} " >


        <div class="col-12 exercise-box " style="padding: 5px 0 0 0">
            <div  class="discipilne-name">{{ optional($exerciseset->discipline)->discipline_name }} </div>
            <div class="col-lg-12 discipline exe_woner" id="disciplines">exercise created by: {{ optional($exerciseset->owner)->name }}</div>
            <div class="clear-line"></div>
            <div class="col-lg-4 col-sm-4 col-xs-4 count-box">{{  $exerciseset->question->count() }} <br><span class="count-box-sub"> @lang('exercisesets.question')</span></div>
            <div class="col-lg-4 col-sm-4 col-xs-4 count-box">{{ ($exerciseset->question->groupby('skill_id')->count('skill_id')) }} <br> <span class="count-box-sub">@lang('exercisesets.skills')</span></div>
            <div class="col-lg-4 col-sm-4 col-xs-4   count-box">{{  gmdate("H:i:s",$exerciseset->question->sum('maxtime')) }} <br> <span class="count-box-sub">@lang('exercisesets.duration')</span></div>
            <div class="clear-line"></div>

        </div>
    </div>

    <div class=" col-xl-6 col-lg-6 col-sm-6 col-xs-12 ">
        <div class="col-12 description-box">
            @can ('update', $exerciseset)
            <a href="{{ route('exercisesets.exerciseset.show', $exerciseset->id) }}" class="exercise_link"> {{ $exerciseset->title }}</a>
            @endcan
            @cannot ('update', $exerciseset)
            <a href="{{ route('exercisesets.exerciseset.summary', $exerciseset->id) }}" class="exercise_link">
                {{ $exerciseset->title }}</a>
            @endcannot</div>
        <div class="col-12 description-box"> {{ strlen($exerciseset->description) > 50 ? substr($exerciseset->description,0,47)."..." : $exerciseset->description }}</div>
    </div>
    <div class="clear"></div>
</div>
