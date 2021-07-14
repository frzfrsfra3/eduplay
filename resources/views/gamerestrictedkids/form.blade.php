
<div class="form-group {{ $errors->has('kid_id') ? 'has-error' : '' }}">
    <label for="kid_id" class="col-md-2 control-label">Kid</label>
    <div class="col-md-10">
        <select class="form-control" id="kid_id" name="kid_id" required="true">
        	    <option value="" style="display: none;" {{ old('kid_id', optional($gamerestrictedkid)->kid_id ?: '') == '' ? 'selected' : '' }} disabled selected>Select kid</option>
        	@foreach ($kids as $key => $kid)
			    <option value="{{ $key }}" {{ old('kid_id', optional($gamerestrictedkid)->kid_id) == $key ? 'selected' : '' }}>
			    	{{ $kid }}
			    </option>
			@endforeach
        </select>
        
        {!! $errors->first('kid_id', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group {{ $errors->has('game_id') ? 'has-error' : '' }}">
    <label for="game_id" class="col-md-2 control-label">Game</label>
    <div class="col-md-10">
        <select class="form-control" id="game_id" name="game_id" required="true">
        	    <option value="" style="display: none;" {{ old('game_id', optional($gamerestrictedkid)->game_id ?: '') == '' ? 'selected' : '' }} disabled selected>Select game</option>
        	@foreach ($games as $key => $game)
			    <option value="{{ $key }}" {{ old('game_id', optional($gamerestrictedkid)->game_id) == $key ? 'selected' : '' }}>
			    	{{ $game }}
			    </option>
			@endforeach
        </select>
        
        {!! $errors->first('game_id', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group {{ $errors->has('restricted_by') ? 'has-error' : '' }}">
    <label for="restricted_by" class="col-md-2 control-label">Restricted By</label>
    <div class="col-md-10">
        <select class="form-control" id="restricted_by" name="restricted_by" required="true">
        	    <option value="" style="display: none;" {{ old('restricted_by', optional($gamerestrictedkid)->restricted_by ?: '') == '' ? 'selected' : '' }} disabled selected>Select restricted by</option>
        	@foreach ($restrictedBies as $key => $restrictedBy)
			    <option value="{{ $key }}" {{ old('restricted_by', optional($gamerestrictedkid)->restricted_by) == $key ? 'selected' : '' }}>
			    	{{ $restrictedBy }}
			    </option>
			@endforeach
        </select>
        
        {!! $errors->first('restricted_by', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group {{ $errors->has('isactive') ? 'has-error' : '' }}">
    <label for="isactive" class="col-md-2 control-label">Isactive</label>
    <div class="col-md-10">
        <select class="form-control" id="isactive" name="isactive" required="true">
        	    <option value="" style="display: none;" {{ old('isactive', optional($gamerestrictedkid)->isactive ?: '') == '' ? 'selected' : '' }} disabled selected>Enter isactive here...</option>
        	@foreach (['Y' => 'Y',
'N' => 'N',
'' => ''] as $key => $text)
			    <option value="{{ $key }}" {{ old('isactive', optional($gamerestrictedkid)->isactive) == $key ? 'selected' : '' }}>
			    	{{ $text }}
			    </option>
			@endforeach
        </select>
        
        {!! $errors->first('isactive', '<p class="help-block">:message</p>') !!}
    </div>
</div>

