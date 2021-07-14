
<div class="form-group {{ $errors->has('class_id') ? 'has-error' : '' }}">
    <label for="class_id" class="col-md-2 control-label">Class</label>
    <div class="col-md-10">
        <select class="form-control" id="class_id" name="class_id" required="true">
        	    <option value="" style="display: none;" {{ old('class_id', optional($classlearner)->class_id ?: '') == '' ? 'selected' : '' }} disabled selected>Select class</option>
        	@foreach ($courseclasses as $key => $courseclass)
			    <option value="{{ $key }}" {{ old('class_id', optional($classlearner)->class_id) == $key ? 'selected' : '' }}>
			    	{{ $courseclass }}
			    </option>
			@endforeach
        </select>
        
        {!! $errors->first('class_id', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group {{ $errors->has('user_id') ? 'has-error' : '' }}">
    <label for="user_id" class="col-md-2 control-label">User</label>
    <div class="col-md-10">
        <select class="form-control" id="user_id" name="user_id" required="true">
        	    <option value="" style="display: none;" {{ old('user_id', optional($classlearner)->user_id ?: '') == '' ? 'selected' : '' }} disabled selected>Select user</option>
        	@foreach ($users as $key => $user)
			    <option value="{{ $key }}" {{ old('user_id', optional($classlearner)->user_id) == $key ? 'selected' : '' }}>
			    	{{ $user }}
			    </option>
			@endforeach
        </select>
        
        {!! $errors->first('user_id', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group {{ $errors->has('joindate') ? 'has-error' : '' }}">
    <label for="joindate" class="col-md-2 control-label">Joindate</label>
    <div class="col-md-10">
        <input class="form-control" name="joindate" type="text" id="joindate" value="{{ old('joindate', optional($classlearner)->joindate) }}" required="true" placeholder="Enter joindate here...">
        {!! $errors->first('joindate', '<p class="help-block">:message</p>') !!}
    </div>
</div>

