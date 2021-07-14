@section('header_styles')
<style>
.profile-pic {
    width: 100px;
    height: 100px;
}
</style>
@endsection
<div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
    <label for="name" class="col-md-2 control-label">Name</label>
    <div class="col-md-10">
        <input class="form-control" name="name" type="text" id="name" value="{{ old('name', optional($user)->name) }}" minlength="1" maxlength="250" required="true" placeholder="Enter name here...">
        {!! $errors->first('name', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group {{ $errors->has('email') ? 'has-error' : '' }}">
    <label for="email" class="col-md-2 control-label">Email</label>
    <div class="col-md-10">
        <input class="form-control" name="email" type="text" id="email" value="{{ old('email', optional($user)->email) }}" minlength="1" maxlength="25" required="true" placeholder="Enter email here...">
        {!! $errors->first('email', '<p class="help-block">:message</p>') !!}
    </div>
</div>


<div class="form-group {{ $errors->has('mobile') ? 'has-error' : '' }}">
    <label for="mobile" class="col-md-2 control-label">Mobile</label>
    <div class="col-md-10">
        <input class="form-control" name="mobile" type="text" id="mobile" value="{{ old('mobile', optional($user)->mobile) }}" maxlength="50" placeholder="Enter mobile here...">
        {!! $errors->first('mobile', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group {{ $errors->has('gender') ? 'has-error' : '' }}">
    <label for="gender" class="col-md-2 control-label">Gender</label>
    <div class="col-md-10">
        <select class="form-control" id="gender" name="gender">
        	    <option value="" style="display: none;" {{ old('gender', optional($user)->gender ?: '') == '' ? 'selected' : '' }} disabled selected>Enter gender here...</option>
        	@foreach (['M' => 'M',
'F' => 'F',
'' => ''] as $key => $text)
			    <option value="{{ $key }}" {{ old('gender', optional($user)->gender) == $key ? 'selected' : '' }}>
			    	{{ $text }}
			    </option>
			@endforeach
        </select>
        
        {!! $errors->first('gender', '<p class="help-block">:message</p>') !!}
    </div>
</div>

@if($user !== null)
<div class="form-group {{ $errors->has('update_password') ? 'has-error' : '' }}">
    <label for="update_password" class="col-md-2 control-label">New Password</label>
    <div class="col-md-10">
        <input class="form-control" name="update_password" type="text" id="update_password" value="{{ old('update_password') }}" maxlength="500" placeholder="Enter new password here...">
        {!! $errors->first('update_password', '<p class="help-block">:message</p>') !!}
    </div>
</div>
@else
<div class="form-group {{ $errors->has('password') ? 'has-error' : '' }}">
    <label for="password" class="col-md-2 control-label">Password</label>
    <div class="col-md-10">
        <input class="form-control" name="password" type="text" id="password" value="{{ old('password') }}" maxlength="500" placeholder="Enter password here...">
        {!! $errors->first('password', '<p class="help-block">:message</p>') !!}
    </div>
</div>
@endif
<div class="form-group {{ $errors->has('user_image') ? 'has-error' : '' }}">
    <label for="user_image" class="col-md-2 control-label">User Image</label>
      <div class="col-md-10">
        <div class="pro-img ch-pic">
            @if(isset($user->user_image) && !empty($user->user_image))
                @if (strlen($user->user_image) > 0 && File::exists(public_path()."/assets/images/profiles/".$user->user_image))
                    <img class="profile-pic" width="50" src="{{ asset('assets/images/profiles') }}/{{  $user->user_image }}" alt="{{ $user->name }}">
                @else
                    <img class="profile-pic" src="{{ asset('uploads/profile') }}/profile_img.jpg" alt="{{ $user->name }}">
                @endif
            @else
                <img class="profile-pic" src="{{ asset('uploads/profile') }}/profile_img.jpg" alt="">
            @endif
            <input class="file-upload-nw" name="user_image" id="user_image" type="file" accept="image/*" />
            {{-- <a href="javascript:;" class="change-pic">@lang('profile.upload_profile_picture')</a> --}}
        </div>
        <p id="profileError" style="display:none; color:#FF0000;"> Accept only Image </p>
    </div>
</div>


<div class="form-group {{ $errors->has('isactive') ? 'has-error' : '' }}">
    <label for="isactive" class="col-md-2 control-label">Isactive</label>
    <div class="col-md-10">
        <div class="checkbox">
            <label for="isactive_1">
            	<input id="isactive_1" class="" name="isactive" type="checkbox" value="1" {{ old('isactive', optional($user)->isactive) == '1' ? 'checked' : '' }}>
                Yes
            </label>
        </div>

        {!! $errors->first('isactive', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group {{ $errors->has('isverified') ? 'has-error' : '' }}">
    <label for="isverified" class="col-md-2 control-label">Isverified</label>
    <div class="col-md-10">
        <div class="checkbox">
            <label for="isverified_1">
            	<input id="isverified_1" class="" name="isverified" type="checkbox" value="1" {{ old('isverified', optional($user)->isverified) == '1' ? 'checked' : '' }}>
                Yes
            </label>
        </div>

        {!! $errors->first('isverified', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group {{ $errors->has('grade_id') ? 'has-error' : '' }}">
    <label for="grade_id" class="col-md-2 control-label">Grade</label>
    <div class="col-md-10">
        <select class="form-control" id="grade_id" name="grade_id">
        	    <option value="" style="display: none;" {{ old('grade_id', optional($user)->grade_id ?: '') == '' ? 'selected' : '' }} disabled selected>Select grade</option>
        	@foreach ($grades as $key => $grade)
			    <option value="{{ $key }}" {{ old('grade_id', optional($user)->grade_id) == $key ? 'selected' : '' }}>
			    	{{ $grade }}
			    </option>
			@endforeach
        </select>
        
        {!! $errors->first('grade_id', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group {{ $errors->has('school_id') ? 'has-error' : '' }}">
    <label for="school_id" class="col-md-2 control-label">School</label>
    <div class="col-md-10">
        <select class="form-control" id="school_id" name="school_id">
        	    <option value="" style="display: none;" {{ old('school_id', optional($user)->school_id ?: '') == '' ? 'selected' : '' }} disabled selected>Select school</option>
        	@foreach ($schools as $key => $school)
			    <option value="{{ $key }}" {{ old('school_id', optional($user)->school_id) == $key ? 'selected' : '' }}>
			    	{{ $school }}
			    </option>
			@endforeach
        </select>
        
        {!! $errors->first('school_id', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group {{ $errors->has('parent_id') ? 'has-error' : '' }}">
    <label for="parent_id" class="col-md-2 control-label">Parent</label>
    <div class="col-md-10">
        <select class="form-control" id="parent_id" name="parent_id">
        	    <option value="" style="display: none;" {{ old('parent_id', optional($user)->parent_id ?: '') == '' ? 'selected' : '' }} disabled selected>Select parent</option>
        	@foreach ($parents as $key => $parent)
			    <option value="{{ $key }}" {{ old('parent_id', optional($user)->parent_id) == $key ? 'selected' : '' }}>
			    	{{ $parent }}
			    </option>
			@endforeach
        </select>
        
        {!! $errors->first('parent_id', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group {{ $errors->has('country_id') ? 'has-error' : '' }}">
    <label for="country_id" class="col-md-2 control-label">Country</label>
    <div class="col-md-10">
        <select class="form-control" id="country_id" name="country_id">
        	    <option value="" style="display: none;" {{ old('country_id', optional($user)->country_id ?: '') == '' ? 'selected' : '' }} disabled selected>Enter country here...</option>
        	@foreach ($countries as $key => $country)
			    <option value="{{ $key }}" {{ old('country_id', optional($user)->country_id) == $key ? 'selected' : '' }}>
			    	{{ $country }}
			    </option>
			@endforeach
        </select>
        
        {!! $errors->first('country_id', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group {{ $errors->has('uilanguage_id') ? 'has-error' : '' }}">
    <label for="uilanguage_id" class="col-md-2 control-label">Uilanguage</label>
    <div class="col-md-10">
        <select class="form-control" id="uilanguage_id" name="uilanguage_id">
        	    <option value="" style="display: none;" {{ old('uilanguage_id', optional($user)->uilanguage_id ?: '') == '' ? 'selected' : '' }} disabled selected>Enter UI preferred Language here...</option>
        	@foreach ($uilanguages as $key => $uilanguage)
			    <option value="{{ $key }}" {{ old('uilanguage_id', optional($user)->uilanguage_id) == $key ? 'selected' : '' }}>
			    	{{ $uilanguage }}
			    </option>
			@endforeach
        </select>
        
        {!! $errors->first('uilanguage_id', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group {{ $errors->has('dob') ? 'has-error' : '' }}">
    <label for="dob" class="col-md-2 control-label">Date of Birth</label>
    <div class="col-md-10">
       <input class="form-control" name="dob" type="date" id="dob" value="{{old('dob', optional($user)->dob)}}" placeholder="Enter Date of Birth here...">
        {!! $errors->first('dob', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group {{ $errors->has('lastloggedon') ? 'has-error' : '' }}">
    <label for="lastloggedon" class="col-md-2 control-label">Lastloggedon</label>
    <div class="col-md-10">
        <input class="form-control" name="lastloggedon" type="text" id="lastloggedon" value="{{ old('lastloggedon', optional($user)->lastloggedon) }}" disabled placeholder="Automatically updated...">
        {!! $errors->first('lastloggedon', '<p class="help-block">:message</p>') !!}
    </div>
    <label for="registeredon" class="col-md-2 control-label">Registeredon</label>
    <div class="col-md-10">
        <input class="form-control" name="registeredon" type="text" id="registeredon" value="{{ old('registeredon', optional($user)->registeredon) }}" disabled placeholder="Automatically updated...">
        {!! $errors->first('registeredon', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group {{ $errors->has('phone') ? 'has-error' : '' }}">
    <label for="phone" class="col-md-2 control-label">Phone</label>
    <div class="col-md-10">
        <input class="form-control" name="phone" type="text" id="phone" value="{{ old('phone', optional($user)->phone) }}" maxlength="50" placeholder="Enter phone here...">
        {!! $errors->first('phone', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group {{ $errors->has('parentmail') ? 'has-error' : '' }}">
    <label for="parentmail" class="col-md-2 control-label">Parentmail</label>
    <div class="col-md-10">
        <input class="form-control" name="parentmail" type="text" id="parentmail" value="{{ old('parentmail', optional($user)->parentmail) }}" maxlength="250" placeholder="Enter parentmail here...">
        {!! $errors->first('parentmail', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group {{ $errors->has('isapproved_byparent') ? 'has-error' : '' }}">
    <label for="isapproved_byparent" class="col-md-2 control-label">Isapproved Byparent</label>
    <div class="col-md-10">
        <div class="checkbox">
            <label for="isapproved_byparent_1">
            	<input id="isapproved_byparent_1" class="" name="isapproved_byparent" type="checkbox" value="1" {{ old('isapproved_byparent', optional($user)->isapproved_byparent) == '1' ? 'checked' : '' }}>
                Yes
            </label>
        </div>

        {!! $errors->first('isapproved_byparent', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group {{ $errors->has('isintroinfo_displayed') ? 'has-error' : '' }}">
    <label for="isintroinfo_displayed" class="col-md-2 control-label">Isintroinfo Displayed</label>
    <div class="col-md-10">
        <div class="checkbox">
            <label for="isintroinfo_displayed_1">
            	<input id="isintroinfo_displayed_1" class="" name="isintroinfo_displayed" type="checkbox" value="1" {{ old('isintroinfo_displayed', optional($user)->isintroinfo_displayed) == '1' ? 'checked' : '' }}>
                Yes
            </label>
        </div>

        {!! $errors->first('isintroinfo_displayed', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group {{ $errors->has('passwordtoken') ? 'has-error' : '' }}">
    <label for="passwordtoken" class="col-md-2 control-label">Passwordtoken</label>
    <div class="col-md-10">
        <input class="form-control" name="passwordtoken" type="text" id="passwordtoken" value="{{ old('passwordtoken', optional($user)->passwordtoken) }}" maxlength="500" placeholder="Enter passwordtoken here...">
        {!! $errors->first('passwordtoken', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group {{ $errors->has('registeredby') ? 'has-error' : '' }}">
    <label for="registeredby" class="col-md-2 control-label">Registeredby</label>
    <div class="col-md-10">
        <select class="form-control" id="registeredby" name="registeredby" required="true">
        	    <option value="" style="display: none;" {{ old('registeredby', optional($user)->registeredby ?: '') == '' ? 'selected' : '' }} disabled selected>Enter registeredby here...</option>
        	@foreach (['email' => 'Email', 'facebook' => 'Facebook','google' => 'Google','' => ''] as $key => $text)
			    <option value="{{ $key }}" {{ old('registeredby', optional($user)->registeredby) == $key ? 'selected' : '' }}>
			    	{{ $text }}
			    </option>
			@endforeach
        </select>
        
        {!! $errors->first('registeredby', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group {{ $errors->has('totalpoints') ? 'has-error' : '' }}">
    <label for="totalpoints" class="col-md-2 control-label">Totalpoints</label>
    <div class="col-md-10">
        <input class="form-control" name="totalpoints" type="number" id="totalpoints" value="{{ old('totalpoints', optional($user)->totalpoints) }}" min="-2147483648" max="2147483647" required="true" placeholder="Enter totalpoints here...">
        {!! $errors->first('totalpoints', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group {{ $errors->has('remember_token') ? 'has-error' : '' }}">
    <label for="remember_token" class="col-md-2 control-label">Remember Token</label>
    <div class="col-md-10">
        <input class="form-control" name="remember_token" type="text" id="remember_token" value="{{ old('remember_token', optional($user)->remember_token) }}" maxlength="100" placeholder="Enter remember token here...">
        {!! $errors->first('remember_token', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group {{ $errors->has('quota') ? 'has-error' : '' }}">
    <label for="quota" class="col-md-2 control-label">Quota in KB</label>
    <div class="col-md-10">
        <input class="form-control" name="quota" type="number" id="quota" value="{{ old('quota', optional($user)->quota) }}" maxlength="50" placeholder="Enter quota here...">
        {!! $errors->first('quota', '<p class="help-block">:message</p>') !!}
    </div>
</div>

@section('footer_scripts')
<script>
/*profile-upload*/
$(document).ready(function() {
    var readURL = function(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                $('.profile-pic').attr('src', e.target.result);
            }

            reader.readAsDataURL(input.files[0]);
        }
    }
    $(".file-upload-nw").on('change', function(){
        readURL(this);
    });

    $(".profile-pic").on('click', function() {
        $(".file-upload-nw").click();
    });
    $(".change-pic").on('click', function() {
        $(".file-upload-nw").click();
    });

});
</script>
@endsection