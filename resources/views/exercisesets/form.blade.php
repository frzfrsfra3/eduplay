<div class="col-xl-12 col-lg-12 col-sm-12 col-xs-12 exercise-blue">
    <div class="col-xl-12 col-lg-12 col-sm-12 col-xs-12 {{ $errors->has('title') ? 'has-error' : '' }}">
        <div for="title" class="col-xl-2 col-lg-2 col-sm-2 col-xs-2 title" >Title</div>
        <div class="col-xl-10 col-lg-10 col-sm-10 col-xs-12 input-box">
            <input class="form-control" name="title" type="text" id="title" value="{{ old('title', optional($exerciseset)->title) }}" minlength="1" maxlength="250" required=true" placeholder="Enter title here...">
            {!! $errors->first('title', '<p class="help-block">:message</p>') !!}
        </div>
    </div>

    <div class="col-xl-12 col-lg-12 col-sm-12 col-xs-12  {{ $errors->has('description') ? 'has-error' : '' }}">
        <div for="description" class="col-xl-2 col-lg-2 col-sm-2 col-xs-2 title">Description</div>
        <div class="col-xl-10 col-lg-10 col-sm-10 col-xs-12 input-box">
            <textarea class="form-control" name="description" cols="50" rows="10" id="description" required="true">{{ old('description', optional($exerciseset)->description) }}</textarea>
            {!! $errors->first('description', '<p class="help-block">:message</p>') !!}
        </div>
    </div>
</div>
<div class="col-xl-12 col-lg-12 col-sm-12 col-xs-12 exercise-gray">
    <div class="col-xl-6 col-lg-6 col-sm-12 col-xs-12 {{ $errors->has('discipline_id') ? 'has-error' : '' }}">
        <div for="discipline_id" class="col-xl-2 col-lg-2 col-sm-2 col-xs-2 title">Discipline/<br>Curriculum </div>
        <div class="col-xl-4 col-lg-10 col-sm-10 col-xs-12 input-box">
            <select class="form-control" id="discipline_id" name="discipline_id">
                    <option value="" style="display: none;" {{ old('discipline_id', optional($exerciseset)->discipline_id ?: '') == '' ? 'selected' : '' }} disabled selected>Select discipline</option>
                @foreach ($disciplines as $key => $discipline)
                    <option value="{{ $key }}" {{ old('discipline_id', optional($exerciseset)->discipline_id) == $key ? 'selected' : '' }}>
                        {{ $discipline }}
                    </option>
                @endforeach
            </select>

            {!! $errors->first('discipline_id', '<p class="help-block">:message</p>') !!}
        </div>
    </div>

<div class="col-xl-6 col-lg-6 col-sm-12 col-xs-12 {{ $errors->has('grade_id') ? 'has-error' : '' }}">
    <div for="grade_id" class="col-xl-2 col-lg-2 col-sm-2 col-xs-2 title">Grade</div>
    <div class="col-xl-10 col-lg-10 col-sm-10 col-xs-12 input-box">
        <select class="form-control" id="grade_id" name="grade_id">
        	    <option value="" style="display: none;" {{ old('grade_id', optional($exerciseset)->grade_id ?: '') == '' ? 'selected' : '' }} disabled selected>Select grade</option>
        	@if($grades)
                @foreach ($grades as $key => $grade)
			    <option value="{{ $key }}" {{ old('grade_id', optional($exerciseset)->grade_id) == $key ? 'selected' : '' }}>
			    	{{ $grade }}
			    </option>
			    @endforeach
            @endif

        </select>

        {!! $errors->first('grade_id', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="col-xl-6 col-lg-6 col-sm-12 col-xs-12 {{ $errors->has('language_id') ? 'has-error' : '' }}">
    <div for="language_id" class="col-xl-2 col-lg-2 col-sm-2 col-xs-2 title">Language</div>
    <div class="col-xl-10 col-lg-10 col-sm-10 col-xs-12 input-box">
        <select class="form-control" id="language_id" name="language_id" required="true">
        	    <option value="" style="display: none;" {{ old('language_id', optional($exerciseset)->language_id ?: '') == '' ? 'selected' : '' }} disabled selected>Enter language here...</option>
        	@foreach ($languages as $key => $language)
			    <option value="{{ $key }}" {{ old('language_id', optional($exerciseset)->language_id) == $key ? 'selected' : '' }}>
			    	{{ $language }}
			    </option>
			@endforeach
        </select>

        {!! $errors->first('language_id', '<p class="help-block">:message</p>') !!}
    </div>
</div>



<div class="col-xl-6 col-lg-6 col-sm-12 col-xs-12 {{ $errors->has('price') ? 'has-error' : '' }}">
    <div for="price" class="col-xl-2 col-lg-2 col-sm-2 col-xs-2 title">Price</div>
    <div class="col-xl-10 col-lg-10 col-sm-10 col-xs-12 input-box">
        <input class="form-control" name="price" rows="1" type="number" id="price" value="{{ old('price', optional($exerciseset)->price) }}" minlength="1" maxlength="100" required="false"  min="0">
        {!! $errors->first('price', '<p class="help-block">:message</p>') !!}
    </div>
</div>


<div class="col-xl-6 col-lg-6 col-sm-12 col-xs-12 {{ $errors->has('description') ? 'has-error' : '' }}">
    <div for="tags" class="col-xl-2 col-lg-2 col-sm-2 col-xs-2 title">Tags</div>
    <div class="col-xl-10 col-lg-10 col-sm-10 col-xs-12 input-box">
        <input class="form-control" name="tags" rows="1" type="text" id="tags" value="{{ old('tags', optional($exerciseset)->tagNames()) ==  ''  ? '' :  implode(optional($exerciseset)->tagNames(),',')}}" minlength="1" maxlength="100" required="false">

    </div>
</div>


 @can('publish' ,\App\Models\Exerciseset::class)

<div class="col-xl-6 col-lg-6 col-sm-12 col-xs-12 {{ $errors->has('publish_status') ? 'has-error' : '' }}">
    <div for="publish_status" class="col-xl-2 col-lg-2 col-sm-2 col-xs-2 title">Status</div>
    <div class="col-xl-10 col-lg-10 col-sm-10 col-xs-12 input-box">
        <input  id="publish_status" name="publish_status" type="checkbox" class="form-control"
                @if (  optional($exerciseset)->publish_status=='public' ) { checked }
                @endif
                data-toggle="toggle" data-on='public' data-off='private' data-onstyle="public" data-offstyle="private"
                value="{{optional($exerciseset)->publish_status}}">



    </div>
  @endcan

</div>
 <input class="form-control" name="createdby" type="hidden" id="createdby" value="{{ old('createdby', optional($exerciseset)->createdby) ==  ''  ? Auth::user()->id : $exerciseset->createdby  }}" >
</div>

@section('footer_scripts')

    <script>

            $('#discipline_id').change(function(){



                var id=$(this).val();

                var url="{{ url('/exercisesets/getgrades')}}/"+$(this).val();

                $.get(url,
                    function(data) {
                        var grades = $('#grade_id');
                        grades.empty();
                        grades.append("<option value=''>" + "Select grade" + "</option>");
                        $.each(data, function(index, element) {
                            grades.append("<option value='"+ element.id +"'>" + element.grade_name + "</option>");
                        });
                    });
            });




            $(function() {
                $('#publish_status').change(function() {


                    if ($(this).prop('checked')== true) {
                    $('#publish_status').val('public')

                    }
                    else
                    { $('#publish_status').val('private')

                    }
                })
            })





    </script>

    <script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>
@endsection


