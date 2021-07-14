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
    <link rel="stylesheet" href="{{ asset('assets/css/glyphicon.css') }}">
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

        @php

            $nday=Carbon\Carbon::parse (session('bday'))->age;

           if($nday >= 13) {$cbox='right-bar-box1';}
           else {$cbox='right-bar-box2';}

        @endphp

        <div class="col-xl-6 col-lg-6 col-sm-6 col-xs-12 right-bar all-padding">
            <div class="col-xl-12 col-lg-12 col-sm-12 col-xs-12 {{$cbox}}" >
                <div style="margin: auto !important;width: 85%">

                    @if ($nday>=13)
                    <div class="col-xl-12 col-lg-12 col-sm-12 col-xs-12 all-padding " ><button class="btn-google" onclick="facebookclose('{!! url('auth/google') !!}')"> Continue with Google+ </button></div>
                    <div class="col-xl-12 col-lg-12 col-sm-12 col-xs-12 all-padding " ><button class="btn-facebook"   onclick="facebookclose('{!! url('auth/facebook') !!}')"> Continue with Facebook </button></div>
                     @endif


                    <form method="POST" action="" name="form_sign3">
                        @csrf
                        <div class="col-xl-12 col-lg-12 col-sm-12 col-xs-12 all-padding " style="margin: 20px 0 0 0;" >

                            <div class="[ form-group ]">
                                <input type="checkbox" name="bit_learner" id="fancy-checkbox-info" autocomplete="off" checked />
                                <div class="[ btn-group ]">
                                    <label for="fancy-checkbox-info" class="[ btn btn-info ]">
                                        <span class="[ glyphicon glyphicon-ok ]"></span>
                                        <span> </span>
                                    </label>
                                    <label for="fancy-checkbox-info" class="[ btn btn-default active ]">
                                        Learner
                                    </label>
                                </div>
                            </div>

                            @if ($nday>=13)
                            <div class="[ form-group ]">
                                <input type="checkbox" name="bit_teacher" id="fancy-checkbox-warning" autocomplete="off" />
                                <div class="[ btn-group ]">
                                    <label for="fancy-checkbox-warning" class="[ btn btn-warning ]">
                                        <span class="[ glyphicon glyphicon-ok ]"></span>
                                        <span> </span>
                                    </label>
                                    <label for="fancy-checkbox-warning" class="[ btn btn-default active ]">
                                        Teacher
                                    </label>
                                </div>
                            </div>

                            <div class="[ form-group ]">
                                <input type="checkbox" name="bit_parent" id="fancy-checkbox-danger" autocomplete="off" />
                                <div class="[ btn-group ]">
                                    <label for="fancy-checkbox-danger" class="[ btn btn-danger ]">
                                        <span class="[ glyphicon glyphicon-ok ]"></span>
                                        <span> </span>
                                    </label>
                                    <label for="fancy-checkbox-danger" class="[ btn btn-default active ]">
                                        Parent
                                    </label>
                                </div>
                            </div>
                            @endif

                        </div>


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

                            </div>
                            <div class="col-xl-12 col-lg-12 col-sm-12 col-xs-12 all-padding  user_label" id="repassword_label">Comfirm Password</div>
                            <div class="col-xl-12 col-lg-12 col-sm-12 col-xs-12 all-padding  ">

                                <input id="password-confirm" type="password" class="login-input-blue" name="password_confirmation" required  placeholder="Confirm the password">
                            </div>
                        </div>
                        @if ($nday<13)
                            <div class="col-xl-12 col-lg-12 col-sm-12 col-xs-12 all-padding  user_label" id="email_label">Parent Email</div>
                            <div class="col-xl-12 col-lg-12 col-sm-12 col-xs-12 all-padding  ">

                                <input id="parentmail" type="email" class="login-input-blue {{ $errors->has('parentmail') ? ' is-invalid' : '' }}" name="parentmail" value="{{ old('parentmail') }}" required
                                       placeholder="Your parent  email address" >

                                @if ($errors->has('parentmail'))
                                    <span class="txt-small error-txt" >
                                        <strong>{{ $errors->first('parentmail') }}</strong>
                                    </span>
                                @endif
                            </div>
                         @else
                            <input id="parentmail" type="hidden"  name="parentmail"  value=""  >
                        @endif



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