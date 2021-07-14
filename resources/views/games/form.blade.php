
<div class="form-group {{ $errors->has('discipline_id') ? 'has-error' : '' }}">
    <label for="discipline_id" class="col-md-2 control-label">Discipline</label>
    <div class="col-md-10">
        <select class="form-control" id="discipline_id" name="discipline_id" required="true">
        	    <option value="" style="display: none;" {{ old('discipline_id', optional($game)->discipline_id ?: '') == '' ? 'selected' : '' }} disabled selected>Select discipline</option>
        	@foreach ($disciplines as $key => $discipline)
			    <option value="{{ $key }}" {{ old('discipline_id', optional($game)->discipline_id) == $key ? 'selected' : '' }}>
			    	{{ $discipline }}
			    </option>
			@endforeach
        </select>
        
        {!! $errors->first('discipline_id', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group {{ $errors->has('developer_id') ? 'has-error' : '' }}">
    <label for="developer_id" class="col-md-2 control-label">Developer</label>
    <div class="col-md-10">
        <select class="form-control" id="developer_id" name="developer_id" required="true">
        	    <option value="" style="display: none;" {{ old('developer_id', optional($game)->developer_id ?: '') == '' ? 'selected' : '' }} disabled selected>Select developer</option>
        	@foreach ($developers as $key => $developer)
			    <option value="{{ $key }}" {{ old('developer_id', optional($game)->developer_id) == $key ? 'selected' : '' }}>
			    	{{ $developer }}
			    </option>
			@endforeach
        </select>
        
        {!! $errors->first('developer_id', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group {{ $errors->has('game_name') ? 'has-error' : '' }}">
    <label for="game_name" class="col-md-2 control-label">Game Name</label>
    <div class="col-md-10">
        <input class="form-control" name="game_name" type="number" id="game_name" value="{{ old('game_name', optional($game)->game_name) }}" min="-2147483648" max="2147483647" required="true" placeholder="Enter game name here...">
        {!! $errors->first('game_name', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group {{ $errors->has('patform') ? 'has-error' : '' }}">
    <label for="patform" class="col-md-2 control-label">Patform</label>
    <div class="col-md-10">
        <select class="form-control" id="patform" name="patform" required="true">
        	    <option value="" style="display: none;" {{ old('patform', optional($game)->patform ?: '') == '' ? 'selected' : '' }} disabled selected>Enter patform here...</option>
        	@foreach (['IOS' => 'IOS',
'android' => 'Android',
'' => ''] as $key => $text)
			    <option value="{{ $key }}" {{ old('patform', optional($game)->patform) == $key ? 'selected' : '' }}>
			    	{{ $text }}
			    </option>
			@endforeach
        </select>
        
        {!! $errors->first('patform', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group {{ $errors->has('app_id') ? 'has-error' : '' }}">
    <label for="app_id" class="col-md-2 control-label">App</label>
    <div class="col-md-10">
        <select class="form-control" id="app_id" name="app_id" required="true">
        	    <option value="" style="display: none;" {{ old('app_id', optional($game)->app_id ?: '') == '' ? 'selected' : '' }} disabled selected>Select app</option>
        	@foreach ($apps as $key => $app)
			    <option value="{{ $key }}" {{ old('app_id', optional($game)->app_id) == $key ? 'selected' : '' }}>
			    	{{ $app }}
			    </option>
			@endforeach
        </select>
        
        {!! $errors->first('app_id', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group {{ $errors->has('secrete_key') ? 'has-error' : '' }}">
    <label for="secrete_key" class="col-md-2 control-label">Secrete Key</label>
    <div class="col-md-10">
        <input class="form-control" name="secrete_key" type="text" id="secrete_key" value="{{ old('secrete_key', optional($game)->secrete_key) }}" minlength="1" maxlength="500" required="true" placeholder="Enter secrete key here...">
        {!! $errors->first('secrete_key', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group {{ $errors->has('game_icon') ? 'has-error' : '' }}">
    <label for="game_icon" class="col-md-2 control-label">Game Icon</label>
    <div class="col-md-10">
        <input class="form-control" name="game_icon" type="text" id="game_icon" value="{{ old('game_icon', optional($game)->game_icon) }}" minlength="1" maxlength="250" required="true" placeholder="Enter game icon here...">
        {!! $errors->first('game_icon', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group {{ $errors->has('image1') ? 'has-error' : '' }}">
    <label for="image1" class="col-md-2 control-label">Image1</label>
    <div class="col-md-10">
        <input class="form-control" name="image1" type="text" id="image1" value="{{ old('image1', optional($game)->image1) }}" min="1" max="250" required="true" placeholder="Enter image1 here...">
        {!! $errors->first('image1', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group {{ $errors->has('image2') ? 'has-error' : '' }}">
    <label for="image2" class="col-md-2 control-label">Image2</label>
    <div class="col-md-10">
        <input class="form-control" name="image2" type="text" id="image2" value="{{ old('image2', optional($game)->image2) }}" min="1" max="250" required="true" placeholder="Enter image2 here...">
        {!! $errors->first('image2', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group {{ $errors->has('image3') ? 'has-error' : '' }}">
    <label for="image3" class="col-md-2 control-label">Image3</label>
    <div class="col-md-10">
        <input class="form-control" name="image3" type="text" id="image3" value="{{ old('image3', optional($game)->image3) }}" min="1" max="250" required="true" placeholder="Enter image3 here...">
        {!! $errors->first('image3', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group {{ $errors->has('image4') ? 'has-error' : '' }}">
    <label for="image4" class="col-md-2 control-label">Image4</label>
    <div class="col-md-10">
        <input class="form-control" name="image4" type="text" id="image4" value="{{ old('image4', optional($game)->image4) }}" min="1" max="250" required="true" placeholder="Enter image4 here...">
        {!! $errors->first('image4', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group {{ $errors->has('image5') ? 'has-error' : '' }}">
    <label for="image5" class="col-md-2 control-label">Image5</label>
    <div class="col-md-10">
        <input class="form-control" name="image5" type="text" id="image5" value="{{ old('image5', optional($game)->image5) }}" min="1" max="250" required="true" placeholder="Enter image5 here...">
        {!! $errors->first('image5', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group {{ $errors->has('category_id') ? 'has-error' : '' }}">
    <label for="category_id" class="col-md-2 control-label">Category</label>
    <div class="col-md-10">
        <select class="form-control" id="category_id" name="category_id" required="true">
        	    <option value="" style="display: none;" {{ old('category_id', optional($game)->category_id ?: '') == '' ? 'selected' : '' }} disabled selected>Select category</option>
        	@foreach ($categories as $key => $category)
			    <option value="{{ $key }}" {{ old('category_id', optional($game)->category_id) == $key ? 'selected' : '' }}>
			    	{{ $category }}
			    </option>
			@endforeach
        </select>
        
        {!! $errors->first('category_id', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group {{ $errors->has('age_id') ? 'has-error' : '' }}">
    <label for="age_id" class="col-md-2 control-label">Age</label>
    <div class="col-md-10">
        <select class="form-control" id="age_id" name="age_id" required="true">
        	    <option value="" style="display: none;" {{ old('age_id', optional($game)->age_id ?: '') == '' ? 'selected' : '' }} disabled selected>Enter age here...</option>
        	@foreach ($ages as $key => $age)
			    <option value="{{ $key }}" {{ old('age_id', optional($game)->age_id) == $key ? 'selected' : '' }}>
			    	{{ $age }}
			    </option>
			@endforeach
        </select>
        
        {!! $errors->first('age_id', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group {{ $errors->has('status') ? 'has-error' : '' }}">
    <label for="status" class="col-md-2 control-label">Status</label>
    <div class="col-md-10">
        <select class="form-control" id="status" name="status" required="true">
        	    <option value="" style="display: none;" {{ old('status', optional($game)->status ?: '') == '' ? 'selected' : '' }} disabled selected>Enter status here...</option>
        	@foreach (['draft' => 'Draft',
'published' => 'Published',
'unpublished' => 'Unpublished',
'' => ''] as $key => $text)
			    <option value="{{ $key }}" {{ old('status', optional($game)->status) == $key ? 'selected' : '' }}>
			    	{{ $text }}
			    </option>
			@endforeach
        </select>
        
        {!! $errors->first('status', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group {{ $errors->has('isapproved') ? 'has-error' : '' }}">
    <label for="isapproved" class="col-md-2 control-label">Isapproved</label>
    <div class="col-md-10">
        <select class="form-control" id="isapproved" name="isapproved" required="true">
        	    <option value="" style="display: none;" {{ old('isapproved', optional($game)->isapproved ?: '') == '' ? 'selected' : '' }} disabled selected>Enter isapproved here...</option>
        	@foreach (['Y' => 'Y',
'N' => 'N',
'' => ''] as $key => $text)
			    <option value="{{ $key }}" {{ old('isapproved', optional($game)->isapproved) == $key ? 'selected' : '' }}>
			    	{{ $text }}
			    </option>
			@endforeach
        </select>
        
        {!! $errors->first('isapproved', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group {{ $errors->has('isactive') ? 'has-error' : '' }}">
    <label for="isactive" class="col-md-2 control-label">Isactive</label>
    <div class="col-md-10">
        <select class="form-control" id="isactive" name="isactive" required="true">
        	    <option value="" style="display: none;" {{ old('isactive', optional($game)->isactive ?: '') == '' ? 'selected' : '' }} disabled selected>Enter isactive here...</option>
        	@foreach (['Y' => 'Y',
'N' => 'N',
'' => ''] as $key => $text)
			    <option value="{{ $key }}" {{ old('isactive', optional($game)->isactive) == $key ? 'selected' : '' }}>
			    	{{ $text }}
			    </option>
			@endforeach
        </select>
        
        {!! $errors->first('isactive', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group {{ $errors->has('description') ? 'has-error' : '' }}">
    <label for="description" class="col-md-2 control-label">Description</label>
    <div class="col-md-10">
        <textarea class="form-control" name="description" cols="50" rows="10" id="description" required="true">{{ old('description', optional($game)->description) }}</textarea>
        {!! $errors->first('description', '<p class="help-block">:message</p>') !!}
    </div>
</div>

