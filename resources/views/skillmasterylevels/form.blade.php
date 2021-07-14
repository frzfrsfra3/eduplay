
<div class="form-group {{ $errors->has('levelname') ? 'has-error' : '' }}">
    <label for="levelname" class="col-md-2 control-label">Levelname</label>
    <div class="col-md-10">
        <input class="form-control" name="levelname" type="text" id="levelname" value="{{ old('levelname', optional($skillmasterylevel)->levelname) }}" maxlength="250" placeholder="Enter levelname here...">
        {!! $errors->first('levelname', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group {{ $errors->has('level_massage') ? 'has-error' : '' }}">
    <label for="level_massage" class="col-md-2 control-label">Level Massage</label>
    <div class="col-md-10">
        <input class="form-control" name="level_massage" type="text" id="level_massage" value="{{ old('level_massage', optional($skillmasterylevel)->level_massage) }}" min="0" max="250" placeholder="Enter level massage here...">
        {!! $errors->first('level_massage', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group {{ $errors->has('min_score') ? 'has-error' : '' }}">
    <label for="min_score" class="col-md-2 control-label">Min Score</label>
    <div class="col-md-10">
        <input class="form-control" name="min_score" type="number" id="min_score" value="{{ old('min_score', optional($skillmasterylevel)->min_score) }}" min="-2147483648" max="2147483647" required="true" placeholder="Enter min score here...">
        {!! $errors->first('min_score', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group {{ $errors->has('max_score') ? 'has-error' : '' }}">
    <label for="max_score" class="col-md-2 control-label">Max Score</label>
    <div class="col-md-10">
        <input class="form-control" name="max_score" type="number" id="max_score" value="{{ old('max_score', optional($skillmasterylevel)->max_score) }}" min="-2147483648" max="2147483647" required="true" placeholder="Enter max score here...">
        {!! $errors->first('max_score', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group {{ $errors->has('consecutive_value') ? 'has-error' : '' }}">
    <label for="consecutive_value" class="col-md-2 control-label">Consecutive Value</label>
    <div class="col-md-10">
        <input class="form-control" name="consecutive_value" type="number" id="consecutive_value" value="{{ old('consecutive_value', optional($skillmasterylevel)->consecutive_value) }}" min="-2147483648" max="2147483647" required="true" placeholder="Enter consecutive value here...">
        {!! $errors->first('consecutive_value', '<p class="help-block">:message</p>') !!}
    </div>
</div>

