
<div class="form-group {{ $errors->has('title') ? 'has-error' : '' }}">
    <label for="title" class="col-md-2 control-label">Title</label>
    <div class="col-md-10">
        <input class="form-control" name="title" type="text" id="title" value="{{ old('title', optional($exercise )->title) }}" minlength="1" maxlength="250" required="true" placeholder="Enter title here...">
        {!! $errors->first('title', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group {{ $errors->has('exerciseset_image') ? 'has-error' : '' }}">
    <label for="image" class="col-md-2 control-label">Exercise Image</label>
      <div class="col-md-10">
        <div class="pro-img ch-pic">
            @if(!empty($exercise))
              <img class="exercise-pic" src="{{ asset('/uploads/exercisesets') }}/{{ optional($exercise)->exerciseset_image }}" width="100px">
            @else 
              <img class="exercise-pic" src="{{ asset('uploads/profile') }}/profile_img.jpg" width="100px">
            @endif
            <input class="file-upload-nw" name="exerciseset_image" id="image" type="file" accept="image/*" />
        </div>
    </div>
</div>

<div class="form-group {{ $errors->has('description') ? 'has-error' : '' }}">
    <label for="description" class="col-md-2 control-label">Description</label>
    <div class="col-md-10">
        <textarea class="form-control" name="description" type="text" id="description" minlength="1" maxlength="250" required="true" placeholder="Enter description here...">{{ old('description', optional($exercise )->description) }}
        </textarea>
        {!! $errors->first('description', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group {{ $errors->has('topic_id') ? 'has-error' : '' }}">
    <label for="topic_id" class="col-md-2 control-label">Topic</label>
    <div class="col-md-10">
      <select class="form-control" id="topic_id" name="topic_id" required="true">
        @foreach($topics as $topic)
          <option value="{{ $topic->id }}" {{ old('topic_id', optional($exercise)->topic_id) == $topic->id ? 'selected' : '' }}>
			    	{{ $topic->topic_name }}
			    </option>
        @endforeach
      </select>
    </div>
</div>

<div class="form-group {{ $errors->has('discipline_id') ? 'has-error' : '' }}">
    <label for="discipline_id" class="col-md-2 control-label">Discipline</label>
    <div class="col-md-10">
      <select class="form-control" id="discipline_id" name="discipline_id">
       @foreach($disciplines as $discipline)
          <option value="{{ $discipline->id }}" {{ old('discipline_id', optional($exercise)->discipline_id) == $discipline->id ? 'selected' : '' }}>
			    	{{ $discipline->discipline_name }}
			    </option>
        @endforeach
      </select>
    </div>
</div>

<div class="form-group {{ $errors->has('grade_id') ? 'has-error' : '' }}">
    <label for="grade_id" class="col-md-2 control-label">Grade</label>
    <div class="col-md-10">
      <select class="form-control" id="grade_id" name="grade_id">
        @foreach($grades as $grade)
          <option value="{{ $grade->id }}" {{ old('grade_id', optional($exercise)->grade_id) == $grade->id ? 'selected' : '' }}>
			    	{{ $grade->grade_name }}
			    </option>
        @endforeach
      </select>
    </div>
</div>

<div class="form-group {{ $errors->has('language_id') ? 'has-error' : '' }}">
    <label for="language_id" class="col-md-2 control-label">Language</label>
    <div class="col-md-10">
      <select class="form-control" id="language_id" name="language_id" required="true">
        @foreach($languages as $language)
          <option value="{{ $language->id }}" {{ old('language_id', optional($exercise)->language_id) == $language->id ? 'selected' : '' }}>
			    	{{ $language->language }}
			    </option>
        @endforeach
      </select>
    </div>
</div>

<div class="form-group {{ $errors->has('minimum_age') ? 'has-error' : '' }}">
    <label for="minimum_age" class="col-md-2 control-label">Minimum Age</label>
    <div class="col-md-10">
        <input class="form-control" name="minimum_age" type="text" id="minimum_age" value="{{ old('minimum_age', optional($exercise )->minimum_age) }}" minlength="1" maxlength="250" required="true" placeholder="Enter minimum age here...">
        {!! $errors->first('minimum_age', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group {{ $errors->has('maximum_age') ? 'has-error' : '' }}">
    <label for="maximum_age" class="col-md-2 control-label">Maximum Age</label>
    <div class="col-md-10">
        <input class="form-control" name="maximum_age" type="text" id="maximum_age" value="{{ old('maximum_age', optional($exercise )->maximum_age) }}" minlength="1" maxlength="250" required="true" placeholder="Enter maximum age here...">
        {!! $errors->first('maximum_age', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group {{ $errors->has('publish_status') ? 'has-error' : '' }}">
    <label for="publish_status" class="col-md-2 control-label">Publish Status</label>
    <div class="col-md-10">
        <select class="form-control" id="publish_status" name="publish_status" required="true">
        	    <option value="" style="display: none;" {{ old('publish_status', optional($exercise)->publish_status ?: '') == '' ? 'selected' : '' }} disabled selected>Enter publish status here...</option>
        	@foreach (['public' => 'Public',
                    'private' => 'Private',
                    ] as $key => $text)
			    <option value="{{ $key }}" {{ old('publish_status', optional($exercise)->publish_status) == $key ? 'selected' : '' }}>
			    	{{ $text }}
			    </option>
			@endforeach
        </select>
        
        {!! $errors->first('publish_status', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group {{ $errors->has('createdby') ? 'has-error' : '' }}">
    <label for="createdby" class="col-md-2 control-label">Created By</label>
    <div class="col-md-10">
      <select class="form-control" id="createdby" name="createdby" required="true">
         @foreach($users as $user)
          <option value="{{ $user->id }}" {{ old('createdby', optional($exercise)->createdby) == $user->id ? 'selected' : '' }}>
			    	{{ $user->name }}
			    </option>
        @endforeach
      
      </select>
    </div>
</div>

@section('footer_scripts')
<script>
/*avatar-upload*/
$(document).ready(function() {
    var readURL = function(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                $('.exercise-pic').attr('src', e.target.result);
            }

            reader.readAsDataURL(input.files[0]);
        }
    }
    $(".file-upload-nw").on('change', function(){
        readURL(this);
    });

    $(".exercise-pic").on('click', function() {
        $(".file-upload-nw").click();
    });
    $(".change-pic").on('click', function() {
        $(".file-upload-nw").click();
    });

});
</script>
@endsection