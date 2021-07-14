@extends('authenticated.layouts.default')
@section('content')
<!---Content-->
<div class="work_page main_content exercesi_block mrgn-bt-40 text-ar-right">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-11-rduce col-xl-12">
                <h4 class="exersc_title existing_fnt">@lang('classcourse.add_from_existing_or_create_new_exam')</h4>
                <a href="{{ route('Exams.exam.create.first',['edit'=>'class','class_id'=>$classId]) }}" class="creat_new">@lang('classcourse.add_new')</a>

                @if(Session::has('success_message'))
                    <div class="alert alert-success">
                        <span class="glyphicon glyphicon-ok"></span>
                        {!! session('success_message') !!}
                        <button type="button" class="close" data-dismiss="alert" aria-label="close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @endif
                <div class="highlight_homewrk mrgn-tp-40">
                    <form class="def_form form_heightlit" method="post" id="exestingExam" action="{{ route('courseclasses.courseclass.addexam',$classId) }}">
                        @csrf
                        <div class="row">
                            @if(isset($myexams) && count($myexams) > 0)
                                <div class="col-md-12 errors">
                                    {{--  {{ $myexams }}  --}}
                                        @foreach($myexams as $myexam)
                                        <ul class="subject_list_hieghlt">
                                            <li>
                                                <div class="form-group mrgn-bt-20">
                                                    <div class="custum-checkbox-tp custom-control custom-checkbox">
                                                        <input name="subject_type" value="1" id="Highcharts_{{ $myexam->id }}" type="checkbox" class="custom-control-input">
                                                        <label class="custom-control-label" for="Highcharts_{{ $myexam->id }}">{{ $myexam->title }}</label>
                                                    </div>
                                                </div>
                                            </li>
                                            <li>
                                                <div class="form-group mrgn-bt-20">
                                                    <h5>
                                                        @if ($myexam->examtype == 'test') 
                                                            @lang('exam.test')
                                                        @elseif ($myexam->examtype == 'homework')
                                                            @lang('exam.home_work')
                                                        @else 
                                                            @lang('exam.practice')
                                                        @endif
                                                        
                                                    </h5>
                                                    {{-- <input type="text" class="form-control input_{{ $myexam->id }}" placeholder="{{ $myexam->examtype }}"> --}}
                                                </div>
                                            </li>
                                            <li>
                                                <div class="form-group mrgn-bt-20">
                                                    <input type="text" name="exam[{{ $myexam->id }}][startDate]" id="startDate_{{ $myexam->id }}" class="startDate dttmpckr form-control input_{{ $myexam->id }}" placeholder="@lang('filter.start_date')">
                                                </div>
                                            </li>
                                            <li>
                                                <div class="form-group mrgn-bt-20">
                                                    <input type="text" name="exam[{{ $myexam->id }}][endDate]" id="endDate_{{ $myexam->id }}" class="endDate dttmpckr form-control input_{{ $myexam->id }}" placeholder="@lang('filter.end_date')">
                                                </div>
                                            </li>
                                            @if($myexam->examtype === 'test')
                                                @if (count(LogicHelper::getExamDuration($myexam->id)) > 0)
                                                    @php
                                                        $sum=0;
                                                        $examLogic = LogicHelper::getExamDuration($myexam->id); 
                                                    @endphp
                                                    @foreach($examLogic as $key => $question)
                                                        {{-- {{ $question }} --}}
                                                        @if (count(LogicHelper::getQuestionDuration($question->question_id)) > 0)
                                                            @php
                                                                $que=LogicHelper::getQuestionDuration($question->question_id);
                                                                foreach($que as $key => $question){
                                                                    $sum+=$question->maxtime;
                                                                }
                                                            @endphp
                                                        @endif
                                                    @endforeach
                                                @endif
                                                <li>
                                                    <div class="form-group mrgn-bt-20">
                                                        <h5>{{ gmdate("H:i:s", $sum) }}</h5>
                                                        {{-- <input type="text" class="form-control  input_{{ $myexam->id }}" value="{{ gmdate("H:i:s", $sum) }}" placeholder="Duration"> --}}
                                                    </div>
                                                </li>
                                            @endif
                                        </ul>
                                        @endforeach
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group mrgn-bt-70 mrgn-tp-30">
                                        <a href="{{ route('courseclasses.courseclass.show',$classId.'#assignments') }}" class="btn btn-primary cancel-btn">@lang('classcourse.cancel')</a>
                                        <input type="submit" name="submit" value="@lang('classcourse.Add')" class="btn btn-primary add_btn" />
                                    </div>
                                </div>
                            @else
                                <div class="col-md-12">
                                    <p> @lang('classcourse.no_exam_available') </p>
                                </div>
                            @endif
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<!---End Content-->
@endsection

<?php /*Load jquery to footer section*/ ?>
@push('inc_script')

@endpush

<?php /*Load jquery to footer section*/ ?>
@push('inc_jquery')
    <script>
        $(document).ready(function() {

            @if(isset($myexams) || !empty($myexams))
                @foreach($myexams as $myexam)
                    $('.input_{{ $myexam->id }}').prop("disabled", true);
                    $('#Highcharts_{{ $myexam->id }}').click(function(){
                        if($(this).prop("checked") == true){
                            $('.input_{{ $myexam->id }}').prop("disabled", false);
                        }else{
                            $('.input_{{ $myexam->id }}').prop("disabled", true);
                        }
                    });

                    $(".input_{{ $myexam->id }}").each(function() {
                        var element = $(this);
                        if (element.val() == "") {
                            $(this).attr('required',true);
                        }
                        else{
                            $(this).attr('required',false);
                        }
                    });

                    $('#startDate_{{ $myexam->id }}').datetimepicker({
                        minDate:new Date().setHours(0,0,0,0),
                        format: 'DD-MM-YYYY LT',
                        /*maxDate: 'now'*/
                    });

                    $('#endDate_{{ $myexam->id }}').datetimepicker({
                        minDate:new Date().setHours(0,0,0,0),
                        format: 'DD-MM-YYYY LT',
                        useCurrent: false
                    });
                    $("#startDate_{{ $myexam->id }}").on("dp.change", function (e) {
                        $('#endDate_{{ $myexam->id }}').data("DateTimePicker").minDate(e.date);
                    });
                    $("#endDate_{{ $myexam->id }}").on("dp.change", function (e) {
                        $('#startDate_{{ $myexam->id }}').data("DateTimePicker").maxDate(e.date);
                    });


                @endforeach
            @endif
        });
        /*$('.fa').on('click', function(e){
            $('.list-unstyled li').toggleClass('in');
            e.preventDefault();
        });*/

    </script>

    <script>
        /* Validation */
        $("#exestingExam").validate({
            rules: {
                subject_type: {
                    required: true,
                },
                /*'startDate[]': {
                    required: true,
                },
                'endDate[]': {
                    required: true,
                },*/
            },
            /*messages: {
                subject_type:  "Please select at least one exam",
            },
            errorPlacement: function(error, element) {
                if(element.attr("name") == "subject_type"){
                    error.insertBefore($(element).parents('.error'));
                }
                else {
                    error.insertAfter(element);
                }
            },*/
        });
    </script>
@endpush