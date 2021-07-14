@extends('guest.layouts.default')
@section('content')
<section class="strmng_edctn" id="strmng_edctn">
    <div class="container">
        <div class="row">
            <div class="col-md-7">
                <img class="d-block w-100" src="{{ asset('assets/eduplaycloud/image/w_w_d_img.png') }}" alt="">
            </div>
            <div class="col-md-5">
                <div class="eductn_strming text-ar-right">
                    <h4>@lang('what_we_do.what_we_do')</h4>
                    <h3>@lang('what_we_do.know_about_us')</h3>
                    @lang('what_we_do.know_about_us_content')
                </div>
            </div>
        </div>
    </div>
</section>
<section class="practice_exercises">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10 text-ar-right">
                <h3 class="blue_title">@lang('what_we_do.about_our_work')</h3>
                @lang('what_we_do.about_our_work_content')
                <div class="row bnfts_prnt ">
                    @lang('what_we_do.about_our_work_full_content')
                </div>
            </div>
        </div>
    </div>
</section>
<section class="for_did_you_know text-ar-right clnts_sy w_o_c_say">
    <div class="container">
        <div class="row justify-content-end">
            <div class="col-md-11">
                <div class="row">
                    <div class="col-md-6">
                        <div class="did_n_content">
                            <h3 class="black_title">@lang('what_we_do.what_our_clients_say')</h3>
                            @lang('what_we_do.what_our_clients_say_content')
                            <a href="javascript:;">@lang('what_we_do.albert')</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endSection