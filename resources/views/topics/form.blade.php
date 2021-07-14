
<div class="form-group {{ $errors->has('topic_name') ? 'has-error' : '' }}">
    <label for="topic_name" class="col-md-2 control-label">Topic Name</label>
    <div class="col-md-10">
        <input class="form-control" name="topic_name" type="text" id="topic_name" value="{{ old('topic_name', optional($topic)->topic_name) }}" minlength="1" maxlength="250" required="true" placeholder="Enter topic name here...">
        {!! $errors->first('topic_name', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group {{ $errors->has('discipline_id') ? 'has-error' : '' }}">
    <label for="discipline_id" class="col-md-2 control-label">Discipline</label>
    <div class="col-md-10">
        <select class="form-control" id="discipline_id" name="discipline_id" required="true">
        	    <option value="" style="display: none;" {{ old('discipline_id', optional($topic)->discipline_id ?: '') == '' ? 'selected' : '' }} disabled selected>Select discipline</option>
        	@foreach ($disciplines as $key => $discipline)
			    <option value="{{ $key }}" {{ old('discipline_id', optional($topic)->discipline_id) == $key ? 'selected' : '' }}>
			    	{{ $discipline }}
			    </option>
			@endforeach
        </select>
        
        {!! $errors->first('discipline_id', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group {{ $errors->has('approve_status') ? 'has-error' : '' }}">
    <label for="approve_status" class="col-md-2 control-label">Approve Status</label>
    <div class="col-md-10">
        <select class="form-control" id="approve_status" name="approve_status" required="true">
        	    <option value="" style="display: none;" {{ old('approve_status', optional($topic)->approve_status ?: '') == '' ? 'selected' : '' }} disabled selected>Enter approve status here...</option>
        	@foreach (['pending' => 'Pending',
'approved' => 'Approved',
'declined' => 'Declined',
'' => ''] as $key => $text)
			    <option value="{{ $key }}" {{ old('approve_status', optional($topic)->approve_status) == $key ? 'selected' : '' }}>
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
        	    <option value="" style="display: none;" {{ old('publish_status', optional($topic)->publish_status ?: '') == '' ? 'selected' : '' }} disabled selected>Enter publish status here...</option>
        	@foreach (['draft' => 'Draft',
'published' => 'Published',
'unpublished' => 'Unpublished',
'' => ''] as $key => $text)
			    <option value="{{ $key }}" {{ old('publish_status', optional($topic)->publish_status) == $key ? 'selected' : '' }}>
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
        <input class="form-control" name="createdby" type="number" id="createdby" value="{{ old('createdby', optional($topic)->createdby) }}" min="-2147483648" max="2147483647" required="true" placeholder="Enter createdby here...">
        {!! $errors->first('createdby', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group {{ $errors->has('updatedby') ? 'has-error' : '' }}">
    <label for="updatedby" class="col-md-2 control-label">Updatedby</label>
    <div class="col-md-10">
        <input class="form-control" name="updatedby" type="number" id="updatedby" value="{{ old('updatedby', optional($topic)->updatedby) }}" min="-2147483648" max="2147483647" required="true" placeholder="Enter updatedby here...">
        {!! $errors->first('updatedby', '<p class="help-block">:message</p>') !!}
    </div>
</div>

