
<div class="form-group {{ $errors->has('exerciseset_id') ? 'has-error' : '' }}">
    <label for="exerciseset_id" class="col-md-2 control-label">Exerciseset</label>
    <div class="col-md-10">
        <select class="form-control" id="exerciseset_id" name="exerciseset_id" required="true">
        	    <option value="" style="display: none;" {{ old('exerciseset_id', optional($exercisesetbuyer)->exerciseset_id ?: '') == '' ? 'selected' : '' }} disabled selected>Select exerciseset</option>
        	@foreach ($exercisesets as $key => $exerciseset)
			    <option value="{{ $key }}" {{ old('exerciseset_id', optional($exercisesetbuyer)->exerciseset_id) == $key ? 'selected' : '' }}>
			    	{{ $exerciseset }}
			    </option>
			@endforeach
        </select>
        
        {!! $errors->first('exerciseset_id', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group {{ $errors->has('user_id') ? 'has-error' : '' }}">
    <label for="user_id" class="col-md-2 control-label">User</label>
    <div class="col-md-10">
        <select class="form-control" id="user_id" name="user_id" required="true">
        	    <option value="" style="display: none;" {{ old('user_id', optional($exercisesetbuyer)->user_id ?: '') == '' ? 'selected' : '' }} disabled selected>Select user</option>
        	@foreach ($users as $key => $user)
			    <option value="{{ $key }}" {{ old('user_id', optional($exercisesetbuyer)->user_id) == $key ? 'selected' : '' }}>
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
        <input class="form-control" name="joindate" type="text" id="joindate" value="{{ old('joindate', optional($exercisesetbuyer)->joindate) }}" required="true" placeholder="Enter joindate here...">
        {!! $errors->first('joindate', '<p class="help-block">:message</p>') !!}
    </div>
</div>

