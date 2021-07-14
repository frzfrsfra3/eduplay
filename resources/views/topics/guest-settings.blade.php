<div class="col-md-7 pddng_llf">
    <h3>
        @php
            if (isset($topic_name) && !empty($topic_name)):
                echo $topic_name;
            endif;
        @endphp
    </h3>
    <form class="def_form" action="{{route('topics.topic.exercisesets')}}" method="get">
        <div class="form-group {{ $errors->has('language_id') ? 'has-error' : '' }}">
            <label class="fm_label">Select Language</label>
            <div class="df-select">
                <select class="form-control" id="language_id" name="language_id" required="true">
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
                <select class="form-control" id="discipline_id" name="discipline_id" required="true">
                    <option value="0">@lang('topic.not_linked_to_skill')</option>
                    <option value="" style="display: none;" {{ old('discipline_id', optional($userinterest)->discipline_id ?: '') == '' ? 'selected' : '' }} disabled selected>@lang('topic.select_discipline_curriculum')</option>
                    @foreach ($disciplines as $key => $discipline)
                    <option value="{{ $key }}" {{ old('discipline_id', optional($userinterest)->discipline_id) == $key ? 'selected' : '' }}>
                        {{ $discipline }}
                    </option>
                    @endforeach
                </select>
                {!! $errors->first('discipline_id', '<p class="help-block">:message</p>') !!}
            </div>
        </div>
        <div class="form-group">
            <label class="fm_label">Select Grade</label>
            <div class="df-select">
                <select class="form-control" id="grade_id" name="grade_id">
                    <option value="" style="display: none;" {{ old('grade_id', optional($userinterest)->grade_id ?: '') == '' ? 'selected' : '' }} disabled selected>@lang('topic.select_grade')</option>
                    @foreach ($grades as $key => $grade)
                        <option value="{{ $key }}" {{ old('grade_id', optional($userinterest)->grade_id) == $key ? 'selected' : '' }}>
                            {{ $grade }}
                        </option>
                    @endforeach
                </select>
                {!! $errors->first('grade_id', '<p class="help-block">:message</p>') !!}
            </div>
        </div>
        <div class="form-group publis_mrgn">
            {{-- <button type="button" class="btn btn-primary btn-login" onclick="document.forms['form_submit'].submit();">Next</button> --}}
            <button type="submit" class="btn btn-primary" >@lang('topic.next')</button>
        </div>
    </form>
</div>
<div class="col-md-5 frm_rt_cntnt">
    <div class="form_txt_info">
            @lang('topic.details')
    </div>
</div>