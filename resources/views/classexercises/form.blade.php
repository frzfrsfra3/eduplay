
<div class="form-group {{ $errors->has('class_id') ? 'has-error' : '' }}">
    <label for="class_id" class="col-md-2 control-label">Class</label>
    <div class="col-md-10">
        <select class="form-control" id="class_id" name="class_id" required="true">
        	    <option value="" style="display: none;" {{ old('class_id', optional($classexercise)->class_id ?: '') == '' ? 'selected' : '' }} disabled selected>Select class</option>
        	@foreach ($courseclasses as $key => $courseclass)
			    <option value="{{ $key }}" {{ old('class_id', optional($classexercise)->class_id) == $key ? 'selected' : '' }}>
			    	{{ $courseclass }}
			    </option>
			@endforeach
        </select>
        
        {!! $errors->first('class_id', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group {{ $errors->has('exercise_id') ? 'has-error' : '' }}">
    <label for="exercise_id" class="col-md-2 control-label">Exercise</label>
    <div class="col-md-10">
        <select class="form-control" id="exercise_id" name="exercise_id" required="true">
        	    <option value="" style="display: none;" {{ old('exercise_id', optional($classexercise)->exercise_id ?: '') == '' ? 'selected' : '' }} disabled selected>Select exercise</option>
        	@foreach ($exercises as $key => $exercise)
			    <option value="{{ $key }}" {{ old('exercise_id', optional($classexercise)->exercise_id) == $key ? 'selected' : '' }}>
			    	{{ $exercise }}
			    </option>
			@endforeach
        </select>
        
        {!! $errors->first('exercise_id', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group {{ $errors->has('addedon') ? 'has-error' : '' }}">
    <label for="addedon" class="col-md-2 control-label">Addedon</label>
    <div class="col-md-10">
        <input class="form-control" name="addedon" type="text" id="addedon" value="{{ old('addedon', optional($classexercise)->addedon) }}" required="true" placeholder="Enter addedon here...">
        {!! $errors->first('addedon', '<p class="help-block">:message</p>') !!}
    </div>
</div>

