<div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
    <label for="name" class="col-md-2 control-label">Avatar Name</label>
    <div class="col-md-10">
        <input class="form-control" name="name" type="text" id="name" value="{{ old('name', optional($avatar)->name) }}" minlength="1" maxlength="250" required="true" placeholder="Enter avatar name here...">
        {!! $errors->first('name', '<p class="help-block">:message</p>') !!}
    </div>
</div>


<div class="form-group {{ $errors->has('image') ? 'has-error' : '' }}">
    <label for="image" class="col-md-2 control-label">Avatar Image</label>
      <div class="col-md-10">
        <div class="pro-img ch-pic">
            @if(!empty($avatar))
              <img class="avatar-pic" src="{{ asset('assets/eduplaycloud/image/') }}/{{ optional($avatar)->image }}" width="100px">
            @else 
              <img class="avatar-pic" src="{{ asset('uploads/profile') }}/profile_img.jpg" width="100px">
            @endif
            <input class="file-upload-nw" name="image" id="image" type="file" accept="image/*" />
        </div>
    </div>
</div>

<div class="form-group {{ $errors->has('category') ? 'has-error' : '' }}">
    <label for="category" class="col-md-2 control-label">Avatar category</label>
    <div class="col-md-10">
        <input class="form-control" name="category" type="text" id="category" value="{{ old('category', optional($avatar)->category) }}" minlength="1" maxlength="250" required="true" placeholder="Enter avatar category here...">
        {!! $errors->first('category', '<p class="help-block">:message</p>') !!}
    </div>
</div>


<div class="form-group {{ $errors->has('points') ? 'has-error' : '' }}">
    <label for="points" class="col-md-2 control-label">Avatar points</label>
    <div class="col-md-10">
        <input class="form-control" name="points" type="number" id="points" value="{{ old('points', optional($avatar)->points) }}" minlength="1" maxlength="250" required="true" placeholder="Enter avatar points here...">
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