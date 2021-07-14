
<div class="form-group {{ $errors->has('discipline_id') ? 'has-error' : '' }}">
    <label for="discipline_id" class="col-md-2 control-label">Discipline</label>
    <div class="col-md-10">
        <select class="form-control" id="discipline_id" name="discipline_id" required="true">
        	    <option value="" style="display: none;" {{ old('discipline_id', optional($skillcategory)->discipline_id ?: '') == '' ? 'selected' : '' }} disabled selected>Select discipline</option>
        	@foreach ($disciplines as $key => $discipline)
			    <option value="{{ $key }}" {{ old('discipline_id', optional($skillcategory)->discipline_id) == $key ? 'selected' : '' }}>
			    	{{ $discipline }}
			    </option>
			@endforeach
        </select>
        
        {!! $errors->first('discipline_id', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group {{ $errors->has('skill_category_name') ? 'has-error' : '' }}">
    <label for="skill_category_name" class="col-md-2 control-label">Skill Category Name</label>
    <div class="col-md-10">
        <input class="form-control" name="skill_category_name" type="text" id="skill_category_name" value="{{ old('skill_category_name', optional($skillcategory)->skill_category_name) }}" minlength="1" maxlength="250" required="true" placeholder="Enter skill category name here...">
        {!! $errors->first('skill_category_name', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group {{ $errors->has('skill_category_decsription') ? 'has-error' : '' }}">
    <label for="skill_category_decsription" class="col-md-2 control-label">Skill Category Decsription</label>
    <div class="col-md-10">
        <input class="form-control" name="skill_category_decsription" type="text" id="skill_category_decsription" value="{{ old('skill_category_decsription', optional($skillcategory)->skill_category_decsription) }}" minlength="1" maxlength="500" required="true" placeholder="Enter skill category decsription here...">
        {!! $errors->first('skill_category_decsription', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group {{ $errors->has('description_Fr') ? 'has-error' : '' }}">
    <label for="description_Fr" class="col-md-2 control-label">Skill description Fr</label>
    <div class="col-md-10">
        <input class="form-control" name="description_Fr" type="text" id="description_Fr" value="{{ old('description_Fr', optional($skillcategory)->description_Fr) }}" minlength="1" maxlength="500" required="true" placeholder="Enter skill description here...">
        {!! $errors->first('description_Fr', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group {{ $errors->has('description_Ar') ? 'has-error' : '' }}">
    <label for="description_Ar" class="col-md-2 control-label">Skill description Ar</label>
    <div class="col-md-10">
        <input class="form-control" name="description_Ar" type="text" id="description_Ar" value="{{ old('description_Ar', optional($skillcategory)->description_Ar) }}" minlength="1" maxlength="500" required="true" placeholder="Enter skill description here...">
        {!! $errors->first('description_Ar', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group {{ $errors->has('version') ? 'has-error' : '' }}">
    <label for="version" class="col-md-2 control-label">Version</label>
    <div class="col-md-10">
        <input class="form-control" name="version" type="number" id="version" value="{{ old('version', optional($skillcategory)->version) }}" min="-2147483648" max="2147483647" required="true" placeholder="Enter version here...">
        {!! $errors->first('version', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group {{ $errors->has('sort_order') ? 'has-error' : '' }}">
    <label for="sort_order" class="col-md-2 control-label">Sort Order</label>
    <div class="col-md-10">
        <input class="form-control" name="sort_order" type="number" id="sort_order" value="{{ old('sort_order', optional($skillcategory)->sort_order) }}" min="-2147483648" max="2147483647" required="true" placeholder="Enter sort order here...">
        {!! $errors->first('sort_order', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group {{ $errors->has('approve_status') ? 'has-error' : '' }}">
    <label for="approve_status" class="col-md-2 control-label">Approve Status</label>
    <div class="col-md-10">
        <select class="form-control" id="approve_status" name="approve_status" required="true">
        	    <option value="" style="display: none;" {{ old('approve_status', optional($skillcategory)->approve_status ?: '') == '' ? 'selected' : '' }} disabled selected>Enter approve status here...</option>
        	@foreach (['pending' => 'Pending',
'approved' => 'Approved',
'declined' => 'Declined',
'' => ''] as $key => $text)
			    <option value="{{ $key }}" {{ old('approve_status', optional($skillcategory)->approve_status) == $key ? 'selected' : '' }}>
			    	{{ $text }}
			    </option>
			@endforeach
        </select>
        
        {!! $errors->first('approve_status', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group {{ $errors->has('publish_status') ? 'has-error' : '' }}">
    <label for="publish_status" class="col-md-2 control-label">Publish Status</label>
    <div class="col-md-10">
        <select class="form-control" id="publish_status" name="publish_status" required="true">
        	    <option value="" style="display: none;" {{ old('publish_status', optional($skillcategory)->publish_status ?: '') == '' ? 'selected' : '' }} disabled selected>Enter publish status here...</option>
        	@foreach (['draft' => 'Draft',
'published' => 'Published',
'unpublished' => 'Unpublished',
'' => ''] as $key => $text)
			    <option value="{{ $key }}" {{ old('publish_status', optional($skillcategory)->publish_status) == $key ? 'selected' : '' }}>
			    	{{ $text }}
			    </option>
			@endforeach
        </select>
        
        {!! $errors->first('publish_status', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group {{ $errors->has('createdby') ? 'has-error' : '' }}">
    <label for="createdby" class="col-md-2 control-label">Createdby</label>
    <div class="col-md-10">
        <input class="form-control" name="createdby" type="number" id="createdby" value="{{ old('createdby', optional($skillcategory)->createdby) }}" min="-2147483648" max="2147483647" required="true" placeholder="Enter createdby here...">
        {!! $errors->first('createdby', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group {{ $errors->has('updatedby') ? 'has-error' : '' }}">
    <label for="updatedby" class="col-md-2 control-label">Updatedby</label>
    <div class="col-md-10">
        <input class="form-control" name="updatedby" type="number" id="updatedby" value="{{ old('updatedby', optional($skillcategory)->updatedby) }}" min="-2147483648" max="2147483647" required="true" placeholder="Enter updatedby here...">
        {!! $errors->first('updatedby', '<p class="help-block">:message</p>') !!}
    </div>
</div>

