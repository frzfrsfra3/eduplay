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


                    <div class="col-xl-12 col-lg-12 col-sm-12 col-xs-12 all-padding " ><button class="btn-google" onclick="facebookclose('{!! url('auth/google') !!}')"> Continue with Google+ </button></div>
                    <div class="col-xl-12 col-lg-12 col-sm-12 col-xs-12 all-padding " ><button class="btn-facebook"   onclick="facebookclose('{!! url('auth/facebook') !!}')"> Continue with Facebook </button></div>
                    <form id="login-form" class="login-form" action="{{ route('login') }}" method="post" role="form">
                        {{ csrf_field() }}
                        <div class="col-xl-12 col-lg-12 col-sm-12 col-xs-12 all-padding  login-label" id="email_label">Email</div>
                        <div class="col-xl-12 col-lg-12 col-sm-12 col-xs-12 all-padding  ">

                            <input type="text" name="email" id="email" placeholder="Email" value="" class=" login-input-blue" required>
                            @if ($errors->has('email'))
                                <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                            @endif
                        </div>
                        <div class="col-xl-12 col-lg-12 col-sm-12 col-xs-12 all-padding  login-label" id="Password_label" >Password</div>
                        <div class="col-xl-12 col-lg-12 col-sm-12 col-xs-12 all-padding"  >

                            <input type="password" value="" name="password" id="password" placeholder="Password" class=" login-input-blue" required>

                            @if ($errors->has('password'))
                                <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                            @endif
                        </div>
                        <div class="col-xl-12 col-lg-12 col-sm-12 col-xs-12 all-padding login-link-label"   ><a href="{{ route('password.request') }}{{$lnk}}" id="forgotpass" class="loginlink">@lang('auth.Forgot Password?')</a></div>



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