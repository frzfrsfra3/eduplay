
<div class="form-group {{ $errors->has('user_id') ? 'has-error' : '' }}">
    <label for="user_id" class="col-md-2 control-label">User</label>
    <div class="col-md-10">
        <select class="form-control" id="user_id" name="user_id" required="true">
        	    <option value="" style="display: none;" {{ old('user_id', optional($pendingtask)->user_id ?: '') == '' ? 'selected' : '' }} disabled selected>Select user</option>
        	@foreach ($users as $key => $user)
			    <option value="{{ $key }}" {{ old('user_id', optional($pendingtask)->user_id) == $key ? 'selected' : '' }}>
			    	{{ $user }}
			    </option>
			@endforeach
        </select>
        
        {!! $errors->first('user_id', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group {{ $errors->has('sender_id') ? 'has-error' : '' }}">
    <label for="sender_id" class="col-md-2 control-label">Sender</label>
    <div class="col-md-10">
        <select class="form-control" id="sender_id" name="sender_id" required="true">
        	    <option value="" style="display: none;" {{ old('sender_id', optional($pendingtask)->sender_id ?: '') == '' ? 'selected' : '' }} disabled selected>Select sender</option>
        	@foreach ($senders as $key => $sender)
			    <option value="{{ $key }}" {{ old('sender_id', optional($pendingtask)->sender_id) == $key ? 'selected' : '' }}>
			    	{{ $sender }}
			    </option>
			@endforeach
        </select>
        
        {!! $errors->first('sender_id', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group {{ $errors->has('pending_task') ? 'has-error' : '' }}">
    <label for="pending_task" class="col-md-2 control-label">Pending Task</label>
    <div class="col-md-10">
        <input class="form-control" name="pending_task" type="text" id="pending_task" value="{{ old('pending_task', optional($pendingtask)->pending_task) }}" minlength="1" maxlength="250" required="true" placeholder="Enter pending task here...">
        {!! $errors->first('pending_task', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group {{ $errors->has('status') ? 'has-error' : '' }}">
    <label for="status" class="col-md-2 control-label">Status</label>
    <div class="col-md-10">
        <select class="form-control" id="status" name="status" required="true">
        	    <option value="" style="display: none;" {{ old('status', optional($pendingtask)->status ?: '') == '' ? 'selected' : '' }} disabled selected>Enter status here...</option>
        	@foreach (['pending' => 'Pending',
'done' => 'Done',
'' => ''] as $key => $text)
			    <option value="{{ $key }}" {{ old('status', optional($pendingtask)->status) == $key ? 'selected' : '' }}>
			    	{{ $text }}
			    </option>
			@endforeach
        </select>
        
        {!! $errors->first('status', '<p class="help-block">:message</p>') !!}
    </div>
</div>

