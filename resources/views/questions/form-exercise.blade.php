
<div id="myform">

    <div class="form-group {{ $errors->has('passage_id') ? 'has-error' : '' }}">
        <label for="passage_id" class="col-md-2 control-label">Passage</label>
        <div class="col-md-10">
            <select class="form-control" id="passage_id" name="passage_id">

                <option value=""  {{ old('passage_id', optional($question)->passage_id ?: '') == '' ? 'selected' : '' }}  selected>Select a Passage </option>
                @foreach ($passages as $key => $passage)
                    <option value="{{ $key }}" {{ old('passage_id', optional($question)->passage_id) == $key ? 'selected' : '' }}>
                        {{ $passage }}
                    </option>
                @endforeach
            </select>

            {!! $errors->first('passage_id', '<p class="help-block">:message</p>') !!}
        </div>
    </div>

<div class="form-group {{ $errors->has('details') ? 'has-error' : '' }}">
    <label for="details" class="col-md-2 control-label">Details</label>
    <div class="col-md-10">
        <textarea class="form-control" name="details" cols="50" rows="10" id="details" required="true"> {{ old('details', optional($question)->details ? : '')== '' ? '&nbsp;'  : old('details', optional($question)->details)  }}</textarea>
        {!! $errors->first('details', '<p class="help-block">:message</p>') !!}
    </div>
</div>

    <div class="form-group }">
        <label for="tags" class="col-md-2 control-label">Tags</label>
        <div class="col-md-10">

             <input type="text" class="form-control" name="tags"  id="tags" value=" {{ old('tags', optional($question)->tagNames()) ==  ''  ? '' :  implode(optional($question)->tagNames(),',')}}"  >

        </div>
    </div>


    <div class="form-group }">
        <label for="files" class="col-md-2 control-label">Param File</label>
        <div class="col-md-10">

            <input type="file" class="inputfile inputfile-1" name="param" style="width: 0.1px;height: 0.1px;padding: 3px 0 0 0" id="param" value=" {{ old('param', optional($question)->param ? : '')== '' ? ''  : old('param', optional($question)->param)  }}"  >
            <label for="param" style="margin-bottom: 0"><i class="fa fa-file-excel-o" aria-hidden="true" style="padding: 0 5px 0 5px"></i><span>Choose a file…</span></label>
            <label for="param"> <span> {{ old('param', optional($question)->param ? : '')== '' ? ''  : old('param', optional($question)->param)  }}</span></label>

        </div>
    </div>



 <div class="form-group {{ $errors->has('skillcategory_id') ? 'has-error' : '' }}">
        <label for="skillcategory_id" class="col-md-2 control-label">Skill Category</label>
        <div class="col-md-10">
            <select class="form-control" id="skillcategory_id" name="skillcategory_id">
                <option value=""  {{ old('skillcategory_id', optional($question)->skillcategory_id ?: '') == '' ? 'selected' : '' }}  selected>Select skillcategory</option>
                @foreach ($skillcategories as $key => $skillcategory)
                    <option value="{{ $key }}" {{ old('skillcategory_id', optional($question)->skillcategory_id) == $key ? 'selected' : '' }}>
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
        	    <option value=""  {{ old('skill_id', optional($question)->skill_id ?: '') == '' ? 'selected' : '' }}  selected>Select skill</option>
        	@if(isset($skills))
                @foreach ($skills as $key => $skill)
			    <option value="{{ $key }}" {{ old('skill_id', optional($question)->skill_id) == $key ? 'selected' : '' }}>
			    	{{ $skill }}
			    </option>
			@endforeach
           @endif
        </select>

        {!! $errors->first('skill_id', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group {{ $errors->has('maxtime') ? 'has-error' : '' }}">
    <label for="maxtime" class="col-md-2 control-label">Maxtime</label>
    <div class="col-md-9" style="margin: 5px 0 0 0">

        <input class="" name="maxtime" type="range" min="0" max="300" style="margin: 0 0 0 10px;"   id="maxtime" value="{{ old('maxtime', optional($question)->maxtime) ==  ''  ? '0' :  optional($question)->maxtime}}" oninput="myFunction(this.value)" required>
        {!! $errors->first('maxtime', '<p class="help-block">:message</p>') !!}
    </div> <div class="col-md-1" id="timeslider">{{old('maxtime', optional($question)->maxtime)}}</div>
</div>

<div class="form-group {{ $errors->has('mintime') ? 'has-error' : '' }}">
        <label for="mintime" class="col-md-2 control-label">Mintime</label>
        <div class="col-md-9" style="margin: 5px 0 0 0">

            <input class="" name="mintime" type="range" min="0" max="300" style="margin: 0 0 0 10px;"   id="mintime" value="{{ old('mintime', optional($question)->mintime) ==  ''  ? '0' :  optional($question)->mintime}}" oninput="myFunction(this.value)" required>
            {!! $errors->first('mintime', '<p class="help-block">:message</p>') !!}
        </div> <div class="col-md-1" id="timeslider">{{old('mintime', optional($question)->mintime)}}</div>
</div>

 @if ((isset($_POST['sid'])) && (!empty($_POST['sid'])) )
 <input name="exercise_id" type="hidden" id="exercise_id" value="{{$_POST['sid']}}" >
@else
     <div class="form-group {{ $errors->has('exercise_id') ? 'has-error' : '' }}">
    <label for="exercise_id" class="col-md-2 control-label">Exercise </label>
    <div class="col-md-10">
        <select class="form-control" id="exercise_id" name="exercise_id">
        	    <option value="" style="display: none;" {{ old('exercise_id', optional($question)->exercise_id ?: '') == '' ? 'selected' : '' }} disabled selected>Select exercise</option>
        	@foreach ($exercises as $key => $exercise)
			    <option value="{{ $key }}" {{ old('exercise_id', optional($question)->exercise_id) == $key ? 'selected' : '' }}>
			    	{{ $exercise }}
			    </option>
			@endforeach
        </select>

        {!! $errors->first('exercise_id', '<p class="help-block">:message</p>') !!}
    </div>
</div>
@endif


<div class="form-group {{ $errors->has('difficultylevel') ? 'has-error' : '' }}">

    <label for="difficultylevel" class="col-md-2 control-label">Difficulty Level</label>
    <div class="col-md-10">
        <div class="" data-toggle="buttons">
            <label class="btn btn-info btn-border {{ old('difficultylevel', optional($question)->difficultylevel ?: '') == 'easy' ? 'active' : '' }}  " style="margin: 0 8px 0 0">
                <input name="difficultylevel" id="option1" autocomplete="off" {{ old('difficultylevel', optional($question)->difficultylevel ?: '') == 'easy' ? 'checked' : '' }} type="radio" value="easy" required> Easy
            </label>
            <label class="btn  btn-circle btn-warning btn-border {{ old('difficultylevel', optional($question)->difficultylevel ?: '') == 'medium' ? 'active' : '' }}" style="margin: 0 8px 0 0">
                <input name="difficultylevel" id="option2" autocomplete="off" {{ old('difficultylevel', optional($question)->difficultylevel ?: '') == 'medium' ? 'checked' : '' }}  type="radio" value="medium" required> Medium
            </label>
            <label class="btn  btn-danger btn-circle btn-border {{ old('difficultylevel', optional($question)->difficultylevel ?: '') == 'hard' ? 'active' : '' }}">
                <input name="difficultylevel" id="option3" autocomplete="off" {{ old('difficultylevel', optional($question)->difficultylevel ?: '') == 'hard' ? 'checked' : '' }}  type="radio" value="hard" required> Hard
            </label>
        </div>

        {!! $errors->first('difficultylevel', '<p class="help-block">:message</p>') !!}
        <input name="questiontype" type="hidden" id="questiontype" value="richtext" >

    </div>
</div>

<div class="form-group {{ $errors->has('hint') ? 'has-error' : '' }}">
    <label for="hint" class="col-md-2 control-label">Hint</label>
    <div class="col-md-10">
        <textarea class="form-control" name="hint" cols="50" rows="10" id="hint" placeholder="Enter hint here...">{{ old('hint', optional($question)->hint) }}</textarea>
        {!! $errors->first('hint', '<p class="help-block">:message</p>') !!}
    </div>
</div>
<div class="form-group">
    <div class="col-md-offset-2 col-md-10">
        @if (isset($_POST['ans']) && $_POST['ans']==1 )
            <input  id="btnSave" class="btn btn-primary" type="submit" value="Edit" data-edit-link="{{route('questions.question.update_question',optional($question)->id)}}"><div id="qid"  style="display: none">{{optional($question)->id}}</div>
       @else
            <input  id="btnSave" class="btn btn-primary" type="submit" value="Add" data-edit-link="{{route('questions.question.store_question')}}"><div id="qid"  style="display: none">0</div>
        @endif


            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>

    </div>
</div>
</div>

    <script type="text/javascript" src="{{ asset('assets/tinymce/js/tinymce/tinymce.min.js') }}"></script>
<script>tinymce.init({ plugins : ['image','media','table','eqneditor','param'],toolbar: "image | media | table | eqneditor  | alignleft aligncenter alignright alignjustify | removeformat | param",selector : "#details",menubar: false,
        relative_urls: false,
        filemanager_title:"Responsive Filemanager",
        image_advtab: true,
        external_filemanager_path:"{{ asset('assets/filemanager/') }}/",
        external_plugins: { "filemanager" : "{{ asset('assets/filemanager/plugin.min.js') }}" }, });

    'use strict';

    ;( function ( document, window, index )
    {
        var inputs = document.querySelectorAll( '.inputfile' );
        Array.prototype.forEach.call( inputs, function( input )
        {
            var label	 = input.nextElementSibling,
                labelVal = label.innerHTML;

            input.addEventListener( 'change', function( e )
            {
                var fileName = '';
                if( this.files && this.files.length > 1 )
                    fileName = ( this.getAttribute( 'data-multiple-caption' ) || '' ).replace( '{count}', this.files.length );
                else
                    fileName = e.target.value.split( '\\' ).pop();

                if( fileName )
                    label.querySelector( 'span' ).innerHTML = fileName;
                else
                    label.innerHTML = labelVal;
            });

            // Firefox bug fix
            input.addEventListener( 'focus', function(){ input.classList.add( 'has-focus' ); });
            input.addEventListener( 'blur', function(){ input.classList.remove( 'has-focus' ); });
        });
    }( document, window, 0 ));


    $('#skillcategory_id').change(function(){

        var id=$(this).val();
        var url="{{ url('/questions/getskills')}}/"+$(this).val();
        $.get(url,
            function(data) {
                var skills = $('#skill_id');
                skills.empty();
                skills.append("<option value=''>" + "Select skill" + "</option>");
                $.each(data, function(index, element) {
                    skills.append("<option value='"+ element.id +"'>" + element.skill_name + "</option>");
                });
            });
    });


</script>




