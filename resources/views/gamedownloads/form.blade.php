
<div class="form-group {{ $errors->has('user_id') ? 'has-error' : '' }}">
    <label for="user_id" class="col-md-2 control-label">User</label>
    <div class="col-md-10">
        <select class="form-control" id="user_id" name="user_id" required="true">
        	    <option value="" style="display: none;" {{ old('user_id', optional($gamedownload)->user_id ?: '') == '' ? 'selected' : '' }} disabled selected>Select user</option>
        	@foreach ($users as $key => $user)
			    <option value="{{ $key }}" {{ old('user_id', optional($gamedownload)->user_id) == $key ? 'selected' : '' }}>
			    	{{ $user }}
			    </option>
			@endforeach
        </select>
        
        {!! $errors->first('user_id', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group {{ $errors->has('game_id') ? 'has-error' : '' }}">
    <label for="game_id" class="col-md-2 control-label">Game</label>
    <div class="col-md-10">
        <select class="form-control" id="game_id" name="game_id" required="true">
        	    <option value="" style="display: none;" {{ old('game_id', optional($gamedownload)->game_id ?: '') == '' ? 'selected' : '' }} disabled selected>Select game</option>
        	@foreach ($games as $key => $game)
			    <option value="{{ $key }}" {{ old('game_id', optional($gamedownload)->game_id) == $key ? 'selected' : '' }}>
			    	{{ $game }}
			    </option>
			@endforeach
        </select>
        
        {!! $errors->first('game_id', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group {{ $errors->has('download_type') ? 'has-error' : '' }}">
    <label for="download_type" class="col-md-2 control-label">Download Type</label>
    <div class="col-md-10">
        <select class="form-control" id="download_type" name="download_type" required="true">
        	    <option value="" style="display: none;" {{ old('download_type', optional($gamedownload)->download_type ?: '') == '' ? 'selected' : '' }} disabled selected>Enter download type here...</option>
        	@foreach (['google' => 'Google',
'app' => 'App',
'' => ''] as $key => $text)
			    <option value="{{ $key }}" {{ old('download_type', optional($gamedownload)->download_type) == $key ? 'selected' : '' }}>
			    	{{ $text }}
			    </option>
			@endforeach
        </select>
        
        {!! $errors->first('download_type', '<p class="help-block">:message</p>') !!}
    </div>
</div>

