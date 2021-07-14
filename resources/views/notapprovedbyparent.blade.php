@extends('layouts.popup')

@section('header_styles')
    <link rel="stylesheet" href="{{ asset('assets/css/signup.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/login.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/glyphicon.css') }}">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">

@endsection

@section('content')
    <div class="col-xl-12 col-lg-12 col-sm-12 col-xs-12 all-padding " >
        <div class="col-xl-6 col-lg-6 col-sm-6 col-xs-12 left-bar all-padding" style="background-color:#FF8F3B !important;  "  >
            <div class="col-xl-12 col-lg-12 col-sm-12 col-xs-12 signup-page1" style="font-family: 'Open Sans', sans-serif;">
                @lang('home.parent_message_2')
            </div>
        </div>
        <div class="col-xl-6 col-lg-6 col-sm-6 col-xs-12 right-bar all-padding">
            <div class="col-xl-12 col-lg-12 col-sm-12 col-xs-12 right-bar-box" >
                <h4 style="font-family: 'Open Sans', sans-serif;">@lang('home.parent_message_1')<h4>
                <div style="margin-top:10px; text-align:center;"><a href="{{ route('welcome') }}" class="btn btn-danger btn-lg">@lang('home.continue')</a></div>
                <br><Br>
            </div>
        </div>
    </div>
@endsection
