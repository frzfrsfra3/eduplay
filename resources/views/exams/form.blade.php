
<div class="form-group {{ $errors->has('examtype') ? 'has-error' : '' }}">
    <label for="examtype" class="col-md-2 control-label">Examtype</label>
    <div class="col-md-10">
        <select class="form-control" id="examtype" name="examtype" required="true">
        	    <option value="" style="display: none;" {{ old('examtype', optional($exam)->examtype ?: '') == '' ? 'selected' : '' }} disabled selected>Enter examtype here...</option>
        	@foreach (['homework' => 'Homework',
'test' => 'Test',
'practice' => 'Practice',
'' => ''] as $key => $text)
			    <option value="{{ $key }}" {{ old('examtype', optional($exam)->examtype) == $key ? 'selected' : '' }}>
			    	{{ $text }}
			    </option>
			@endforeach
        </select>
        
        {!! $errors->first('examtype', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group {{ $errors->has('title') ? 'has-error' : '' }}">
    <label for="title" class="col-md-2 control-label">Title</label>
    <div class="col-md-10">
        <input class="form-control" name="title" type="text" id="title" value="{{ old('title', optional($exam)->title) }}" minlength="1" maxlength="250" required="true" placeholder="Enter title here...">
        {!! $errors->first('title', '<p class="help-block">:message</p>') !!}
    </div>
</div>







<div class="form-group {{ $errors->has('isavailable') ? 'has-error' : '' }}">
    <label for="isavailable" class="col-md-2 control-label">Isavailable</label>
    <div class="col-md-10">
        <select class="form-control" id="isavailable" name="isavailable" required="true">
        	    <option value="" style="display: none;" {{ old('isavailable', optional($exam)->isavailable ?: '') == '' ? 'selected' : '' }} disabled selected>Enter isavailable here...</option>
        	@foreach (['Y' => 'Y', 'N' => 'N', '' => ''] as $key => $text)
			    <option value="{{ $key }}" {{ old('isavailable', optional($exam)->isavailable) == $key ? 'selected' : '' }}>
			    	{{ $text }}
			    </option>
			@endforeach
        </select>
        
        {!! $errors->first('isavailable', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group {{ $errors->has('skillcategory_id') ? 'has-error' : '' }}">
    <label for="skillcategory_id" class="col-md-2 control-label">Skillcategory</label>
    <div class="col-md-10">
        <select class="form-control" id="skillcategory_id" name="skillcategory_id">
        	    <option value="" style="display: none;" {{ old('skillcategory_id', optional($exam)->skillcategory_id ?: '') == '' ? 'selected' : '' }} disabled selected>Select skillcategory</option>
        	@foreach ($skillcategories as $key => $skillcategory)
			    <option value="{{ $key }}" {{ old('skillcategory_id', optional($exam)->skillcategory_id) == $key ? 'selected' : '' }}>
			    	{{ $skillcategory }}
			    </option>
			@endforeach
        </select>
        
        {!! $errors->first('skillcategory_id', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group {{ $errors->has('skill_id') ? 'has-error' : '' }}">
    <label for="skill_id" class="col-md-2 control-label">Skill</label>
    <div class="col-md-10">
        <select class="form-control" id="skill_id" name="skill_id">
        	    <option value="" style="display: none;" {{ old('skill_id', optional($exam)->skill_id ?: '') == '' ? 'selected' : '' }} disabled selected>Select skill</option>
        	@foreach ($skills as $key => $skill)
			    <option value="{{ $key }}" {{ old('skill_id', optional($exam)->skill_id) == $key ? 'selected' : '' }}>
			    	{{ $skill }}
			    </option>
			@endforeach
        </select>
        
        {!! $errors->first('skill_id', '<p class="help-block">:message</p>') !!}
    </div>
</div>



<div class="form-group {{ $errors->has('teacheruser_id') ? 'has-error' : '' }}">
    <label for="teacheruser_id" class="col-md-2 control-label">Teacheruser</label>
    <div class="col-md-10">


        <input class="form-control" name="teacheruser_id" type="text" id="title" value="{{ old('teacheruser_id', optional($teacherusers)->id) }}"
               minlength="1" maxlength="250" required="true" placeholder="Enterteacher id"  value="{{$teacherusers->id}}">
        {!! $errors->first('teacheruser_id', '<p class="help-block">:message</p>') !!}
        

    </div>
</div>

