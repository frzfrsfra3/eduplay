
<div class="form-group {{ $errors->has('receiver_userid') ? 'has-error' : '' }}">
    <label for="receiver_userid" class="col-md-2 control-label">Receiver Userid</label>
    <div class="col-md-10">
        <input class="form-control" name="receiver_userid" type="number" id="receiver_userid" value="{{ old('receiver_userid', optional($usernotification)->receiver_userid) }}" min="-2147483648" max="2147483647" required="true" placeholder="Enter receiver userid here...">
        {!! $errors->first('receiver_userid', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group {{ $errors->has('sender_userid') ? 'has-error' : '' }}">
    <label for="sender_userid" class="col-md-2 control-label">Sender Userid</label>
    <div class="col-md-10">
        <input class="form-control" name="sender_userid" type="number" id="sender_userid" value="{{ old('sender_userid', optional($usernotification)->sender_userid) }}" min="-2147483648" max="2147483647" required="true" placeholder="Enter sender userid here...">
        {!! $errors->first('sender_userid', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group {{ $errors->has('notification') ? 'has-error' : '' }}">
    <label for="notification" class="col-md-2 control-label">Notification</label>
    <div class="col-md-10">
        <textarea class="form-control" name="notification" cols="50" rows="10" id="notification" required="true" placeholder="Enter notification here...">{{ old('notification', optional($usernotification)->notification) }}</textarea>
        {!! $errors->first('notification', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group {{ $errors->has('action_id') ? 'has-error' : '' }}">
    <label for="action_id" class="col-md-2 control-label">Action</label>
    <div class="col-md-10">
        <select class="form-control" id="action_id" name="action_id">
        	    <option value="" style="display: none;" {{ old('action_id', optional($usernotification)->action_id ?: '') == '' ? 'selected' : '' }} disabled selected>Select action</option>
        	@foreach ($actions as $key => $action)
			    <option value="{{ $key }}" {{ old('action_id', optional($usernotification)->action_id) == $key ? 'selected' : '' }}>
			    	{{ $action }}
			    </option>
			@endforeach
        </select>
        
        {!! $errors->first('action_id', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group {{ $errors->has('status') ? 'has-error' : '' }}">
    <label for="status" class="col-md-2 control-label">Status</label>
    <div class="col-md-10">
        <select class="form-control" id="status" name="status">
        	    <option value="" style="display: none;" {{ old('status', optional($usernotification)->status ?: '') == '' ? 'selected' : '' }} disabled selected>Enter status here...</option>
        	@foreach (['Y' => 'Y',
'N' => 'N',
'' => ''] as $key => $text)
			    <option value="{{ $key }}" {{ old('status', optional($usernotification)->status) == $key ? 'selected' : '' }}>
			    	{{ $text }}
			    </option>
			@endforeach
        </select>
        
        {!! $errors->first('status', '<p class="help-block">:message</p>') !!}
    </div>
</div>

