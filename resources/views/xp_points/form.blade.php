
<div class="form-group {{ $errors->has('activity_name') ? 'has-error' : '' }}">
    <label for="activity_name" class="col-md-2 control-label">Activity Name</label>
    <div class="col-md-10">
        <input class="form-control" name="activity_name" type="text" id="activity_name" value="{{ old('activity_name', optional($xpPoint)->activity_name) }}" minlength="1" maxlength="250" required="true" placeholder="Enter activity name here...">
        {!! $errors->first('activity_name', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group {{ $errors->has('point') ? 'has-error' : '' }}">
    <label for="point" class="col-md-2 control-label">Point</label>
    <div class="col-md-10">
        <input class="form-control" name="point" type="number" id="point" value="{{ old('point', optional($xpPoint)->point) }}" min="-2147483648" max="2147483647" required="true" placeholder="Enter point here...">
        {!! $errors->first('point', '<p class="help-block">:message</p>') !!}
    </div>
</div>

