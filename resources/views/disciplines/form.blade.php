
<div class="form-group {{ $errors->has('discipline_name') ? 'has-error' : '' }}">
    <label for="discipline_name" class="col-md-4 control-label">Discipline Curriculum Name</label>
    <div class="col-md-8">
        <textarea class="form-control" name="discipline_name" cols="50" rows="1" id="discipline_name" required="true" placeholder="Enter discipline name here...">{{ old('discipline_name', optional($discipline)->discipline_name) }}</textarea>
        {!! $errors->first('discipline_name', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group {{ $errors->has('description') ? 'has-error' : '' }}">
    <label for="description" class="col-md-4 control-label">Description</label>
    <div class="col-md-8">
        <input class="form-control" name="description" rows="5" type="text" id="description" value="{{ old('description', optional($discipline)->description) }}" minlength="1" maxlength="500" required="true">
        {!! $errors->first('description', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group {{ $errors->has('description') ? 'has-error' : '' }}">
    <label for="description" class="col-md-4 control-label">Tags</label>
    <div class="col-md-8">
        <input class="form-control" name="tags" rows="1" type="text" id="tags" value="" minlength="1" maxlength="100" required="false">
        {!! $errors->first('description', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group {{ $errors->has('curriculum_gradelist_id') ? 'has-error' : '' }}">
    <label for="curriculum_gradelist_id" class="col-md-4 control-label">Curriculum Grades List</label>
    <div class="col-md-8">
        <select class="form-control" id="curriculum_gradelist_id" name="curriculum_gradelist_id">
        	    <option value="" style="display: none;" {{ old('curriculum_gradelist_id', optional($discipline)->curriculum_gradelist_id ?: '') == '' ? 'selected' : '' }} disabled selected>Select curriculum</option>
        	@foreach ($curricula as $key => $curriculum)
			    <option value="{{ $key }}" {{ old('curriculum_gradelist_id', optional($discipline)->curriculum_gradelist_id) == $key ? 'selected' : '' }}>
			    	{{ $curriculum }}
			    </option>
			@endforeach
        </select>
        
        {!! $errors->first('curriculum_gradelist_id', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group {{ $errors->has('topic_id') ? 'has-error' : '' }}">
    <label for="topic_id" class="col-md-4 control-label">topics</label>
    <div class="col-md-8">
        <select class="form-control" id="topic_id" name="topic_id">
            <option value="" style="display: none;" {{ old('topic_id', optional($discipline)->topic_id ?: '') == '' ? 'selected' : '' }} disabled selected>Select topics</option>
            @foreach ($topics as $key => $topic)
                <option value="{{ $key }}" {{ old('topic_id', optional($discipline)->topic_id) == $key ? 'selected' : '' }}>
                    {{ $topic }}
                </option>
            @endforeach
        </select>

        {!! $errors->first('topic_id', '<p class="help-block">:message</p>') !!}
    </div>
</div>



<div class="form-group {{ $errors->has('iconurl') ? 'has-error' : '' }}">
    <label for="iconurl" class="col-md-4 control-label">Iconurl</label>
    <div class="col-md-8">
        <input class="form-control" name="iconurl" type="text" id="iconurl" value="{{ old('iconurl', optional($discipline)->iconurl) }}" minlength="1" maxlength="50" placeholder="Enter iconurl here...">
        {!! $errors->first('iconurl', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group {{ $errors->has('language_preference_id') ? 'has-error' : '' }}">
    <label for="language_preference_id" class="col-md-4 control-label">Language</label>
    <div class="col-md-8">
        <select class="form-control" id="language_preference_id" name="language_preference_id" required="true">
        	    <option value="" style="display: none;" {{ old('language_preference_id', optional($discipline)->language_preference_id ?: '') == '' ? 'selected' : '' }} disabled selected>Enter language preference here...</option>
        	@foreach ($languagePreferences as $key => $languagePreference)
			    <option value="{{ $key }}" {{ old('language_preference_id', optional($discipline)->language_preference_id) == $key ? 'selected' : '' }}>
			    	{{ $languagePreference }}
			    </option>
			@endforeach
        </select>
        
        {!! $errors->first('language_preference_id', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group {{ $errors->has('approve_status') ? 'has-error' : '' }}">
    <label for="approve_status" class="col-md-4 control-label">Approve Status</label>
    <div class="col-md-8">
        <select class="form-control" id="approve_status" name="approve_status" required="true">
        	    <option value="" style="display: none;" {{ old('approve_status', optional($discipline)->approve_status ?: '') == '' ? 'selected' : '' }} disabled selected>Enter approve status here...</option>
        	@foreach (['pending' => 'Pending','approved' => 'Approved','declined' => 'Declined','' => ''] as $key => $text)
			    <option value="{{ $key }}" {{ old('approve_status', optional($discipline)->approve_status) == $key ? 'selected' : '' }}>
			    	{{ $text }}
			    </option>
			@endforeach
        </select>
        
        {!! $errors->first('approve_status', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group {{ $errors->has('publish_status') ? 'has-error' : '' }}">
    <label for="publish_status" class="col-md-4 control-label">Publish Status</label>
    <div class="col-md-8">
        <select class="form-control" id="publish_status" name="publish_status" required="true">
        	    <option value="" style="display: none;" {{ old('publish_status', optional($discipline)->publish_status ?: '') == '' ? 'selected' : '' }} disabled selected>Enter publish status here...</option>
        	@foreach (['draft' => 'Draft','published' => 'Published','unpublished' => 'Unpublished','' => ''] as $key => $text)
			    <option value="{{ $key }}" {{ old('publish_status', optional($discipline)->publish_status) == $key ? 'selected' : '' }}>
			    	{{ $text }}
			    </option>
			@endforeach
        </select>
        
        {!! $errors->first('publish_status', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group {{ $errors->has('createdby') ? 'has-error' : '' }}">
    <label for="createdby" class="col-md-4 control-label">Createdby</label>
    <div class="col-md-8">
        <input class="form-control" name="createdby" type="number" id="createdby" value="{{ old('createdby', optional($discipline)->createdby) }}" min="1" max="2147483647" required="true" placeholder="Enter createdby here...">
        {!! $errors->first('createdby', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group {{ $errors->has('updatedby') ? 'has-error' : '' }}">
    <label for="updatedby" class="col-md-4 control-label">Updatedby</label>
    <div class="col-md-8">
        <input class="form-control" name="updatedby" type="number" id="updatedby" value="{{ old('updatedby', optional($discipline)->updatedby) }}" min="1" max="2147483647" required="true" placeholder="Enter updatedby here...">
        {!! $errors->first('updatedby', '<p class="help-block">:message</p>') !!}
    </div>
</div>

