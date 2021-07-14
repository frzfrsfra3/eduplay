
<div class="form-group {{ $errors->has('curriculum_gradelist_name') ? 'has-error' : '' }}">
    <label for="curriculum_gradelist_name" class="col-md-2 control-label">Curriculum Name</label>
    <div class="col-md-10">
        <input class="form-control" name="curriculum_gradelist_name" type="text" id="curriculum_ Grade list name" value="{{ old('curriculum_gradelist_name', optional($curriculum)->curriculum_gradelist_name) }}" minlength="1" maxlength="250" required="true" placeholder="Enter curriculum name here...">
        {!! $errors->first('curriculum_gradelist_name', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group {{ $errors->has('description') ? 'has-error' : '' }}">
    <label for="description" class="col-md-2 control-label">Description</label>
    <div class="col-md-10">
        <textarea class="form-control" name="description" cols="50" rows="10" id="description" required="true">{{ old('description', optional($curriculum)->description) }}</textarea>
        {!! $errors->first('description', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group {{ $errors->has('country_id') ? 'has-error' : '' }}">
    <label for="country_id" class="col-md-2 control-label">Country</label>
    <div class="col-md-10">
        <select class="form-control" id="country_id" name="country_id" required="true">
        	    <option value="" style="display: none;" {{ old('country_id', optional($curriculum)->country_id ?: '') == '' ? 'selected' : '' }} disabled selected>Enter country here...</option>
        	@foreach ($countries as $key => $country)
			    <option value="{{ $key }}" {{ old('country_id', optional($curriculum)->country_id) == $key ? 'selected' : '' }}>
			    	{{ $country }}
			    </option>
			@endforeach
        </select>
        
        {!! $errors->first('country_id', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group {{ $errors->has('approve_status') ? 'has-error' : '' }}">
    <label for="approve_status" class="col-md-2 control-label">Approve Status</label>
    <div class="col-md-10">
        <select class="form-control" id="approve_status" name="approve_status" required="true">
        	    <option value="" style="display: none;" {{ old('approve_status', optional($curriculum)->approve_status ?: '') == '' ? 'selected' : '' }} disabled selected>Enter approve status here...</option>
        	@foreach (['pending' => 'Pending',
'approved' => 'Approved',
'declined' => 'Declined',
'' => ''] as $key => $text)
			    <option value="{{ $key }}" {{ old('approve_status', optional($curriculum)->approve_status) == $key ? 'selected' : '' }}>
			    	{{ $text }}
			    </option>
			@endforeach
        </select>
        
        {!! $errors->first('approve_status', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group {{ $errors->has('createdby') ? 'has-error' : '' }}">
    <label for="createdby" class="col-md-2 control-label">Createdby</label>
    <div class="col-md-10">
        <input class="form-control" name="createdby" type="number" id="createdby" value="{{ old('createdby', optional($curriculum)->createdby) }}" min="-2147483648" max="2147483647" required="true" placeholder="Enter createdby here...">
        {!! $errors->first('createdby', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group {{ $errors->has('updatedby') ? 'has-error' : '' }}">
    <label for="updatedby" class="col-md-2 control-label">Updatedby</label>
    <div class="col-md-10">
        <input class="form-control" name="updatedby" type="number" id="updatedby" value="{{ old('updatedby', optional($curriculum)->updatedby) }}" min="-2147483648" max="2147483647" required="true" placeholder="Enter updatedby here...">
        {!! $errors->first('updatedby', '<p class="help-block">:message</p>') !!}
    </div>
</div>

