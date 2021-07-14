@php
    if (isset($_GET['popup'])){
    $view="popup";$p=1;$lnk="?popup=y";}
    else
    { $view="popup";$p=2;$lnk="";}
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
                    <form method="POST" action="{{ route('register') }}" name="form_sign3">
                        @csrf
                        <div class="" id="sign-main">
                            <div class="col-xl-12 col-lg-12 col-sm-12 col-xs-12 all-padding  user_label" id="name_label">Name</div>
                            <div class="col-xl-12 col-lg-12 col-sm-12 col-xs-12 all-padding  ">
                                <input id="name" type="text" class="login-input-blue {{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{ old('name') }}" required autofocus
                                       placeholder="Your full name" >
                                @if ($errors->has('name'))
                                    <span class="txt-small error-txt" >
                                        <strong>{{ $errors->first('name') }}</strong>

                                    </span>

                                @endif
                            </div>

                            <div class="col-xl-12 col-lg-12 col-sm-12 col-xs-12 all-padding  user_label" id="email_label">Email</div>
                            <div class="col-xl-12 col-lg-12 col-sm-12 col-xs-12 all-padding  ">

                                <input id="email" type="email" class="login-input-blue {{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required
                                       placeholder="Your email address" >

                                @if ($errors->has('email'))
                                    <span class="txt-small error-txt" >
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="col-xl-12 col-lg-12 col-sm-12 col-xs-12 all-padding  user_label" id="password_label">Password</div>
                            <div class="col-xl-12 col-lg-12 col-sm-12 col-xs-12 all-padding  ">
                                <input id="password" type="password" class="login-input-blue {{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required placeholder="Set a password" data-toggle="tooltip" data-placement="top" title="@lang('auth.Min 6 characteralpha numeric')">
                                @if ($errors->has('password'))
                                    <span class="txt-small error-txt" >
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                    <br>
                                @endif
                                <span class="txt-small">@lang('auth.Min 6 characteralpha numeric')</span>
                            </div>
                            <div class="col-xl-12 col-lg-12 col-sm-12 col-xs-12 all-padding  user_label" id="repassword_label">Comfirm Password</div>
                            <div class="col-xl-12 col-lg-12 col-sm-12 col-xs-12 all-padding  ">

                                <input id="password-confirm" type="password" class="login-input-blue" name="password_confirmation" required  placeholder="Confirm the password">
                            </div>
                        </div>
                        <div  class=" col-xl-12 col-lg-12 col-sm-12 col-xs-12 " style="text-align: center;padding: 0"> <button type="submit" class="btn icon-btn1 btn-mylogin">
                                @lang('auth.START USING EDUPLAYCLOUD')
                            </button></div>

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


    </script>

@endsection