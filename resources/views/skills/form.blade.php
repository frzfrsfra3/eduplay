


<div class="form-group {{ $errors->has('skill_category_id') ? 'has-error' : '' }}">
    <label for="skill_category_id" class="col-md-2 control-label">Skill Category</label>
    <div class="col-md-10">
        <select class="form-control" id="skill_category_id" name="skill_category_id" required="true">
        	    <option value="" style="display: none;" {{ old('skill_category_id', optional($skill)->skill_category_id ?: '') == '' ? 'selected' : '' }} disabled selected>Select skill category</option>
        	@foreach ($skillcategories as  $skillcategory)
			    <option value="{{ $skillcategory->id }}" {{ old('skill_category_id', optional($skill)->skill_category_id) == $skillcategory->id ? 'selected' : '' }}>
			    	{{ $skillcategory->skill_category_name }}
			    </option>
			@endforeach
        </select>

        {!! $errors->first('skill_category_id', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group {{ $errors->has('topic_id') ? 'has-error' : '' }}">
    <label for="topic_id" class="col-md-2 control-label">Topic</label>
    <div class="col-md-10">
        <select class="form-control" id="topic_id" name="topic_id">
        	    <option value="" style="display: none;" {{ old('topic_id', optional($skill)->topic_id ?: '') == '' ? 'selected' : '' }} disabled selected>Select topic</option>
        	@foreach ($topics as $key => $topic)
			    <option value="{{ $key  }}" {{ old('topic_id', optional($skill)->topic_id) == $key  ? 'selected' : '' }}>
			    	{{ $topic }}
			    </option>
			@endforeach
        </select>

        {!! $errors->first('topic_id', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group {{ $errors->has('grade_id') ? 'has-error' : '' }}">
    <label for="grade_id" class="col-md-2 control-label">Grade</label>
    <div class="col-md-10">
        <select class="form-control" id="grade_id" name="grade_id">
        	    <option value="" style="display: none;" {{ old('grade_id', optional($skill)->grade_id ?: '') == '' ? 'selected' : '' }} disabled selected>Select grade</option>
        	@foreach ($grades as $key => $grade)
			    <option value="{{ $key }}" {{ old('grade_id', optional($skill)->grade_id) == $key ? 'selected' : '' }}>
			    	{{ $grade }}
			    </option>
			@endforeach
        </select>
        
        {!! $errors->first('grade_id', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group {{ $errors->has('skill_name') ? 'has-error' : '' }}">
    <label for="skill_name" class="col-md-2 control-label">Skill Name</label>
    <div class="col-md-10">
        <input class="form-control" name="skill_name" type="text" id="skill_name" value="{{ old('skill_name', optional($skill)->skill_name) }}" minlength="1" maxlength="250" required="true" placeholder="Enter skill name here...">
        {!! $errors->first('skill_name', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group {{ $errors->has('skill_description') ? 'has-error' : '' }}">
    <label for="skill_description" class="col-md-2 control-label">Skill Description</label>
    <div class="col-md-10">
        <input class="form-control" name="skill_description" type="text" id="skill_description" value="{{ old('skill_description', optional($skill)->skill_description) }}" minlength="1" maxlength="500" required="true" placeholder="Enter skill description here...">
        {!! $errors->first('skill_description', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group {{ $errors->has('description_Fr') ? 'has-error' : '' }}">
    <label for="description_Fr" class="col-md-2 control-label">Skill description Fr</label>
    <div class="col-md-10">
        <input class="form-control" name="description_Fr" type="text" id="description_Fr" value="{{ old('description_Fr', optional($skill)->description_Fr) }}" minlength="1" maxlength="500" required="true" placeholder="Enter skill description here...">
        {!! $errors->first('description_Fr', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group {{ $errors->has('description_Ar') ? 'has-error' : '' }}">
    <label for="description_Ar" class="col-md-2 control-label">Skill description Ar</label>
    <div class="col-md-10">
        <input class="form-control" name="description_Ar" type="text" id="description_Ar" value="{{ old('description_Ar', optional($skill)->description_Ar) }}" minlength="1" maxlength="500" required="true" placeholder="Enter skill description here...">
        {!! $errors->first('description_Ar', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group {{ $errors->has('version') ? 'has-error' : '' }}">
    <label for="version" class="col-md-2 control-label">Version</label>
    <div class="col-md-10">
        <input class="form-control" name="version" type="number" id="version" value="{{ old('version', optional($skill)->version) }}" min="-2147483648" max="2147483647" required="true" placeholder="Enter version here...">
        {!! $errors->first('version', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group {{ $errors->has('publish_status') ? 'has-error' : '' }}">
    <label for="publish_status" class="col-md-2 control-label">Publish Status</label>
    <div class="col-md-10">
        <select class="form-control" id="publish_status" name="publish_status" required="true">
        	    <option value="" style="display: none;" {{ old('publish_status', optional($skill)->publish_status ?: '') == '' ? 'selected' : '' }} disabled selected>Enter publish status here...</option>
        	@foreach (['draft' => 'Draft',
'published' => 'Published',
'unpublished' => 'Unpublished',
'' => ''] as $key => $text)
			    <option value="{{ $key }}" {{ old('publish_status', optional($skill)->publish_status) == $key ? 'selected' : '' }}>
			    	{{ $text }}
			    </option>
			@endforeach
        </select>
        
        {!! $errors->first('publish_status', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group {{ $errors->has('approve_status') ? 'has-error' : '' }}">
    <label for="approve_status" class="col-md-2 control-label">Approve Status</label>
    <div class="col-md-10">
        <select class="form-control" id="approve_status" name="approve_status" required="true">
        	    <option value="" style="display: none;" {{ old('approve_status', optional($skill)->approve_status ?: '') == '' ? 'selected' : '' }} disabled selected>Enter approve status here...</option>
        	@foreach (['pending' => 'Pending',
'approved' => 'Approved',
'declined' => 'Declined',
'' => ''] as $key => $text)
			    <option value="{{ $key }}" {{ old('approve_status', optional($skill)->approve_status) == $key ? 'selected' : '' }}>
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
        <input class="form-control" name="createdby" type="number" id="createdby" value="{{ old('createdby', optional($skill)->createdby) }}" min="-2147483648" max="2147483647" required="true" placeholder="Enter createdby here...">
        {!! $errors->first('createdby', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group {{ $errors->has('updatedby') ? 'has-error' : '' }}">
    <label for="updatedby" class="col-md-2 control-label">Updated By</label>
    <div class="col-md-10">
        <input class="form-control" name="updatedby" type="number" id="updatedby" value="{{ old('updatedby', optional($skill)->updatedby) }}" min="-2147483648" max="2147483647" required="true" placeholder="Enter updated by here...">
        {!! $errors->first('updatedby', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group {{ $errors->has('sort_order') ? 'has-error' : '' }}">
    <label for="sort_order" class="col-md-2 control-label">Sort Order</label>
    <div class="col-md-10">
        <input class="form-control" name="sort_order" type="number" id="sort_order" value="{{ old('sort_order', optional($skill)->sort_order) }}" min="-2147483648" max="2147483647" placeholder="Enter sort order here...">
        {!! $errors->first('sort_order', '<p class="help-block">:message</p>') !!}
    </div>
</div>

