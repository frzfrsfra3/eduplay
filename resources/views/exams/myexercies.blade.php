
    @if(isset($exercisesets) && count($exercisesets) > 0)
        <div class="col-md-12 col-lg-12 col-xl-12 cusmize-col">
            <h5 class="gray-pannel">@lang('exam.select_Exercisesets_s3')</h5>
            <div class="custum-checkbox-tp select-all-ckbx custom-control custom-checkbox">
                <input  value="1" id="selectallexercises" type="checkbox" class="custom-control-input">
                <label class="custom-control-label" for="selectallexercises">@lang('exam.select_all')</label>
            </div>
        </div>
        @foreach($exercisesets as $exerciseset)
            <div class="col-md-6 col-lg-6 col-xl-3 cusmize-col">
                <div class="main_info">
                    <a href="javascript:;" class="info_exercise">
                            @php
                            if (isset($exerciseset->exerciseset_image) && !empty($exerciseset->exerciseset_image)) {
                                if (strlen($exerciseset->exerciseset_image) > 0 && File::exists(public_path()."/uploads/exercisesets/".$exerciseset->exerciseset_image)) {
                                    $exercisesetImage = '/uploads/exercisesets/'.$exerciseset->exerciseset_image;

                                } else {
                                    $exercisesetImage = 'assets/eduplaycloud/image/exers_prfl.png';
                                }
                            } else {
                                $exercisesetImage = 'assets/eduplaycloud/image/exers_prfl.png';
                            }
                            @endphp
                        <img src="{{ asset($exercisesetImage) }}" class="img-fluid">
                        <div class="whit_checbx">
                            <div class="custom-control custom-checkbox chbx_wt">
                                <input name="exercisesId" value="{{$exerciseset->id}}" id="exercises_{{$exerciseset->id}}" type="checkbox" class="custom-control-input 
                                selectedexercises"
                                @if(isset($selected_examexercisesets))
                                    @if(in_array($exerciseset->id, $selected_examexercisesets)) checked  @endif
                                @endif
                                >
                                <label class="custom-control-label" for="exercises_{{$exerciseset->id}}"></label>
                            </div>
                        </div>
                        <div class="main_shr">
                            {{--  <button type="button" class="share_link_icn"></button>  --}}
                        </div>
                        <div class="left_time_info">
                            <ul class="time_info float-left">
                                {{--  <li>
                                    @if ($exerciseset->price != 0)
                                        ${{ $exerciseset->price }}
                                    @else
                                        @lang('exercisesets.free')
                                    @endif
                                </li>  --}}
                                <li class="time_icn">{{ gmdate("H:i:s", $exerciseset->question->sum('maxtime')) }}</li>
                            </ul>
                            <ul class="skill_info float-right">
                                <li>@lang('exercisesets.skills'):
                                        {{ ($exerciseset->question->where('skill_id','!=',null)->groupby('skill_id')->count('skill_id')) }}</li>
                                <li> @lang('exercisesets.question'):{{ $exerciseset->question->count() }}</li>
                            </ul>
                        </div>
                    </a>
                    <ul class="title_cmbo">
                        <li><a href="#">{{str_limit($exerciseset->title, '30')}}</a></li>
                        {{--  <li><p>{{ $exerciseset->description }}</p></li>  --}}
                        @if($exerciseset->discipline)
                            <li>
                                {{-- <a href="javascript:;"> --}}
                                {{ str_limit(@$exerciseset->discipline->discipline_name,'50') }}
                                {{-- </a> --}}
                            </li>
                        @else 
                            <li><span>@lang('filter.n/a')</span></li>
                        @endif
                    </ul>
                    <ul class="star_wth_user">
                        <li>
                            <div class="gray_star">
                                <div class="orng_star" style="width: {{(@$exerciseset->averageRating(1)[0]) * 100 / 5}}%;"></div>
                            </div>
                        </li>
                        @if($exerciseset->grade)
                            <li><span>{{str_limit(@$exerciseset->grade->grade_name, '18')}}</span></li>
                        @endif
                    </ul>
                </div>
            </div>
            @endforeach
        <input type="hidden" id="noexercisesset" name="" value="1" />
    @else
        <div class="col-md-6 col-lg-6 col-xl-3 cusmize-col">
            <input type="hidden" id="noexercisesset" name="" value="0" />
            <p>@lang('exam.no_exercisesset_available')</p>
            </br>
        </div>
    @endif
    {{--  <script src="{{ asset('assets/eduplaycloud/customs/js/filter/exam-exersice.js') }}"></script>  --}}
    <script type="text/javascript">
        $(document).ready(function () {
            $('#exercise-startDate').datetimepicker({
                format: 'DD-MM-YYYY',
                maxDate: 'now'
            });

            $('#exercise-endDate').datetimepicker({
                format: 'DD-MM-YYYY',
                useCurrent: false,
                maxDate: 'now'
            });

            // Onload checkbox checked on edit
            if($('.selectedexercises').not(':checked').length == 0){
                $('#selectallexercises').attr( 'checked', true );
            }
            // Select all exercises
            $("#selectallexercises").on("click", function(){
                $('.selectedexercises').prop('checked', this.checked);
            });

            $('.selectedexercises').change(function () {
                var check = ($('.selectedexercises').filter(":checked").length == $('.selectedexercises').length);
                $('#selectallexercises').prop("checked", check);
            });
        });
    </script>
