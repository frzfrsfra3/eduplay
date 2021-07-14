
<div class="form-group {{ $errors->has('details') ? 'has-error' : '' }}">
    <label for="details" class="col-md-2 control-label">Details</label>
    <div class="col-md-10">
        <textarea class="form-control" name="details" cols="50" rows="10" id="details" required="true">{{ old('details', (optional($question)->json_details)) }}&nbsp;</textarea>
        {!! $errors->first('details', '<p class="help-block">:message</p>') !!}
    </div>
    <div>
        @php
            $det=((($question->json_details)));
            print_r( json_encode($det));
        @endphp
        <br><BR>
      </div>
</div>



 <div class="form-group {{ $errors->has('skillcategory_id') ? 'has-error' : '' }}">
        <label for="skillcategory_id" class="col-md-2 control-label">Skill Category</label>
        <div class="col-md-10">
            <select class="form-control" id="skillcategory_id" name="skillcategory_id">
                <option value="" style="display: none;" {{ old('skillcategory_id', optional($question)->skillcategory_id ?: '') == '' ? 'selected' : '' }} disabled selected>Select skillcategory</option>
                @foreach ($skillcategories as $key => $skillcategory)
                    <option value="{{ $key }}" {{ old('skillcategory_id', optional($question)->skillcategory_id) == $key ? 'selected' : '' }}>
                        {{ $skillcategory }}
                    </option>
                @endforeach
            </select>

            {!! $errors->first('skillcategory_id', '<p class="help-block">:message</p>') !!}
        </div>
    </div>
<div class="form-group }">
    <label for="param" class="col-md-2 control-label">Select File</label>
    <div class="col-md-10">

        <input type="file"  name="param"  id="param" value=" {{ old('param', optional($question)->param ? : '')== '' ? '&nbsp;'  : old('param', optional($question)->param)  }}"  >

    </div>
</div>

<div class="form-group {{ $errors->has('skill_id') ? 'has-error' : '' }}">
    <label for="skill_id" class="col-md-2 control-label">Skill</label>
    <div class="col-md-10">
        <select class="form-control" id="skill_id" name="skill_id">
        	    <option value="" style="display: none;" {{ old('skill_id', optional($question)->skill_id ?: '') == '' ? 'selected' : '' }} disabled selected>Select skill</option>
        	@foreach ($skills as $key => $skill)
			    <option value="{{ $key }}" {{ old('skill_id', optional($question)->skill_id) == $key ? 'selected' : '' }}>
			    	{{ $skill }}
			    </option>
			@endforeach
        </select>

        {!! $errors->first('skill_id', '<p class="help-block">:message</p>') !!}
    </div>
</div>


<div class="">


</div>


<div class="form-group {{ $errors->has('maxtime') ? 'has-error' : '' }}">
    <label for="maxtime" class="col-md-2 control-label">Maxtime</label>
    <div class="col-md-9">

        <input class="" name="maxtime" type="range" min="0" max="300"   id="maxtime" value="{{ old('maxtime', optional($question)->maxtime) ==  ''  ? '0' :   optional($question)->maxtime}}" oninput="myFunction(this.value)">
        {!! $errors->first('maxtime', '<p class="help-block">:message</p>') !!}
    </div> <div class="col-md-1" id="timeslider">{{old('maxtime', optional($question)->maxtime)}}</div>
</div>

<div class="form-group {{ $errors->has('mintime') ? 'has-error' : '' }}">
    <label for="mintime" class="col-md-2 control-label">Mintime</label>
    <div class="col-md-9">

        <input class="" name="mintime" type="range" min="0" max="300"   id="mintime" value="{{ old('mintime', optional($question)->mintime) ==  ''  ? '0' :   optional($question)->mintime}}" oninput="myFunction(this.value)">
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
            <label class="btn btn-info  {{ old('difficultylevel', optional($question)->difficultylevel ?: '') == 'easy' ? 'active' : '' }}  " style="margin: 0 15px 0 0">
                <input name="difficultylevel" id="option1" autocomplete="off" {{ old('difficultylevel', optional($question)->difficultylevel ?: '') == 'easy' ? 'checked' : '' }} type="radio" value="easy" required> Easy
            </label>
            <label class="btn  btn-circle btn-warning  {{ old('difficultylevel', optional($question)->difficultylevel ?: '') == 'medium' ? 'active' : '' }}" style="margin: 0 15px 0 0">
                <input name="difficultylevel" id="option2" autocomplete="off" {{ old('difficultylevel', optional($question)->difficultylevel ?: '') == 'medium' ? 'checked' : '' }}  type="radio" value="medium" required> Medium
            </label>
            <label class="btn  btn-danger btn-circle {{ old('difficultylevel', optional($question)->difficultylevel ?: '') == 'hard' ? 'active' : '' }}">
                <input name="difficultylevel" id="option3" autocomplete="off" {{ old('difficultylevel', optional($question)->difficultylevel ?: '') == 'hard' ? 'checked' : '' }}  type="radio" value="hard" required> Hard
            </label>
        </div>

        {!! $errors->first('difficultylevel', '<p class="help-block">:message</p>') !!}
        <input name="questiontype" type="hidden" id="questiontype" value="richtext" >

    </div>
</div>

<div class="form-group {{ $errors->has('hint') ? 'has-error' : '' }}">
    <label for="hint" class="col-md-2 control-label">Hint</label>
    <div class="col-md-10">{{json_encode(var_dump(($question->hint)),true)}}

        <br>
        <textarea class="form-control" name="hint" cols="50" rows="10" id="hint" placeholder="Enter hint here...">{{ old('hint', optional($question)->hint) }}</textarea>
        {!! $errors->first('hint', '<p class="help-block">:message</p>') !!}
    </div>
</div>
<script>
    function myFunction(val) {
        document.getElementById("timeslider").innerHTML = val;
    }



</script>

