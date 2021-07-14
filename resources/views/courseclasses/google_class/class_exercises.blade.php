<div class="main_summery_earth pd_lf_25">
    <div class="clearfix"></div>
    <div class="name_list mrgn-bt-30">
        <h4>{{ $googleclass->name }}</h4>
    </div>
    <div class="row">
        <div class="col-md-12">
            <ul class="exe_tbs nav nav-pills sub-tabs class_exercises mb-3" id="pills-tab" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" id="pills-exersice-tab" data-toggle="pill" href="#pills-exersice" role="tab" aria-controls="pills-exersice" aria-selected="true">@lang('classcourse.exercise_set')</a>
                </li>
                {{-- <li class="nav-item ">
                    <a class="nav-link" id="pills-pins-tab" data-toggle="pill" href="#pills-pins" role="tab" aria-controls="pills-pins" aria-selected="false">@lang('classcourse.pins')</a>
                </li> --}}
            </ul>
        </div>
    </div>
    
    <div class="tab-content" id="pills-tabContent">
        <div class="tab-pane fade show active" id="pills-exersice" role="tabpanel" aria-labelledby="pills-exersice-tab">
            <div class="my_exercise mrgn-tp-20 mrgn-bt-30 tabs_publish_lf_00">
                <div class="row">
                    <div class="col-sm-12">
                        <h4 class="exersc_title">@lang('classcourse.my_exercises')</h4>
                        {{-- @if(Auth::user()->id == $googleclass->user_id)
                        <a href="{{ route('exercisesets.exerciseset.private',['class_id' => $googleclass->id]) }}" class="creat_new pdng_add_btn">@lang('classcourse.Add')</a>
                        @endif --}}
                    </div>
                </div>
                <div class="list_of_exercise mrgn-tp-20 aaa">
                    <div class="row">
                        @php
                        $courseclassexercises= $googleclass->exercises()->where([['createdby', '=', $googleclass->user_id]])->get();
                        @endphp
                        @if (count($courseclassexercises))
                            @foreach($courseclassexercises as $myexercise)
                                @include('courseclasses.google_class.exercise' ,$myexercise)
                            @endforeach
                        @else
                            <div class="col-md-12">
                                <p {{--class="no_dt_title"--}}>@lang('classcourse.no_library_available')</p>
                                <div class="clearfix"></div><br/>
                                <div class="clearfix"></div><br/>
                            </div>
                        @endif
                    </div>
                </div>
                <div class="list_of_exercise add_nw_exrsc">
                    <h4 class="exersc_title ">@lang('classcourse.recommended_from_public_library')</h4>
                    {{-- @if(Auth::user()->id == $googleclass->user_id)
                    <a href="{{ route('explore.exerciseset',['class_id' => $googleclass->id ]) }}" class="creat_new m2">@lang('classcourse.add_recommendation')</a>
                    @endif --}}
                        <div class="row">
                            @php
                                $courseclassPublicExercises= $googleclass->exercises()->where([['publish_status', 'like', 'public'],['createdby', '!=', $googleclass->user_id]])->get();
                            @endphp
                            @if (count($courseclassPublicExercises))
                                @foreach($courseclassPublicExercises as $publicExercise)
                                    @include('courseclasses.public_exercies' ,$publicExercise)
                                @endforeach
                            @else
                                <div class="col-md-12">
                                    <p {{-- class="no_dt_title" --}}>@lang('classcourse.no_public_library_available')</p>
                                    <div class="clearfix"></div><br/>
                                    <div class="clearfix"></div><br/>
                                </div>
                            @endif
                        </div>
                </div>
            </div>
        </div>
    </div>
</div>