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


                <div class="col-xl-12 col-lg-12 col-sm-12 col-xs-12 " style="margin: 10px 0 0 0;padding: 5px 0 0 0">
                    <div class=" user-form">
                        <div class=" col-md-12 profile-header">Invite Friend
                        </div>
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

                                <form method="POST" action="{{ route('invitedusers.inviteduser.store_profile') }}" accept-charset="UTF-8" id="create_inviteduser_form"
                          name="create_inviteduser_form" class="form-horizontal">
                        {{ csrf_field() }}
                    <div class="form-group" style="padding: 10px 0 0 0">
                        <label for="email" class="col-md-2 control-label">Email</label>
                        <div class="col-md-10">
                            <input class="form-control" name="email" type="email" id="email" value="" minlength="1" maxlength="250" required="true" placeholder="Enter email here...">
                            {!! $errors->first('email', '<p class="help-block">:message</p>') !!}
                        </div>
                    </div>
                    <div class="form-group">
                           <div class="col-md-10">
                            <input class="form-control" type="hidden" name="invitedby" type="number" id="invitedby"
                              value="{{$user->id}}"     min="-2147483648" max="2147483647" required="true" placeholder="Enter invitedby here...">
                            {!! $errors->first('invitedby', '<p class="help-block">:message</p>') !!}
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="message" class="col-md-2 control-label">Message</label>
                        <div class="col-md-10">
                            <textarea class="form-control" name="message" cols="50" rows="10" id="message" required="true" placeholder="Enter message here..."></textarea>
                            {!! $errors->first('message', '<p class="help-block">:message</p>') !!}
                        </div>
                    </div>

                    <div class="form-group">

                        <div class="col-md-10">
                            <input class="form-control" name="invitationtype" type="hidden" value="friend" cols="50" rows="10" id="message" required="true" placeholder="Enter message here...">
                            {!! $errors->first('invitationtype', '<p class="help-block">:message</p>') !!}
                        </div>

                        <div class="col-md-10">
                            <input class="form-control" name="invitationstatus" type="hidden" value="pending" cols="50" rows="10" id="message" required="true">
                            {!! $errors->first('invitationstatus', '<p class="help-block">:message</p>') !!}
                        </div>
                    </div>
                        <div class="form-group">
                            <div class="col-md-offset-2 col-md-10">
                                <input class="btn btn-primary" type="submit" value="@lang('user.Send')">
                            </div>
                        </div>


                    </form>
                    </div>
                    <div class="col-xl-12 col-lg-12 col-sm-12 col-xs-12 all-padding  " style="margin: 0 0 10px 0;text-align: center">

                        <div class="col-xl-12 col-lg-12 col-sm-12 col-xs-12 all-padding exam-header ">
                            <div class="col-xl-4 col-lg-4 col-sm-4 col-xs-4 ">Email</div>
                            <div class="col-xl-4 col-lg-4 col-sm-4 col-xs-4 ">message</div>
                            <div class="col-xl-4 col-lg-4 col-sm-4 col-xs-4 ">status</div>

                            <th></th>
                        </div>


                        @foreach($invitedusers as $inviteduser)
                            <div  class="col-xl-12 col-lg-12 col-sm-12 col-xs-12   alternative-row" >
                                <div class="col-xl-4 col-lg-4 col-sm-4 col-xs-4 ">{{ $inviteduser->email }}</div>
                                <div class="col-xl-4 col-lg-4 col-sm-4 col-xs-4 ">{{ $inviteduser->message }}</div>
                                <div class="col-xl-4 col-lg-4 col-sm-4 col-xs-4 ">{{ $inviteduser->invitationstatus }}</div>

                            </div>
                        @endforeach

                    </div>


            </div>

    </div>
    </div>

@endsection

@section('footer_scripts')

@endsection





