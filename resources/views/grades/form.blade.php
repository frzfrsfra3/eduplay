
<div class="form-group {{ $errors->has('grade_name') ? 'has-error' : '' }}">
    <label for="grade_name" class="col-md-2 control-label">Grade Name</label>
    <div class="col-md-10">
        <input class="form-control" name="grade_name" type="text" id="grade_name" value="{{ old('grade_name', optional($grade)->grade_name) }}" minlength="1" maxlength="250" required="true" placeholder="Enter grade name here...">
        {!! $errors->first('grade_name', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group {{ $errors->has('curriculum_gradelist_id') ? 'has-error' : '' }}">
    <label for="curriculum_gradelist_id" class="col-md-2 control-label">Curriculum</label>
    <div class="col-md-10">
        <select class="form-control" id="curriculum_gradelist_id" name="curriculum_gradelist_id">
        	    <option value="" style="display: none;" {{ old('curriculum_gradelist_id', optional($grade)->curriculum_gradelist_id ?: '') == '' ? 'selected' : '' }} disabled selected>Select curriculum</option>
        	@foreach ($curricula as $key => $curriculum)
			    <option value="{{ $key }}" {{ old('curriculum_gradelist_id', optional($grade)->curriculum_gradelist_id) == $key ? 'selected' : '' }}>
			    	{{ $curriculum }}
			    </option>
			@endforeach
        </select>
        
        {!! $errors->first('curriculum_gradelist_id', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group {{ $errors->has('createdby') ? 'has-error' : '' }}">
    <label for="createdby" class="col-md-2 control-label">Createdby</label>
    <div class="col-md-10">
        <input class="form-control" name="createdby" type="number" id="createdby" value="{{ old('createdby', optional($grade)->createdby) }}" min="-2147483648" max="2147483647" required="true" placeholder="Enter createdby here...">
        {!! $errors->first('createdby', '<p class="help-block">:message</p>') !!}
    </div>
</div>

