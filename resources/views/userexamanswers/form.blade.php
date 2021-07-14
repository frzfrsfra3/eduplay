
<div class="form-group {{ $errors->has('answerdate') ? 'has-error' : '' }}">
    <label for="answerdate" class="col-md-2 control-label">Answerdate</label>
    <div class="col-md-10">
        <input class="form-control" name="answerdate" type="text" id="answerdate" value="{{ old('answerdate', optional($userexamanswer)->answerdate) }}" required="true" placeholder="Enter answerdate here...">
        {!! $errors->first('answerdate', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group {{ $errors->has('user_id') ? 'has-error' : '' }}">
    <label for="user_id" class="col-md-2 control-label">User</label>
    <div class="col-md-10">
        <select class="form-control" id="user_id" name="user_id" required="true">
        	    <option value="" style="display: none;" {{ old('user_id', optional($userexamanswer)->user_id ?: '') == '' ? 'selected' : '' }} disabled selected>Select user</option>
        	@foreach ($users as $key => $user)
			    <option value="{{ $key }}" {{ old('user_id', optional($userexamanswer)->user_id) == $key ? 'selected' : '' }}>
			    	{{ $user }}
			    </option>
			@endforeach
        </select>
        
        {!! $errors->first('user_id', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group {{ $errors->has('exam_id') ? 'has-error' : '' }}">
    <label for="exam_id" class="col-md-2 control-label">Exam</label>
    <div class="col-md-10">
        <select class="form-control" id="exam_id" name="exam_id" required="true">
        	    <option value="" style="display: none;" {{ old('exam_id', optional($userexamanswer)->exam_id ?: '') == '' ? 'selected' : '' }} disabled selected>Select exam</option>
        	@foreach ($exams as $key => $exam)
			    <option value="{{ $key }}" {{ old('exam_id', optional($userexamanswer)->exam_id) == $key ? 'selected' : '' }}>
			    	{{ $exam }}
			    </option>
			@endforeach
        </select>
        
        {!! $errors->first('exam_id', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group {{ $errors->has('attempt_number') ? 'has-error' : '' }}">
    <label for="attempt_number" class="col-md-2 control-label">Attempt Number</label>
    <div class="col-md-10">
        <input class="form-control" name="attempt_number" type="number" id="attempt_number" value="{{ old('attempt_number', optional($userexamanswer)->attempt_number) }}" min="-2147483648" max="2147483647" required="true" placeholder="Enter attempt number here...">
        {!! $errors->first('attempt_number', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group {{ $errors->has('question_id') ? 'has-error' : '' }}">
    <label for="question_id" class="col-md-2 control-label">Question</label>
    <div class="col-md-10">
        <select class="form-control" id="question_id" name="question_id" required="true">
        	    <option value="" style="display: none;" {{ old('question_id', optional($userexamanswer)->question_id ?: '') == '' ? 'selected' : '' }} disabled selected>Select question</option>
        	@foreach ($questions as $key => $question)
			    <option value="{{ $key }}" {{ old('question_id', optional($userexamanswer)->question_id) == $key ? 'selected' : '' }}>
			    	{{ $question }}
			    </option>
			@endforeach
        </select>
        
        {!! $errors->first('question_id', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group {{ $errors->has('answer_id') ? 'has-error' : '' }}">
    <label for="answer_id" class="col-md-2 control-label">Answer</label>
    <div class="col-md-10">
        <select class="form-control" id="answer_id" name="answer_id" required="true">
        	    <option value="" style="display: none;" {{ old('answer_id', optional($userexamanswer)->answer_id ?: '') == '' ? 'selected' : '' }} disabled selected>Select answer</option>
        	@foreach ($answers as $key => $answer)
			    <option value="{{ $key }}" {{ old('answer_id', optional($userexamanswer)->answer_id) == $key ? 'selected' : '' }}>
			    	{{ $answer }}
			    </option>
			@endforeach
        </select>
        
        {!! $errors->first('answer_id', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group {{ $errors->has('timespent') ? 'has-error' : '' }}">
    <label for="timespent" class="col-md-2 control-label">Timespent</label>
    <div class="col-md-10">
        <input class="form-control" name="timespent" type="number" id="timespent" value="{{ old('timespent', optional($userexamanswer)->timespent) }}" min="-2147483648" max="2147483647" required="true" placeholder="Enter timespent here...">
        {!! $errors->first('timespent', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group {{ $errors->has('iscorrect') ? 'has-error' : '' }}">
    <label for="iscorrect" class="col-md-2 control-label">Iscorrect</label>
    <div class="col-md-10">
        <select class="form-control" id="iscorrect" name="iscorrect" required="true">
        	    <option value="" style="display: none;" {{ old('iscorrect', optional($userexamanswer)->iscorrect ?: '') == '' ? 'selected' : '' }} disabled selected>Enter iscorrect here...</option>
        	@foreach (['0' => '0',
'1' => '1',
'' => ''] as $key => $text)
			    <option value="{{ $key }}" {{ old('iscorrect', optional($userexamanswer)->iscorrect) == $key ? 'selected' : '' }}>
			    	{{ $text }}
			    </option>
			@endforeach
        </select>
        
        {!! $errors->first('iscorrect', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group {{ $errors->has('teachermark') ? 'has-error' : '' }}">
    <label for="teachermark" class="col-md-2 control-label">Teachermark</label>
    <div class="col-md-10">
        <input class="form-control" name="teachermark" type="number" id="teachermark" value="{{ old('teachermark', optional($userexamanswer)->teachermark) }}" min="-2147483648" max="2147483647" required="true" placeholder="Enter teachermark here...">
        {!! $errors->first('teachermark', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group {{ $errors->has('pointsgained') ? 'has-error' : '' }}">
    <label for="pointsgained" class="col-md-2 control-label">Pointsgained</label>
    <div class="col-md-10">
        <input class="form-control" name="pointsgained" type="number" id="pointsgained" value="{{ old('pointsgained', optional($userexamanswer)->pointsgained) }}" min="-2147483648" max="2147483647" placeholder="Enter pointsgained here...">
        {!! $errors->first('pointsgained', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group {{ $errors->has('gameid') ? 'has-error' : '' }}">
    <label for="gameid" class="col-md-2 control-label">Gameid</label>
    <div class="col-md-10">
        <input class="form-control" name="gameid" type="number" id="gameid" value="{{ old('gameid', optional($userexamanswer)->gameid) }}" min="-2147483648" max="2147483647" placeholder="Enter gameid here...">
        {!! $errors->first('gameid', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group {{ $errors->has('user_agent') ? 'has-error' : '' }}">
    <label for="user_agent" class="col-md-2 control-label">User Agent</label>
    <div class="col-md-10">
        <textarea class="form-control" name="user_agent" cols="50" rows="10" id="user_agent" placeholder="Enter user agent here...">{{ old('user_agent', optional($userexamanswer)->user_agent) }}</textarea>
        {!! $errors->first('user_agent', '<p class="help-block">:message</p>') !!}
    </div>
</div>

