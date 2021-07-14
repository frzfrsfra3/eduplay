
@extends('authenticated.layouts.default')
@section('content')
<div class="main_content">
    <div class="container" id="addChildPage">
        <div class="add_child_cls">
            <div class="row justify-content-center">
                <div class="col-lg-11">
                    <div class="inner_add_child text-ar-right">
                        <h6>@lang('profile.add_existing_child')</h6>
                        @if(Session::has('error_message'))
                        <div class="alert alert-danger">
                            <i class="fa fa-exclamation-triangle" aria-hidden="true"></i>
                            {!! session('error_message') !!}
                            <button type="button" class="close" data-dismiss="alert" aria-label="close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <br />
                        @endif
                        <form class="def_form" method="post" action="{{ route('storeParentRequest') }}" name="addChild" id="addChild">
                            @csrf
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group mrgn-bt-30 mrgn-tp-30">
                                        <div class="col-md-6">
                                            <div class="form-group mrgn-bt-30">
                                                <label> Enter Email or Username of your child :</label>
                                                <input type="text" class="form-control" name="email_or_user" autocomplete="off"/>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <a href="{{ URL('users/profile/'.Auth::user()->id . '/#pills-profile') }}" class="btn btn-primary cancel-btn">@lang('profile.cancel')</a>
                                            <button type="submit" class="btn btn-primary add_btn">@lang('profile.add')</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

<?php /*Load jquery to footer section*/ ?>
@push('inc_script')
    <script type="text/javascript" src="{{ asset('assets/eduplaycloud/customs/js/jquery-validate/jquery.validate.min.js') }}"></script>
@endpush

<?php /*Load jquery to footer section*/ ?>
@push('inc_jquery')
<script>
$(function () {
    var date = new Date();
    date.setDate(date.getDate() - 7);

    $('#dob').datetimepicker({
        maxDate: 'now',
        format: 'DD/MM/YYYY',
    });
});
$('#dob').on('dp.change', function(e){ 
    var now = new Date();
    var currentYear = now.getFullYear();
    var userYear = $("#dob").val();
    var userYear = userYear.substring(userYear.lastIndexOf("/") + 1, userYear.length);

    if (currentYear-userYear <= 13) {
        $("#password_div").slideDown();
        $("#passwordConfirm_div").slideDown();
        $("#username_div").slideDown();
        $("#email_div").slideUp();
    } else {
        $("#email_div").slideDown();
        $("#username_div").slideUp();
        $("#password_div").slideUp();
        $("#passwordConfirm_div").slideUp();
    }
});

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

    $("#addChild").validate({
        rules: {
            child_name: {
                required: true,
                maxlength: 30
            },
            email: {
                required: true,
                email: true,
                remote: {
                    url: site_url + "/child/validate/unique/email",
                    type: "post",
                    headers: { 'X-CSRF-TOKEN': $('meta[name="csrfToken"]').attr('content') },
                    data: {
                        value: function () {
                            return $("#addChild #email").val();
                        },
                        'column': 'email'
                    }
                }
            },
            username:{
                required:true,
                maxlength: 50,
                remote: {
                    url: site_url + "/child/validate/unique/email",
                    type: "post",
                    headers: { 'X-CSRF-TOKEN': $('meta[name="csrfToken"]').attr('content') },
                    data: {
                        value: function () {
                            return $("#addChild #username").val();
                        },
                        'column': 'email'
                    }
                }
            },
            password: {
                required: true,
                minlength: 6
            },
            passwordConfirm: {
                required: true,
                minlength: 6,
                equalTo: "#child_password"
            },
            grade_id:{
                required: true,
            },
            school_id:{
                required: false,
            },
            gender:{
                required: true,
            },
            dob:{
                required: true,
            },
        },
        messages: {
            email: {
                required: message['validator_email'],
                remote: $.validator.format(message['email_taken'])
            },
            username: {
                remote: $.validator.format(message['email_taken'])
            }
        },
        errorPlacement: function(error, element) {
            if(element.attr("name") == "gender"){
                error.insertAfter($(element).parents('.prsn-action-rdio'));
            }
            else {
                error.insertAfter(element);
            }
        },
    });
});
</script>
@endpush

