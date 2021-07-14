
<div class="form-group {{ $errors->has('activity_id') ? 'has-error' : '' }}">
    <label for="activity_id" class="col-md-2 control-label">Activity</label>
    <div class="col-md-10">
        <select class="form-control" id="activity_id" name="activity_id" required="true">
        	    <option value="" style="display: none;" {{ old('activity_id', optional($useractivitylog)->activity_id ?: '') == '' ? 'selected' : '' }} disabled selected>Select activity</option>
        	@foreach ($activities as $key => $activity)
			    <option value="{{ $key }}" {{ old('activity_id', optional($useractivitylog)->activity_id) == $key ? 'selected' : '' }}>
			    	{{ $activity }}
			    </option>
			@endforeach
        </select>
        
        {!! $errors->first('activity_id', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group {{ $errors->has('user_id') ? 'has-error' : '' }}">
    <label for="user_id" class="col-md-2 control-label">User</label>
    <div class="col-md-10">
      <input type="text" id="user_id" name="user_id" value="{{$id}}" readonly>
        {{-- <select class="form-control" id="user_id" name="user_id" required="true">
        	    <option value="" style="display: none;" {{ old('user_id', optional($useractivitylog)->user_id ?: '') == '' ? 'selected' : '' }} disabled selected>Select user</option>
        	@foreach ($users as $key => $user)
			    <option value="{{ $key }}" {{ old('user_id', optional($useractivitylog)->user_id) == $key ? 'selected' : '' }}>
			    	{{ $user }}
			    </option>
		    	@endforeach
        </select> --}}
        
        {!! $errors->first('user_id', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group {{ $errors->has('newpoints') ? 'has-error' : '' }}">
    <label for="newpoints" class="col-md-2 control-label">Newpoints</label>
    <div class="col-md-10">
        <input class="form-control" name="newpoints" type="number" id="newpoints" value="{{ old('newpoints', optional($useractivitylog)->newpoints) }}" min="-2147483648" max="2147483647" placeholder="Enter newpoints here...">
        {!! $errors->first('newpoints', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group {{ $errors->has('device') ? 'has-error' : '' }}">
    <label for="device" class="col-md-2 control-label">Device</label>
    <div class="col-md-10">
        <input class="form-control" name="device" type="text" id="device" value="{{ old('device', optional($useractivitylog)->device) }}" maxlength="500" placeholder="Enter device here...">
        {!! $errors->first('device', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group {{ $errors->has('browserinformation') ? 'has-error' : '' }}">
    <label for="browserinformation" class="col-md-2 control-label">Browserinformation</label>
    <div class="col-md-10">
        <input class="form-control" name="browserinformation" type="text" id="browserinformation" value="{{ old('browserinformation', optional($useractivitylog)->browserinformation) }}" maxlength="500" placeholder="Enter browserinformation here...">
        {!! $errors->first('browserinformation', '<p class="help-block">:message</p>') !!}
    </div>
</div>

