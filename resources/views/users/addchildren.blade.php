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
            <div class="panel-body ">
                <div class="col-md-2 "></div>
                <div class="col-md-8 profile-form">
                    <div class="row user-form">

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
                            <br>
                        <form method="POST" action="{{ route('invitedusers.inviteduser.savechild' ,Auth::user()) }}"
                              accept-charset="UTF-8" id="create_inviteduser_form"
                              name="create_inviteduser_form" class="form-horizontal">
                            {{ csrf_field() }}
                            @include ('users.addchildform', [
                                       'child' => null,
                                     ])

                            <div class="form-group">
                                <div class="col-md-offset-2 col-md-10">
                                    <input class="btn btn-primary" type="submit" value="@lang('user.Add')">
                                </div>
                            </div>


                        </form>
                            <br>
                    </div>


                </div>
            </div>
        </div>
    </div>

@endsection

@section('footer_scripts')

@endsection





