
<div class="form-group {{ $errors->has('class_id') ? 'has-error' : '' }}">
    <label for="class_id" class="col-md-2 control-label">Class</label>
    <div class="col-md-10">
        <select class="form-control" id="class_id" name="class_id" required="true">
        	    <option value="" style="display: none;" {{ old('class_id', optional($classexam)->class_id ?: '') == '' ? 'selected' : '' }} disabled selected>Select class</option>
        	@foreach ($courseclasses as $key => $courseclass)
			    <option value="{{ $key }}" {{ old('class_id', optional($classexam)->class_id) == $key ? 'selected' : '' }}>
			    	{{ $courseclass }}
			    </option>
			@endforeach
        </select>
        
        {!! $errors->first('class_id', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group {{ $errors->has('exam_id') ? 'has-error' : '' }}">
    <label for="exam_id" class="col-md-2 control-label">Exam</label>
    <div class="col-md-10">
        <select class="form-control" id="exam_id" name="exam_id" required="true">
        	    <option value="" style="display: none;" {{ old('exam_id', optional($classexam)->exam_id ?: '') == '' ? 'selected' : '' }} disabled selected>Select exam</option>
        	@foreach ($exams as $key => $exam)
			    <option value="{{ $key }}" {{ old('exam_id', optional($classexam)->exam_id) == $key ? 'selected' : '' }}>
			    	{{ $exam }}
			    </option>
			@endforeach
        </select>
        
        {!! $errors->first('exam_id', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group {{ $errors->has('addedon') ? 'has-error' : '' }}">
    <label for="addedon" class="col-md-2 control-label">Addedon</label>
    <div class="col-md-10">
        <input class="form-control" name="addedon" type="text" id="addedon" value="{{ old('addedon', optional($classexam)->addedon) }}" required="true" placeholder="Enter addedon here...">
        {!! $errors->first('addedon', '<p class="help-block">:message</p>') !!}
    </div>
</div>

