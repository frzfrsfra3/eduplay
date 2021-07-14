
<div class="form-group {{ $errors->has('school_name') ? 'has-error' : '' }}">
    <label for="school_name" class="col-md-2 control-label">School Name</label>
    <div class="col-md-10">
        <input class="form-control" name="school_name" type="text" id="school_name" value="{{ old('school_name', optional($school)->school_name) }}" minlength="1" maxlength="250" required="true" placeholder="Enter school name here...">
        {!! $errors->first('school_name', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group {{ $errors->has('address') ? 'has-error' : '' }}">
    <label for="address" class="col-md-2 control-label">Address</label>
    <div class="col-md-10">
        <input class="form-control" name="address" type="text" id="address" value="{{ old('address', optional($school)->address) }}" maxlength="250" placeholder="Enter address here...">
        {!! $errors->first('address', '<p class="help-block">:message</p>') !!}
    </div>
</div>

