
<div class="form-group {{ $errors->has('discipline_id') ? 'has-error' : '' }}">
    <label for="discipline_id" class="col-md-2 control-label">Discipline</label>
    <div class="col-md-10">
        <select class="form-control" id="discipline_id" name="discipline_id" required="true">
        	    <option value="" style="display: none;" {{ old('discipline_id', optional($disciplineversion)->discipline_id ?: '') == '' ? 'selected' : '' }} disabled selected>Select discipline</option>
        	@foreach ($disciplines as $key => $discipline)
			    <option value="{{ $key }}" {{ old('discipline_id', optional($disciplineversion)->discipline_id) == $key ? 'selected' : '' }}>
			    	{{ $discipline }}
			    </option>
			@endforeach
        </select>
        
        {!! $errors->first('discipline_id', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group {{ $errors->has('version') ? 'has-error' : '' }}">
    <label for="version" class="col-md-2 control-label">Version</label>
    <div class="col-md-10">
        <input class="form-control" name="version" type="number" id="version" value="{{ old('version', optional($disciplineversion)->version) }}" min="-2147483648" max="2147483647" required="true" placeholder="Enter version here...">
        {!! $errors->first('version', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group {{ $errors->has('ispublished') ? 'has-error' : '' }}">
    <label for="ispublished" class="col-md-2 control-label">Ispublished</label>
    <div class="col-md-10">
        <input class="form-control" name="ispublished" type="number" id="ispublished" value="{{ old('ispublished', optional($disciplineversion)->ispublished) }}" min="-2147483648" max="2147483647" required="true" placeholder="Enter ispublished here...">
        {!! $errors->first('ispublished', '<p class="help-block">:message</p>') !!}
    </div>
</div>

