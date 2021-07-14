@php
if(Session::has('local')):
    $lang = session('local');
else:
    $lang = 'en';
endif;
@endphp
<!DOCTYPE html>
<html lang="en" @php if($lang == 'ar'): echo 'dir="rtl"'; endif; @endphp>
    <head>
        <meta charset="utf-8">

        <title>
            {{ config('app.name', 'Laravel') }} @section('title')
            @show
        </title>

        <!-- Google / Search Engine Tags -->
        <meta itemprop="name" content=" Eduplaycloud ">
        <meta itemprop="description" content="Simplifying learning through a more learner-centered, fun based, gaming approach. Experience a world-class training program, across multiple domains with EduPlayCloud.">
        <meta itemprop="image" content="https://eduplaycloud.com/assets/eduplaycloud/image/3.png">

        <!-- Facebook Meta Tags -->
        <meta property="og:url" content="https://eduplaycloud.com">
        <meta property="og:type" content="website">
        <meta property="og:title" content=" Eduplaycloud ">
        <meta property="og:description" content="Simplifying learning through a more learner-centered, fun based, gaming approach. Experience a world-class training program, across multiple domains with EduPlayCloud.">
        <meta property="og:image" content="https://eduplaycloud.com/assets/eduplaycloud/image/3.png">

        @include('guest.includes.headerInc')
        <!--page level css-->
        @yield('header_styles')
        <!--end of page level css-->
    </head>
    <body id="page-top">
        @include('guest.includes.header')
        @yield('content')
        @include('guest.includes.footer')

        <!--login-modal-->
        <div class="modal fade default_modal frm_login_modal" id="login_btn" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static" data-keyboard="false">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content img_fr_lgn">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12 col-lg-6 col-csm-45">
                                <div class="left_contnt text-ar-right">
                                    <h4>@lang('landing.frm_good_to_see_you')</h4>
                                    <p>@lang('landing.frm_by_logging') <a href="{{ URL('terms') }}" target="_blank">@lang('landing.frm_terms_of_use')</a> @lang('landing.frm_and') <a href="{{ route('privacy-policy') }}" target="_blank">@lang('messages.privacypolicy')</a></p>
                                </div>
                            </div>
                            <div class="col-md-12 col-lg-6 col-csm-55">
                                <div class="right_contnt logn_info text-ar-right">
                                    <h3>@lang('landing.frm_login')</h3>
                                    <form class="login def_form" action="{{ url('/login') }}" method="post" data-type="json" id="loginform">
                                        @csrf
                                        <div class="form-group">
                                            <input type="text" name="email" class="form-control" value="" placeholder="@lang('landing.frm_email_address')">
                                        </div>
                                        <div class="form-group mrgn_bt mrgn-bt-40">
                                            <input type="password" name="password" class="form-control" value="" placeholder="@lang('landing.frm_password')">
                                            <div class="text-right">
                                            <a href="javascript:;" data-toggle="modal" data-target="#frgt_btn" data-dismiss="modal" class="forgt_pswd">@lang('landing.frm_forgot_password')</a>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <button type="submit" class="btn btn-primary btn-login">@lang('landing.frm_login')</button>
                                        </div>
                                    </form>
                                    <div class="or_cnected">
                                        <p>@lang('landing.frm_or_connect_with')</p>
                                        <div class="fbc_gogl_combo">
                                            <button type="button" class="live_btn facebok_btn" onclick="facebookclose('{!! url('auth/facebook') !!}')">@lang('landing.frm_facebook')</button>
                                            <button type="button" class="live_btn google_btn" onclick="facebookclose('{!! url('auth/google') !!}')">@lang('landing.frm_google')</button>
                                        </div>
                                        <div class="dont_have">
                                            <p>@lang('landing.dont_have_account') <a href="javascript:;" class="click_me" data-toggle="modal" data-target="#sign_up" data-dismiss="modal">@lang('messages.Signup')</a></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!--date-of-birth-modal-->
        <div class="modal fade default_modal frm_step1_modal" id="sign_up" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static" data-keyboard="false">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content img_fr_sinup">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12 col-lg-6 col-csm-45">
                                <div class="left_contnt">
                                    <div class="logn_left text-ar-right">
                                    <p>@lang('landing.helping_every_student')</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12 col-lg-6 col-csm-55">
                                <div class="right_contnt logn_info text-ar-right">
                                    <h3>@lang('landing.sign_up')</h3>
                                    <div class="item_cmo">
                                        <h6>@lang('landing.welcome_to_eduplaycloud')</h6>
                                        <p>@lang('landing.i_am_your_assistance')</p>
                                    </div>
                                    <form name="frmSignUpDate" id="frmSignUpDate" class="def_form" method="post" action="#">
                                        <div class="form-group date_btm_mrgn">
                                            {{-- <input type="text" name="dateOfBirth" class="form-control dateOfBirth" placeholder="@lang('landing.date_of_birth')" id="startDate" onkeydown="return false;" readonly onfocus="this.removeAttribute('readonly');" autocomplete="off"> --}}
                                            <input type="date" name="dateOfBirth" class="form-control dateOfBirth" placeholder="@lang('landing.date_of_birth')" id="startDateDob" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <button type="submit" class="btn btn-primary btn-login">@lang('landing.proceed')</button>
                                        </div>
                                    </form>
                                    <div class="dont_have">
                                        <p>@lang('landing.already_have_an_account') <a href="javascript:;" data-toggle="modal" data-target="#login_btn" data-dismiss="modal">@lang('landing.login')</a></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!--topic-modal-->
        <div class="modal fade default_modal select-yr-topc frm_step2_modal" id="procced_btn" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static" data-keyboard="false">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content img_fr_sinup">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12 col-lg-6 col-csm-45">
                                <div class="left_contnt">
                                    <div class="logn_left text-ar-right">
                                        <p>@lang('landing.helping_every_student')</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12 col-lg-6 col-csm-55">
                                <div class="right_contnt logn_info text-ar-right">
                                    <h3>@lang('landing.select_your_topics')</h3>
                                    <form name="frmTopic" id="frmTopic" class="def_form" method="post" action="#">
                                        <div class="form-group">
                                            <ul class="prsn-action">
                                                @if(isset($topics))
                                                @foreach($topics as $topic)
                                                    <li>
                                                        <div class="custom-control custom-checkbox">
                                                            <input type="checkbox" name="bit_topics[]" id="bit_topics[{{ $topic->id }}]" class="custom-control-input yourTopics" value="{{ $topic->id }}"/>
                                                            @if (strlen($topic->iconurl)==0)
                                                                <img src={{ asset('assets/images/topic_default-test.png') }} alt="{{ $topic->topic_name }}" class="img_checkbox img-fluid">
                                                            @else
                                                                @php
                                                                    $file = public_path("assets/images/").$topic->iconurl;
                                                                    $fileExists = file_exists($file);
                                                                @endphp

                                                                @if (isset($fileExists) && !empty($fileExists))
                                                                    <img src={{ asset('assets/images/'.$topic->iconurl) }} alt="{{ $topic->topic_name }}" class="img_checkbox img-fluid">
                                                                @else
                                                                    <img src={{ asset('assets/images/topic_default-test.png') }} alt="{{ $topic->topic_name }}" class="img_checkbox img-fluid">
                                                                @endif
                                                            @endif
                                                            <label class="custom-control-label">{{ $topic->topic_name }}</label>
                                                        </div>
                                                    </li>
                                                @endforeach
                                                @endif
                                            </ul>
                                            <span class="error-message error-topic"></span>
                                        </div>
                                        <div class="form-group mrgnt back_top_mrgn">
                                            <button type="button" class="btn btn-primary btn-login" id="bake_btn">@lang('landing.topic_back')</button>
                                            <button type="submit" class="btn btn-primary btn-login">@lang('landing.topic_next')</button>
                                        </div>
                                    </form>
                                    <div class="dont_have">
                                        <p>@lang('landing.already_have_an_account') <a href="javascript:;" data-toggle="modal" data-target="#login_btn" data-dismiss="modal">@lang('landing.login')</a></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!--sign-up-modal-->
        <div class="modal fade default_modal frm_step3_modal" id="next-techer" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static" data-keyboard="false">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="signup_content modal-content img_fr_sinup">
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
                                    <h3>@lang('landing.frm_sign_up')</h3>
                                    <form name="frmSignUp" id="frmSignUp" class="def_form" method="post" action="#">
                                        <div class="form-group">
                                            <ul class="teacher-action">
                                                <li>
                                                    <div class="custom-control custom-checkbox">
                                                        <input name="role[]" value="1" id="learner" type="checkbox" class="custom-control-input">
                                                        <label class="custom-control-label" for="learner">@lang('messages.learners')</label>
                                                    </div>
                                                </li>
                                                <li class="teacherLi">
                                                    <div class="custom-control custom-checkbox">
                                                        <input name="role[]" value="2" id="teacher" type="checkbox" class="custom-control-input">
                                                        <label class="custom-control-label" for="teacher">@lang('messages.teachers')</label>
                                                    </div>
                                                </li>
                                                <li class="parentLi">
                                                    <div class="custom-control custom-checkbox">
                                                        <input name="role[]" value="3" id="parent" type="checkbox" class="custom-control-input">
                                                        <label class="custom-control-label" for="parent">@lang('messages.parents')</label>
                                                    </div>
                                                </li>
                                            </ul>
                                            <span class="error-message error-role"></span>
                                        </div>
                                        <div class="form-group">
                                            <input type="text" name="name" id="name" class="form-control name" placeholder="@lang('landing.frm_full_name')">
                                        </div>
                                        <div class="form-group">
                                            <input type="text" name="email" id="email" class="form-control" placeholder="@lang('landing.frm_email_address')">
                                        </div>
                                        <div class="form-group">
                                            <input type="password" name="password" id="password" class="form-control password" placeholder="@lang('landing.frm_password')">
                                        </div>
                                        <div class="form-group mrgn_less mrgn-bt-40">
                                            <input type="password" name="passwordConfirmation" id="passwordConfirmation" class="form-control passwordConfirmation" placeholder="@lang('landing.frm_confirm_password')">
                                        </div>
                                        <div class="form-group">
                                            <button type="submit" class="btn btn-primary btn-login">@lang('landing.frm_sign_up')</button>
                                        </div>
                                    </form>
                                    <div class="mrgn_less or_cnected">
                                        <p>@lang('landing.frm_or_connect_with')</p>
                                        <div class="fbc_gogl_combo">
                                            <button type="button" class="live_btn facebok_btn" onclick="facebookclose('{!! url('auth/facebook') !!}')">@lang('landing.frm_facebook')</button>
                                            <button type="button" class="live_btn google_btn" onclick="facebookclose('{!! url('auth/google') !!}')">@lang('landing.frm_google')</button>
                                        </div>
                                    </div>
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

        <!--forgot-password-modal-->
        <div class="modal fade default_modal frm_forgot_password_modal" id="frgt_btn" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static" data-keyboard="false">
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
                                    <h3>@lang('landing.frm_rest_forgot_password')</h3>
                                    <p class="enter_youremil">@lang('landing.frm_rest_enter_your_email')</p>
                                    <form name="frmForgotPassword" id="frmForgotPassword" class="def_form" method="POST" action="{{ URL('password/reset/email') }}" aria-label="{{ __('Reset Password') }}">
                                        @csrf
                                        <div class="form-group">
                                            <input id="femail" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" placeholder="@lang('landing.frm_rest_email_email')" maxlength="100">
                                            <span class="error-message"></span>
                                            @if ($errors->has('message'))
                                                <span class="error-message">{{ $errors->message }}</span>
                                            @endif
                                        </div>
                                        <div class="form-group mrgn_frgt">
                                            <button type="submit" class="btn btn-primary btn-login">@lang('landing.frm_rest_email_send')</button>
                                        </div>
                                    </form>
                                    <div class="mrgn_less or_cnected">
                                        <div class="mrgn_less dont_have">
                                            <p>@lang('landing.already_have_an_account')? <a href="javascript:;" data-toggle="modal" data-target="#login_btn" data-dismiss="modal">@lang('landing.login')</a></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!--what-we-processed-modal-->
        <div class="modal fade default_modal" id="get_started" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static" data-keyboard="false">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="signup_content modal-content img_fr_lgn">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12 col-lg-6 col-csm-45">
                                <div class="left_contnt text-ar-right">
                                    <div class="logn_left">
                                        <p>Helping every student succeed with personalized practice</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12 col-lg-6 col-csm-55">
                                <div class="right_contnt getsrtd_info sign_up_info logn_info text-ar-right">
                                    <h3>Want To Proceed As</h3>
                                    <form class="def_form">
                                        <div class="form-group">
                                            <ul class="teacher-action">
                                                <li>
                                                    <div class="custom-control custom-checkbox">
                                                        <input name="techer_tpe" value="1" id="dd" type="checkbox" class="custom-control-input">
                                                        <label class="custom-control-label" for="Learner1">Learner</label>
                                                    </div>
                                                </li>
                                                <li>
                                                    <div class="custom-control custom-checkbox">
                                                        <input name="techer_tpe" value="1" id="Teacher2" type="checkbox" class="custom-control-input" checked>
                                                        <label class="custom-control-label" for="Teacher2">Teacher</label>
                                                    </div>
                                                </li>
                                                <li>
                                                    <div class="custom-control custom-checkbox">
                                                        <input name="techer_tpe" value="1" id="Parent3" type="checkbox" class="custom-control-input">
                                                        <label class="custom-control-label" for="Parent3">Parent</label>
                                                    </div>
                                                </li>
                                            </ul>
                                        </div>
                                        <div class="form-group">
                                            <button type="button" class="btn btn-primary btn-login">Proceed</button>
                                        </div>
                                    </form>
                                    <div class="mrgn_less or_cnected">
                                        <p>Or connect with</p>
                                        <div class="fbc_gogl_combo">
                                            <button type="button" class="live_btn facebok_btn" onclick="facebookclose('{!! url('auth/facebook') !!}')">Connect with Facebook</button>
                                            <button type="button" class="live_btn google_btn" onclick="facebookclose('{!! url('auth/google') !!}')">Connect with Google</button>
                                        </div>
                                        <div class="dont_have">
                                            <p>Don’t Have An Account? <a href="javascript:;" class="click_me" data-toggle="modal" data-target="#sign_up" data-dismiss="modal">SIgn Up</a></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade default_modal small_deflt_mdl frm_step0_modal" id="13_year_child" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static" data-keyboard="false">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12 col-lg-6 col-csm-45">
                                <div class="left_contnt text-ar-right">
                                    <div class="logn_left child_left">
                                        <h6>@lang('landing.if_child_is_younger')</h6>
                                        @lang('landing.if_child_is_younger_left_content')
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12 col-lg-6 col-csm-55">
                                <div class="right_contnt right_present logn_info text-ar-right">
                                    <div class="item_cmo">
                                        @lang('landing.if_child_is_younger_right_content')
                                    </div>
                                    <div class="presnt_grp">
                                        @lang('landing.plz_enter_parent_email')
                                    </div>
                                    <form name="frmParentEmail" id="frmParentEmail" class="def_form" method="POST" action="#">
                                        <div class="form-group">
                                            <input type="email" name="parentEmail" id="parentEmail" class="form-control" placeholder="@lang('landing.parent_email_address')">
                                        </div>
                                        <div class="form-group mrgn_mr_add">
                                            <button type="submit" class="btn btn-primary btn-login">@lang('landing.submit')</button>
                                        </div>
                                    </form>
                                    <div class="dont_have">
                                        <p>@lang('landing.already_have_an_account') <a href="javascript:;" data-toggle="modal" data-target="#login_btn" data-dismiss="modal">@lang('landing.login')</a></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @include('guest.includes.footerInc')
        <script type="text/javascript" src="{{ asset('assets/eduplaycloud/customs/js/jquery-validate/jquery.validate.min.js') }}"></script>

        <script>
            /* Validation */
            $("#contactUs").validate({
                rules: {
                    full_name: {
                        required: true,
                    },
                    subject: {
                        required: true,
                    },
                    message: {
                        required: true,
                    },
                },
                messages: {

                }
            });
        </script>

        <script>
            function facebookclose(url) {
                parent.location = url;
            }

            $(document).ready(function() {
                
                $.extend(jQuery.validator.messages, {
                    required: message['validator_required'],
                    remote: message['validator_remote'],
                    email: message['validator_email'],
                    url: message['validator_url'],
                    date: message['validator_date'],
                    number: message['validator_number'],
                    digits: message['validator_digits'],
                    equalTo: message['validator_equalTo'],
                    maxlength: jQuery.validator.format(message['validator_maxlength']),
                    minlength: jQuery.validator.format(message['validator_minlength']),
                    rangelength: jQuery.validator.format(message['validator_rangelength']),
                    range: jQuery.validator.format(message['validator_range']),
                    max: jQuery.validator.format(message['validator_max']),
                    min: jQuery.validator.format(message['validator_min'])
                });

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                

                $("#loginform").validate({
                    rules: {
                        email: {
                            required: true,
                        },
                        password: {
                            required: true
                        }
                    },
                    messages: {
                        email: message['required_email'],
                        password: message['required_password']
                    },
                    submitHandler: function(form) {
                        var $this = $("#loginform");

                        $.ajax({
                            type: $this.attr('method'),
                            url: $this.attr('action'),
                            headers: { 'X-CSRF-TOKEN': $('meta[name="csrfToken"]').attr('content') },
                            data: $this.serializeArray(),
                            dataType: $this.data('type'),
                            beforeSend: function() {
                                $('.frm_login_modal').block({ css: { border: 'none', backgroundColor: 'none' }, message: '<img src="'+site_url+'/assets/eduplaycloud/image/loader.gif" alt="Loading" width="100" />' });
                            },
                            success: function (response) {
                                console.log(response);
                                //console.log('response',response);
                                if (response.success) {
                                    if(response.role == 'Admin'){
                                        window.location.href = site_url+'/users';
                                    } else {
                                        //window.location.href = site_url+'/home';
                                        //window.location.href = site_url+'/exercisesets/private';
                                        var url = window.location.href;
                                        if (url.indexOf('mail') > -1) {
                                          location.reload();
                                        } else {
                                          window.location.href = site_url+'/pendingtasks/mypendingtasks';
                                        }
                                    }
                                } else {
                                    $('.frm_login_modal').unblock();
                                    if (response.messages) {
                                        swal(response.messages, {
                                            closeOnClickOutside: false,
                                            icon: ("info"),
                                        }).then(function() {
                                            // location.reload();
                                        });
                                    }
                                }
                            },
                            error: function (jqXHR) {
                                $('.frm_login_modal').unblock();
                                var response = $.parseJSON(jqXHR.responseText);
                                if (response.messages) {
                                    alert(response.messages);
                                }
                            }
                        });
                    }
                });

                $("#frmForgotPassword").validate({
                    rules: {
                        email: {
                            required: true,
                            email: true
                        }
                    },
                    messages: {
                        email: message['required_email']
                    },
                    submitHandler: function(form) {
                        var $this = $("#frmForgotPassword");

                        $('#frmForgotPassword .error').text('');

                        $.ajax({
                            type: $this.attr('method'),
                            url: $this.attr('action'),
                            data: $this.serializeArray(),
                            dataType: $this.data('type'),
                            beforeSend: function() {
                                $('.frm_forgot_password_modal').block({ css: { border: 'none', backgroundColor: 'none' }, message: '<img src="'+site_url+'/assets/eduplaycloud/image/loader.gif" alt="Loading" width="100" />' });
                            },
                            success: function (response) {

                                $('#frmForgotPassword #email').val();
                                $('.frm_forgot_password_modal').unblock();
                                $('.frm_forgot_password_modal').modal('hide');

                                swal(message['reset_password_successfully'], {
                                    closeOnClickOutside: false,
                                    icon: ("success"),
                                }).then(function() {
                                    location.reload();
                                });
                                
                            },
                            error: function (jqXHR) {
                                $('.frm_forgot_password_modal').unblock();
                                var response = $.parseJSON(jqXHR.responseText);

                                if (response.errors) {
                                    $('#frmForgotPassword .error').text(response.errors.email);
                                } else {
                                    $('#frmForgotPassword .error').text('');
                                }
                                $('#frmForgotPassword .error').show();
                            }
                        });
                    }
                });

                var userDob;

                $("#frmSignUpDate").validate({
                    rules: {
                        dateOfBirth: {
                            required: true
                        }
                    },
                    messages: {
                        dateOfBirth: message['required_dob']
                    },
                    submitHandler: function(form) {
                        var now = new Date();
                        var currentYear = now.getFullYear();
                        var userYear = $("#startDateDob").val();
                        var userYear = userYear.substring(userYear.lastIndexOf("/") + 1, userYear.length);

                        if (currentYear-userYear <= 13) {
                            $(".frm_step1_modal").modal("hide");
                            $(".frm_step0_modal").modal("show");
                            userDob=true;
                        } else {
                            $(".frm_step1_modal").modal("hide");
                            $(".frm_step2_modal").modal("show");
                            userDob=false;
                        }
                    }
                });

                $("#frmParentEmail").validate({
                    rules: {
                        parentEmail: {
                            required: true,
                            email: true,
                            /*remote: {
                                url: site_url + "/validate/unique/email",
                                type: "post",
                                headers: { 'X-CSRF-TOKEN': $('meta[name="csrfToken"]').attr('content') },
                                data: {
                                    value: function () {
                                        return $("#frmParentEmail #parentEmail").val();
                                    },
                                    'column': 'email'
                                }
                            }*/
                        }
                    },
                    messages: {
                        parentEmail: {
                            required: message['required_parent_email'],
                            remote: $.validator.format(message['email_taken'])
                        }
                    },
                    submitHandler: function(form) {
                        $(".frm_step0_modal").modal("hide");
                        $(".frm_step2_modal").modal("show");
                    }
                });

                $(document).on("click", "#bake_btn",function() {
                    $(".frm_step2_modal").modal("hide");
                    $(".frm_step1_modal").modal("show");
                });

                $("#frmTopic").validate({
                    rules: {
                        'bit_topics[]': {
                            required: true
                        },
                    },
                    messages: {

                    },
                    errorPlacement: function(error, element) {
                        if (element.attr("name") == "bit_topics[]") {
                            error.appendTo($('.error-topic'));
                        } else {
                            error.insertAfter(element);
                        }
                    },
                    submitHandler: function(form) {
                        $(".frm_step2_modal").modal("hide");
                        $(".frm_step3_modal").modal("show");
                        if(userDob == true){
                            $(".or_cnected ,.parentLi,.teacherLi").hide();
                        }
                    }
                });

                $("#frmSignUp").validate({
                    rules: {
                        'role[]': {
                            required: true
                        },
                        name: {
                            required: true
                        },
                        email: {
                            required: true,
                            remote: {
                                url: site_url + "/validate/unique/email",
                                type: "post",
                                headers: { 'X-CSRF-TOKEN': $('meta[name="csrfToken"]').attr('content') },
                                data: {
                                    value: function () {
                                        return $("#frmSignUp #email").val();
                                    },
                                    'column': 'email'
                                }
                            }
                        },
                        password: {
                            required: true,
                            minlength: 6,
                        },
                        passwordConfirmation: {
                            required: true,
                            minlength: 6,
                            equalTo: "#password"
                        }
                    },
                    messages: {
                        email: {
                            required: message['required_email'],
                            remote: $.validator.format(message['email_taken'])
                        },
                        passwordConfirmation: {
                            required: message['required_password_confirmation'],
                            equalTo: message['password_confirmation_equal_to']
                        }
                    },
                    errorPlacement: function(error, element) {
                        if (element.attr("name") == "role[]") {
                            error.appendTo($('.error-role'));
                        } else {
                            error.insertAfter(element);
                        }
                    },
                    submitHandler: function(form) {
                        var dateOfBirth = $('.dateOfBirth').val();
                        var parentEmail = $('#parentEmail').val();
                        var topics = $('.yourTopics:checkbox:checked').map(function() {
                            return this.value;
                        }).get();
                        var userDetails = $('#frmSignUp').serialize();

                        $.ajax({
                            type: 'post',
                            url: site_url + '/register/new/user',
                            dataType: "json",
                            data: {
                                dateOfBirth: dateOfBirth,
                                parentEmail: parentEmail,
                                topics: topics.join(","),
                                userDetails: userDetails,
                                _token: '{{ csrf_token() }}'
                            },
                            beforeSend: function() {
                                $('.frm_step3_modal').block({ css: { border: 'none', backgroundColor: 'none' }, message: '<img src="'+site_url+'/assets/eduplaycloud/image/loader.gif" alt="Loading" width="100" />' });
                            },
                            success: function (response) {
                                console.log(response);
                                $('.frm_step3_modal').unblock();
                                if(response.child === false){
                                    window.location.href = site_url+'/notapprovedbyparent';
                                } else if(response.child === 'withname'){
                                    swal({
                                        title: "Congratulations!",
                                        text: "{{ Lang::get('controller.account_created_successfully') }}",
                                        closeOnClickOutside: false,
                                        closeOnEsc: false,
                                        allowOutsideClick: false,
                                    }).then(function(){
                                        window.location.href = site_url+'/';
                                        //window.location.href = site_url+'/exercisesets/private';
                                    });
                                } else{
                                    swal({
                                        title: "Congratulations!",
                                        text: "Your account is registered, you will shortly receive an email to activate your account. ",
                                        closeOnClickOutside: false,
                                        closeOnEsc: false,
                                        allowOutsideClick: false,
                                    }).then(function(){
                                        window.location.href = site_url+'/';
                                        //window.location.href = site_url+'/exercisesets/private';
                                    });
                                }

                                if (response.status === true) {
                                    $(".frm_step3_modal").modal("hide");

                                }
                            },
                            error: function (jqXHR) {
                                console.log(jqXHR.response);
                                $('.frm_step3_modal').unblock();
                            }
                        });

                        return false;
                    }
                });
            });
        </script>
    </body>
</html>