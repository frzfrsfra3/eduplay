
<div class="form-group {{ $errors->has('user_id') ? 'has-error' : '' }}">
    <label for="user_id" class="col-md-2 control-label">User</label>
    <div class="col-md-10">
        <select class="form-control" id="user_id" name="user_id" required="true">
        	    <option value="" style="display: none;" {{ old('user_id', optional($userexamscore)->user_id ?: '') == '' ? 'selected' : '' }} disabled selected>Select user</option>
        	@foreach ($users as $key => $user)
			    <option value="{{ $key }}" {{ old('user_id', optional($userexamscore)->user_id) == $key ? 'selected' : '' }}>
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
        	    <option value="" style="display: none;" {{ old('exam_id', optional($userexamscore)->exam_id ?: '') == '' ? 'selected' : '' }} disabled selected>Select exam</option>
        	@foreach ($exams as $key => $exam)
			    <option value="{{ $key }}" {{ old('exam_id', optional($userexamscore)->exam_id) == $key ? 'selected' : '' }}>
			    	{{ $exam }}
			    </option>
			@endforeach
        </select>
        
        {!! $errors->first('exam_id', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group {{ $errors->has('score') ? 'has-error' : '' }}">
    <label for="score" class="col-md-2 control-label">Score</label>
    <div class="col-md-10">
        <input class="form-control" name="score" type="number" id="score" value="{{ old('score', optional($userexamscore)->score) }}" min="-2147483648" max="2147483647" required="true" placeholder="Enter score here...">
        {!! $errors->first('score', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group {{ $errors->has('totaltimespent') ? 'has-error' : '' }}">
    <label for="totaltimespent" class="col-md-2 control-label">Totaltimespent</label>
    <div class="col-md-10">
        <input class="form-control" name="totaltimespent" type="number" id="totaltimespent" value="{{ old('totaltimespent', optional($userexamscore)->totaltimespent) }}" min="-2147483648" max="2147483647" required="true" placeholder="Enter totaltimespent here...">
        {!! $errors->first('totaltimespent', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group {{ $errors->has('skill_id') ? 'has-error' : '' }}">
    <label for="skill_id" class="col-md-2 control-label">Skill</label>
    <div class="col-md-10">
        <select class="form-control" id="skill_id" name="skill_id">
        	    <option value="" style="display: none;" {{ old('skill_id', optional($userexamscore)->skill_id ?: '') == '' ? 'selected' : '' }} disabled selected>Select skill</option>
        	@foreach ($skills as $key => $skill)
			    <option value="{{ $key }}" {{ old('skill_id', optional($userexamscore)->skill_id) == $key ? 'selected' : '' }}>
			    	{{ $skill }}
			    </option>
			@endforeach
        </select>
        
        {!! $errors->first('skill_id', '<p class="help-block">:message</p>') !!}
    </div>
</div>

