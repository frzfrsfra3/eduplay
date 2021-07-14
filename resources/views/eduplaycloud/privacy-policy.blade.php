@extends('guest.layouts.default')
@section('content')
<div class="main_content">
    <div class="container">
        <div class="sub_page_cntnt">
            <div class="row justify-content-center">
                <div class="col-lg-10">
                    <div class="inner_add_child text-ar-right">
                        <h6>@lang('privacy_policy_lang.privacy_policy')</h6><br />
                        @lang('privacy_policy_lang.privacy_policy_content')
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endSection