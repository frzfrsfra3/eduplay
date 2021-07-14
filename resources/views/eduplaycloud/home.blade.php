@extends('guest.layouts.default')
@section('content')
<section class="strmng_edctn" id="strmng_edctn">
    <div class="container">
        <div class="row">
            <div class="col-md-7">
                <div id="carouselExampleControls" class="carousel slide stream_slider" data-ride="carousel">
                    <div class="carousel-inner">
                        <div class="carousel-item active">
                            <img class="d-block w-100" src="{{ asset('assets/eduplaycloud/image/3.png') }}" alt="">
                        </div>
                        <div class="carousel-item">
                            <img class="d-block w-100" src="{{ asset('assets/eduplaycloud/image/3.png') }}" alt="">
                        </div>
                        <div class="carousel-item">
                            <img class="d-block w-100" src="{{ asset('assets/eduplaycloud/image/3.png') }}" alt="">
                        </div>
                    </div>
                    <a class="carousel-control-prev" href="#carouselExampleControls" role="button" data-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="sr-only">@lang('landing.previous')</span>
                    </a>
                    <a class="carousel-control-next" href="#carouselExampleControls" role="button" data-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="sr-only">@lang('landing.next')</span>
                    </a>
                    <div class="spn_lin">
                        <span class="next_line">@lang('landing.next')</span>
                    </div>
                </div>
            </div>
            <div class="col-md-5">
                <div class="eductn_strming text-ar-right">
                    <h4>@lang('landing.learn')</h4>
                    <h3>@lang('landing.create')</h3>
                    <p>@lang('landing.explore')</p>
                    <a href="javascript:;" data-toggle="modal" data-target="#sign_up" data-dismiss="modal" class="getstrd_btn">@lang('landing.get_started')</a>
                </div>
            </div>
        </div>
    </div>
</section>
<section class="our_position" id="our_position">
    <div class="container">
        <div class="row">
            <div class="col-md-7 wht_clr">
                <div class="value_postn text-ar-right">
                    <h3>@lang('landing.our_value_proposition')</h3>
                    <div class="for_teacher">
                        <div class="bg_techer">
                            <h4>@lang('landing.for_teacher')</h4>
                            @lang('landing.for_teacher_content')
                        </div>
                        <a href="{{route('teachers')}}" class="learn_more">@lang('landing.learn_more')</a>
                    </div>
                </div>
            </div>
            <div class="col-md-5">
                <div class="right_man">
                    <img class="img-fluid" src="{{ asset('assets/eduplaycloud/image/man.jpg') }}">
                    <div class="bottom_arw">
                        <a class="cm_pre p" href="#strmng_edctn"><span class="cm_icon_pre"></span></a>
                        <a class="next_btm p" href="#for_student"><span class="icon_btm"></span></a>
                        <h3>@lang('landing.next')</h3>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<section class="for_student" id="for_student">
    <div class="container reltv_cls">
        <div class="row">
            <div class="col-md-7">
                <div class="orng_img">
                    <img src="{{ asset('assets/eduplaycloud/image/4_n.png') }}" class="img-fluid">
                </div>
            </div>
            <div class="col-md-5">
                <div class="for_inner_studnt text-ar-right">
                    <div class="bg_techer">
                        <h4>@lang('landing.for_students')</h4>
                        @lang('landing.for_students_content')
                    </div>
                    <a href="{{route('students')}}" class="learn_more">@lang('landing.learn_more')</a>
                </div>
            </div>
            </div>
        <div class="orng_bottom_arw">
            <a class="orng_pre_btm p" href="#our_position"><span class="orng_preicn_btm"></span></a>
            <a class="orng_next_btm p" href="#for_perents"><span class="orng_icon_btm"></span></a>
            <h3>@lang('landing.next')</h3>
        </div>
        </div>
</section>
<section class="for_perents" id="for_perents">
    <div class="container">
        <div class="row justify-content-end">
            <div class="col-md-11">
                <div class="row">
                    <div class="col-md-6">
                        <div class="prent_bg text-ar-right">
                            <div class="bg_techer">
                                <h4>@lang('landing.for_parents')</h4>
                                @lang('landing.for_parents_content')
                            </div>
                            <a href="{{route('parents')}}" class="learn_more">@lang('landing.learn_more')</a>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="pernt_img">
                            <img src="{{ asset('assets/eduplaycloud/image/grp.png')}}" class="img-fluid">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="abso_cmbo_btn">
        <a class="cm_pre p" href="#for_student"><span class="cm_icon_pre"></span></a>
        <a class="cm_next p" href="#for_work"><span class="cm_icon_next"></span></a>
        <h3>@lang('landing.next')</h3>
    </div>
</section>
<section class="for_work text-ar-right" id="for_work">
    <div class="container">
        <div class="row">
            <div class="col-lg-6">
                <div class="row justify-content-center">
                    <div class="col-lg-8 lft_wt">
                        <h2>@lang('landing.how_eduplaycloud_works')</h2>
                        @lang('landing.how_eduplaycloud_works_content')
                    </div>
                </div>
            </div>
            <div class="col-lg-6 rtg_wt">
                <div class="row justify-content-center">
                    <div class="col-lg-10">
                        <ul class="flow_list">
                            <li>
                                <h4><i class="jn_lgn_i"></i>@lang('landing.join') <span class="n_counts">01</span></h4>
                                @lang('landing.create_an_account')
                            </li>
                            <li>
                                <h4><i class="explr_i"></i>@lang('landing.explore_disciplines') <span class="n_counts">02</span></h4>
                                @lang('landing.discover_available')
                            </li>
                            <li>
                                <h4><i class="strt_crtng_i"></i>@lang('landing.create_your_own_content')<span class="n_counts">03</span></h4>
                                @lang('landing.create_personalized')
                            </li>
                            <li>
                                <h4><i class="invt_ern_i"></i>@lang('landing.deliver_your_content')<span class="n_counts">04</span></h4>
                                @lang('landing.deliver_your_content_in')
                            </li>
                            <li>
                                <h4><i class="invt_ern_i"></i>@lang('landing.analyze_monitor')<span class="n_counts">05</span></h4>
                                @lang('landing.analyze_the_strength')
                            </li>
                            <li>
                                <h4><i class="invt_trnrs_i"></i>@lang('landing.invite_share')<span class="n_counts">06</span></h4>
                                @lang('landing.encourage_friends')
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="abso_cmbo_btn">
            <a class="cm_pre p" href="#for_perents"><span class="cm_icon_pre"></span></a>
            <a class="cm_next p" href="#For_Need"><span class="cm_icon_next"></span></a>
            <h3>@lang("landing.next")</h3>
        </div>
    </div>
</section>
<section class="for_need text-ar-right" id="For_Need">
    <div class="container">
        <div class="row justify-content-end">
            <div class="col-md-11">
                <div class="row">
                    <div class="col-xl-3">
                        <h2>@lang('landing.why_you_need_eduplaycloud')</h2>
                    </div>
                    <div class="col-xl-7 p_need">
                        @lang('landing.learning_through')
                    </div>
                    <div class="col-xl-3 col-md-6 nd_content">
                        <h6>@lang('landing.mastery_progress')</h6>
                        @lang('landing.eduplaycloud_allows_monitoring')
                    </div>
                    <div class="col-xl-3 col-md-6 nd_content">
                        <h6>@lang('landing.avoid_rework')</h6>
                        @lang('landing.create_your_exercise')
                    </div>
                    <div class="col-xl-3 col-md-6 nd_content">
                        <h6>@lang('landing.useful_gaming')</h6>
                        @lang('landing.parent_can_stop')
                    </div>

                    <div class="col-xl-3 col-md-6 nd_content">
                        <h6>@lang('landing.choose_your_own_curriculum')</h6>
                        @lang('landing.eduplaycloud_empowers_teachers')
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="abso_cmbo_btn">
        <a class="cm_pre p" href="#for_work"><span class="cm_icon_pre"></span></a>
        <a class="cm_next p" href="#For_Did_You_Know"><span class="cm_icon_next"></span></a>
        <h3>@lang("landing.next")</h3>
    </div>
</section>
<section class="for_did_you_know text-ar-right" id="For_Did_You_Know">
    <div class="container">
        <div class="row justify-content-end">
            <div class="col-md-11">
                <div class="row">
                    <div class="col-md-12">
                        <div class="did_n_content">
                            <h2>@lang('landing.did_you_know')</h2>
                            @lang('landing.education_is_not_learning')
                            <a href="javascript:;">@lang('landing.albert')</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="abso_cmbo_btn">
        <a class="cm_next p" href="#For_Need"><span class="cm_icon_next"></span></a>
        <h3>@lang("landing.next")</h3>
    </div>
</section>
@endsection

@if('password/reset' == Request::segment(1).'/'.Request::segment(2))
<!--reset-password-modal-->
<div class="modal fade default_modal frm_change_password_modal" id="reset_pswrd" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content img_fr_frgtpswd">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12 col-lg-6 col-csm-45">
                        <div class="left_contnt text-ar-right">
                            <div class="logn_left">
                                <p>@lang('landing.helping_every_student')</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12 col-lg-6 col-csm-55">
                        <div class="right_contnt sign_up_info logn_info text-ar-right">
                            <h3>@lang('landing.reset_password')</h3>
                            <p class="enter_youremil">@lang('landing.enter_new_confirm')</p>
                            <form name="frmResetPassword" id="frmResetPassword" class="def_form" method="post" action="{{ URL('password/update') }}" aria-label="{{ __('Reset Password') }}">
                                @csrf
                                <div class="form-group">
                                    @php
                                        if (isset($_GET['email']) && !empty($_GET['email'])) {
                                            $email = $_GET['email'];
                                        } else {
                                            $email = '';
                                        }
                                    @endphp
                                    @if(isset($token))
                                        <input type="hidden" name="token" value="{{ $token }}">
                                    @endif
                                    <input id="resetEmail" type="hidden" name="email" value="{{ $email }}">
                                </div>
                                <div class="form-group">
                                    <input id="resetPassword" type="password" class="form-control" name="password" maxlength="16" placeholder="New Password">
                                    <span class="error-message password-error-message"></span>
                                </div>
                                <div class="form-group">
                                    <input id="password_confirmation" type="password" class="form-control" name="password_confirmation" placeholder="Confirm New Password" maxlength="16">
                                    <span class="error-message confirmation-error-message"></span>
                                </div>
                                <div class="form-group mrgn_reset">
                                    <button type="submit" class="btn btn-primary btn-login">@lang('landing.reset')</button>
                                </div>
                            </form>
                            <div class="reset_cectd or_cnected">
                                <div class="mrgn_less dont_have">
                                    <p>@lang('landing.already_have_an_account') <a href="javascript:;" data-toggle="modal" data-target="#login_btn" data-dismiss="modal">@lang('landing.login')</a></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endif

<?php /*Load jquery to footer section*/ ?>
@push('inc_script')
<script type="text/javascript" src="{{ asset('assets/eduplaycloud/customs/js/jquery-validate/jquery.validate.min.js') }}"></script>
@endpush

<?php /*Load jquery to footer section*/ ?>
@push('inc_jquery')
<script src= 'https://statics.teams.cdn.office.net/sdk/v1.6.0/js/MicrosoftTeams.min.js'></script>
<script type="text/javascript">
    microsoftTeams.initialize();

    $(document).ready(function() {
        var segment1 = '{{ Request::segment(1) }}';
	    var segment2 = '{{ Request::segment(2) }}';
        if('password/reset' == segment1+'/'+segment2){
            $('.frm_change_password_modal').modal('show');
        }

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $("#frmResetPassword").validate({
            rules: {
                email: {
                    required: true,
                    email: true
                },
                password: {
                    required: true,
                    minlength: 6
                },
                password_confirmation: {
                    required: true,
                    minlength: 6,
                    equalTo: "#frmResetPassword #resetPassword"
                }
            },
            messages: {
                email: "@lang('landing.this_field_is_required')",
                password: {
                    // required: 'This field is required.'
                },
                password_confirmation: {
                    // required: 'This field is required.',
                    equalTo: '@lang("landing.new_password_do_not")'
                }
            },
            submitHandler: function(form) {
                var $this = $(this);

                $.ajax({
                    type: $this.attr('method'),
                    url: $this.attr('action'),
                    data: $this.serializeArray(),
                    dataType: $this.data('type'),
                    beforeSend: function() {
                        $('.frm_change_password_modal').block({ css: { border: 'none', backgroundColor: 'none' }, message: '<img src="'+site_url+'/assets/eduplaycloud/image/loader.gif" alt="Loading" width="100" />' });
                    },
                    success: function (response) {
                        $('.frm_change_password_modal').unblock();

                        swal("@lang('landing.password_has_been_updated')", {
                            closeOnClickOutside: false,
                            icon: ("success"),
                        }).then(function() {
                            // location.reload();
                        });
                    },
                    error: function (jqXHR) {
                        $('.frm_change_password_modal').unblock();

                        var response = $.parseJSON(jqXHR.responseText);
                    }
                });
            }
        });
    });

    $(document).on('click', '.close', function () {
        window.location.href = site_url;
    });
</script>
@endpush