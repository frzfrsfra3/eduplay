@extends('guest.layouts.default')
@section('content')
<div class="main_content">
    <div class="container">
        <div class="add_child_cls">
            <div class="row justify-content-center">
                <div class="col-lg-11">
                    <div class="inner_add_child text-ar-right">
                        <div class="row">
                            <div class="col-xl-7 col-lg-6">
                                <h6>@lang('contact_us.contact_us')</h6>
                                <form class="def_form full_def_frm" id="contactUs" method="POST">
                                    @csrf
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group mrgn-bt-30">
                                                <label for="full_name">@lang('contact_us.frm_full_name')</label>
                                                <input type="text" id="full_name" name="full_name" class="form-control" >
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group mrgn-bt-30">
                                                <label for="subject">@lang('contact_us.frm_subject')</label>
                                                <input type="text" id="subject" name="subject" class="form-control" >
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group mrgn-bt-30">
                                                <label for="message">@lang('contact_us.frm_your_message')</label>
                                                <textarea name="message" id="message" class="form-control" ></textarea>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group mrgn-bt-70 mrgn-tp-30">
                                                <button type="submit" class="btn btn-primary add_btn">@lang('contact_us.frm_send')</button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="col-lg-1"></div>
                            <div class="col-xl-4 col-lg-5">
                                <h6>@lang('contact_us.reach_to_us')</h6>
                                <ul class="cntct_list">
                                    <li class="addrs_i">
                                        @lang('contact_us.address')
                                    </li>
                                    <li class="pnh_i"><a href="javascript:;">+961 81 864 912</a></li>
                                    <li class="eml_i"><a href="javascript:;">info@eduplaycloud.com</a></li>
                                </ul>
                                <ul class="c_share_links">
                                    <li><a href="https://www.facebook.com/eduplaycloud" class="fcbk_ii"></a></li>
                                    <li><a href="https://twitter.com/EduPlayCloud" class="twtr_ii"></a></li>
                                    <li><a href="javascript:;" class="lnkn_ii"></a></li>
                                    <li><a href="https://www.youtube.com/channel/UC2rss8MWdalazlE9p-M8-fA" class="ytb_ii"></a></li> 
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endSection