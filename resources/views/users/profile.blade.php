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
                    <div class="row ">
                        <div class=" col-xl-3 col-lg-3 col-sm-3 col-xs-8">
                            <form enctype="multipart/form-data" id="upload_form" role="form" method="POST" action="">
                                <input type="hidden" name="_token" value="{{ csrf_token()}}">
                                @php
                                    if (strlen($user->user_image) >0 && File::exists(public_path()."\assets\images\profiles\\".$user->user_image)) {$userimage= $user->user_image;}
                                    else{


                                    $userimage= 'userdefaultimg.png';}
                                @endphp
                                <img id="ajax-img" style="display: none;" src="{{ asset('assets/images/ajax-loader.gif') }}">
                                <div class=" inline" id="user-img">

                                    <img id="user_img" class="user-img"
                                         src="{{ asset('assets/images/profiles') }}/{{$userimage}}" alt="{{$user->name}}"
                                         title="{{$user->name}}">
                                </div>

                                <div class=" inline button-wrapper  ">
                                      <label for="upload-photo" class="pointer">
                                        <input type="file" class="form-control" name="upload-photo"
                                               data-url="{{route('users.user.updatepicture',$user->id)}}"
                                               id="upload-photo" accept="image/*"/>
                                        <i class="fa fa-pencil-square-o fa-5x" aria-hidden="true"></i></label>

                                </div>
                                <div class="clearBoth"></div>

                            </form>
                        </div>
                        <br>
                        <div class="row">
                        <div class="points col-xl-2 col-lg-2 col-sm-2 col-xs-8">
                            <div class="pointval pointcolor">{{$lastuseractivitylogs->accumulated_points}}</div>
                            <div>@lang('user.Points')</div>
                        </div>
                        <div class="points col-xl-2 col-lg-2 col-sm-2 col-xs-8">
                            <div class="pointval badgecolor">{{$user->badges()->count()}}</div>
                            <div>@lang('user.Badges')</div>
                        </div>
                        <div class="points col-xl-2 col-lg-2 col-sm-2 col-xs-8">
                            <div class="pointval coursecolor">{{$user->enrolledclasses()->count()}}</div>
                            <div>@lang('user.Enrolled Courses')</div>
                        </div>

                            <div class="points col-xl-2 col-lg-2 col-sm-2 col-xs-8">
                            <div class="progress-bar" data-percent="{{$user->calculate_profile($profile)}}"><span style="color: black">Profile complete:</span> </div>
                            </div>
                        </div>


                        @php
                            $lastbadges=$user->badges()->orderBy('userbadges.id', 'desc')->take(4)->get();
                        @endphp
                        @if( $lastbadges->count()!=0)
                        <div class="row listbadge">
                            <div class=" inline"><b>@lang('user.Recently earned Badges'):</b></div>
                            <a href="{{route('users.user.userbadges',$user->id)}}" >    <div class=" inline" style="float: right"><b>@lang('user.AllBadges')</b></div> </a>
                            <div class="clearBoth"></div>

                            @foreach($lastbadges as $badge)
                                @php
                                    if (strlen($badge->badgeimageurl) >0 && File::exists(public_path()."\assets\images\badges\\".$badge->badgeimageurl)) {$badgeimage= $badge->badgeimageurl;}
                                    else{$userimage= '';
                                         $badgeimage='default.png';   }
                                @endphp
                                <div id="badge-img" class=" col-xl-3 col-lg-3 col-sm-2 col-xs-8">
                                       <div  >
                                        <img id="badge-div" class="cbadge-div"
                                             src="{{ asset('assets/images/badges') }}/{{$badgeimage}}" alt="{{$badge->badgetitle}}"
                                             title="{{$badge->badgetitle}}">
                                    </div>
                                    <div class="badage-text">{{$badge->badgetitle}}</div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    @endif


                    <div class="row ">
                        <div><b>@lang('user.Roles:')</b></div>
                        @if ($user->hasRole('Learner'))
                            <a href="#" style="text-decoration: none;">
                            <div class="  inline userrole col-xl-2 col-lg-2 col-sm-3 col-xs-7"  onclick="removerole('{{route('users.user.removerole',[$user->id,'Learner'])}}')">
                                <i class="fa fa-check" aria-hidden="true"></i> @lang('user.learner')
                            </div>
                            </a>
                        @else
                            <a href="#" style="text-decoration: none;">
                                <div class="inline askforrole col-xl-2 col-lg-2 col-sm-3 col-xs-7"
                                     onclick="addrole('{{route('users.user.addrole',[$user->id,'Learner'])}}')">   @lang('user.learner')
                                </div>
                            </a>

                        @endif
                        @if ($user->hasRole('Teacher'))
                            <a href="#" style="text-decoration: none;">
                            <div class="inline userrole col-xl-2 col-lg-2 col-sm-3 col-xs-7" onclick="removerole('{{route('users.user.removerole',[$user->id,'Teacher'])}}')">
                                <i class="fa fa-check"   aria-hidden="true">
                                </i> @lang('user.Teacher') </div>
                            </a>
                        @else
                            <a href="#" style="text-decoration: none;">
                                <div class="inline askforrole  col-xl-2 col-lg-2 col-sm-3 col-xs-7"
                                     onclick="addrole('{{route('users.user.addrole',[$user->id,'Teacher'])}}')">   @lang('user.Teacher')
                                </div>
                            </a>

                        @endif
                        @if ($user->hasRole('Parent'))
                            <a href="#" style="text-decoration: none;">
                            <div class="inline userrole col-xl-2 col-lg-2 col-sm-3 col-xs-7" onclick="removerole('{{route('users.user.removerole',[$user->id,'Parent'])}}')">
                                <i class="fa fa-check"  aria-hidden="true"></i> @lang('user.Parent')
                            </div>
                            </a>

                        @else

                            <a href="#" style="text-decoration: none;">
                                <div class="inline  askforrole col-xl-2 col-lg-2 col-sm-3 col-xs-7"
                                     onclick="addrole('{{route('users.user.addrole',[$user->id,'Parent'])}}')">   @lang('user.Parent')
                                </div>
                            </a>
                        @endif
                        <div class="inline   col-xl-2 col-lg-2 col-sm-3 col-xs-7" style="margin-top: 5px">
                            <a href="{{route('users.user.invitefriend',Auth::user())}}" class="btn btn-edubtn" >
                                Invite friend </a>
                        </div>
                    </div>

                    <div class="row col-xl-12 col-lg-12 col-sm-12 col-xs-12">
                        <div class=" col-md-12 profile-header">

                           My Profile

                        </div>
                        <div class="user-form" id="user-form">
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


                            <form method="POST" action="{{ route('users.update.user' ,$user->id)  }}"
                                  accept-charset="UTF-8" id="create_user_form" name="create_user_form" class="form-horizontal">
                                {{ csrf_field() }}

                                <div> @include('users.formprofile') </div>
                                <div class="form-group">
                                    <div class="col-md-offset-2 col-md-10">
                                        <input class="btn btn-primary" type="submit" value="@lang('user.Save')">
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="col-md-2 "></div>
                </div>

            </div>
        </div>
    </div>


@endsection

@section('footer_scripts')

    <script type="text/javascript" src="{{ asset('assets/js/jQuery-plugin-progressbar.js') }}"></script>
    <script type="text/javascript">
        $(function () {



            $("input:file").change(function () {

                var fileName = $(this).val();
                var url = $(this).data("url");
                var image = $('#upload-photo')[0].files[0];
                var form = new FormData();
                var formData = new FormData($('#upload_form')[0]);

                $.ajax({
                    url: url,
                    data: formData,
                    dataType: 'json',
                    async: true,
                    type: 'post',
                    processData: false,
                    contentType: false,
                    beforeSend:function(){
                        // show image here
                        $("#ajax-img").show();
                    },
                    complete:function(){
                        // hide image here
                        $("#ajax-img").hide();
                    },
                    success: function (response) {

                        $("#user_img").attr("src", "{{ asset('assets/images/profiles') }}/" + response['filename']);
                        $("#ajax-img").hide();
                    },
                    error: function (xhr, ajaxOptions, thrownError) {
                        $("#ajax-img").hide();
                    }

                });

            });
        });

        function addrole(url) {
            $.ajax({
                type: "POST",
                dataType: "text",
                url: url,
                data: {
                    "_token": "{{ csrf_token() }}",
                },
                success: function (response) {
                    location.reload();
                    
                },
                error: function (err) {
                    // console.log("AJAX error in request: " + JSON.stringify(err, null, 2));
                }
            })

        }

        function removerole(url) {
            $.ajax({
                type: "POST",
                dataType: "text",
                url: url,
                data: {
                    "_token": "{{ csrf_token() }}",
                },
                success: function (response) {
                    location.reload();
                },
                error: function (err) {
                    // console.log("AJAX error in request: " + JSON.stringify(err, null, 2));
                }
            })

        }
    </script>

    <script>
        $(document).ready(function() {
            var percent=$('#profilepercent').val();
            $(".progress-bar").loading();
        });


    </script>


@endsection

