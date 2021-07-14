@extends('authenticated.layouts.default')
@section('content')
<div class="child-passwrd main_content tabs_my_profile" id="profilePage">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-11">
                    <div class="befr-img-pswd">
                    @if(Session::has('error_message'))
                        <div class="alert alert-danger">
                            <i class="fa fa-check-square-o" aria-hidden="true"></i>
                            {!! session('error_message') !!}
                            <button type="button" class="close" data-dismiss="alert" aria-label="close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    <br />
                    @endif
                        <div class="row">
                            <div class="col-md-12 col-lg-5">
                                <div class="left_contnt text-ar-right"></div>
                             </div>
                            <div class="col-md-12 col-lg-6">
                                <div class="right-child-side">
                                <h3>@lang('profile.change_password')</h3>
                                    <form name="frmChangePassword" id="frmChangePassword" class="def_form" method="POST" action="{{url('/users/child/change/password')}}">
                                        @csrf
                                        <div class="form-group">
                                            <label>@lang('profile.old_password'):</label>
                                            <input type="hidden" name="child_password_reset" value="1">
                                            <input type="password" name="old_password" id="old_password" class="form-control">
                                        </div>
                                        <div class="form-group">
                                            <label>@lang('profile.new_password'):</label>
                                            <input type="password" name="password" id="password" class="form-control" maxlength="13">
                                        </div>
                                        <div class="form-group">
                                            <label>@lang('profile.confirm_new_password'):</label>
                                            <input type="password" name="conform_password" id="conform_password" class="form-control" maxlength="13">
                                        </div>
                                        <div class="form-group chnge_rst_mrgn">
                                            <button type="submit" class="btn btn-primary btn-login">@lang('profile.change')</button>
                                            <a href="{{route('users.user.profile',[Auth::user()->id])}}" class="btn btn-primary skip-btn">@lang('profile.skip')</a>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
</div>

@endsection
<?php /*Load jquery to footer section*/ ?>
@push('inc_script')
    <script type="text/javascript" src="{{ asset('assets/eduplaycloud/customs/js/pages/profile/change-password.js') }}"></script>
@endpush