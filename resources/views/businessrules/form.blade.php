
<div class="form-group {{ $errors->has('businessrule_name') ? 'has-error' : '' }}">
    <label for="businessrule_name" class="col-md-2 control-label">Businessrule Name</label>
    <div class="col-md-10">
        <input class="form-control" name="businessrule_name" type="text" id="businessrule_name" value="{{ old('businessrule_name', optional($businessrule)->businessrule_name) }}" minlength="1" maxlength="250" required="true" placeholder="Enter businessrule name here...">
        {!! $errors->first('businessrule_name', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group {{ $errors->has('businessrule_condition') ? 'has-error' : '' }}">
    <label for="businessrule_condition" class="col-md-2 control-label">Businessrule Condition</label>
    <div class="col-md-10">
        <input class="form-control" name="businessrule_condition" type="text" id="businessrule_condition" value="{{ old('businessrule_condition', optional($businessrule)->businessrule_condition) }}" minlength="1" maxlength="250" required="true" placeholder="Enter businessrule condition here...">
        {!! $errors->first('businessrule_condition', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group {{ $errors->has('isactive') ? 'has-error' : '' }}">
    <label for="isactive" class="col-md-2 control-label">Isactive</label>
    <div class="col-md-10">
        <div class="checkbox">
            <label for="isactive_1">
            	<input id="isactive_1" class="" name="isactive" type="checkbox" value="1" {{ old('isactive', optional($businessrule)->isactive) == '1' ? 'checked' : '' }}>
                Yes
            </label>
        </div>

        {!! $errors->first('isactive', '<p class="help-block">:message</p>') !!}
    </div>
</div>

