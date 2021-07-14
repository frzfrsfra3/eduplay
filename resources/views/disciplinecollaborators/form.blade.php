
<div class="form-group {{ $errors->has('discipline_id') ? 'has-error' : '' }}">
    <label for="discipline_id" class="col-md-2 control-label">Discipline</label>
    <div class="col-md-10">
        <select class="form-control" id="discipline_id" name="discipline_id" required="true">
        	    <option value="" style="display: none;" {{ old('discipline_id', optional($disciplinecollaborator)->discipline_id ?: '') == '' ? 'selected' : '' }} disabled selected>Select discipline</option>
        	@foreach ($disciplines as $key => $discipline)
			    <option value="{{ $key }}" {{ old('discipline_id', optional($disciplinecollaborator)->discipline_id) == $key ? 'selected' : '' }}>
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
        	    <option value="" style="display: none;" {{ old('user_id', optional($disciplinecollaborator)->user_id ?: '') == '' ? 'selected' : '' }} disabled selected>Select user</option>
        	@foreach ($users as $key => $user)
			    <option value="{{ $key }}" {{ old('user_id', optional($disciplinecollaborator)->user_id) == $key ? 'selected' : '' }}>
			    	{{ $user }}
			    </option>
			@endforeach
        </select>
        
        {!! $errors->first('user_id', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group {{ $errors->has('message') ? 'has-error' : '' }}">
    <label for="message" class="col-md-2 control-label">Message</label>
    <div class="col-md-10">
        <textarea class="form-control" name="message" cols="50" rows="10" id="message" required="true" placeholder="Enter message here...">{{ old('message', optional($disciplinecollaborator)->message) }}</textarea>
        {!! $errors->first('message', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group {{ $errors->has('iscoordinator') ? 'has-error' : '' }}">
    <label for="iscoordinator" class="col-md-2 control-label">Iscoordinator</label>
    <div class="col-md-10">
        <div class="checkbox">
            <label for="iscoordinator_1">
            	<input id="iscoordinator_1" class="" name="iscoordinator" type="checkbox" value="1" {{ old('iscoordinator', optional($disciplinecollaborator)->iscoordinator) == '1' ? 'checked' : '' }}>
                Yes
            </label>
        </div>

        {!! $errors->first('iscoordinator', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group {{ $errors->has('approvalstatus') ? 'has-error' : '' }}">
    <label for="approvalstatus" class="col-md-2 control-label">Approvalstatus</label>
    <div class="col-md-10">
        <select class="form-control" id="approvalstatus" name="approvalstatus" required="true">
        	    <option value="" style="display: none;" {{ old('approvalstatus', optional($disciplinecollaborator)->approvalstatus ?: '') == '' ? 'selected' : '' }} disabled selected>Enter approvalstatus here...</option>
        	@foreach (['pending' => 'Pending',
'approved' => 'Approved',
'declined' => 'Declined',
'' => ''] as $key => $text)
			    <option value="{{ $key }}" {{ old('approvalstatus', optional($disciplinecollaborator)->approvalstatus) == $key ? 'selected' : '' }}>
			    	{{ $text }}
			    </option>
			@endforeach
        </select>
        
        {!! $errors->first('approvalstatus', '<p class="help-block">:message</p>') !!}
    </div>
</div>

