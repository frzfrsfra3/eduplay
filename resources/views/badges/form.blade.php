
<div class="form-group {{ $errors->has('badgetitle') ? 'has-error' : '' }}">
    <label for="badgetitle" class="col-md-2 control-label">Title</label>
    <div class="col-md-10">
        <textarea class="form-control" name="badgetitle" cols="50" rows="1" id="badgetitle" required="true" placeholder="Enter badgetitle here...">{{ old('badgetitle', optional($badge)->badgetitle) }}</textarea>
        {!! $errors->first('badgetitle', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group {{ $errors->has('badgedescription') ? 'has-error' : '' }}">
    <label for="badgedescription" class="col-md-2 control-label">Description</label>
    <div class="col-md-10">
        <textarea class="form-control" name="badgedescription" cols="50" rows="5" id="badgedescription" required="true" placeholder="Enter badgedescription here...">{{ old('badgedescription', optional($badge)->badgedescription) }}</textarea>
        {!! $errors->first('badgedescription', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group {{ $errors->has('badgeimageurl') ? 'has-error' : '' }}">
    <label for="badgeimageurl" class="col-md-2 control-label">Imageurl</label>
    <div class="col-md-10">
        <input class="form-control" name="badgeimageurl" type="text" id="badgeimageurl" value="{{ old('badgeimageurl', optional($badge)->badgeimageurl) }}" min="1" max="250" required="true" placeholder="Enter badgeimageurl here...">
        {!! $errors->first('badgeimageurl', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group {{ $errors->has('points') ? 'has-error' : '' }}">
    <label for="points" class="col-md-2 control-label">Points</label>
    <div class="col-md-3">
        <input class="form-control" name="points" type="number" id="points" value="{{ old('points', optional($badge)->points) }}" min="0" max="1000" placeholder="Enter points here...">
        {!! $errors->first('points', '<p class="help-block">:message</p>') !!}
    </div>
    <div class="form-group {{ $errors->has('badgeorder') ? 'has-error' : '' }}">
        <label for="badgeorder" class="col-md-2 control-label">Badge order</label>
        <div class="col-md-3">
            <input class="form-control" name="badgeorder" type="number" id="badgeorder" value="{{ old('badgeorder', optional($badge)->badgeorder) }}" min="-2147483648" max="2147483647" placeholder="Enter badgeorder here...">
            {!! $errors->first('badgeorder', '<p class="help-block">:message</p>') !!}
        </div>
    </div>
    <div class="form-group {{ $errors->has('isactive') ? 'has-error' : '' }}">
        <label for="isactive" class="col-md-2 control-label">Isactive</label>
        <div class="col-md-2">
            <div class="checkbox">
                <label for="isactive_1">
                    <input id="isactive_1" class="" name="isactive" type="checkbox" value="1" {{ old('isactive', optional($badge)->isactive) == '1' ? 'checked' : '' }}>
                    Yes
                </label>
            </div>
            {!! $errors->first('isactive', '<p class="help-block">:message</p>') !!}
        </div>
    </div>

</div>


<div class="form-group {{ $errors->has('badge_condition') ? 'has-error' : '' }}">
    <label for="badge_condition" class="col-md-2 control-label">Badge Condition</label>
    <div class="col-md-10">
        <input class="form-control" name="badge_condition" type="text" id="badge_condition" value="{{ old('badge_condition', optional($badge)->badge_condition) }}" minlength="1" maxlength="250" required="true" placeholder="Enter badge condition here...">
        {!! $errors->first('badge_condition', '<p class="help-block">:message</p>') !!}
    </div>
</div>


