
<div class="form-group {{ $errors->has('language_id') ? 'has-error' : '' }}" style="width: 100%!important;">
    <label for="language_id" class="col-md-2 control-label">language</label>
    <div class="col-md-10">
        <select class="form-control" id="language_id" name="language_id" required="true">
        	    <option value="" style="display: none;" {{ old('language_id', optional($userinterest)->language_id ?: '') == '' ? 'selected' : '' }} disabled selected>Select language</option>
        	@foreach ($languages as $key => $language)

			    <option value="{{ $key }}"
                    @if (old('language_id', optional($userinterest)->language_id) == $key)
                         selected="selected"
                       @else
                           @if ($key ==1)
                            selected="selected"
                               @endif
                               @endif
                            >
			    	{{ $language }}
			    </option>
			@endforeach
        </select>
        
        {!! $errors->first('discipline_id', '<p class="help-block">:message</p>') !!}
    </div>
</div>


<div class="form-group {{ $errors->has('discipline_id') ? 'has-error' : '' }}" style="width: 100%!important;">
    <label for="discipline_id" class="col-md-2 control-label">Curriculum</label>
    <div class="col-md-10">
        <select class="form-control" id="discipline_id" name="discipline_id" required="true">
            <option value="" style="display: none;" {{ old('discipline_id', optional($userinterest)->discipline_id ?: '') == '' ? 'selected' : '' }} disabled selected>Select discipline's Curriculum</option>
            @foreach ($disciplines as $key => $discipline)
                                <option value="{{ $key }}" {{ old('discipline_id', optional($userinterest)->discipline_id) == $key ? 'selected' : '' }}>
                    {{ $discipline }}
                </option>
            @endforeach
        </select>

        {!! $errors->first('discipline_id', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group {{ $errors->has('grade_id') ? 'has-error' : '' }}" style="width: 100%!important;">
    <label for="grade_id" class="col-md-2 control-label">Grade</label>
    <div class="col-md-10">
        <select class="form-control" id="grade_id" name="grade_id">
            <option value="" style="display: none;" {{ old('grade_id', optional($userinterest)->grade_id ?: '') == '' ? 'selected' : '' }} disabled selected>Select grade</option>
            @foreach ($grades as $key => $grade)
                <option value="{{ $key }}" {{ old('grade_id', optional($userinterest)->grade_id) == $key ? 'selected' : '' }}>
                    {{ $grade }}
                </option>
            @endforeach
        </select>

        {!! $errors->first('grade_id', '<p class="help-block">:message</p>') !!}
    </div>
</div>
@if ($user = Auth::user() )
<div class="form-group {{ $errors->has('exercise_type') ? 'has-error' : '' }}" style="width: 100%!important;">
    <label for="exercise_type" class="col-md-5 control-label" style="text-align: left !important;">Exersise set collection</label>
    <div class="col-md-7">
        <select class="form-control" id="exercise_type" name="exercise_type" required="false">
            <option value="1"  {{ old('exercise_type', optional($userinterest)->exercise_type) == $key ? 'selected' : '' }} >Free exercises</option>
            <option value="2" {{ old('exercise_type', optional($userinterest)->exercise_type) == $key ? 'selected' : '' }}>My exercises</option>

        </select>

        {!! $errors->first('exercise', '<p class="help-block">:message</p>') !!}
    </div>
</div>
@endif

<div class="form-group {{ $errors->has('topic_id') ? 'has-error' : '' }}">

    <div class="col-md-7">
        <input name="topic_id" type="hidden" id="topic_id" value="{{$topic_id}}" >

        {!! $errors->first('exercise', '<p class="help-block">:message</p>') !!}
    </div>
</div>

{{--

<div class="form-group {{ $errors->has('user_id') ? 'has-error' : '' }}">
    <label for="user_id" class="col-md-2 control-label">User</label>
    <div class="col-md-10">
        <select class="form-control" id="user_id" name="user_id" required="true">
            <option value="" style="display: none;" {{ old('user_id', optional($userinterest)->user_id ?: '') == '' ? 'selected' : '' }} disabled selected>Select user</option>
            @foreach ($users as $key => $user)
                <option value="{{ $key }}" {{ old('user_id', optional($userinterest)->user_id) == $key ? 'selected' : '' }}>
                    {{ $user }}
                </option>
            @endforeach
        </select>

        {!! $errors->first('user_id', '<p class="help-block">:message</p>') !!}
    </div>
</div>--}}


