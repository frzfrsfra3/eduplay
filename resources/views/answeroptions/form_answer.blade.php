<div id="myform">

    <input name="question_id" type="hidden" id="question_id" value="{{$_POST['sid']}}" >
    <input name="answer_type" type="hidden" id="answer_type" value="richtext" >


<div class="form-group {{ $errors->has('details') ? 'has-error' : '' }}">
    <label for="details" class="col-md-2 control-label">{{ trans('answeroptions.details') }}</label>
    <div class="col-md-10">
        <textarea class="form-control" name="details" cols="50" rows="10" id="details" required="true">{{ old('details', optional($answeroption)->details ? : '')== '' ? '&nbsp;'  : old('details', optional($answeroption)->details)  }}</textarea>
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
        <input class="form-control" name="sort_order" type="number" id="sort_order" value="{{ old('sort_order', optional($answeroption)->sort_order=='') ? '1' : optional($answeroption)->sort_order}}" min="0" max="100" required="true" placeholder="{{ trans('answeroptions.sort_order__placeholder') }}">
        {!! $errors->first('sort_order', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group">
    <div class="col-md-offset-2 col-md-10">
        @if (isset($_POST['ans']) && $_POST['ans']==1 )
            <input  id="btnSave" class="btn btn-primary" type="submit" value="Edit" data-edit-link="{{route('answeroptions.answeroption.update_answer',optional($answeroption)->id)}}"><div id="aid"  style="display: none">{{optional($answeroption)->id}}</div>
        @else
            <input  id="btnSave" class="btn btn-primary" type="submit" value="Add" data-edit-link="{{route('answeroptions.answeroption.store_answer')}}"><div id="aid"  style="display: none">0</div>
        @endif


        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>

    </div>
</div>
</div>
<script type="text/javascript" src="{{ asset('assets/tinymce/js/tinymce/tinymce.min.js') }}"></script>
<script>tinymce.init({ plugins : ['image','media','table','eqneditor','imagetools'],toolbar: "image | media | table | eqneditor  | alignleft aligncenter alignright alignjustify ",selector : "#details",menubar: false,
        relative_urls: false,
        filemanager_title:"Edu File Manager",
        image_advtab: true,
        external_filemanager_path:"{{ asset('assets/filemanager/') }}/",
        external_plugins: { "filemanager" : "{{ asset('assets/filemanager/plugin.min.js') }}" }, });</script>
