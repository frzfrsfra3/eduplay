<div class="col-xl-12 col-lg-12 col-sm-12 col-xs-12 exercise-blue">

<div class="col-xl-4 col-lg-4 col-sm-12 col-xs-12">
<div class="form-group {{ $errors->has('examtype') ? 'has-error' : '' }}">
    <div for="examtype" class="col-md-3 control-label title">Examtype</div>
    <div class="col-md-9">
        <select class="form-control" id="examtype" name="examtype" required="true">
        	    <option value="" style="display: none;" {{ old('examtype', optional($exam)->examtype ?: '') == '' ? 'selected' : '' }} disabled selected>Enter examtype here...</option>
        	@foreach (['homework' => 'Homework',
'test' => 'Test',
'practice' => 'Practice',
] as $key => $text)
			    <option value="{{ $key }}" {{ old('examtype', optional($exam)->examtype) == $key ? 'selected' : '' }}>
			    	{{ $text }}
			    </option>
			@endforeach
        </select>

        {!! $errors->first('examtype', '<p class="help-block">:message</p>') !!}
    </div>
</div>
</div>
<div class="col-xl-4 col-lg-4 col-sm-12 col-xs-12">
<div class="form-group {{ $errors->has('title') ? 'has-error' : '' }}">
    <div for="title" class="col-md-3 control-label">Title</div>
    <div class="col-md-9">
        <input class="form-control" name="title" type="text" id="title" value="{{ old('title', optional($exam)->title) }}" minlength="1" maxlength="250" required="true" placeholder="Enter title here...">
        {!! $errors->first('title', '<p class="help-block">:message</p>') !!}
    </div>
</div>
</div>
<div class="col-xl-4 col-lg-4 col-sm-12 col-xs-12">
<div class="form-group {{ $errors->has('isavailable') ? 'has-error' : '' }}">
    <div for="isavailable" class="col-md-12 control-label">
            <label class="container-checkbox container-checkbox-exam check-block">
        <input type="checkbox"
               name="isavailable"
               id="isavailable"
        @if(optional($exam)->isavailable =='Y')
            checked
         @endif >
        <span class="checkmark">   </span>
                Is available
        {!! $errors->first('isavailable', '<p class="help-block">:message</p>') !!}
        </label>
    </div>
</div>
</div>
        <div class="col-xl-12 col-lg-12 col-sm-12 col-xs-12 " style="margin-top: 20px">
    <div class="col-xl-4 col-lg-4 col-sm-12 col-xs-12">
      Total question :  {{$questions->count()}}
    </div>
        <div class="col-xl-4 col-lg-4 col-sm-12 col-xs-12">

            Total duration  :  {{gmdate("H:i:s", $questions->sum('maxtime'))}}
        </div>
        <div class="col-xl-4 col-lg-4 col-sm-12 col-xs-12">
            Total marks  : <span class="total-mark">


                @if ($exam)
                {{optional($exam)->examquestions ()->sum('points')}}
               @else
                    0
                    @endif
            </span>
        </div>
    </div>
    </div>




    <div class=" col-xl-12 col-lg-12 col-sm-12 col-xs-12 exercise-gray">

        {!! $nestquestion !!}
    </div>


