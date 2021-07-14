@php
    if (isset($_GET['popup'])){
   $view="popup";$p=1;$lnk="?popup=y";}
    else
    {$view="app"; $p=2;$lnk="";}
@endphp
@extends('layouts.'.$view)
@section('header_styles')
    <link rel="stylesheet" href="{{ asset('assets/css/signup.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/login.css') }}">

    <style>

        #login-form img{max-width: 56px !important;height: auto !important;}
        .col-centered{
            float: none;
            margin: auto;min-height: 150px;padding:50px 0 150px 0
        }

    </style>
    @if ($p==1)
        <style>
            .col-centered{
              min-height: 150px;padding:150px 0
            }


        </style>
    @endif

@endsection
@if ($p==2)
@section('top')
    <div class="panel-heading clearfix">
        <div class="container">
            <span class="pull-left">
                <h4 class="mt-5 mb-5">Reset Password</h4>
            </span>

            <div class="pull-right">



            </div>
        </div>
    </div>
@endsection
@endif

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
                    <form method="POST" action="{{ route('password.email') }}">
                        @csrf


                            <div for="email" class="col-xl-12 col-lg-12 col-sm-12 col-xs-12 all-padding login-label"  >E-Mail Address</div>
                            <div class="col-xl-12 col-lg-12 col-sm-12 col-xs-12 all-padding">

                                <input id="email" type="email" class="login-input-blue {{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required>

                                @if ($errors->has('email'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif

                        </div>


                        <div class="col-xl-12 col-lg-12 col-sm-12 col-xs-12 all-padding ">
                            <button type="submit" class="btn icon-btn1 btn-mylogin">
                                Send Password
                            </button>
                        </div>
                        <div class=" col-xl-12 col-lg-12 col-sm-12 col-xs-12"><a href="{{ route('login') }}{{$lnk}}" id="myModalsignup" class="loginlink">@lang('Already have an account')</a></div>

                    </form>


                </div>

            </div>










        </div>
    </div>


@endsection
