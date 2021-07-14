
<div class="form-group {{ $errors->has('country_name') ? 'has-error' : '' }}">
    <label for="country_name" class="col-md-2 control-label">Country Name</label>
    <div class="col-md-10">
        <input class="form-control" name="country_name" type="text" id="country_name" value="{{ old('country_name', optional($country)->country_name) }}" min="1" max="100" required="true" placeholder="Enter country name here...">
        {!! $errors->first('country_name', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group {{ $errors->has('abbreviation_code') ? 'has-error' : '' }}">
    <label for="abbreviation_code" class="col-md-2 control-label">Abbreviation Code</label>
    <div class="col-md-10">
        <input class="form-control" name="abbreviation_code" type="text" id="abbreviation_code" value="{{ old('abbreviation_code', optional($country)->abbreviation_code) }}" maxlength="50" placeholder="Enter abbreviation code here...">
        {!! $errors->first('abbreviation_code', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group {{ $errors->has('country_flag') ? 'has-error' : '' }}">
    <label for="country_flag" class="col-md-2 control-label">Country Flag</label>
    <div class="col-md-10">
        <input class="form-control" name="country_flag" type="text" id="country_flag" value="{{ old('country_flag', optional($country)->country_flag) }}" min="0" max="100" placeholder="Enter country flag here...">
        {!! $errors->first('country_flag', '<p class="help-block">:message</p>') !!}
    </div>
</div>

