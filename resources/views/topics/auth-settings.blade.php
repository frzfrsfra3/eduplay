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
    <form name="frmSettings" id="frmSettings" class="def_form next-{{ $topic_id }} " method="post" action="#">
        @csrf
        <div class="form-group {{ $errors->has('language_id') ? 'has-error' : '' }}">
            <label class="fm_label">@lang('topic.select_language')</label>
            <div class="df-select">
                <select class="selectpicker" id="language_id" name="language_id" data-topic="{{ $topic_id }}">
                    <option value="" style="display: none;" {{ old('language_id', optional($userinterest)->language_id ?: '') == '' ? 'selected' : '' }}  selected>@lang('topic.select_language')</option>
                    @foreach ($languages as $key => $language)
                        @if(Auth::user())
                            <option value="{{ $language->id }}"
                                @if (old('language_id', optional($userinterest)->language_id) == $language->id)
                                    selected="selected"
                                @endif>
                                {{ $language->language }}
                            </option>
                        @else
                            <option value="{{ $language->id }}">{{ $language->language }}</option>
                        @endif
                    @endforeach
                </select>
                {!! $errors->first('language_id', '<p class="help-block">:message</p>') !!}
            </div>
        </div>
        <div class="form-group {{ $errors->has('discipline_id') ? 'has-error' : '' }}">
            <label class="fm_label">@lang('topic.select_curriculum')</label>
            <div class="df-select">
                <select class="selectpicker" id="discipline_id" name="discipline_id">
                    <option value="">@lang('topic.not_linked_to_skill')</option>
                    @foreach ($disciplines as $key => $discipline)
                        @if(Auth::user())
                            <option value="{{ $discipline->id }}" {{ old('discipline_id', optional($userinterest)->discipline_id) == $discipline->id ? 'selected' : '' }}>{{ $discipline->discipline_name }}</option>
                        @else
                            <option value="{{ $discipline->id }}">{{ $discipline->discipline_name }}</option>
                        @endif
                    @endforeach
                </select>
                {!! $errors->first('discipline_id', '<p class="help-block">:message</p>') !!}
            </div>
        </div>
        <div class="form-group">
            <label class="fm_label">@lang('topic.select_grade')</label>
            <div class="df-select">
                <select class="selectpicker" id="grade_id" name="grade_id">
                    <option value="0" style="display: block;" {{ old('grade_id', optional($userinterest)->grade_id ?: '') == '' ? 'selected' : '' }} >@lang('topic.select_grade')</option>
                    @foreach ($grades as $key => $grade)
                        @if(Auth::user())
                            <option value="{{ $grade->id }}" {{ old('grade_id', optional($userinterest)->grade_id) == $grade->id ? 'selected' : '' }}>{{ $grade->grade_name }}</option>
                        @else
                            <option value="{{ $grade->id }}">{{ $grade->grade_name }}</option>
                        @endif
                    @endforeach
                </select>
                {!! $errors->first('grade_id', '<p class="help-block">:message</p>') !!}
            </div>
        </div>
        <div class="form-group publis_mrgn">
            <button type="submit" class="btn btn-primary btn-login">@lang('topic.next')</button>
        </div>
    </form>
</div>
<div class="col-md-5 frm_rt_cntnt">
    <div class="form_txt_info">
        @lang('topic.details')
    </div>
</div>

<script src="{{ asset('assets/eduplaycloud/customs/js/jquery-validate/jquery.validate.min.js') }}" type="text/javascript"></script>
<script>
    $.extend(jQuery.validator.messages, {
        required: message['validator_required'],
        remote: message['validator_remote'],
        email: message['validator_email'],
        url: message['validator_url'],
        date: message['validator_date'],
        number: message['validator_number'],
        digits: message['validator_digits'],
        equalTo: message['validator_equalTo'],
        maxlength: jQuery.validator.format(message['validator_maxlength']),
        minlength: jQuery.validator.format(message['validator_minlength']),
        rangelength: jQuery.validator.format(message['validator_rangelength']),
        range: jQuery.validator.format(message['validator_range']),
        max: jQuery.validator.format(message['validator_max']),
        min: jQuery.validator.format(message['validator_min'])
    });

    $("#frmSettings").validate({
        rules: {
            language_id: {
                required: true
            },
            discipline_id : {
                required: true
            }
        },
        messages: {

        },
        ignore: [],
        errorPlacement: function (error, element) {
            error.insertAfter(element);
        },
        submitHandler: function (form) {
            var desciplineId = 0;
            if ($("#frmSettings #discipline_id option:selected").val() != "") {
                desciplineId = $("#frmSettings #discipline_id option:selected").val();
            }

            var userInterestId = $('#topics-result .discipline_'+'<?php echo $topic_id; ?>').attr('data-interested-id');
            $.ajax({
                type: "get",
                url: "<?php echo route('userinterests.userinterest.updateinterests'); ?>",
                data: {
                    "_token": $('meta[name="csrf-token"]').attr('content'),
                    "id": $(".discipline_"+"{{ $topic_id }}").attr('data-interested-id'),
                    "discipline_id": desciplineId,
                    "topic_id": '{{ $topic_id }}',
                    "language_id": $("#frmSettings #language_id option:selected").val(),
                    "grade_id": $("#frmSettings #grade_id option:selected").val(),
                    "exercise_type": 1,
                    "user_id": $('header').attr('id'),
                    "_method": 'put',
                },
                beforeSend: function () {
                    showLoader();
                },
                success: function (response) {
                    // console.log(response);
                    hideLoader();
                    if (response.status !== false) {
                        window.location.href = "<?php echo route('topics.topic.exercisesets'); ?>";
                    }
                },
                error: function (err) {
                    hideLoader();
                    swal('No response from the server.', {
                        closeOnClickOutside: false,
                        icon: 'info',
                    }).then(function() {
                        // location.reload();
                    });
                }
            });

            return false;
        }
    });


    /* dynamic grades - Client code  */
    $('#language_id').on('change', function(){
        var topic_id = $(this).data('topic');
        var url=site_url+'/exercisesets/getdisciplieslist/'+$(this).val()+'/'+topic_id;
        $.get(url,
        function(data) {
            var discipline = $('#discipline_id');
            $('#discipline_id').empty();
            $('#discipline_id').append("<option value='0'>" + "@lang('topic.select_discipline_curriculum')" + "</option><option value='notlinked'>" + "@lang('topic.not_linked_to_skill')" + "</option>");
            $.each(data, function(index, discipline) {
                $('#discipline_id').append("<option value='"+ discipline.id +"'>" + discipline.discipline_name + "</option>");
            });
            $('.selectpicker').selectpicker('refresh');
        });
    });

    /* dynamic grades - Client code  */
    $('#discipline_id').on('change', function(){
        var id=$(this).val();
        var language_id = $("#frmSettings #language_id option:selected").val();
        var url=site_url+'/exercisesets/getgradeslist/'+$(this).val()+'/'+language_id;
        $.get(url,
        function(data) {
            var grades = $('#grade_id');
            grades.empty();
            grades.append("<option value=''>" + "Select grade" + "</option>");
            $.each(data, function(index, element) {
                grades.append("<option value='"+ element.id +"'>" + element.grade_name + "</option>");
            });

            $('.selectpicker').selectpicker('refresh');
        });
    });
</script>