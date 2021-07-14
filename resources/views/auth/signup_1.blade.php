@php
    if (isset($_GET['popup'])){
    $view="popup";$p=1;$lnk="?popup=y";}
    else
    { $view="app";$p=2;$lnk="";}
@endphp
@extends('layouts/'.$view)
@section('header_styles')
    <link rel="stylesheet" href="{{ asset('assets/css/signup.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/login.css') }}">
@stop
{{-- Page title --}}
@section('title')
    Sign up
    @parent
@stop

@section('content')

        <div class="col-xl-12 col-lg-12 col-sm-12 col-xs-12 all-padding " >
            <div class="col-xl-6 col-lg-6 col-sm-6 col-xs-12 left-bar all-padding"  >
                <div class="col-xl-12 col-lg-12 col-sm-12 col-xs-12 signup-page1">
                    helping every student succeed with personalized practice. 100% free



                </div>

            </div>



            <div class="col-xl-6 col-lg-6 col-sm-6 col-xs-12 right-bar all-padding">
                    <div class="col-xl-12 col-lg-12 col-sm-12 col-xs-12 right-bar-box" >
                <div style="margin: auto !important;width: 80%">


                            <div class="col-xl-12 col-lg-12 col-sm-12 col-xs-12 all-padding " style="border: 1px solid #000000;" >
                                <div class="col-xl-3 col-lg-3 col-sm-3 col-xs-3 all-padding welcome-image "><img src={{asset('assets/images/logo-signup.png')}} width='60' height='60' /></div>
                                <div class="col-xl-9 col-lg-9 col-sm-9col-xs-9 all-padding welcome-text" >welcome to EduPlayCloud
                                <br>I'm your assistance
                                    <br>I will help you in going step by step through creating your account
                                </div>


                            </div>
                            <form id="login-form" class="login-form" action="{{ route('login') }}" method="post" role="form">
                                {{ csrf_field() }}
                                <div class="col-xl-12 col-lg-12 col-sm-12 col-xs-12 all-padding  login-label" id="email_label">What is Your Date of Birth</div>
                                <div class="col-xl-12 col-lg-12 col-sm-12 col-xs-12 all-padding  ">

                                    <input type="date" name="dob" id="email" placeholder="Date of Birth" value="" class=" login-input-blue" required>
                                    @if ($errors->has('email'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                    @endif
                                </div>



                                <div class=" col-xl-12 col-lg-12 col-sm-12 col-xs-12  all-padding " >

                                    <input type="submit" class="btn icon-btn1 btn-mylogin" value="Secured Login" id="submitlogin" name="submitlogin">
                                    <div class="alert alert-danger fade" id="invaliderror" style="display:none;"></div>
                                </div>


                                    <div class=" col-xl-12 col-lg-12 col-sm-12 col-xs-12"><a href="{{ route('signup') }}{{$lnk}}" id="myModalsignup" class="loginlink">@lang('auth.Don\'t have an account')</a></div>






                            </form>


                        </div>

                    </div>










            </div>
        </div>

@endsection

@section('footer_scripts')

    <script>

        function facebookclose(url){

            parent.location = url;
        }

        $("#email").focus(function(){
            $("#user-icon").attr('src', "{{asset('assets/images/user-icon-off.png')}}");

        })
        $("#email").focusout(function(){
            $("#user-icon").attr('src', "{{asset('assets/images/user-icon.png')}}");

        })

        $("#password").focus(function(){
            $("#lock-icon").attr('src', "{{asset('assets/images/user-lock-off.png')}}");

        })
        $("#password").focusout(function(){
            $("#lock-icon").attr('src', "{{asset('assets/images/user-lock.png')}}");

        })
    </script>

@endsection