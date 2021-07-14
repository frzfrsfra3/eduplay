
<div class="form-group {{ $errors->has('discipline_id') ? 'has-error' : '' }}" style="display: none;">
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

<div class="form-group {{ $errors->has('sort_order') ? 'has-error' : '' }}">
    <label for="sort_order" class="col-md-2 control-label">Sort Order</label>
    <div class="col-md-10">
        <input class="form-control" name="sort_order" type="number" id="sort_order" value="{{ old('sort_order', optional($skillcategory)->sort_order) }}" min="-2147483648" max="2147483647" required="true" placeholder="Enter sort order here...">
        {!! $errors->first('sort_order', '<p class="help-block">:message</p>') !!}
    </div>
</div>




