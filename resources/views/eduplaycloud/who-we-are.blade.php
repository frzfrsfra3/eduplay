@extends('guest.layouts.default')
@section('content')
<section class="strmng_edctn" id="strmng_edctn">
    <div class="container">
        <div class="row">
            <div class="col-md-7">
                <img class="d-block w-100" src="{{ asset('assets/eduplaycloud/image/w_w_r_img.png') }}" alt="">
            </div>
            <div class="col-md-5">
                <div class="eductn_strming text-ar-right">
                    <h4>@lang('who_we_are.who_we_are')</h4>
                    <h3>@lang('who_we_are.know_about_us')</h3>
                    @lang('who_we_are.play_learn_teach')
                </div>
            </div>
        </div>
    </div>
</section>
<section class="practice_exercises">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10 text-ar-right">
                <h3 class="blue_title">@lang('who_we_are.from_the_past')</h3>
                @lang('who_we_are.from_the_past_content')
            </div>
        </div>
    </div>
</section>
<section class="why_chs_us">
    <div class="container">
        <div class="row justify-content-end">
            <div class="col-md-8 why_chs_cntnt text-ar-right">
                <h3>@lang('who_we_are.why_choose_us')</h3>
                @lang('who_we_are.why_choose_us_content')
            </div>
        </div>
    </div>
</section>
<section class="for_did_you_know text-ar-right clnts_sy w_w_are">
    <div class="container">
        <div class="row justify-content-end">
            <div class="col-md-11">
                <div class="row">
                    <div class="col-xl-6">
                        <div class="did_n_content">
                            <h3 class="black_title">@lang('who_we_are.our_mission_vision')</h3>
                            @lang('who_we_are.our_mission_vision_content')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection