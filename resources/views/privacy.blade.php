@extends('layouts.app')
@section('header_styles')
    <link rel="stylesheet" href="{{ asset('assets/css/info.css') }}">
@endsection
@section('top')
    <div class="panel-heading clearfix">
        <div class="container" style="text-align: center; padding:10px;">
            <h3 style="color:#fff;">@lang('privacy.Title')</h3>
        </div>
    </div>
@endsection

@section('content')
    <div class="container">
        <p>
            <h3 class="info-content-title">@lang('privacy.title1')</h3>
        @lang('privacy.paragraph1')
        </p>
        <p>
        <h3 class="info-content-title">@lang('privacy.title2')</h3>
        @lang('privacy.paragraph2')
        </p>
        <p>
        <h3 class="info-content-title">@lang('privacy.title3')</h3>
        @lang('privacy.paragraph3')
        </p>
    </div>
@endsection