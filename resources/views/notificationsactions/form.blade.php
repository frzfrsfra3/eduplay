
<div class="form-group {{ $errors->has('modelname') ? 'has-error' : '' }}">
    <label for="modelname" class="col-md-2 control-label">Modelname</label>
    <div class="col-md-10">
        <input class="form-control" name="modelname" type="text" id="modelname" value="{{ old('modelname', optional($notificationsaction)->modelname) }}" minlength="1" maxlength="250" required="true" placeholder="Enter modelname here...">
        {!! $errors->first('modelname', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group {{ $errors->has('notificationtpl') ? 'has-error' : '' }}">
    <label for="notificationtpl" class="col-md-2 control-label">Notificationtpl</label>
    <div class="col-md-10">
        <textarea class="form-control" name="notificationtpl" cols="50" rows="10" id="notificationtpl" required="true" placeholder="Enter notificationtpl here...">{{ old('notificationtpl', optional($notificationsaction)->notificationtpl) }}</textarea>
        {!! $errors->first('notificationtpl', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group {{ $errors->has('type') ? 'has-error' : '' }}">
    <label for="type" class="col-md-2 control-label">Type</label>
    <div class="col-md-10">
        <select class="form-control" id="type" name="type" required="true">
        	    <option value="" style="display: none;" {{ old('type', optional($notificationsaction)->type ?: '') == '' ? 'selected' : '' }} disabled selected>Enter type here...</option>
        	@foreach (['information' => 'Information',
'action' => 'Action',
'' => ''] as $key => $text)
			    <option value="{{ $key }}" {{ old('type', optional($notificationsaction)->type) == $key ? 'selected' : '' }}>
			    	{{ $text }}
			    </option>
			@endforeach
        </select>
        
        {!! $errors->first('type', '<p class="help-block">:message</p>') !!}
    </div>
</div>

