@if(count($disciplines))
    @foreach ($disciplines as $discipline)
    <div class="col-md-6 col-lg-4 col-xl-3 cusmize-col">
        <div class="inr_cir_exrs">
            <a href="#" class="circullm_box circullm_box_btm">
                <div class="combo_check_txt">
                    <div class="creat_exr orng_checkbx float-left">
                        <div class="radio_bx rdio rdio-primary">
                            <input name="discipline_name" value="{{ $discipline->id }}" id="discipline_name_{{$discipline->id}}" type="radio" class="custom-control-input radio" {{ (!empty($exerciseset) ? ($exerciseset->discipline_id === $discipline->id ? "checked" : "")  : "")  }}>
                            <label class="custom-control-label discipline-name" for="discipline_name_{{$discipline->id}}" data-discipline="{{ $discipline->id }}">{{$discipline->discipline_name}}</label>
                        </div>
                    </div>
                </div>
                <div class="text_block_cir">
                    <p>{{ str_limit($discipline->description,'75') }}</p>
                </div>
            </a>
        </div>
    </div>
    @endforeach
@else 
<div class="col-md-12">
    <p>@lang('select_curriculum.no_curriculum')</p>
</div>
@endif