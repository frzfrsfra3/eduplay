@extends('layouts.app')
@section('header_styles')

    <link rel="stylesheet" href="{{ asset('assets/css/eduplay.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/user.css') }}">


@endsection
@section('top')

    <div class="panel-heading clearfix">
        <div class="container">

            <div class="tabbable-line">
                <ul class="nav nav-tabs ">
                    <li>
                        <a href="">
                            @lang('user.user badges') </a>
                    </li>
                    <li>
                        <a> <i class="fa fa-caret-right " aria-hidden="true"></i></a>
                    </li>
                    <li>
                        <a href="">
                            {!! $user->name !!} </a>

                    </li>

                </ul>
            </div>

        </div>
    </div>



@endsection

@section('content')

    <div class="panel panel-default">
        <div class="container">
            <div class="panel-body ">
                <div class="col-md-2 "></div>
                <div class="col-md-8 profile-form">

                    <div class="row ">


                        <div class="row listbadge">
                            <div class=" "><b>@lang('user.AllBadges'):</b></div>

                            <div class="clearBoth"></div>
                            @php
                                    $lastbadges=$user->badges()->orderBy('userbadges.id', 'desc')->get();
                                    @endphp

                            @foreach($lastbadges as $badge)
                                @php
                                    if (strlen($badge->badgeimageurl) >0 && File::exists(public_path()."\assets\images\badges\\".$badge->badgeimageurl)) {$badgeimage= $badge->badgeimageurl;}
                                    else{$userimage= '';
                                        $badgeimage='default.png';
                                        }
                                @endphp
                                <div id="badge-img" class=" col-xl-3 col-lg-3 col-sm-2 col-xs-8">
                                       <div  >
                                        <img id="badge-div" class="cbadge-div"
                                             src="{{ asset('assets/images/badges') }}/{{$badgeimage}}" alt="{{$badge->badgetitle}}"
                                             title="{{$badge->badgetitle}}">
                                    </div>
                                    <div class="badage-text">{{$badge->badgetitle}}</div>
                                    <div class="badage-text"  > {{date('d - M - Y', strtotime( $badge->pivot->dateacquired ))}}</div>

                                </div>
                                @endforeach

                        </div>



                    </div>

                    <div class="col-md-2 "></div>
                </div>

            </div>
        </div>
    </div>


@endsection

@section('footer_scripts')

@endsection

