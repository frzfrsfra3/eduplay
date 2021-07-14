
<div class="form-group {{ $errors->has('activity_description') ? 'has-error' : '' }}">
    <label for="activity_description" class="col-md-2 control-label">Activity Description</label>
    <div class="col-md-10">
        <input class="form-control" name="description" type="text" id="description" value="{{ old('description', optional($activity)->description) }}" minlength="1" maxlength="250" required="true" placeholder="Enter activity description here...">
        {!! $errors->first('activity_description', '<p class="help-block">:message</p>') !!}
    </div>
</div>

