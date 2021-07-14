@extends('authenticated.layouts.default')
@section('header_styles')
<style>

    .plan-template .card{
        border: 0;
        box-shadow: 3px 4px 12px #ddd;
        text-align: center;
    }

    .plan-template .card-header{
        border: 0;
        background: #ff9128;
        color : #fff;
        text-transform: uppercase;
        letter-spacing: 4px;
        
    }

    .plan-template .card-header h2{
        font-size: 21px !important;
        font-weight: lighter;
    }

    .plan-template ul{
        text-align: left;
        padding:0;
    }

    .plan-template ul li{
        padding-left: 15px;
        list-style-type: none;
    }

</style>
@endsection
@section('content')
    @include('eduplaycloud.users.welcome-header')
<div class="tabs_my_profile" id="profilePage">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-12 col-xl-12">
                <div class="content_tabs_iner text-ar-right">
                <ul class="tabs_menu nav nav-pills mb-3" id="pills-tab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="pills-home-tab" data-toggle="pill" href="#pills-home" role="tab" aria-controls="pills-home" aria-selected="true">@lang('profile.my_profile')</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="pills-profile-tab" data-toggle="pill" href="#pills-profile" role="tab" aria-controls="pills-profile" aria-selected="false">@lang('profile.linked_profiles')</a>
                    </li>
                    <li class="nav-item m3">
                        <a class="nav-link" id="pills-bdget-tab" data-toggle="pill" href="#pills-contact" role="tab" aria-controls="pills-contact" aria-selected="false">@lang('profile.badges')</a>
                    </li>
                    <li class="nav-item ">
                        <a class="nav-link" id="pills-avatar-tab" data-toggle="pill" href="#pills-avtar" role="tab" aria-controls="pills-avtar" aria-selected="false">@lang('profile.avatar')</a>
                    </li>
                    <li class="nav-item ">
                        <a class="nav-link" id="pills-interests-tab" data-toggle="pill" href="#pills-interests" role="tab" aria-controls="pills-interests" aria-selected="false">My Interests</a>
                    </li>
                    <li class="nav-item ">
                        <a class="nav-link" id="pills-subscription-tab" data-toggle="pill" href="#pills-subscription" role="tab" aria-controls="pills-subscription" aria-selected="false">Subscriptions</a>
                    </li>
                </ul>
                {{-- for session message --}}
                @if(Session::has('success_message'))
                    <div class="alert alert-success">
                        <i class="fa fa-check-square-o" aria-hidden="true"></i>
                        {!! session('success_message') !!}
                        <button type="button" class="close" data-dismiss="alert" aria-label="close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <br />
                @endif
                @if(Session::has('info_message'))
                <div class="alert alert-info">
                    <i class="fa fa-check-square-o" aria-hidden="true"></i>
                    {!! session('info_message') !!}
                    <button type="button" class="close" data-dismiss="alert" aria-label="close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <br />
                @endif
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
                @if ( count(Auth::user()->parent_requests_for_child) > 0 && Auth::user()->hasRole('Learner') )
                    @foreach (Auth::user()->parent_requests_for_child as $parent_request)
                        @if ( !$parent_request->approved )
                            <div class="alert alert-info">
                                <i class="fa fa-bell" aria-hidden="true"></i>
                                <span> `{{ $parent_request->parent->email }}` sent you a parent request, 
                                    <a href="{{ route('approveParentRequest', $parent_request->id) }}">Click here </a>
                                 to approve it.</span>
                                <button type="button" class="close" data-dismiss="alert" aria-label="close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        @endif
                    @endforeach
                @endif
                {{-- session message end --}}
                <div class="tp_tab_cntnt tab-content" id="pills-tabContent">
                    <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
                        <form enctype="multipart/form-data" class="def_form" id="profile" action="{{ route('users.update.user' ,$user->id) }}" method="post">
                            @csrf
                            <div class="row">
                                <div class="col-md-5">
                                    <div class="basic-detail mrgn_btm_100">
                                        <h6 class="basic_title">@lang('profile.basic_details')</h6>
                                        <div class="form-group">
                                            <label>@lang('profile.registered_on') :</label>
                                            <input type="text" class="form-control" value="{{ old('created_at', optional($user)->created_at) }}" id="registeredOn" readonly="readonly">
                                        </div>
                                        <div class="form-group mrgn_tp_60">
                                            <ul class="teacher-action">
                                                <li><label class="role_lbl">@lang('profile.roles') :</label></li>
                                                <li class="teacherLi">
                                                    <div class="custom-control custom-checkbox">
                                                        @if ($user->hasRole('Teacher'))
                                                            <input name="role[]" value="2" id="Teachers" type="checkbox" class="custom-control-input" {{ $user->hasRole('Teacher') ? 'checked' : '' }} onclick="removerole('{{ route('users.user.removerole',[$user->id, 'Teacher']) }}')">
                                                        @else
                                                            <input name="role[]" value="2" id="Teachers" type="checkbox" class="custom-control-input" {{ $user->hasRole('Teacher') ? 'checked' : '' }} onclick="addrole('{{ route('users.user.addrole',[$user->id, 'Teacher']) }}')">
                                                        @endif
                                                        <label class="custom-control-label" for="Teachers">@lang('profile.teacher')</label>
                                                    </div>
                                                </li>
                                                <li>
                                                    <div class="custom-control custom-checkbox">
                                                        @if ($user->hasRole('Learner'))
                                                            <input name="role[]" value="1" id="Learners" type="checkbox" class="custom-control-input" {{ $user->hasRole('Learner') ? 'checked' : '' }} onclick="removerole('{{ route('users.user.removerole',[$user->id, 'Learner']) }}')">
                                                        @else
                                                            <input name="role[]" value="1" id="Learners" type="checkbox" class="custom-control-input" {{ $user->hasRole('Learner') ? 'checked' : '' }} onclick="addrole('{{ route('users.user.addrole',[$user->id, 'Learner']) }}')">
                                                        @endif
                                                        <label class="custom-control-label" for="Learners">@lang('profile.learner')</label>
                                                    </div>
                                                </li>
                                                <li class="parentLi">
                                                    <div class="custom-control custom-checkbox">
                                                        @if ($user->hasRole('Parent'))
                                                            <input name="role[]" value="3" id="Parents" type="checkbox" class="custom-control-input" {{ $user->hasRole('Parent') ? 'checked' : '' }} onclick="removerole('{{ route('users.user.removerole',[$user->id,'Parent']) }}')">
                                                        @else
                                                            <input name="role[]" value="3" id="Parents" type="checkbox" class="custom-control-input" {{ $user->hasRole('Parent') ? 'checked' : '' }} onclick="addrole('{{ route('users.user.addrole',[$user->id, 'Parent']) }}')">
                                                        @endif
                                                        <label class="custom-control-label" for="Parents">@lang('profile.parent')</label>
                                                    </div>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-2"></div>
                                <div class="col-md-5">
                                    <div class="prefrence mrgn_btm_100">
                                        <h6 class="basic_title">@lang('profile.preferences')</h6>
                                        {{-- <div class="form-group">
                                            <div class="df-select">
                                                <label>@lang('profile.grade') :</label>
                                                <select class="selectpicker" id="grade_id" name="grade_id">
                                                    <option value="" style="display: none;" {{ old('grade_id', optional($user)->grade_id ?: '') == '' ? 'selected' : '' }} disabled selected>@lang('Grade')</option>
                                                    @foreach ($grades as $key => $grade)
                                                        <option value="{{ $grade->id }}" {{ old('grade_id', optional($user)->grade_id) == $grade->id ? 'selected' : '' }}>
                                                            {{ $grade->grade_name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div> --}}
                                        <div class="form-group mrgn-tp-30">
                                            <div class="df-select">
                                                <label>@lang('profile.ui_preferred_language') :</label>
                                                <select class="selectpicker" id="uilanguage_id" name="uilanguage_id">
                                                    <option value="" style="display: none;" {{ old('uilanguage_id', optional($user)->uilanguage_id ?: '') == '' ? 'selected' : '' }} disabled selected>@lang('user.Enter UI preferred Language here...')</option>
                                                    @foreach ($uilanguages as $key => $uilanguage)
                                                        <option value="{{ $uilanguage->id }}" {{ old('uilanguage_id', optional($user)->uilanguage_id) == $uilanguage->id ? 'selected' : '' }}>
                                                            {{ $uilanguage->language }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="persnol-detail mrgn_btm_100">
                                        <h6 class="basic_title">@lang('profile.personal_details')</h6>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="pro-img ch-pic">
                                                    @php
                                                        $user=Auth::user();
                                                    @endphp
                                                    @if(strtolower($user->provider) == 'facebook' || strtolower($user->provider) == 'google')
                                                        <img class="profile-pic" src="{{ $user->user_image }}" alt="{{ $user->name }}">
                                                    @elseif(isset($user->user_image) && !empty($user->user_image))
                                                        @if (strlen($user->user_image) > 0 && File::exists(public_path()."/assets/images/profiles/".$user->user_image))
                                                            <img class="profile-pic" width="50" src="{{ asset('assets/images/profiles') }}/{{  $user->user_image }}" alt="{{ $user->name }}">
                                                        @else
                                                            <img class="profile-pic" src="{{ asset('uploads/profile') }}/profile_img.jpg" alt="{{ $user->name }}">
                                                        @endif
                                                    @else
                                                        <img class="profile-pic" src="{{ asset('uploads/profile') }}/profile_img.jpg" alt="{{ $user->name }}">
                                                    @endif
                                                    <input class="file-upload-nw" name="user_image" id="user_image" type="file" accept="image/*" />
                                                    <a href="javascript:;" class="change-pic">@lang('profile.upload_profile_picture')</a>
                                                </div>
                                                <p id="profileError" style="display:none; color:#FF0000;"> Accept only Image </p>
                                            </div>
                                            <div class="col-md-5">
                                                <div class="form-group">
                                                    <label>@lang('profile.name') :</label>
                                                    <input type="text" name="name" id="name" class="form-control" value="{{ old('name', optional($user)->name) }}" placeholder="@lang('profile.name')" maxlength="50" />
                                                </div>
                                            </div>
                                            <div class="col-md-2"></div>
                                            <div class="col-md-5">
                                                <div class="form-group">
                                                    <label>@lang('profile.dob') :</label>
                                                    <input class="form-control" type="text" value="{{  date('d-m-Y', strtotime($user->dob)) }}" placeholder="@lang('profile.dob')" readonly>
                                                </div>
                                            </div>
                                            <div class="col-md-5">
                                                <div class="form-group">
                                                    @if($input_email_type === 'email')
                                                    <label>@lang('profile.email') :</label>
                                                    <input type="email" name="email" id="email" class="form-control" value="{{ old('email', optional($user)->email) }}" placeholder="@lang('profile.email')" maxlength="50" {{ !empty(optional($user)->email) ? "readonly" : "" }}/>
                                                    @else 
                                                    <label>@lang('profile.username') :</label>
                                                    <input type="text" name="username" id="username" class="form-control" value="{{ old('email', optional($user)->email) }}" placeholder="Username Address" maxlength="50"/>
                                                    @endIf
                                                </div>
                                            </div>
                                            <div class="col-md-2"></div>
                                            <div class="col-md-5">
                                                <div class="form-group mtgn_less_btm">
                                                    <label>@lang('profile.password') :</label>
                                                    <input type="password" class="form-control" value="{{ $user->password }} placeholder="@lang('profile.password')" disabled/>
                                                    <div class="text-right">
                                                        <a href="javascript:;" data-toggle="modal" data-target="#rechange_pswrd" data-dismiss="modal" class="chnge-pswrd">@lang('profile.change_password')</a>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-5">
                                                <div class="form-group">
                                                    <label>@lang('profile.mobile_number') :</label>
                                                    <input type="tel" name="mobile" id="mobile"  class="form-control" value="{{ old('mobile', optional($user)->mobile) }}" maxlength="13" />
                                                </div>
                                            </div>
                                            <div class="col-md-2"></div>
                                            <div class="col-md-5">
                                                <div class="form-group">
                                                    <div class="df-select">
                                                        <label>@lang('profile.gender') : </label>
                                                        <select class="selectpicker" id="gender" name="gender">
                                                            <option value="">@lang('profile.gender')</option>
                                                            <option value="M" {{ $user->gender == 'M' ? "selected" : ''}} >@lang('profile.male')</option>
                                                            <option value="F" {{ $user->gender == 'F' ? "selected" : ''}} >@lang('profile.female')</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-5">
                                                <div class="form-group">
                                                    <label>@lang('profile.native_language') : </label>
                                                    <input type="text" name="native_language" id="native_language"  class="form-control" value="{{ old('native_language', optional($user)->native_language) }}" maxlength="50" />
                                                </div>
                                            </div>
                                            <div class="col-md-2"></div>
                                        <div class="col-md-5">
                                            <div class="form-group">
                                                <div class="df-select">
                                                    <label>@lang('profile.country') : </label>
                                                    <select class="selectpicker" id="country_id" name="country_id">
                                                        <option value="" style="display: none;" {{ old('country_id', optional($user)->country_id ?: '') == '' ? 'selected' : '' }} disabled selected>@lang('profile.country')</option>
                                                        @foreach ($countries as $key => $country)
                                                            <option value="{{ $country->id }}" {{ old('country_id', optional($user)->country_id) == $country->id ? 'selected' : '' }}>
                                                                {{ $country->country_name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-5">
                                            <div class="form-group">
                                                <label>@lang('profile.city') : </label>
                                                <input type="text" name="city" id="city"  class="form-control" value="{{ old('city', optional($user)->city) }}" maxlength="50" />
                                            </div>
                                        </div>
                                            <div class="col-md-2"></div>
                                        <div class="col-md-5">
                                            <div class="form-group">
                                                <label>@lang('profile.state') :</label>
                                                <input type="text" name="state" id="state"  class="form-control" value="{{ $user->state }}" maxlength="50" />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="persnol-detail">
                                        <h6 class="basic_title">@lang('profile.professional_details')</h6>
                                        <div class="row">
                                            <div class="col-md-5">
                                                <div class="form-group">
                                                    <label>@lang('profile.linkedin_url') :</label>
                                                    <input type="text" name="linkedin_url" id="linkedin_url" class="form-control" value="{{ old('linkedin_url', optional($user)->linkedin_url) }}" maxlength="255" />
                                                </div>
                                            </div>
                                            <div class="col-md-2"></div>
                                            <div class="col-md-5"></div>
                                            <div class="col-md-5">
                                                <div class="form-group">
                                                    <label>@lang('profile.aboutme') :</label>
                                                    {{--  <input type="text" name="aboutme" id="aboutme" class="form-control" value="{{ old('aboutme', optional($user)->aboutme) }}" maxlength="255" />  --}}
                                                    <textarea name="aboutme" id="aboutme" class="form-control abut-me">{{ old('aboutme', optional($user)->aboutme) }}</textarea>
                                                </div>
                                            </div>
                                            <div class="col-md-2"></div>
                                            <div class="col-md-5"></div>
                                            <div class="col-md-12">
                                                <div class="form-group mrgn-tp-40">
                                                    <button type="submit" id="profileBtn" class="btn btn-primary btn-login add_btn drk_bg_btn">@lang('profile.update')</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab">
                        <div class="linked_profile mrgn-bt-100">
                            <h6 class="child_title">@lang('profile.linked_profiles')</h6>
                            <a class="add_childe" href="{{route('users.user.addchildren',Auth::user())}}">@lang('profile.add_child')</a>
                            @if ( auth()->user()->hasRole("Parent"))
                            <a class="add_childe" href="{{route('createParentRequest')}}">@lang('profile.add_existing_child')</a>
                            @endIf
                            <div class="list_profile_pic">
                                <ul class="link_of_detail">
                                @if(count($children) > 0)
                                    @php
                                        $i=0;
                                    @endphp
                                    @foreach($children as $child)
                                        @php
                                        $i=$i+1;
                                        @endphp
                                        <li>
                                            <div class="profile_persnol">
                                                @php
                                                if (isset($child->user_image) && !empty($child->user_image)) {
                                                    if (strlen($child->user_image) > 0 && File::exists(public_path()."/uploads/profile/".$child->user_image)) {
                                                        $childImage = $child->user_image;
                                                    } else {
                                                        $childImage = 'proflie_welcome.png';
                                                    }
                                                } else {
                                                    $childImage = 'proflie_welcome.png';
                                                }
                                                @endphp
                                                <img src="{{ asset('uploads/profile') }}/{{ $childImage }}" class="img-fluid">
                                                <h3>{{ $child->name }}</h3>
                                                <h6>{{ $child->email }}</h6>
                                                @php
                                                    $lastLoggedOn = $child->lastloggedon;
                                                    $lastLoggedOnArr = explode(' ', $lastLoggedOn);
                                                    $date1 = strtr($lastLoggedOnArr[0], '/', '-');
                                                    $fd=date('d/m/Y', strtotime($date1));
                                                @endphp
                                                <p>@lang('profile.created_on'):{{ $fd }} 
                                                    {{--  @lang('profile.at') {{ $lastLoggedOnArr[1] }} @if($lastLoggedOnArr[2] == 'PM')  @lang('profile.PM')  @elseif($lastLoggedOnArr[2] == 'AM') @lang('profile.AM') @else {{ $lastLoggedOnArr[2] }} @endif  --}}
                                                 </p>
                                                <ul class="editable_list">
                                                    <li><a class="edit_wt_icn m2" href="{{route('invitedusers.inviteduser.editchild',[$child->id])}}">@lang('profile.edit')</a></li>
                                                    <li><a class="delet_wt_icn" href="javascript:void(0)" onclick="isconfirm({{$child->id}})" >@lang('profile.delete')</a></li>
                                                </ul>
                                            </div>
                                        </li>
                                        @if($i === 5)
                                            <div class="clearfix"></div>
                                            @php $i=0; @endphp
                                        @endif
                                    @endforeach
                                @else 
                                <li>
                                    <p>@lang('profile.no_child_available') !!</p>
                                </li>
                                @endif
                                    {{-- <div class="clearfix"></div> --}}
                                </ul>
                                <div class="clearfix"></div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="pills-contact" role="tabpanel" aria-labelledby="pills-contact-tab">
                        <div class="bagets">
                            <div class="inner_level_badgets mrgn-bt-30">
                                <h5 class="level_title mrgn-bt-50">@lang('profile.levels')</h5>
                                <ul class="level_of_games">
                                    {{--  $levels as $level  --}}
                                    @forelse ($badgesAll as $badgeget)
                                        <li>
                                            {{-- For future condition for level icons
                                                @if(done)
                                                done
                                            @elseif(currentt)
                                                currentt
                                            @else
                                                loack
                                            @endif  --}}

                                            <div class="list_of_level done">
                                                <i class="icon-lvl"></i>
                                                @if( $badgeget->badge_info == "learning")
                                                    <h6>{{ $badgeget->badge_info }}</h6>
                                                    @break
                                                @endif
                                            </div>
                                        </li>
                                    @empty
                                        <p>@lang('profile.no_levels_available')</p>
                                    @endforelse
                                    <div class="clearfix"></div>
                                </ul>
                                <div class="clearfix"></div>
                            </div>
                            <div class="earned_level_badgets mrgn-bt-30">
                                <h5 class="level_title mrgn-bt-50">@lang('profile.earned_badges')</h5>
                                @php
                                    $earnedBadgesCounter = 1;
                                @endphp
                                <ul class="badget_earned">
                                    @forelse ($earnedBadges as $badge)
                                        @if($badge->badgetitle != '' || $badge->badgedescription != '')
                                            <li>
                                                <div class="point_earn red">
                                                    <i class="icon_bdget 
                                                    @if($badge->type == 'point')
                                                        red_icon
                                                    @elseif($badge->type == 'activity')
                                                        green_icon
                                                    @else
                                                        blue_icon
                                                    @endif
                                                    "></i>
                                                    <h4>{{ $badge->badgetitle }}</h4>
                                                    @if($badge->type == 'point')
                                                        <h6>{{ $badge->points }} Points</h6>
                                                    @elseif($badge->type == 'activity')
                                                        {{--  <h6>{{ ucfirst($badge->type) }}</h6>  --}}
                                                    @else
                                                        <h6>{{ ucfirst($badge->skill_type) }}</h6>
                                                    @endif
                                                    <p>{{ $badge->badgedescription }}</p>
                                                </div>
                                            </li>
                                        @endif
                                        @php
                                            if ($earnedBadgesCounter % 4 === 0):
                                                echo '';
                                            endif;
                                            $earnedBadgesCounter++;
                                        @endphp
                                    @empty
                                        <li><p class="text-left">@lang('profile.no_earned_badges_available')</p></li>
                                    @endforelse
                                    <div class="clearfix"></div>
                                </ul>
                                <div class="clearfix"></div>
                            </div>
                            <div class="earned_level_badgets">
                                <h5 class="level_title mrgn-bt-50">@lang('profile.badges')</h5>
                                <ul class="badget_earned">
                                    @php
                                        $badgesCounter = 1;
                                    @endphp
                                    @forelse ($badgesAll as $badgeget)
                                        <li>
                                            <div class="point_earn red">
                                                <i class="icon_bdget 
                                                @if($badgeget->badge_type == 'point')
                                                        red_icon
                                                    @elseif($badgeget->badge_type == 'activity')
                                                        green_icon
                                                    @else
                                                        blue_icon
                                                    @endif
                                                "></i>
                                                <h4>{{ $badgeget->badgetitle }}</h4>
                                                @if($badgeget->badge_type == 'point')
                                                    <h6>{{ $badgeget->points }} Points</h6>
                                                @elseif($badgeget->badge_type == 'activity')
                                                    <h6>{{ ucfirst($badgeget->badge_type) }}</h6>
                                                @else
                                                    <h6>{{ ucfirst($badgeget->badge_type) }}</h6>
                                                @endif
                                                <p>{{ $badgeget->badgedescription }}</p>
                                                {{--  <h6>{{ $badgeget->points }} @lang('profile.points')</h6>  --}}
                                            </div>
                                        </li>
                                        @php
                                            if ($badgesCounter % 4 === 0):
                                                echo '';
                                            endif;
                                            $badgesCounter++;
                                        @endphp
                                    @empty
                                        <p class="col-md-12">@lang('profile.no_badges_available')</p>
                                    @endforelse
                                    <div class="clearfix"></div>
                                </ul>
                                <div class="clearfix"></div>
                            </div>
                        </div>
                    </div>
                    @include('eduplaycloud.users.avatar',$avatarList)
                    <div class="tab-pane fade" id="pills-interests" role="tabpanel" aria-labelledby="pills-interests-tab">
                        <div class="row">
                            <div class="col-md-8">
                                @include('eduplaycloud.users.profile-interests')
                            </div>
                        </div>
                    </div>

                    <div class="tab-pane fade" id="pills-subscription" role="tabpanel" aria-labelledby="pills-subscription-tab">
                        <div class="row">
                            <div class="col-md-8">
                                @include('eduplaycloud.users.profile-subscriptions')
                            </div>
                        </div>
                    </div>
                    
                </div>
            </div>
            </div>
        </div>
    </div>
</div>

<!--change-password-->
<div class="modal fade default_modal" id="rechange_pswrd" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content img_fr_frgtpswd">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12 col-lg-6 col-csm-45">
                        <div class="left_contnt text-ar-right">
                        </div>
                    </div>
                    <div class="col-md-12 col-lg-6 col-csm-55">
                        <div class="right_contnt sign_up_info logn_info text-ar-right">
                            <h3>@lang('profile.change_password')</h3>
                            <form name="frmChangePassword" id="frmChangePassword" class="def_form">
                                <div class="form-group">
                                    <input type="password" name="old_password" id="old_password" class="form-control" placeholder="@lang('profile.old_password')">
                                </div>
                                <div class="form-group">
                                    <input type="password" name="profile_password" id="profile_password" class="form-control" placeholder="@lang('profile.new_password')" maxlength="13">
                                </div>
                                <div class="form-group">
                                    <input type="password" name="conform_password" id="conform_password" class="form-control" placeholder="@lang('profile.confirm_new_password')" maxlength="13">
                                </div>
                                <div class="form-group chnge_rst_mrgn">
                                    <button type="submit" class="btn btn-primary btn-login">@lang('profile.change')</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!--avatar-model-->
<div class="modal fade width-700-model default_modal wht_bg_mdl" id="avatar_model" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content text-ar-right">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
            <div class="modal-body">
                <h3 class="exam_title">@lang('profile.customised_avatar')</h3>
                <form name="frmApplyAvatar" id="frmApplyAvatar" class="def_form" method="POST" action="{{ route('update-avatar') }}">
                    {{ csrf_field() }}
                    <input type="hidden" id="avatar_id" name="avatar_acc_id" value=""/>
                    <div id="main_area">
                        
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

<?php /*Load jquery to footer section*/ ?>
@push('inc_script')
    <script type="text/javascript" src="{{ asset('assets/eduplaycloud/customs/js/jquery-validate/jquery.validate.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/eduplaycloud/customs/js/block-ui/jquery.blockUI.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/eduplaycloud/customs/js/sweetalert/sweetalert.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/eduplaycloud/js/circlos.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/eduplaycloud/customs/js/pages/profile/details.js') }}"></script>
@endpush

<?php /*Load jquery to footer section*/ ?>
@push('inc_jquery')
<script>
    var userAges={{ $checkuserAge }};
    if(userAges <= 13){
        $(".teacherLi, .parentLi").hide();
    }
    $(function() {
        var hash = window.location.hash;
        hash && $('.tabs_my_profile ul.nav a[href="' + hash + '"]').tab('show');

        $('.tabs_my_profile .nav a').click(function (e) {
            $(this).tab('show');
            window.location.hash = this.hash;
        });
    });

    //Profile birth date
    $(function () {
         $('#profile_dob').datetimepicker({
            maxDate: 'now',
            format: 'DD/MM/YYYY',
        });
    });

    // Avatar 
    function avatarDetails(id) {
    
        $('#avatar_model').modal('show');
        
        // Get avatar accessories
        $.ajax({
            type: "GET",
            url: site_url + '/avatars/accessories/' + id,
            success: function (response) {
                $('#main_area').html(response);
            }
        });
    }

    // Submit Avatar Form
    function submitAvatar() {
        var status = $('#apply_button').data('status');
        if (status == 'locked') {
            $("#myCarousel").carousel('pause');   // Pause the carousel
            swal({
                text: "@lang('profile.you_are_not_allowed_to_apply')",
                icon: 'error',
                button: {
                    text: '@lang("profile.ok")',
                },
                dangerMode : true,
            }).then(function() {
                $("#myCarousel").carousel('cycle');   // Start the carousel
            });
            
        } else {
            $('#frmApplyAvatar').submit();
        }
    }

    //Delete Child
    function isconfirm(id){
        swal({
            text: "@lang('profile.sure_delete')",
            icon: "warning",
            buttons: [
              '@lang("exam.cancel_it")',
              '@lang("exam.sure")'
            ],
            dangerMode: true,
          }).then(function(isConfirm) {
            if (isConfirm) {
                window.location.href = site_url+'/users/deletechild/'+id;
            }
          })
      }
      
</script>
@endpush