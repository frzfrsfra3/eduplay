<div id="CurriculumHTML">
    @if(isset($disciplines) && count($disciplines) > 0)
        <h5 class="gray-pannel">@lang('exam.select_discipline_s2')</h5>
        <div class="row">
            <div class="col-11-rduce col-xl-7">
                <ul class="desipline_list teacher-action">
                    <li>
                    <div class="form-group mrgn-bt-30">
                        <div class="custom-control custom-checkbox">
                            <input  value="1" id="selectallDiscipline" type="checkbox" class="custom-control-input">
                            <label class="custom-control-label" for="selectallDiscipline">@lang('exam.select_all')</label>
                        </div>
                    </div>
                    </li>
                    @foreach($disciplines as $discipline)
                        <li>
                            <div class="form-group mrgn-bt-30">
                                <div class="custom-control custom-checkbox">
                                    <input name="disciplineId"  value="{{$discipline->id}}" id="discipline_{{$discipline->id}}" type="checkbox"
                                    @if(isset($selected_discipline))
                                        @if(in_array($discipline->id, $selected_discipline)) checked  @endif
                                    @endif
                                    class="custom-control-input selectedDiscipline">
                                    <label class="custom-control-label" for="discipline_{{$discipline->id}}">{{$discipline->discipline_name}}</label>
                                </div>
                            </div>
                        </li>
                    @endforeach
                </ul>
                <div class="clearfix"></div>
                <input type="hidden" id="nodiscipline" name="" value="1" />
            </div>
        </div>
    @else
        <div class="row">
            <div class="col-md-12 cusmize-col">
                {{--  <input type="hidden" id="nodiscipline" name="" value="0" />  --}}
                <p>@lang('exam.no_curriculum_available')</p>
                </br>
            </div>
        </div>
    @endif
</div>
    <script src="{{ asset('assets/eduplaycloud/customs/js/filter/exam-curriculum-filter.js') }}"></script>
    <script src="{{ asset('assets/eduplaycloud/customs/js/filter/save-filter.js') }}"></script>
    <script type="text/javascript">
        $(document).ready(function () {

            // Onload checkbox checked on edit
            if($('.selectedDiscipline').not(':checked').length == 0){
                $('#selectallDiscipline').attr( 'checked', true );
            }
            // Select all discipline
            $('#selectallDiscipline').click(function () {
                $('.selectedDiscipline').prop('checked', this.checked);
            });

            $('.selectedDiscipline').change(function () {
                var check = ($('.selectedDiscipline').filter(":checked").length == $('.selectedDiscipline').length);
                $('#selectallDiscipline').prop("checked", check);
            });
        });
    </script>