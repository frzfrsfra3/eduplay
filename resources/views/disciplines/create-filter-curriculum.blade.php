@if(count($disciplines))
@foreach ($disciplines as $discipline)
<div class="col-md-6 col-lg-4 col-xl-3 cusmize-col">
    <div class="inr_cir_exrs">
        <div class="circullm_box circullm_box_btm">
            <div class="combo_check_txt">
                <div class="creat_exr orng_checkbx float-left">
                    <div class="radio_bx rdio rdio-primary">
                        <input name="discipline_name" value="{{ $discipline->id }}" id="discipline_name_{{$discipline->id}}" type="radio" class="custom-control-input radio" {{ (!empty($exerciseset) ? ($exerciseset->discipline_id === $discipline->id ? "checked" : "")  : "")  }}>
                        <label class="custom-control-label discipline-name" for="discipline_name_{{$discipline->id}}" data-discipline="{{ $discipline->id }}">{{$discipline->discipline_name}}</label>
                    </div>
                </div>
            </div>
            <div class="text_block_cir">
                    <p>{!!substr($discipline->description,0,100)."..."!!}</p>
            </div>
            <div class="text_block_cir">
                <h5>{{$discipline->topics->topic_name}}</h5>
            </div>
            <div class="collarble_cmb mrgn-bt-15">
                <ul class="exersize_set float-left">
                    <li>@lang('select_curriculum.exercise_set') : {{count($discipline->exercisesets)}}</li>
                    <li>@lang('select_curriculum.classes') : {{count($discipline->courseclasses)}}</li>
                </ul>
            </div>
            <div class="collarble_cmb pstn_apslt">
                <div class="request_add float-right">
                    <button type="button" class="collbr_btn">{{ optional($discipline->languagePreference)->language }}</button>
                </div>
            </div>
        </div>
    </div>
</div>
@endforeach
@else 
<div class="col-md-6 col-lg-4 col-xl-3 cusmize-col">
<div class="inr_cir_exrs">
    <p>@lang('select_curriculum.no_curriculum')</p>
</div>
</div>    
@endif