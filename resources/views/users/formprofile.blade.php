


<div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
    <label for="name" class="col-md-2 control-label">@lang('user.Name')</label>
    <div class="col-md-10">
        <input class="form-control" name="name" type="text" id="name" value="{{ old('name', optional($user)->name) }}" minlength="1" maxlength="250" required="true" placeholder="@lang('use.Enter name here...')">
        {!! $errors->first('name', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group {{ $errors->has('email') ? 'has-error' : '' }}">
    <label for="email" class="col-md-2 control-label">@lang('user.Email')</label>
    <div class="col-md-10">
        <input class="form-control" name="email" type="text" id="email" value="{{ old('email', optional($user)->email) }}" minlength="1" maxlength="25" required="true" placeholder="@lang('user.Enter email here...')">
        {!! $errors->first('email', '<p class="help-block">:message</p>') !!}
    </div>
</div>


<div class="form-group {{ $errors->has('mobile') ? 'has-error' : '' }}">
    <label for="mobile" class="col-md-2 control-label">@lang('user.Mobile')</label>
    <div class="col-md-10">
        <input class="form-control" name="mobile" type="text" id="mobile" value="{{ old('mobile', optional($user)->mobile) }}" maxlength="50" placeholder="@lang('user.Enter mobile here...')">
        {!! $errors->first('mobile', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group {{ $errors->has('gender') ? 'has-error' : '' }}">
    <label for="gender" class="col-md-2 control-label">@lang('user.Gender')</label>
    <div class="col-md-10">
        <select class="form-control" id="gender" name="gender">
        	    <option value="" style="display: none;" {{ old('gender', optional($user)->gender ?: '') == '' ? 'selected' : '' }} disabled selected>@lang('user.Enter gender here...')</option>
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


<div class="form-group {{ $errors->has('grade_id') ? 'has-error' : '' }}">
    <label for="grade_id" class="col-md-2 control-label">@lang('user.grade')</label>
    <div class="col-md-10">
        <select class="form-control" id="grade_id" name="grade_id">
            <option value="" style="display: none;" {{ old('grade_id', optional($user)->grade_id ?: '') == '' ? 'selected' : '' }} disabled selected>@lang('user.Enter your grade here...')</option>
            @foreach ($grades as $key => $grade)
                <option value="{{ $key }}" {{ old('grade_id', optional($user)->grade_id) == $key ? 'selected' : '' }}>
                    {{ $grade }}
                </option>
            @endforeach
        </select>

        {!! $errors->first('country_id', '<p class="help-block">:message</p>') !!}
    </div>
</div>


<div class="form-group {{ $errors->has('country_id') ? 'has-error' : '' }}">
    <label for="country_id" class="col-md-2 control-label">@lang('user.Country')</label>
    <div class="col-md-10">
        <select class="form-control" id="country_id" name="country_id">
        	    <option value="" style="display: none;" {{ old('country_id', optional($user)->country_id ?: '') == '' ? 'selected' : '' }} disabled selected>@lang('user.Enter country here...')</option>
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
    <label for="uilanguage_id" class="col-md-2 control-label">@lang('user.Uilanguage')</label>
    <div class="col-md-10">
        <select class="form-control" id="uilanguage_id" name="uilanguage_id">
        	    <option value="" style="display: none;" {{ old('uilanguage_id', optional($user)->uilanguage_id ?: '') == '' ? 'selected' : '' }} disabled selected>@lang('user.Enter UI preferred Language here...')</option>
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
    <label for="dob" class="col-md-2 control-label">@lang('user.Date of Birth')</label>
    <div class="col-md-10">
        <input class="form-control" name="dob" type="date" id="dob" value="{{ old('dob', optional($user)->dob) }}" placeholder="@lang('user.Enter Date of Birth here...')">
        {!! $errors->first('dob', '<p class="help-block">:message</p>') !!}
    </div>
</div>


<div class="form-group {{ $errors->has('registeredon') ? 'has-error' : '' }}">
    <label for="registeredon" class="col-md-2 control-label">@lang('user.Registeredon')</label>
    <div class="col-md-10">
        <input class="form-control" name="registeredon" type="text" id="registeredon" value="{{ old('created_at', optional($user)->created_at) }}" disabled placeholder="Automatically updated...">
        {!! $errors->first('registeredon', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group {{ $errors->has('phone') ? 'has-error' : '' }}">
    <label for="phone" class="col-md-2 control-label">@lang('user.Phone')</label>
    <div class="col-md-10">
        <input class="form-control" name="phone" type="tel" id="phone" value="{{ old('phone', optional($user)->phone) }}" maxlength="50" placeholder="@lang('user.Enter phone here...')">
        {!! $errors->first('phone', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group {{ $errors->has('parentmail') ? 'has-error' : '' }}">
    <label for="parentmail" class="col-md-2 control-label">@lang('user.Parentmail')</label>
    <div class="col-md-10">
        <input class="form-control" name="parentmail" type="email" id="parentmail" value="{{ old('parentmail', optional($user)->parentmail) }}" maxlength="250" placeholder="@lang('user.Enter parent mail here...')">
        {!! $errors->first('parentmail', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group {{ $errors->has('aboutme') ? 'has-error' : '' }}">
    <label for="aboutme" class="col-md-2 control-label">About me</label>
    <div class="col-md-10">
        <textarea class="form-control" rows="5" name="aboutme" type="email" id="aboutme">{{ old('aboutme', optional($user)->aboutme) }}</textarea>

        {!! $errors->first('aboutme', '<p class="help-block">:message</p>') !!}
    </div>
</div>






