
<div class="form-group {{ $errors->has('email') ? 'has-error' : '' }}">
    <label for="email" class="col-md-2 control-label">Email</label>
    <div class="col-md-10">
        <input class="form-control" name="email" type="text" id="email" value="{{ old('email', optional($newslettersubscription)->email) }}" minlength="1" maxlength="250" required="true" placeholder="Enter email here...">
        {!! $errors->first('email', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group {{ $errors->has('subscribedon') ? 'has-error' : '' }}">
    <label for="subscribedon" class="col-md-2 control-label">Subscribedon</label>
    <div class="col-md-10">
        <input class="form-control" name="subscribedon" type="text" id="subscribedon" value="{{ old('subscribedon', optional($newslettersubscription)->subscribedon) }}" required="true" placeholder="Enter subscribedon here...">
        {!! $errors->first('subscribedon', '<p class="help-block">:message</p>') !!}
    </div>
</div>

