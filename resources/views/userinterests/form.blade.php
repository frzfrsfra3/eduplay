
<div class="form-group {{ $errors->has('discipline_id') ? 'has-error' : '' }}">
    <label for="discipline_id" class="col-md-2 control-label">Discipline</label>
    <div class="col-md-10">
        <select class="form-control" id="discipline_id" name="discipline_id" required="true">
        	    <option value="" style="display: none;" {{ old('discipline_id', optional($userinterest)->discipline_id ?: '') == '' ? 'selected' : '' }} disabled selected>Select discipline</option>
        	@foreach ($disciplines as $key => $discipline)
			    <option value="{{ $key }}" {{ old('discipline_id', optional($userinterest)->discipline_id) == $key ? 'selected' : '' }}>
			    	{{ $discipline }}
			    </option>
			@endforeach
        </select>
        
        {!! $errors->first('discipline_id', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group {{ $errors->has('user_id') ? 'has-error' : '' }}">
    <label for="user_id" class="col-md-2 control-label">User</label>
    <div class="col-md-10">
        <select class="form-control" id="user_id" name="user_id" required="true">
        	    <option value="" style="display: none;" {{ old('user_id', optional($userinterest)->user_id ?: '') == '' ? 'selected' : '' }} disabled selected>Select user</option>
        	@foreach ($users as $key => $user)
			    <option value="{{ $key }}" {{ old('user_id', optional($userinterest)->user_id) == $key ? 'selected' : '' }}>
			    	{{ $user }}
			    </option>
			@endforeach
        </select>
        
        {!! $errors->first('user_id', '<p class="help-block">:message</p>') !!}
    </div>
</div>

