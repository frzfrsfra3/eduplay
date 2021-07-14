@php $rn=rand(1,3) @endphp

<div class=" col-xl-12 col-lg-12 col-sm-12 col-xs-12  course_box row-eq-height">
    <div class=" course-box-inline " onclick="location.href='@can ('update', $exerciseset) {{ route('exercisesets.exerciseset.show', [$exerciseset->id ,$ispublic]) }} @endcan
    @cannot ('update', $exerciseset){{ route('exercisesets.exerciseset.summary',[ $exerciseset->id  ,$ispublic]) }}@endcannot'" style="cursor: pointer">
        <div class="  col-xl-12 col-lg-12 col-sm-12 col-xs-12  title-boxes{{$rn}}">
            <div class="  col-xl-12 col-lg-12 col-sm-12 col-xs-12 all-padding ">

                <div class="  col-xl-9 col-lg-9 col-sm-8 col-xs-12  all-padding">  {{ optional($exerciseset->discipline)->discipline_name }}</div>
                <div class="  col-xl-3 col-lg-3 col-sm-4 col-xs-12 time-duration all-padding">  {{  gmdate("H:i:s",$exerciseset->question->sum('maxtime')) }} <i class="glyphicon glyphicon-time"></i> </div>
            </div>
            <div class="  col-xl-12 col-lg-12 col-sm-12 col-xs-12   all-padding ">{{ optional($exerciseset->owner)->name }}</div>
        </div>


        <div class=" col-xl-12 col-lg-12 col-sm-12 col-xs-12 exercise-box{{$rn}}">
        {{$exerciseset->title}}
        </div>
       <div class=" col-xl-12 col-lg-12 col-sm-12 col-xs-12  description-box">{{ strlen($exerciseset->description) > 153 ? substr($exerciseset->description,0,150)."..." : $exerciseset->description }}</div>
        <div class="clear-line"></div>
        <div class="col-xl-12 col-lg-12 col-sm-12 col-xs-12 all-padding rowposition" >
        <div class="col-xl-4 col-lg-4 col-sm-4 col-xs-4 count-boxes{{$rn}}"> @lang('exercisesets.question') {{  $exerciseset->question->count() }} </div>
        <div class="col-xl-4 col-lg-4 col-sm-4 col-xs-4 count-boxes{{$rn}}"  style="text-align: center">@lang('exercisesets.skills') {{ ($exerciseset->question->groupby('skill_id')->count('skill_id')) }} </div>
        <div class="col-xl-4 col-lg-4 col-sm-4 col-xs-4 count-price-boxes" style="text-align: center">
                <div class="prices-boxes" >
            @if ($exerciseset->price !=0)
                $ {{$exerciseset->price}} BUY
            @else
               FREE
            @endif
                </div>
        </div>
        </div>
        <div class="col-xl-12 col-lg-12 col-sm-12 col-xs-12 rate">All Rates:
                    <span class="fa  fa-1x @if ($exerciseset->averageRating(1)[0]>= 1) fa-star @else fa-star-o fa-star-default @endif " data-all-rating="1"></span>
                    <span class="fa  fa-1x @if ($exerciseset->averageRating(1)[0]>= 2) fa-star @else fa-star-o fa-star-default @endif" data-all-rating="2"></span>
                    <span class="fa  fa-1x @if ($exerciseset->averageRating(1)[0]>= 3) fa-star @else fa-star-o fa-star-default @endif" data-all-rating="3"></span>
                    <span class="fa  fa-1x @if ($exerciseset->averageRating(1)[0]>= 4) fa-star @else fa-star-o fa-star-default @endif" data-all-rating="4"></span>
                    <span class="fa  fa-1x @if ($exerciseset->averageRating(1)[0]>= 5) fa-star @else fa-star-o fa-star-default @endif" data-all-rating="5"></span>

        </div>
        <div class="clear-line"></div>
    </div>

</div>
