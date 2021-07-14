<a href="{{route('exercisesets.exerciseset.show', [$myexercise->id ,$ispublic=0 ] )}}" style="color: inherit;" >
<div class="col-md-6 col-lg-6 col-xl-3 cusmize-col">
    <div class="main_info pstn_rltv">
        <a href="{{ route('exercisesets.exerciseset.summary',[$myexercise->id ,$ispublic=0]) }}" class="info_exercise">  
            @php
            if (isset($myexercise->exerciseset_image) && !empty($myexercise->exerciseset_image)) {
                if (strlen($myexercise->exerciseset_image) > 0 && File::exists(public_path()."/uploads/exercisesets/".$myexercise->exerciseset_image)) {
                    $myexerciseImage = '/uploads/exercisesets/'.$myexercise->exerciseset_image;
                } else {
                    $myexerciseImage = 'assets/eduplaycloud/image/exers_prfl.png';
                }
            } else {
                $myexerciseImage = 'assets/eduplaycloud/image/exers_prfl.png';
            }
            @endphp
            <img src="{{ asset($myexerciseImage) }}" class="img-fluid">
            <div class="left_time_info">
                <ul class="time_info float-left">
                    <li>
                        @if ($myexercise->price != 0)
                            ${{ $myexercise->price }}
                        @else
                            @lang('classcourse.free')
                        @endif
                    </li>
                    <li class="time_icn">{{ gmdate("H:i:s", $myexercise->question->sum('maxtime')) }}</li>
                </ul>
                <ul class="skill_info float-right">
                    <li>
                        @lang('exercisesets.skills'):
                        {{ ($myexercise->question->where('skill_id','!=',null)->groupby('skill_id')->count('skill_id')) }}
                    </li>
                    <li>
                        @lang('exercisesets.question'):
                        {{ $myexercise->question->count() }}
                    </li>
                </ul>
            </div>
        </a>
        @if(Auth::user()->id == $courseclass->teacher_userid)
            <button class="btn delet_request" onclick="add_remove_exercise_to_class( '{{ route('courseclasses.courseclass.removeexercise', [$courseclass->id  ,$myexercise->id ] ) }}','{!! $myexercise->id !!}' ,'remove') "></button>
        @endif
        <ul class="title_cmbo">
            <li><a href="#"> {{str_limit($myexercise->title,25)}}</a></li>
            @if($myexercise->discipline)
                 <li><p>{{  str_limit(@$myexercise->discipline->discipline_name, '20') }}</p></li>
            @else 
                <li><span>@lang('filter.n/a')</span></li>
            @endif
        </ul>
        <ul class="star_wth_user aa">
            <li>
                <div class="gray_star">
                    <div class="orng_star" style="width: {{(@$myexercise->averageRating(1)[0]) * 100 / 5}}%;"></div>
                </div>
                <span class="rtng">{{@$myexercise->averageRating(1)[0]}}</span>
            </li>
            @if($myexercise->grade)
                <li><span>{{@$myexercise->grade->grade_name}}</span></li>
            @else 
                <li><span>@lang('filter.n/a')</span></li>
            @endif
            <li><small>{{ $myexercise->created_at }}</small></li>
        </ul>
    </div>
</div>
</a>