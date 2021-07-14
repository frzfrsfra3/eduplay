<div class="col-md-7 pddng_llf">
    <h3>
        @php
            if (isset($topic_id) && !empty($topic_id)):
                $topic_id;
            else:
                $topic_id = 0;
            endif;

            if (isset($topic_name) && !empty($topic_name)):
                echo $topic_name;
            endif;
        @endphp
    </h3>
    <form name="frmSettings" id="frmSettings" class="def_form next-{{ $topic_id }} " method="get" action="#">
        @csrf
        <div class="form-group {{ $errors->has('language_id') ? 'has-error' : '' }}">
            <label class="fm_label">@lang('topic.select_language')</label>
            <div class="df-select">
                <select class="selectpicker" id="language_id" name="language_id" data-topic="{{ $topic_id }}">
                    <option value="" style="display: none;" {{ old('language_id', optional($userinterest)->language_id ?: '') == '' ? 'selected' : '' }} disabled selected>@lang('topic.select_language')</option>
                    @foreach ($languages as $key => $language)
                    <option value="{{ $language->id }}"
                        @if (old('language_id', optional($userinterest)->language_id) == $language->id)
                            selected="selected"
                        @else
                            @if ($language->id ==1)
                                selected="selected"
                                @endif
                                @endif
                                >
                        {{ $language->language }}
                    </option>
                    @endforeach
                </select>
                {!! $errors->first('discipline_id', '<p class="help-block">:message</p>') !!}
            </div>
        </div>
        <div class="form-group {{ $errors->has('discipline_id') ? 'has-error' : '' }}">
            <label class="fm_label">@lang('topic.select_curriculum')</label>
            <div class="df-select">
                <select class="selectpicker" id="discipline_id" name="discipline_id">
                    {{-- <option value="" style="display: none;" {{ old('discipline_id', optional($userinterest)->discipline_id ?: '') == '' ? 'selected' : '' }} disabled selected>@lang('topic.select_discipline_curriculum')</option> --}}
                    {{-- <option value="0">@lang('topic.not_linked_to_skill')</option> --}}
                    @foreach ($disciplines as $key => $discipline)
                    <option value="{{ $discipline->id }}" {{ old('discipline_id', optional($userinterest)->discipline_id) == $discipline->id ? 'selected' : '' }}>
                    {{ $discipline->discipline_name }}
                    </option>
                    @endforeach
                </select>
                {!! $errors->first('discipline_id', '<p class="help-block">:message</p>') !!}
            </div>
        </div>
        <div class="form-group">
            <label class="fm_label">@lang('topic.select_grade')</label>
            <div class="df-select">
                <select class="selectpicker" id="grade_id" name="grade_id">
                    <option value="" style="display: none;" {{ old('grade_id', optional($userinterest)->grade_id ?: '') == '' ? 'selected' : '' }} disabled selected>@lang('topic.select_grade')</option>
                    @foreach ($grades as $key => $grade)
                        <option value="{{ $grade->id }}" {{ old('grade_id', optional($userinterest)->grade_id) == $grade->id ? 'selected' : '' }}>
                            {{ $grade->grade_name }}
                        </option>
                    @endforeach
                </select>
                {!! $errors->first('grade_id', '<p class="help-block">:message</p>') !!}
            </div>
        </div>
        <div class="form-group publis_mrgn">
            <input type="hidden" name="id" value="{{optional($userinterest)->id}}">
            <input type="hidden" name="topic_id" value="{{$topic_id}}">
            <input type="hidden" name="exercise_type" value="1">
            <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
            <button type="button" class="btn btn-primary btn-login" id="submit-button">@lang('topic.next')</button>
        </div>
    </form>
</div>
<div class="col-md-5 frm_rt_cntnt">
    <div class="form_txt_info">
        @lang('topic.details')
    </div>
</div>

