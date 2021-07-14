        <h5 class="gray-pannel">@lang('exam.select_skill_categories_s4')</h5>
        <div class="row categories_form">
            <div class="col-11-rduce col-md-6 col-lg-6 col-xl-4">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group mrgn-bt-30">
                            <div class="checkbox-sml custom-control custom-checkbox">
                                <input  value="1" id="selectallskillCat" type="checkbox" class="custom-control-input">
                                <label class="custom-control-label" for="selectallskillCat">@lang('exam.select_all')</label>
                            </div>
                        </div>
                    </div>
                    <div class="col-5">
                        <div class="checkbox-sml custom-control custom-checkbox">
                            <input name="skillCatLists" value="NULL" data-skill-cat-id="NULL" id="a" type="checkbox" class="custom-control-input selectedskillCat"  onclick="skillTextVal(this.id);" 
                            @if(isset($selected_examSkillCategories))
                                @if(in_array(0, $selected_examSkillCategories)) checked  @endif
                            @endif
                            />
                            <label class="custom-control-label" for="a">Not link With  Skill Categories</label>
                        </div>
                    </div>
                    <div class="col-7">
                        <div class="form-group mrgn-bt-30">
                            @php
                                //only for get nolink skill question count 
                                $a = $examSkillCategories->where('skill_category_id',0);
                                foreach($a as $nolink) { 
                                    $a=$nolink['skill_count'];
                                }
                            @endphp
                            <label class="questn_lbl">@lang('exam.max_questions') :</label>
                            <input type="number" name="max_que_NULL" id="max_que_NULL" class="form-control max_que" value="@if($a){{$a}}@else no @endif" min="1" max="{{ $questionsNullCount }}"
                            />
                            <small id="notlinkQueCount" date-queCount="{{ $questionsNullCount }}">{{ $questionsNullCount }} Question Available</small>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-12"></div>
        @if(isset($skillCatList) && count($skillCatList) > 0)
            @foreach($skillCatList as $skillCatLists)
                <div class="col-11-rduce col-md-6 col-lg-6 col-xl-4">
                    <div class="row">
                        <div class="col-5">
                            <div class="form-group mrgn-bt-30">
                            <div class="checkbox-sml custom-control custom-checkbox">
                                <input name="skillCatLists" value="{{ $skillCatLists->id }}" data-skill-cat-id="{{ $skillCatLists->id }}" id="skillCat_{{ $skillCatLists->id }}" type="checkbox" class="custom-control-input selectedskillCat" onclick="skillTextVal(this.id);"
                                @if(count($skillCatLists->SkillExamCategories) > 0)
                                    @if($skillCatLists->id == $skillCatLists->SkillExamCategories[0]->skill_category_id)) checked  @endif
                                @endif
                                >
                                <label class="custom-control-label" for="skillCat_{{ $skillCatLists->id }}">{{ $skillCatLists->skill_category_name }}</label>
                            </div>
                            </div>
                        </div>
                        <div class="col-7">
                            <div class="form-group mrgn-bt-30">
                            <label class="questn_lbl">@lang('exam.max_questions') :</label>
                            <input type="number" name="max_que_{{ $skillCatLists->id }}" id="max_que_{{ $skillCatLists->id }}" class="form-control max_que" min="1" max="{{ $skillCatLists->question_count }}"

                            @if(count($skillCatLists->SkillExamCategories) > 0)
                                value="{{ $skillCatLists->SkillExamCategories[0]->skill_count }}"
                            @endif
                            />
                            <small class="queCount" date-queCount="{{ $skillCatLists->question_count }}" data-skillcatId="{{ $skillCatLists->id }}">{{ $skillCatLists->question_count }} Question Available</small>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
            <input type="hidden" id="noSkillCat" name="" value="1" />
        </div>
    @else
    <div class="row categories_form">
        <div class="row pad_lfsd_15">
            <div class="col-md-12 cusmize-col pad_lfsd_20">
                <input type="hidden" id="noSkillCat" name="" value="0" />
                <p class="pad_lfsd_15">@lang('exam.no_skill_categories_available')</p>
                </br>
            </div>
        </div>
    </div>
    @endif
    {{--  <script src="{{ asset('assets/eduplaycloud/customs/js/filter/exam-skill-filter.js') }}"></script>  --}}
    <script type="text/javascript">
        $(document).ready(function () {
            // not linked question
            var notlinkQueCount = $('#notlinkQueCount').attr('date-queCount');
            if(notlinkQueCount == 0){
                $("# ").attr('disabled',true);
                $("#max_que_NULL").attr('disabled',true);
            }

            // all other skill cat
            var queCount = $('.queCount').attr('date-queCount');
            var skillcatcount = $('.queCount').attr('date-skillcatId');
            if(queCount == 0){
                $("#skillCat_"+skillcatcount).attr('disabled',true);
                $("#max_que_"+skillcatcount).attr('disabled',true);
            }

            $('.max_que').each(function( index ) {
                if(parseInt($( this ).val()) >= parseInt($( this ).attr('max')))
                {
                    $( this ).val($( this ).attr('max'));
                }
                else{
                    $( this ).val();
                }
            });
            // Onload checkbox checked on edit
            if($('.selectedskillCat').not(':checked').length == 0){
                $('#selectallskillCat').attr( 'checked', true );
            }
            // Select all skillcat
            $("#selectallskillCat").on("click", function(){
                if($(this).is(':checked')){
                    $('.categories_form .selectedskillCat').each(function() {
                        var isDisabled = $(this).is('[disabled=disabled]');
                        if(isDisabled){
                            $(this).prop('checked', false);
                        } else{
                            $(this).prop('checked',true);
                        }
                    });
                } else{
                    $('.selectedskillCat').prop('checked', false);
                }
                //$('.selectedskillCat').prop('checked', this.checked);
                if($('.selectedskillCat').is(':checked')){
                    $('.max_que').attr('required',true);
                }
                else{
                    $('.max_que').attr('required',false);
                }
            });

            $('.selectedskillCat').change(function () {
                var check = ($('.selectedskillCat').filter(":checked").length == $('.selectedskillCat').length);
                $('#selectallskillCat').prop("checked", check);
            });
        });

        // not linked question
        $("#skillCat_NULL").change(function() {
            var checked = $(this).is(":checked");
            if (checked) {
                $('#max_que_NULL').attr('required',true);
            } else {
                $('#max_que_NULL').attr('required',false);
            }
         });

        // for skill cat validation on textbox
        function skillTextVal(id=null){
            var skill_id = $('#' + id).attr('data-skill-cat-id');
            if($('#' + id).is(":checked")){
                if($('#max_que_' + skill_id).val() === ''){
                    $('#max_que_' + skill_id).attr('required',true);
                    return false;
                }
            }
            else{
                $('.max_que_' + skill_id).attr('required',false);
            }
        }
    </script>