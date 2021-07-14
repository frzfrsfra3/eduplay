
<div class="form-group {{ $errors->has('user_id') ? 'has-error' : '' }}">
    <label for="user_id" class="col-md-2 control-label">User</label>
    <div class="col-md-10">
        <select class="form-control" id="user_id" name="user_id" required="true">
        	    <option value="" style="display: none;" {{ old('user_id', optional($userbadge)->user_id ?: '') == '' ? 'selected' : '' }} disabled selected>Select user</option>
        	@foreach ($users as $key => $user)
			    <option value="{{ $key }}" {{ old('user_id', optional($userbadge)->user_id) == $key ? 'selected' : '' }}>
			    	{{ $user }}
			    </option>
			@endforeach
        </select>
        
        {!! $errors->first('user_id', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group {{ $errors->has('badge_id') ? 'has-error' : '' }}">
    <label for="badge_id" class="col-md-2 control-label">Badge</label>
    <div class="col-md-10">
        <select class="form-control" id="badge_id" name="badge_id" required="true">
        	    <option value="" style="display: none;" {{ old('badge_id', optional($userbadge)->badge_id ?: '') == '' ? 'selected' : '' }} disabled selected>Select badge</option>
        	@foreach ($badges as $key => $badge)
			    <option value="{{ $key }}" {{ old('badge_id', optional($userbadge)->badge_id) == $key ? 'selected' : '' }}>
			    	{{ $badge }}
			    </option>
			@endforeach
        </select>
        
        {!! $errors->first('badge_id', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group {{ $errors->has('dateacquired') ? 'has-error' : '' }}">
    <label for="dateacquired" class="col-md-2 control-label">Dateacquired</label>
    <div class="col-md-10">
        <input class="form-control" name="dateacquired" type="text" id="dateacquired" value="{{ old('dateacquired', optional($userbadge)->dateacquired) }}" required="true" placeholder="Enter dateacquired here...">
        {!! $errors->first('dateacquired', '<p class="help-block">:message</p>') !!}
    </div>
</div>

