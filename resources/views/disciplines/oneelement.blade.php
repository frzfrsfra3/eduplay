@if(count($disciplines) == 0)


<div class="col-md-12" style="text-align: center;"><p>@lang('disciplines.no_curriculum_available')</p></div>
@else
    @foreach($disciplines as $discipline)
        <div class="col-md-6 col-lg-4 col-xl-3 cusmize-col">
            <div class="inr_cir_exrs">
                {{-- <a href="{{ route('explore.discipline.summary',$discipline->id) }}" class="circullm_box circullm_box_btm"> --}}
                <a href="{{route('explore.curriculum.skill-list',$discipline->id)}}" class="circullm_box circullm_box_btm">
                    <div class="combo_check_txt">
                        <div class="orng_checkbx float-left">
                            <h6>{{@$discipline->discipline_name}}</h6>
                        </div>
                        <div class="float-right">
                            <span><button type="button" class="collbr_btn">{{ optional($discipline->languagePreference)->language }}</button></span>
                        </div>
                    </div>
                    
                    <div class="text_block_cir">
                        <p>{!!substr($discipline->description,0,100)."..."!!}</p>
                    </div>
                    <div class="text_block_cir">
                        <h5>{{ strlen(@$discipline->topics->topic_name) > 25 ? substr($discipline->topics->topic_name,0,20)."..." : $discipline->topics->topic_name }}</h5>
                    </div>
                </a>
                <div class="collarble_cmb pstn_apslt curiclm_listng">
                        <div class="collarble_cmb mrgn-bt-15">
                                <ul class="exersize_set exersz-crclm float-left">
                                    <li>
                                        <a href="{{route('explore.curriculum.exerciseset',['discipline' => $discipline->id,'topic' => $discipline->topics->id])}}">
                                            @auth
                                              @lang('exercisesets.exercise_set') : {{@$discipline->exercisesets()->where([['publish_status', 'like', 'public']])->where('createdby', '!=', \Auth::user()->id)->where('discipline_id','=',$discipline->id)->where('topic_id','=',$discipline->topics->id)->count()}}
                                            @endauth
                                            @guest
                                              @lang('exercisesets.exercise_set') : {{@$discipline->exercisesets()->where([['publish_status', 'like', 'public']])->where('discipline_id','=',$discipline->id)->where('topic_id','=',$discipline->topics->id)->count()}}
                                            @endguest
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{route('explore.curriculum.classes',['discipline' => $discipline->id])}}">
                                            {{-- @lang('explore.classes') : {{ @$discipline->classes($discipline->id,$discipline->language_preference_id) }} --}}
                                            @lang('explore.classes') : {{ @$discipline->courseclasses()->count() }}
                                        </a>
                                    </li>
                                </ul>
                            </div>
                    {{-- <div class="request_add float-right">
                        <button type="button" onclick="return requestDiscipline({{$discipline->id}});" data-toggle="modal" data-target="#okay_mdl" data-dismiss="modal" class="collbr_btn icon_clrbl m3">@lang('disciplines.collabrate')</button>
                    </div> --}}
                </div>
            </div>
        </div>
    @endforeach
@endif