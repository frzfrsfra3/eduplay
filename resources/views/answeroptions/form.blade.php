
<div class="form-group {{ $errors->has('question_id') ? 'has-error' : '' }}">
    <label for="question_id" class="col-md-2 control-label">{{ trans('answeroptions.question_id') }}</label>
    <div class="col-md-10">
        <select class="form-control" id="question_id" name="question_id" required="true">
        	    <option value="" style="display: none;" {{ old('question_id', optional($answeroption)->question_id ?: '') == '' ? 'selected' : '' }} disabled selected>{{ trans('answeroptions.question_id__placeholder') }}</option>
        	@foreach ($questions as $key => $question)
			    <option value="{{ $key }}" {{ old('question_id', optional($answeroption)->question_id) == $key ? 'selected' : '' }}>
			    	{{ $question }}
			    </option>
			@endforeach
        </select>
        
        {!! $errors->first('question_id', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group {{ $errors->has('answer_type') ? 'has-error' : '' }}">
    <label for="answer_type" class="col-md-2 control-label">{{ trans('answeroptions.answer_type') }}</label>
    <div class="col-md-10">
        <select class="form-control" id="answer_type" name="answer_type" required="true">
        	    <option value="" style="display: none;" {{ old('answer_type', optional($answeroption)->answer_type ?: '') == '' ? 'selected' : '' }} disabled selected>{{ trans('answeroptions.answer_type__placeholder') }}</option>
        	@foreach (['text' => trans('answeroptions.answer_type_text'),
'image' => trans('answeroptions.answer_type_image'),
'audio' => trans('answeroptions.answer_type_audio'),
'video' => trans('answeroptions.answer_type_video'),
'richtext' => trans('answeroptions.answer_type_richtext')] as $key => $text)
			    <option value="{{ $key }}" {{ old('answer_type', optional($answeroption)->answer_type) == $key ? 'selected' : '' }}>
			    	{{ $text }}
			    </option>
			@endforeach
        </select>
        
        {!! $errors->first('answer_type', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group {{ $errors->has('details') ? 'has-error' : '' }}">
    <label for="details" class="col-md-2 control-label">{{ trans('answeroptions.details') }}</label>
    <div class="col-md-10">
        <textarea class="form-control" name="details" cols="50" rows="10" id="details" required="true">{{ old('details', optional($answeroption)->details) }}</textarea>
        {!! $errors->first('details', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group {{ $errors->has('iscorrect') ? 'has-error' : '' }}">
    <label for="iscorrect" class="col-md-2 control-label">{{ trans('answeroptions.iscorrect') }}</label>
    <div class="col-md-10">
        <div class="checkbox">
            <label for="iscorrect_1">
            	<input id="iscorrect_1" class="" name="iscorrect" type="checkbox" value="1" {{ old('iscorrect', optional($answeroption)->iscorrect) == '1' ? 'checked' : '' }}>
                Yes
            </label>
        </div>

        {!! $errors->first('iscorrect', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group {{ $errors->has('sort_order') ? 'has-error' : '' }}">
    <label for="sort_order" class="col-md-2 control-label">{{ trans('answeroptions.sort_order') }}</label>
    <div class="col-md-10">
        <input class="form-control" name="sort_order" type="number" id="sort_order" value="{{ old('sort_order', optional($answeroption)->sort_order) }}" min="-2147483648" max="2147483647" required="true" placeholder="{{ trans('answeroptions.sort_order__placeholder') }}">
        {!! $errors->first('sort_order', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group {{ $errors->has('mediapath') ? 'has-error' : '' }}">
    <label for="mediapath" class="col-md-2 control-label">{{ trans('answeroptions.mediapath') }}</label>
    <div class="col-md-10">
        <input class="form-control" name="mediapath" type="text" id="mediapath" value="{{ old('mediapath', optional($answeroption)->mediapath) }}" maxlength="250" placeholder="{{ trans('answeroptions.mediapath__placeholder') }}">
        {!! $errors->first('mediapath', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group {{ $errors->has('mediaurl') ? 'has-error' : '' }}">
    <label for="mediaurl" class="col-md-2 control-label">{{ trans('answeroptions.mediaurl') }}</label>
    <div class="col-md-10">
        <input class="form-control" name="mediaurl" type="text" id="mediaurl" value="{{ old('mediaurl', optional($answeroption)->mediaurl) }}" maxlength="250" placeholder="{{ trans('answeroptions.mediaurl__placeholder') }}">
        {!! $errors->first('mediaurl', '<p class="help-block">:message</p>') !!}
    </div>
</div>

