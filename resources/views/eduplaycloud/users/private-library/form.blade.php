<div class="col-md-12">
        <div class="form-group mrgn-bt-30 {{ $errors->has('title') ? 'has-error' : '' }}">
            <label>@lang('exerciseset_form.title') :</label>
            <input type="text" name="title" class="form-control"  value="{{ old('title', optional($exerciseset)->title) }}" minlength="1" maxlength="60">
            <div class="error">{{ $errors->first('title') }}</div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group mrgn-bt-30 {{ $errors->has('description') ? 'has-error' : '' }}">
            <label>@lang('exerciseset_form.description') :</label>
            <textarea class="form-control" name="description"  id="description">{{ old('description', optional($exerciseset)->description) }}</textarea>
            <div class="error">{{ $errors->first('description') }}</div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group mrgn-bt-30">
            <div class="df-select  {{ $errors->has('topic_id') ? 'has-error' : '' }}">
                <label>@lang('exerciseset_form.select_topic') :</label>
                <select class="selectpicker" id="topic_id" name="topic_id">
                    <option value="" style="display: none;" disabled selected>@lang('exerciseset_form.select_topic')</option>
                    @foreach ($topics as $key => $topic)
                        <option value="{{ $topic->id }}" {{ old('topic_id', optional($exerciseset)->topic_id) == $topic->id  ? 'selected' : '' }}>{{ $topic->topic_name }}</option>
                    @endforeach
                </select>
                <div class="error">{{ $errors->first('topic_id') }}</div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group mrgn-bt-30">
            <div class="langues-seclt df-select  {{ $errors->has('language_id') ? 'has-error' : '' }}">
                <label>@lang('exerciseset_form.language') :</label>
                <select class="" id="language_id" name="language_id"  >
                    <option value="" style="display: none;" {{ old('language_id', optional($exerciseset)->language_id ?: '') == '' ? 'selected' : '' }} disabled selected> @lang('exerciseset_form.select_main_language')</option>
                    @foreach ($languages as $key => $language)
                        <option value="{{ $language->id }}" {{ old('language_id', optional($exerciseset)->language_id) == $language->id  ? 'selected' : '' }}>
                            {{ $language->language }}
                        </option>
                    @endforeach
                </select>
                <div class="error">{{ $errors->first('language_id') }}</div>
            </div>
        </div>
    </div>
    {{-- <div class="col-md-6">
        <div class="form-group mrgn-bt-30  {{ $errors->has('price') ? 'has-error' : '' }}">
            <label>@lang('exerciseset_form.price') :</label>
            <input type="text" class="form-control"  name="price" rows="1" id="price" value="{{ old('price', optional($exerciseset)->price) }}" minlength="1" maxlength="100" min="0">
            <div class="error">{{ $errors->first('price') }}</div>
        </div>
    </div> --}}
    <div class="col-md-3">
        <div class="form-group mrgn-bt-30  {{ $errors->has('tags') ? 'has-error' : '' }}"> 
            <label>@lang('exerciseset_form.tags') :</label>
            <input type="text" class="form-control"  name="tags" rows="1" value="{{old('tags',optional($exerciseset)->tagNames() ==  ''  ? ''  : implode(optional($exerciseset)->tagNames(),',')) }}" id="tags" minlength="1" maxlength="100" min="0">
            <div class="error">{{ $errors->first('tags') }}</div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group mrgn-bt-30  {{ $errors->has('minimum_age') ? 'has-error' : '' }}">
            <label>@lang('exerciseset_form.minimum_age') :</label>
            <input type="number" class="form-control"  name="minimum_age" rows="1" id="minimum_age" value="{{ old('minimum_age', optional($exerciseset)->minimum_age) }}" min="0">
            <div class="error">{{ $errors->first('minimum_age') }}</div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="form-group mrgn-bt-30  {{ $errors->has('maximum_age') ? 'has-error' : '' }}">
            <label>@lang('exerciseset_form.maximum_age') :</label>
            <input type="number" class="form-control"  name="maximum_age" rows="1" id="maximum_age" value="{{ old('maximum_age', optional($exerciseset)->maximum_age) }}" min="0">
            <div class="error">{{ $errors->first('maximum_age') }}</div>
        </div>
    </div>

    <div class="col-md-6">
            <div class="form-group mrgn-bt-30 {{ $errors->has('publish_status') ? 'has-error' : '' }}">
                <ul class="prsn-action-rdio">
                    @if (Auth::user()->hasRole('Teacher'))
                    <li>
                        <div class="rdio rdio-primary">
                            <input name="publish_status" rows="1" type="radio" value="public" id="public" {{ (old('publish_status') == 'public' || optional($exerciseset)->publish_status == 'public') ? 'checked' : '' }}>
                            <label for="public">@lang('exerciseset_form.public')</label>
                        </div>
                    </li>
                    @endif
                    <li>
                        <div class="rdio rdio-primary">
                            <input name="publish_status" rows="1" type="radio" value="private" id="private" {{ (old('publish_status') == 'private' || optional($exerciseset)->publish_status == 'private') ? 'checked' : '' }} {{ (Auth::user()->hasRole('Learner') || Auth::user()->hasRole('Parent')) ? 'checked' : '' }} >
                            <label for="private">@lang('exerciseset_form.private')</label>
                        </div>
                    </li>
                </ul>
                <div class="error">{{ $errors->first('publish_status') }}</div>
            </div>
        </div>
    <div class="col-md-12">
        <div class="form-group mrgn-bt-5">
            <div class="upld_file crsr_p">
            <input type="file"  title="@lang('exerciseset_form.choose_file')"  name="exerciseset-image" id="image" accept="image/*" onchange="loadFile(event)">
            <a href="javascript:void(0);" class="uplod_img">@lang('exerciseset_form.exerciseset_picture')</a>
            </div>

            <div class="img_bx">

            @if(!empty(optional($exerciseset)->exerciseset_image))
                @if(strlen($exerciseset->exerciseset_image) > 0 && File::exists(public_path()."/uploads/exercisesets/".$exerciseset->exerciseset_image))
                    <img id="output" src="{{ asset('/uploads/exercisesets/'.$exerciseset->exerciseset_image) }}">
                @else
                    <img for="" id="output"/>
                @endif
            @else
                    <img for="" id="output"/>
            @endif 
        </div>
    </div>
    <input class="form-control" name="createdby" type="hidden" id="createdby" value="{{ optional($exerciseset)->createdby ==  ''  ? Auth::user()->id : $exerciseset->createdby }}" >
    </div>