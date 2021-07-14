<div class="form-group {{ $errors->has('avatar_id') ? 'has-error' : '' }}">
    <label for="avatar_id" class="col-md-2 control-label">Avatar</label>
    <div class="col-md-10">
        <select class="form-control" id="avatar_id" name="avatar_id">
        	<option value="" style="display: none;" {{ old('avatar_id', optional($accessories)->avatar_id ?: '') == '' ? 'selected' : '' }} disabled selected>Select Avatar</option>
        	@foreach ($avatars as $key => $avatar)
			    <option value="{{ $avatar->id }}" {{ old('avatar_id', optional($accessories)->avatar_id) == $avatar->id ? 'selected' : '' }}>
			    	{{ $avatar->name }}
			    </option>
			    @endforeach
        </select>
        
        {!! $errors->first('avatar_id', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group {{ $errors->has('image') ? 'has-error' : '' }}">
    <label for="image" class="col-md-2 control-label">Avatar accessories Image</label>
      <div class="col-md-10">
        <div class="pro-img ch-pic">
            @if(!empty($accessories))
            <img class="avatar-pic" src="{{ asset('/assets/eduplaycloud/image/') }}/{{optional($accessories)->image}}" width="100px">
            @else
            <img class="avatar-pic" src="{{ asset('uploads/profile') }}/profile_img.jpg" width="100px">
            @endif
            <input class="file-upload-nw" name="image" id="image" type="file" accept="image/*" />
        </div>
    </div>
</div>

<div class="form-group {{ $errors->has('points') ? 'has-error' : '' }}">
    <label for="points" class="col-md-2 control-label">Accessories points</label>
    <div class="col-md-10">
        <input class="form-control" name="points" type="number" id="points" value="{{ old('points', optional($accessories)->points) }}" minlength="1" maxlength="250" required="true" placeholder="Enter accessories points here...">
        {!! $errors->first('points', '<p class="help-block">:message</p>') !!}
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
                $('.avatar-pic').attr('src', e.target.result);
            }

            reader.readAsDataURL(input.files[0]);
        }
    }
    $(".file-upload-nw").on('change', function(){
        readURL(this);
    });

    $(".avatar-pic").on('click', function() {
        $(".file-upload-nw").click();
    });
    $(".change-pic").on('click', function() {
        $(".file-upload-nw").click();
    });

});
</script>
@endsection