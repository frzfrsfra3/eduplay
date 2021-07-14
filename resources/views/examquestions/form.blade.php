
<div class="form-group {{ $errors->has('exam_id') ? 'has-error' : '' }}">
    <label for="exam_id" class="col-md-2 control-label">Exam</label>
    <div class="col-md-10">
        <select class="form-control" id="exam_id" name="exam_id" required="true">
        	    <option value="" style="display: none;" {{ old('exam_id', optional($examquestion)->exam_id ?: '') == '' ? 'selected' : '' }} disabled selected>Select exam</option>
        	@foreach ($exams as $key => $exam)
			    <option value="{{ $key }}" {{ old('exam_id', optional($examquestion)->exam_id) == $key ? 'selected' : '' }}>
			    	{{ $exam }}
			    </option>
			@endforeach
        </select>
        
        {!! $errors->first('exam_id', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group {{ $errors->has('question_id') ? 'has-error' : '' }}">
    <label for="question_id" class="col-md-2 control-label">Question</label>
    <div class="col-md-10">
        <select class="form-control" id="question_id" name="question_id" required="true">
        	    <option value="" style="display: none;" {{ old('question_id', optional($examquestion)->question_id ?: '') == '' ? 'selected' : '' }} disabled selected>Select question</option>
        	@foreach ($questions as $key => $question)
			    <option value="{{ $key }}" {{ old('question_id', optional($examquestion)->question_id) == $key ? 'selected' : '' }}>
			    	{{ $question }}
			    </option>
			@endforeach
        </select>
        
        {!! $errors->first('question_id', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group {{ $errors->has('sort_order') ? 'has-error' : '' }}">
    <label for="sort_order" class="col-md-2 control-label">Sort Order</label>
    <div class="col-md-10">
        <input class="form-control" name="sort_order" type="number" id="sort_order" value="{{ old('sort_order', optional($examquestion)->sort_order) }}" min="-2147483648" max="2147483647" placeholder="Enter sort order here...">
        {!! $errors->first('sort_order', '<p class="help-block">:message</p>') !!}
    </div>
</div>

