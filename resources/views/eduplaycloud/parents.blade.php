@extends('guest.layouts.default')
@section('content')
<section class="strmng_edctn" id="strmng_edctn">
    <div class="container">
        <div class="row">
            <div class="col-md-7">
                <img class="d-block w-100" src="{{ asset('assets/eduplaycloud/image/parents_img.png') }}" alt="">
            </div>
            <div class="col-md-5">
                <div class="eductn_strming text-ar-right">
                    <h4>@lang('for_parents.for_every_parent')</h4>
                    <h3>@lang('for_parents.out_there')</h3>
                    <p class="nrml_p">@lang('for_parents.create_an_account')</p>
                    @guest
                    <a class="getstrd_btn" href="javascript:;" data-toggle="modal" data-target="#sign_up">@lang('for_parents.sign_up')</a>
                    @endguest
                </div>
            </div>
        </div>
    </div>
</section>
<section class="practice_exercises bg_white">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10 text-ar-right">
                <h3 class="blue_title">@lang('for_parents.benefits_as_teacher')</h3>
                <p class="def_p">@lang('for_parents.benefits_as_teacher_content')</p>
                <ul class="fnt_fml">
                    @lang('for_parents.benefits_as_teacher_li')
                </ul>
                <p class="def_p">@lang('for_parents.follow_your_children')</p>
                <div class="row bnfts_prnt">
                    <div class="col-sm-6">
                        <img src="{{ asset('assets/eduplaycloud/image/graph_1.png') }}" alt="" class="img-fluid">
                    </div>
                    <div class="col-sm-6">
                        <img src="{{ asset('assets/eduplaycloud/image/graph_2.png') }}" alt="" class="img-fluid">
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@include('subscription.pricing');

<section class="for_did_you_know report_children">
    <div class="container">
        <div class="row justify-content-end">
            <div class="col-md-11">
                <div class="row">
                    <div class="col-md-6 text-ar-right">
                        <h3 class="black_title">@lang('for_parents.get_reports_of_children')</h3>
                        @lang('for_parents.get_reports_of_children_content')
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection