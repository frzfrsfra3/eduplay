@extends('layouts.app')
@section('header_styles')

    <link rel="stylesheet" href="{{ asset('assets/css/eduplay.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/user.css') }}">


@endsection
@section('top')
    @include('users.userprofilenavigation')
@endsection

@section('content')

    <div class="panel panel-default">
        <div class="container">



                    <div class="col-xs-12 col-lg-12 col-sm-12 col-xs-12" >
                        <div class="col-xs-10 col-lg-10 col-sm-10 col-xs-12" >   </div>
                        <div class="col-xs-2 col-lg-2 col-sm-2 col-xs-12" >  <a href="{{route('users.user.addchildren',Auth::user())}}" class="btn btn-edubtn">
                                @lang('user.Add Children')</a> </div>



                    </div>
                    <div class="col-xs-12 col-lg-12 col-sm-12 col-xs-12" >
                    @if ($errors->any())
                        <ul class="alert alert-danger">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    @endif

                    @if(Session::has('success_message'))
                        <div class="alert alert-success">
                            <i class="fa fa-check-square-o" aria-hidden="true"></i>
                            {!! session('success_message') !!}

                            <button type="button" class="close" data-dismiss="alert" aria-label="close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>

                    @endif
                    </div>

                     @if ($children->count()!=0)
                        <div class="col-xl-12 col-lg-12 col-sm-12 col-xs-12 all-padding  " style="margin: 0 0 10px 0;text-align: center">

                            <div class="col-xl-12 col-lg-12 col-sm-12 col-xs-12 all-padding exam-header ">
                                <div class="col-xl-4 col-lg-4 col-sm-4 col-xs-4 ">Name</div>
                                <div class="col-xl-4 col-lg-4 col-sm-4 col-xs-4 ">Email</div>
                                <div class="col-xl-4 col-lg-4 col-sm-4 col-xs-4 "> last logged on</div>


                            </div>


                            @foreach($children as $child)
                                <div class="col-xl-12 col-lg-12 col-sm-12 col-xs-12 all-padding alternative-row ">
                                    <div class="col-xl-4 col-lg-4 col-sm-4 col-xs-4 ">{{ $child->name }}</div>
                                    <div class="col-xl-4 col-lg-4 col-sm-4 col-xs-4 ">{{ $child->email }}</div>
                                    <div class="col-xl-4 col-lg-4 col-sm-4 col-xs-4 ">{{ $child->lastloggedon }}</div>

                                </div>
                            @endforeach

                        </div>
                    @endif



        </div>
    </div>

@endsection

@section('footer_scripts')

@endsection





