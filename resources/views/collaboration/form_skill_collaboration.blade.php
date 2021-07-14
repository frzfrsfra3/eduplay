
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



<div class="form-group {{ $errors->has('grade_id') ? 'has-error' : '' }}">
    <label for="grade_id" class="col-md-2 control-label">Grade</label>
    <div class="col-md-10">
        <select class="form-control" id="grade_id" name="grade_id"  required="true">
        	    <option value="" style="display: none;" {{ old('grade_id', optional($skill)->grade_id ?: '') == '' ? 'selected' : '' }} disabled selected>Select grade</option>
        	@foreach ($grades as $key => $grade)
			    <option value="{{ $grade->id }}" {{ old('grade_id', optional($skill)->grade_id) == $grade->id ? 'selected' : '' }}>
			    	{{ $grade->grade_name }}
			    </option>
			@endforeach
        </select>
        
        {!! $errors->first('grade_id', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group {{ $errors->has('skill_name') ? 'has-error' : '' }}">
    <label for="skill_name" class="col-md-2 control-label">Skill Name</label>
    <div class="col-md-10">
        <input class="form-control" name="skill_name" type="text" id="skill_name" value="{{ old('skill_name', optional($skill)->skill_name) }}" minlength="1" maxlength="250" required="true" placeholder="Enter skill name here..." style="text-align: left">
        {!! $errors->first('skill_name', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group {{ $errors->has('skill_description') ? 'has-error' : '' }}">
    <label for="skill_description" class="col-md-2 control-label">Skill Description</label>
    <div class="col-md-10">
        <input class="form-control" name="skill_description" type="text" id="skill_description" value="{{ old('skill_description', optional($skill)->skill_description) }}" minlength="1" maxlength="500" required="true" placeholder="Enter skill description here..." style="text-align: left">
        {!! $errors->first('skill_description', '<p class="help-block">:message</p>') !!}
    </div>
</div>


<div class="form-group {{ $errors->has('sort_order') ? 'has-error' : '' }}">
    <label for="sort_order" class="col-md-2 control-label">Sort Order</label>
    <div class="col-md-10">
        <input class="form-control" name="sort_order" type="number" id="sort_order" value="{{ old('sort_order', optional($skill)->sort_order) }}" min="-2147483648" max="2147483647" placeholder="Enter sort order here...">
        {!! $errors->first('sort_order', '<p class="help-block">:message</p>') !!}
    </div>
</div>




