
<div class="col-xl-12 col-lg-12 col-sm-12 col-xs-12 exercise-blue">
    <div class="col-xl-12 col-lg-12 col-sm-12 col-xs-12 {{ $errors->has('passage_title') ? 'has-error' : '' }}">
        <div for="title" class="col-xl-2 col-lg-2 col-sm-2 col-xs-2 title" >Passage Title</div>
        <div class="col-xl-10 col-lg-10 col-sm-10 col-xs-12 input-box">
            <input class="form-control" name="passage_title" type="text" id="passage_title" value="{{ old('passage_title', optional($passage)->passage_title) }}" minlength="1" maxlength="250" required=true" placeholder="Enter passage title here...">
            {!! $errors->first('passage_title', '<p class="help-block">:message</p>') !!}
        </div>
    </div>

    <div class="col-xl-12 col-lg-12 col-sm-12 col-xs-12  {{ $errors->has('passage_text') ? 'has-error' : '' }}">
        <div for="passage_text" class="col-xl-2 col-lg-2 col-sm-2 col-xs-2 title">Passage Text</div>
        <div class="col-xl-10 col-lg-10 col-sm-10 col-xs-12 input-box">
            <textarea class="form-control" name="passage_text" cols="50" rows="8" id="passage_text" >{{ old('passage_text', optional($passage)->passage_text) }}</textarea>
            {!! $errors->first('passage_text', '<p class="help-block">:message</p>') !!}
        </div>
    </div>
</div>



