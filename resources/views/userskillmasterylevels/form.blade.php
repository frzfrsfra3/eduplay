
<div class="form-group {{ $errors->has('user_id') ? 'has-error' : '' }}">
    <label for="user_id" class="col-md-2 control-label">User</label>
    <div class="col-md-10">
        <select class="form-control" id="user_id" name="user_id" required="true">
        	    <option value="" style="display: none;" {{ old('user_id', optional($userskillmasterylevel)->user_id ?: '') == '' ? 'selected' : '' }} disabled selected>Select user</option>
        	@foreach ($users as $key => $user)
			    <option value="{{ $key }}" {{ old('user_id', optional($userskillmasterylevel)->user_id) == $key ? 'selected' : '' }}>
			    	{{ $user }}
			    </option>
			@endforeach
        </select>
        
        {!! $errors->first('user_id', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group {{ $errors->has('skill_id') ? 'has-error' : '' }}">
    <label for="skill_id" class="col-md-2 control-label">Skill</label>
    <div class="col-md-10">
        <select class="form-control" id="skill_id" name="skill_id" required="true">
        	    <option value="" style="display: none;" {{ old('skill_id', optional($userskillmasterylevel)->skill_id ?: '') == '' ? 'selected' : '' }} disabled selected>Select skill</option>
        	@foreach ($skills as $key => $skill)
			    <option value="{{ $key }}" {{ old('skill_id', optional($userskillmasterylevel)->skill_id) == $key ? 'selected' : '' }}>
			    	{{ $skill }}
			    </option>
			@endforeach
        </select>
        
        {!! $errors->first('skill_id', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group {{ $errors->has('score') ? 'has-error' : '' }}">
    <label for="score" class="col-md-2 control-label">Score</label>
    <div class="col-md-10">
        <input class="form-control" name="score" type="number" id="score" value="{{ old('score', optional($userskillmasterylevel)->score) }}" min="-2147483648" max="2147483647" required="true" placeholder="Enter score here...">
        {!! $errors->first('score', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group {{ $errors->has('masteryLevel') ? 'has-error' : '' }}">
    <label for="masteryLevel" class="col-md-2 control-label">Mastery Level</label>
    <div class="col-md-10">
        <input class="form-control" name="masteryLevel" type="number" id="masteryLevel" value="{{ old('masteryLevel', optional($userskillmasterylevel)->masteryLevel) }}" min="-2147483648" max="2147483647" required="true" placeholder="Enter mastery level here...">
        {!! $errors->first('masteryLevel', '<p class="help-block">:message</p>') !!}
    </div>
</div>

