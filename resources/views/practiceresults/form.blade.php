
<div class="form-group {{ $errors->has('question_id') ? 'has-error' : '' }}">
    <label for="question_id" class="col-md-2 control-label">Question</label>
    <div class="col-md-10">
        <select class="form-control" id="question_id" name="question_id" required="true">
        	    <option value="" style="display: none;" {{ old('question_id', optional($practiceresult)->question_id ?: '') == '' ? 'selected' : '' }} disabled selected>Select question</option>
        	@foreach ($questions as $key => $question)
			    <option value="{{ $key }}" {{ old('question_id', optional($practiceresult)->question_id) == $key ? 'selected' : '' }}>
			    	{{ $question }}
			    </option>
			@endforeach
        </select>
        
        {!! $errors->first('question_id', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group {{ $errors->has('answeroption_id') ? 'has-error' : '' }}">
    <label for="answeroption_id" class="col-md-2 control-label">Answeroption</label>
    <div class="col-md-10">
        <select class="form-control" id="answeroption_id" name="answeroption_id" required="true">
        	    <option value="" style="display: none;" {{ old('answeroption_id', optional($practiceresult)->answeroption_id ?: '') == '' ? 'selected' : '' }} disabled selected>Select answeroption</option>
        	@foreach ($answeroptions as $key => $answeroption)
			    <option value="{{ $key }}" {{ old('answeroption_id', optional($practiceresult)->answeroption_id) == $key ? 'selected' : '' }}>
			    	{{ $answeroption }}
			    </option>
			@endforeach
        </select>
        
        {!! $errors->first('answeroption_id', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group {{ $errors->has('iscorrect') ? 'has-error' : '' }}">
    <label for="iscorrect" class="col-md-2 control-label">Iscorrect</label>
    <div class="col-md-10">
        <div class="checkbox">
            <label for="iscorrect_1">
            	<input id="iscorrect_1" class="" name="iscorrect" type="checkbox" value="1" {{ old('iscorrect', optional($practiceresult)->iscorrect) == '1' ? 'checked' : '' }}>
                Yes
            </label>
        </div>

        {!! $errors->first('iscorrect', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group {{ $errors->has('topics_id') ? 'has-error' : '' }}">
    <label for="topics_id" class="col-md-2 control-label">Topics</label>
    <div class="col-md-10">
        <select class="form-control" id="topics_id" name="topics_id">
        	    <option value="" style="display: none;" {{ old('topics_id', optional($practiceresult)->topics_id ?: '') == '' ? 'selected' : '' }} disabled selected>Select topics</option>
        	@foreach ($topics as $key => $topic)
			    <option value="{{ $key }}" {{ old('topics_id', optional($practiceresult)->topics_id) == $key ? 'selected' : '' }}>
			    	{{ $topic }}
			    </option>
			@endforeach
        </select>
        
        {!! $errors->first('topics_id', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group {{ $errors->has('exercise_id') ? 'has-error' : '' }}">
    <label for="exercise_id" class="col-md-2 control-label">Exercise</label>
    <div class="col-md-10">
        <select class="form-control" id="exercise_id" name="exercise_id">
        	    <option value="" style="display: none;" {{ old('exercise_id', optional($practiceresult)->exercise_id ?: '') == '' ? 'selected' : '' }} disabled selected>Select exercise</option>
        	@foreach ($exercises as $key => $exercise)
			    <option value="{{ $key }}" {{ old('exercise_id', optional($practiceresult)->exercise_id) == $key ? 'selected' : '' }}>
			    	{{ $exercise }}
			    </option>
			@endforeach
        </select>
        
        {!! $errors->first('exercise_id', '<p class="help-block">:message</p>') !!}
    </div>
</div>

