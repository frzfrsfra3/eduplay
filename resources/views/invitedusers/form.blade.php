
<div class="form-group {{ $errors->has('email') ? 'has-error' : '' }}">
    <label for="email" class="col-md-2 control-label">Email</label>
    <div class="col-md-10">
        <input class="form-control" name="email" type="text" id="email" value="{{ old('email', optional($inviteduser)->email) }}" minlength="1" maxlength="250" required="true" placeholder="Enter email here...">
        {!! $errors->first('email', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group {{ $errors->has('invitedby') ? 'has-error' : '' }}">
    <label for="invitedby" class="col-md-2 control-label">Invitedby</label>
    <div class="col-md-10">
        <input class="form-control" name="invitedby" type="number" id="invitedby" value="{{ old('invitedby', optional($inviteduser)->invitedby) }}" min="-2147483648" max="2147483647" required="true" placeholder="Enter invitedby here...">
        {!! $errors->first('invitedby', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group {{ $errors->has('message') ? 'has-error' : '' }}">
    <label for="message" class="col-md-2 control-label">Message</label>
    <div class="col-md-10">
        <textarea class="form-control" name="message" cols="50" rows="10" id="message" required="true" placeholder="Enter message here...">{{ old('message', optional($inviteduser)->message) }}</textarea>
        {!! $errors->first('message', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group {{ $errors->has('invitationtype') ? 'has-error' : '' }}">
    <label for="invitationtype" class="col-md-2 control-label">Invitationtype</label>
    <div class="col-md-10">
        <select class="form-control" id="invitationtype" name="invitationtype" required="true">
        	    <option value="" style="display: none;" {{ old('invitationtype', optional($inviteduser)->invitationtype ?: '') == '' ? 'selected' : '' }} disabled selected>Enter invitationtype here...</option>
        	@foreach (['parent' => 'Parent',
'child' => 'Child',
'collaboration' => 'Collaboration',
'' => ''] as $key => $text)
			    <option value="{{ $key }}" {{ old('invitationtype', optional($inviteduser)->invitationtype) == $key ? 'selected' : '' }}>
			    	{{ $text }}
			    </option>
			@endforeach
        </select>
        
        {!! $errors->first('invitationtype', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group {{ $errors->has('invitationstatus') ? 'has-error' : '' }}">
    <label for="invitationstatus" class="col-md-2 control-label">Invitationstatus</label>
    <div class="col-md-10">
        <select class="form-control" id="invitationstatus" name="invitationstatus" required="true">
        	    <option value="" style="display: none;" {{ old('invitationstatus', optional($inviteduser)->invitationstatus ?: '') == '' ? 'selected' : '' }} disabled selected>Enter invitationstatus here...</option>
        	@foreach (['accepted' => 'Accepted',
'rejected' => 'Rejected',
'pending' => 'Pending',
'' => ''] as $key => $text)
			    <option value="{{ $key }}" {{ old('invitationstatus', optional($inviteduser)->invitationstatus) == $key ? 'selected' : '' }}>
			    	{{ $text }}
			    </option>
			@endforeach
        </select>
        
        {!! $errors->first('invitationstatus', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group {{ $errors->has('isinvitedregistered') ? 'has-error' : '' }}">
    <label for="isinvitedregistered" class="col-md-2 control-label">Isinvitedregistered</label>
    <div class="col-md-10">
        <div class="checkbox">
            <label for="isinvitedregistered_1">
            	<input id="isinvitedregistered_1" class="" name="isinvitedregistered" type="checkbox" value="1" {{ old('isinvitedregistered', optional($inviteduser)->isinvitedregistered) == '1' ? 'checked' : '' }}>
                Yes
            </label>
        </div>

        {!! $errors->first('isinvitedregistered', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group {{ $errors->has('discipline_id') ? 'has-error' : '' }}">
    <label for="discipline_id" class="col-md-2 control-label">Discipline</label>
    <div class="col-md-10">
        <select class="form-control" id="discipline_id" name="discipline_id">
        	    <option value="" style="display: none;" {{ old('discipline_id', optional($inviteduser)->discipline_id ?: '') == '' ? 'selected' : '' }} disabled selected>Select discipline</option>
        	@foreach ($disciplines as $key => $discipline)
			    <option value="{{ $key }}" {{ old('discipline_id', optional($inviteduser)->discipline_id) == $key ? 'selected' : '' }}>
			    	{{ $discipline }}
			    </option>
			@endforeach
        </select>
        
        {!! $errors->first('discipline_id', '<p class="help-block">:message</p>') !!}
    </div>
</div>

