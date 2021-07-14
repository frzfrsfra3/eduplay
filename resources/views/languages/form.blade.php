
<div class="form-group {{ $errors->has('language') ? 'has-error' : '' }}">
    <label for="language" class="col-md-2 control-label">Language</label>
    <div class="col-md-10">
        <input class="form-control" name="language" type="text" id="language" value="{{ old('language', optional($language)->language) }}" min="1" max="25" required="true" placeholder="Enter language here...">
        {!! $errors->first('language', '<p class="help-block">:message</p>') !!}
    </div>
</div>

