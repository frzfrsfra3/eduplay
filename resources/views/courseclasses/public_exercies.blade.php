<div class="col-md-6 col-lg-6 col-xl-3 cusmize-col">
        <div class="main_info">
            <a href="{{ route('exercisesets.exerciseset.summary',[$publicExercise->id ,$ispublic=0]) }}" class="info_exercise">
                <div class="info_exercise">
                    <img src="{{asset('assets/eduplaycloud/image/public_libray.png')}}" class="img-fluid">
                    <div class="whit_checbx">
                        <div class="profile_name">
                                @if($publicExercise->owner->user_image)
                                <img src="{{asset('assets/images/profiles')}}/{{  $publicExercise->owner->user_image }}">
                                @else
                                <img src="{{asset('assets/images/profiles/userdefaultimg.png')}}">
                                @endif
                            <p>{{ ($publicExercise->owner)->name }}</p>
                        </div>
                    </div>
                    <div class="left_time_info">
                        <ul class="time_info float-left">
                            <li>
                                @if ($publicExercise->price != 0)
                                    ${{ $publicExercise->price }}
                                @else
                                    @lang('classcourse.free')
                                @endif
                            </li>
                            <li class="time_icn">{{  gmdate("H:i:s",$publicExercise->question->sum('maxtime')) }}</li>
                        </ul>
                        <ul class="skill_info float-right">
                            <li>@lang('classcourse.skills') :  {{ ($publicExercise->question->where('skill_id','!=',null)->groupby('skill_id')->count('skill_id')) }}</li>
                            <li>@lang('classcourse.questions') : {{  $publicExercise->question->count() }}</li>
                        </ul>
                    </div>
                </div>
            </a>
            <ul class="title_cmbo">
                <li><a href="#">{{str_limit(@$publicExercise->title, '30')}}</a></li>
                <li><p>{{@$publicExercise->discipline->discipline_name}}</p></li>
            </ul>
							@if(Auth::user()->id == $courseclass->teacher_userid)
            	<button class="btn delet_request" onclick="add_remove_exercise_to_class( '{{ route('courseclasses.courseclass.removeexercise', [$courseclass->id  ,$publicExercise->id ] ) }}','{!! $publicExercise->id !!}' ,'remove') "></button>
        			@endif
            <ul class="star_wth_user bbb">
                <li>
                    <div class="gray_star">
                        <div class="orng_star" style="width: {{(@$publicExercise->averageRating(1)[0]) * 100 / 5}}%;"></div>
                    </div>
                    <span class="rtng">{{@$publicExercise->averageRating(1)[0]}}</span>
                </li>
                @if($publicExercise->grade)
                <li><span>{{@$publicExercise->grade->grade_name}}</span></li>
                @endif
            </ul>
            <div class="descption_prfl">
                <p> <p>{{ strlen($publicExercise->description) > 153 ? substr($publicExercise->description,0,150)."..." : $publicExercise->description }}</p></p>
            </div>
        </div>
    </div>