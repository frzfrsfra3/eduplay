@if(count($exercisets))
    @foreach ($exercisets as $exerciseset)
    @if($exerciseset->discipline && $exerciseset->grade)   {{--  If discipline & grade not null   --}}
    <div class="col-md-6 col-lg-6 col-xl-3 cusmize-col">
        <div class="main_info">
            <a href="javascript:;" class="info_exercise">
                @php
                    if (isset($exerciseset->exerciseset_image) && !empty($exerciseset->exerciseset_image)) {
                        if (strlen($exerciseset->exerciseset_image) > 0 && File::exists(public_path()."/uploads/exercisesets/".$exerciseset->exerciseset_image)) {
                            $exercisesetImage = '/uploads/exercisesets/'.$exerciseset->exerciseset_image;
                        } else {
                            $exercisesetImage = 'assets/eduplaycloud/image/exers_prfl.png';
                        }
                    } else {
                        $exercisesetImage = 'assets/eduplaycloud/image/exers_prfl.png';
                    }
                    @endphp
                <img src="{{ asset($exercisesetImage) }}" class="img-fluid">
                <div class="whit_checbx">
                    <div class="profile_name">
                            @if($exerciseset->owner->user_image)
                            <img src="{{asset('assets/images/profiles')}}{{  '/'.$exerciseset->owner->user_image }}">
                            @else
                            <img src="{{ asset('uploads/profile') }}/proflie_welcome.png">
                            @endif
                            <p>{{ ($exerciseset->owner)->name }}</p>
                    </div>
                </div>
                @if($exerciseset->discipline && $exerciseset->grade)   {{--  If discipline & grade not null   --}}
                    <div class="main_shr">
                        <div class="custom-control custom-checkbox chbx_wt">
                            <input name="topic_exercise[]" value="{{$exerciseset->id}}" id="topic_exercise_{{$exerciseset->id}}" type="checkbox" class="custom-control-input">
                            <label class="custom-control-label" for="topic_exercise_{{$exerciseset->id}}"></label>
                        </div>
                    </div>
                @else
                    @if(session('discipline_id') == 'notlinked')
                    <div class="main_shr">
                        <div class="custom-control custom-checkbox chbx_wt">
                            <input name="topic_exercise_no_grate[]" value="{{$exerciseset->id}}" id="topic_exercise_no_grate_{{$exerciseset->id}}" type="checkbox" class="custom-control-input">
                            <label class="custom-control-label" for="topic_exercise_no_grate_{{$exerciseset->id}}"></label>
                        </div>
                    </div>
                    @endif
                @endif
                <div class="left_time_info">
                    <ul class="time_info float-left">
                        <li class="time_icn">
                            {{ gmdate("H:i:s", $exerciseset->question->sum('maxtime')) }}
                        </li>
                    </ul>
                    <ul class="skill_info float-right">
                        <li>
                            @lang('exercisesets.skills'):
                            {{ ($exerciseset->question->where('skill_id','!=',null)->groupby('skill_id')->count('skill_id')) }}
                        </li>
                        <li>
                            @lang('exercisesets.question'):
                            {{ $exerciseset->question->count() }}
                        </li>
                    </ul>
                </div>
            </a>
            <ul class="creat_exr title_cmbo">
                <li>
                    <label>{{ str_limit($exerciseset->title,'37') }}</label>
                </li>
                @if($exerciseset->discipline)
                    <li><span>{{@$exerciseset->discipline->discipline_name}}</span></li>
                @else
                    <li><span>@lang('filter.n/a')</span></li>
                @endif
            </ul>
            <ul class="star_wth_user">
                <li>
                    <div class="gray_star">
                        <div class="orng_star" style="width: {{(@$exerciseset->averageRating(1)[0]) * 100 / 5}}%;"></div>
                    </div>
                    <span class="rtng">{{@$exerciseset->averageRating(1)[0]}}</span>
                </li>
                @if($exerciseset->grade)
                    <li title="{{ $exerciseset->grade->grade_name }}"><span>{{ str_limit(@$exerciseset->grade->grade_name, '18')}}</span></li>
                @else
                    <li><span>@lang('filter.n/a')</span></li>
                @endif
                <li><small>{{ $exerciseset->created_at }}</small></li>
            </ul>
            <div class="descption_prfl">
                <p>
                @if($exerciseset->description)
                  {{str_limit(@$exerciseset->description, '25')}}
                @endif
                </p>
            </div>
        </div>
    </div>
    @else
        @if(session('discipline_id') == 'notlinked')
            <div class="col-md-6 col-lg-6 col-xl-3 cusmize-col">
            <div class="main_info">
                <a href="javascript:;" class="info_exercise">
                    @php
                        if (isset($exerciseset->exerciseset_image) && !empty($exerciseset->exerciseset_image)) {
                            if (strlen($exerciseset->exerciseset_image) > 0 && File::exists(public_path()."/uploads/exercisesets/".$exerciseset->exerciseset_image)) {
                                $exercisesetImage = '/uploads/exercisesets/'.$exerciseset->exerciseset_image;
                            } else {
                                $exercisesetImage = 'assets/eduplaycloud/image/exers_prfl.png';
                            }
                        } else {
                            $exercisesetImage = 'assets/eduplaycloud/image/exers_prfl.png';
                        }
                        @endphp
                    <img src="{{ asset($exercisesetImage) }}" class="img-fluid">
                    <div class="whit_checbx">
                        <div class="profile_name">
                                @if($exerciseset->owner->user_image)
                                <img src="{{asset('assets/images/profiles')}}{{  '/'.$exerciseset->owner->user_image }}">
                                @else
                                <img src="{{ asset('uploads/profile') }}/proflie_welcome.png">
                                @endif
                                <p>{{ ($exerciseset->owner)->name }}</p>
                        </div>
                    </div>
                    @if($exerciseset->discipline && $exerciseset->grade)   {{--  If discipline & grade not null   --}}
                        <div class="main_shr">
                            <div class="custom-control custom-checkbox chbx_wt">
                                <input name="topic_exercise[]" value="{{$exerciseset->id}}" id="topic_exercise_{{$exerciseset->id}}" type="checkbox" class="custom-control-input">
                                <label class="custom-control-label" for="topic_exercise_{{$exerciseset->id}}"></label>
                            </div>
                        </div>
                    @else
                        @if(session('discipline_id') == 'notlinked')
                        <div class="main_shr">
                            <div class="custom-control custom-checkbox chbx_wt">
                                <input name="topic_exercise_no_grate[]" value="{{$exerciseset->id}}" id="topic_exercise_no_grate_{{$exerciseset->id}}" type="checkbox" class="custom-control-input">
                                <label class="custom-control-label" for="topic_exercise_no_grate_{{$exerciseset->id}}"></label>
                            </div>
                        </div>
                        @endif
                    @endif
                    <div class="left_time_info">
                        <ul class="time_info float-left">
                            <li class="time_icn">
                                {{ gmdate("H:i:s", $exerciseset->question->sum('maxtime')) }}
                            </li>
                        </ul>
                        <ul class="skill_info float-right">
                            <li>
                                @lang('exercisesets.skills'):
                                {{ ($exerciseset->question->where('skill_id','!=',null)->groupby('skill_id')->count('skill_id')) }}
                            </li>
                            <li>
                                @lang('exercisesets.question'):
                                {{ $exerciseset->question->count() }}
                            </li>
                        </ul>
                    </div>
                </a>
                <ul class="creat_exr title_cmbo">
                    <li>
                        <label>{{ str_limit($exerciseset->title,'37') }}</label>
                    </li>
                    @if($exerciseset->discipline)
                        <li><span>{{@$exerciseset->discipline->discipline_name}}</span></li>
                    @else
                        <li><span>@lang('filter.n/a')</span></li>
                    @endif
                </ul>
                <ul class="star_wth_user">
                    <li>
                        <div class="gray_star">
                            <div class="orng_star" style="width: {{(@$exerciseset->averageRating(1)[0]) * 100 / 5}}%;"></div>
                        </div>
                        <span class="rtng">{{@$exerciseset->averageRating(1)[0]}}</span>
                    </li>
                    @if($exerciseset->grade)
                        <li title="{{ $exerciseset->grade->grade_name }}"><span>{{ str_limit(@$exerciseset->grade->grade_name, '18')}}</span></li>
                    @else
                        <li><span>@lang('filter.n/a')</span></li>
                    @endif
                    <li><small>{{ $exerciseset->created_at }}</small></li>
                </ul>
                <div class="descption_prfl">
                    <p>
                    @if($exerciseset->description)
                    {{str_limit(@$exerciseset->description, '25')}}
                    @endif
                    </p>
                </div>
            </div>
        </div>


        @endif
    @endif
    @endforeach
@else 
<div class="col-md-12">
    <p>@lang('topic.no_exercisets_available')</p>
</div>
@endif