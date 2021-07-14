<div class="form-group">
    <label for="name" class="col-md-2 control-label">Name</label>
    <div class="col-md-10">
        <input class="form-control" name="name" type="text" id="name" value="" minlength="1"
               maxlength="250" required="true" placeholder="Enter Your child name here...">
        {!! $errors->first('name', '<p class="help-block">:message</p>') !!}
    </div>
</div>


<div class="form-group">
    <label for="email" class="col-md-2 control-label">Email</label>
    <div class="col-md-10">
        <input class="form-control" name="email" type="email" id="email" value=""
               minlength="1" maxlength="250" required="true"
               placeholder="Enter email here...">
        {!! $errors->first('email', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group">
    <label for="password" class="col-md-2 control-label">Password</label>
    <div class="col-md-10">
        <input class="form-control" name="password" type="password" id="password" value=""
               minlength="1" maxlength="250" required="true"
               placeholder="Enter password...">
        {!! $errors->first('password', '<p class="help-block">:message</p>') !!}
    </div>
</div>
<div class="form-group">
    <label for="password-confirm" class="col-md-2 control-label">Confirm Password</label>
    <div class="col-md-10">
        <input id="password-confirm" type="password" class="form-control" name="password_confirmation"  minlength="1" maxlength="250" required  placeholder="Confirm the password">
        {!! $errors->first('"password-confirm', '<p class="help-block">:message</p>') !!}
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
<div class="form-group {{ $errors->has('dob') ? 'has-error' : '' }}">
    <label for="dob" class="col-md-2 control-label">Date of Birth</label>
    <div class="col-md-10">
        <input class="form-control" name="dob" type="date" id="dob" value="{{old('dob', optional($child)->dob)}}" required="true" placeholder="Enter Date of Birth here...">
        {!! $errors->first('dob', '<p class="help-block">:message</p>') !!}
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

<input class="form-control" name="registeredby" type="hidden" id="registeredby " value="parent" >
<input class="form-control" name="totalpoints" type="hidden" id="totalpoints" value="0" >





<div class="form-group">
    <div class="col-md-10">
        <input class="form-control" type="hidden" name="invitedby" type="number"
               id="invitedby"
               value="{{$user->id}}" min="-2147483648" max="2147483647" required="true"
               placeholder="Enter invitedby here...">
        {!! $errors->first('invitedby', '<p class="help-block">:message</p>') !!}
    </div>
</div>
