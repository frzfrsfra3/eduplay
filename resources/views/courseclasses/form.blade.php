<div class="col-md-12">
    <div class="form-group mrgn-bt-30">
        <label>@lang('classcourse.Enterclassnamehere')</label>
        <input type="text" class="form-control" name="class_name" id="class_name"  value="{{ old('class_name', optional($courseclass)->class_name) }}">
      {!! $errors->first('class_name', '<p class="help-block">:message</p>') !!}
</div>
    </div>
<div class="col-md-6">
    <div class="form-group mrgn-bt-30">
        <label>@lang('classcourse.Enterclassdescriptionhere')</label>
        <textarea class="form-control" name="class_description" id="class_description" >{{ old('class_description', optional($courseclass)->class_description) }}</textarea>
        {!! $errors->first('class_description', '<p class="help-block">:message</p>') !!}
    </div>
</div>
<div class="col-md-6">
    <div class="form-group mrgn-bt-30">
        <div class="df-select">
            <label>@lang('classcourse.Select Curriculum') </label>
            <select class="selectpicker" name="discipline_id" id="discipline_id">
                <option value="" style="display: block;" {{ old('discipline_id', optional($courseclass)->discipline_id ?: '') == '' ? 'selected' : '' }}  selected>@lang('classcourse.Select Curriculum')</option>
                @foreach ($disciplines as $key => $discipline)
                    <option value="{{ $discipline->id }}" {{ old('discipline_id', optional($courseclass)->discipline_id) == $discipline->id ? 'selected' : '' }}>
                        {{ $discipline->discipline_name }}
                    </option>
                @endforeach
            </select>
        </div>
    </div>
</div>
<div class="col-md-6">
    <div class="form-group mrgn-bt-30">
        <div class="df-select langues-seclt">
            <label>@lang('classcourse.Enterlanguagehere')</label>
            <select class="" name="language_id" id="language_id">
                <option value="" style="display: none;" {{ old('language_id', optional($courseclass)->language_id ?: '') == '' ? 'selected' : '' }} disabled selected>@lang('classcourse.Enterlanguagehere')</option>
                @foreach ($languages as $key => $language)
                    <option value="{{ $language->id }}" {{ old('language_id', optional($courseclass)->language_id) == $language->id  ? 'selected' : '' }}>
                        {{ $language->language }}
                    </option>
                @endforeach
            </select>
            <label for="language_id" generated="true" class="error"></label>
        </div>
    </div>
</div>
<div class="col-md-6">
    <div class="form-group mrgn-bt-30">
        <div class="df-select">
            <label>@lang('classcourse.Select grade')</label>
            <select class="selectpicker" name="grade_id" id="grade_id">
                <option value="" style="display: none;" {{ old('grade_id', optional($courseclass)->grade_id ?: '') == '' ? 'selected' : '' }} disabled selected>@lang('classcourse.Select grade')</option>
                @foreach ($grades as $key => $grade)
                    <option value="{{ $key }}" {{ old('grade_id', optional($courseclass)->grade_id) == $key ? 'selected' : '' }}>
                        {{ $grade }}
                    </option>
                @endforeach
            </select>
        </div>
    </div>
</div>
<div class="col-md-6">
    <div class="form-group mrgn-bt-30">
        <label>@lang('classcourse.StartDate')</label>
        <input type="text" name="start_date" id="start_date" class="form-control"  value="{{ date('d-m-Y', strtotime(optional($courseclass)->start_date)) }}">
        {!! $errors->first('start_date', '<p class="help-block">:message</p>') !!}
    </div>
</div>
<div class="col-md-6">
    <div class="form-group mrgn-bt-30">
        <label>@lang('classcourse.EndDate')</label>
        <input type="text" name="end_date" id="end_date" class="form-control" value="{{ date('d-m-Y', strtotime(optional($courseclass)->end_date)) }}">
        {!! $errors->first('end_date', '<p class="help-block">:message</p>') !!}
    </div>
</div>
<div class="col-md-12">
    <div class="form-group mrgn-bt-30">
        <div class="upld_file crsr_p">
        <input type="file" accept="image/*" name="image" id="image" onchange="loadFile(event)">
        <a href="javascript:void(0);" class="uplod_img">@lang('classcourse.upload_image')</a>
        {{ $errors->has('image') ? 'has-error' : '' }}
        </div>
        <div class="img_bx">
            @if( strlen(optional($courseclass)->iconurl)>0)
                <img id="output" src="{{asset('assets/images/'.optional($courseclass)->iconurl)  }}">
            @else
                <img id="output"/>
            @endif
        </div>
    </div>
</div>
<div class="col-md-12">
        <div class="form-group mrgn-bt-30">
            <div class="custum-checkbox-tp custom-control custom-checkbox">
                <input name="isavailable" value="1" id="Learner" type="checkbox" class="custom-control-input" @if(isset($courseclass->isavailable)){{ ($courseclass->isavailable == 'Y') ? 'checked="checked"' : '' }} @endif>
                <label class="custom-control-label" for="Learner">@lang('classcourse.Enter isavailable here...')</label>
            </div>
        </div>
    </div>
<input class="form-control" name="teacher_userid" type="hidden" id="teacher_userid" value="{{Auth::user()->id}}" />