
    <div class="col-md-6">
        <div class="form-group mrgn-bt-30">
            <label>@lang('profile.dob') :</label>
            <input type="text" class="form-control" name="dob" type="date" id="dob" value="{{ old('dob',empty($user) ? "" : date('d-m-Y', strtotime($user->dob)) ) }}" onkeydown="return false;" autocomplete="off"/>
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group mrgn-bt-30">
            <label>@lang('profile.name') :</label>
            <input type="text" class="form-control" id="child_name" name="child_name" value="{{ old('name', optional($user)->name ) }}" />
        </div>
    </div>
    <div class="col-md-6" id="email_div">
        <div class="form-group mrgn-bt-30">
            <label>@lang('profile.email_address') :</label>
            <input type="email" name="email" id="email" class="form-control" value="{{ old('email', optional($user)->email ) }}" />
        </div>
    </div>
    <div class="col-md-6" id="username_div">
        <div class="form-group mrgn-bt-30">
            <label>@lang('profile.username') :</label>
            <input type="text" name="username" id="username" class="form-control" value="{{ old('username', optional($user)->email ) }}"/>
        </div>
    </div>
    <div class="col-md-6" id="password_div">
        <div class="form-group mrgn-bt-30">
            <label>@lang('profile.password') :</label>
            <input type="password" name="password" id="child_password" class="form-control" value="{{ old('password') }}"/>
        </div>
    </div>
    <div class="col-md-6" id="passwordConfirm_div" @endif>
        <div class="form-group mrgn-bt-30">
            <label>@lang('profile.confirm_password') :</label>
            <input type="password" id="passwordConfirmation" class="form-control" value="{{ old('passwordConfirm') }}"/>
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group mrgn-bt-30">
            <div class="df-select">
                <label>@lang('profile.grade') :</label>
                <select class="selectpicker" id="grade_id" name="grade_id">
                    <option value="" style="display: none;" {{ old('grade_id', optional($user)->grade_id ?: '') == '' ? 'selected' : '' }} disabled selected>@lang('profile.grade')</option>
                    @foreach ($grades as $key => $grade)
                        <option value="{{ $grade->id }}" {{ old('grade_id', optional($user)->grade_id) == $grade->id ? 'selected' : '' }}>
                            {{ $grade->grade_name }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>
    {{-- <div class="col-md-6">
        <div class="form-group mrgn-bt-30">
            <div class="df-select">
                <label>School :</label>
                <select class="selectpicker" id="school_id" name="school_id">
                    @foreach ($schools as $school)
                        <option value="{{ $school->id }}" {{ old('school_id', optional($user)->school_id) == $school->id ? 'selected' : '' }}>
                            {{ $school->school_name }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>
    </div> --}}
    <div class="col-md-6">
        <div class="form-group mrgn-bt-30">
            <label>@lang('profile.gender') :</label>
            <ul class="prsn-action-rdio">
                <li>
                    <div class="rdio rdio-primary">
                        <input name="gender" value="M" id="male" type="radio"  {{ (optional($user)->gender == 'M') ? 'checked' : '' }}>
                        <label for="male">@lang('profile.male')</label>
                    </div>
                </li>
                <li>
                    <div class="rdio rdio-primary">
                        <input name="gender" value="F" id="female" type="radio" {{ (optional($user)->gender == 'F') ? 'checked' : '' }}>
                        <label for="female">@lang('profile.female')</label>
                    </div>
                </li>
            </ul>
        </div>
    </div>
  
   