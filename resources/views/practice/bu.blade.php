@extends('authenticated.layouts.default')
@section('content')

<style>
    body { 
        margin:0;
        padding:0;
        font-family: 'Raleway', sans-serif;
    }
    .key-value-item
    {
        padding: 0;
        text-align: center;
        border-left:2px solid #eee;
        
    }
    .key-value-item:first-child
    {
        border-left:2px solid transparent;
        
    }
    .key-value-item h3 
    {
        font-size: 13px;
        text-transform: uppercase;
        margin: 0;
        padding: 0;
    }
    .key-value-item span 
    {
        font-size: 25px;
        color :#ff9028 ;
    }
    .key-value-item .button-container 
    {
        display: flex;
        align-items: center;
        justify-content: center;
        height: 100%;
}
    }
    .clock-container .clock_wrapper {
        top: inherit;
        left: inherit;

    }
    .practice-header{
        border-bottom: 1px solid #eee;
        padding: 10px;
    }
    .practice-header-title { 
        display: flex;
        align-items: center;
        justify-content: center;
        height: 100%;
    }

    .exam-pagination{ 
        list-style: none;
        padding: 0;
        margin:20px;
    }
    .exam-pagination li {
        display: inline-block;
    }
    .exam-pagination li button { 
        display: block;
        padding: 5px 20px;
        background-color : #eee;
        border: 0;
        color : #777;
        cursor: pointer;
        border-radius: 5px;
        outline: 0 !important;
        box-shadow: 0 !important;
        transition: all 0.2s ease 0s;
    }
    .exam-pagination li button:focus { 
        background-color : #ccc;
    }
    .exam-pagination li button:hover { 
        background-color : #ccc;
    }
    .exam-pagination li button:disabled { 
        background-color: #00b2f0;
        color : #fff;
        cursor: default;
    }
    button.navigation-btn { 
        display: block;
        padding: 5px 20px;
        border: 0;
        cursor: pointer;
        border-radius: 5px;
        outline: 0 !important;
        box-shadow: 0 !important;
        transition: all 0.2s ease 0s;
        background-color: #00b2f0;
        color : #fff;
        max-width: 100%;
    }
</style>

<div class="container full-width">
    {{-- Header --}}
    <div class="row practice-header">
        <div class="col-md-3 col-xs-5 col-sm-5">
            <a class="navbar-brand" href="{{route('exercisesets.exerciseset.private')}}">
                <img src="{{ asset('assets/eduplaycloud/image/logo.svg') }}" alt="" class="logo">
            </a>
        </div>
        <div class="col-md-3 col-xs-5 col-sm-5">
            <h3>
                @if($practice_type == 'exerciseset')
                    {{ $exerciseset->title }}
                @elseif($practice_type == 'assignment')
                    {{ $exam->title }}
                @elseif($practice_type == 'disciplines_no_curriculum')
                    {{ $topic_name }}
                @else 
                    {{ $skill_categories->skill_category_name }}
                @endif
            </h3>
        </div>
        <div class="col-md-6 col-xs-12 col-sm-12">
            <div class="row">
                <div class="col-2 key-value-item clock-container">
                    <div id="clock_wrapper" class="clock_wrapper" >
                        <canvas id="clock" width="60" height="60" class="clock1"></canvas>
                        <div id="timer"></div>
                    </div>
                </div>
                <div class="col-2 key-value-item">
                    <h3>Concutive</h3>
                    <span id='consecutive_ans_count'>0</span>
                </div>
                <div class="col-2 key-value-item">
                    <h3>Correct</h3>
                    <span id='right_ans_count'>0/{{$questionCount}}</span>
                </div>
                <div class="col-3 key-value-item">
                    <h3>Minutes</h3>
                    <span id='countdown'>00:00</span>
                </div>
                <div class="col-3 key-value-item">
                    <div class="button-container">
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Message --}}
    <div class="row">
        <div class="col-12">
            <div  id="message">
                                     
            </div>
        </div>
    </div>

    {{-- Question --}}
    <div class="row">
        <div class="col-12">

        </div>
    </div>

</div>
<!---Content-->
                    @if($practice_type == 'exerciseset')
                        <input type="hidden" id="exercise_id" value="{{$exerciseset->id}}">
                        <input type="hidden" id="topic_id" value="{{$exerciseset->topics->id}}">
                    @elseif($practice_type == 'assignment')
                        <input type="hidden" id="exercise_id" value="">
                        <input type="hidden" id="topic_id" value="">
                    @elseif($practice_type == 'disciplines_no_curriculum')
                        <input type="hidden" id="exercise_id" value="">
                        <input type="hidden" id="topic_id" value="">
                    @else 
                        <form id="exercise_form" action="{{route('topics.exercisesets.skill')}}" method="GET">
                                <li class="breadcrumb-item skill-name"><a href="#">{{$skill_categories->discipline->discipline_name}}</a></li>
                                @csrf
                                <input type='hidden' name='exercises' value='{{$exerciseid}}'>
                        </form>                        
                        <input type="hidden" id="exercise_id" value="">
                        <input type="hidden" id="topic_id" value="">
                    @endif
                
                @if($questionCount > 0)
                                                
                                            
                                        </li>
                                        <li class="col-2" >
                                            <h3></h3>
                                            <p>@lang('practice.consecutive_right_answers')</p>
                                        </li>
                                        <li class="col-2" >
                                            <h3></h3>
                                            <p>@lang('practice.right_answers')</p>
                                        </li>
                                        <li class="col-2" >
                                            <h3 id='countdown'>00:00</h3>
                                            <p>@lang('practice.minutes')</p>
                                        </li>
                                        <li  class="col-2 vertical-centered" style="padding-left: 15px;" >
                        <button type="button" class="navigation-btn next-btn finsh-btn" id="finish_button">@lang('practice.finish')</button>
                                            
                                        </li>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <hr>
                                </div>
                            </div>
                            <div class="row">
                                
                                <div class="col-xl-9 sp_lp_parent bbbb">
                                    <h6 class="sm_title">@lang('practice.practice')</h6>
                                    <div class="practice_bx">
                                        <div id="preview"></div>

                                        <script src="{{ asset('assets/eduplaycloud/customs/js/editor-playground/app-js/plugins-Render-Client.js') }}"></script>
                                        <script id="sample_template" type="text/html">
                                            @{{#.}}
                                            @{{#Questions}}
                                            <div class="clock_time hide" id="clock_time">@{{& Attributes.MaxTime}}</div>
                                            <div class="tmr_p">
                                                <div class="row">
                                                @{{#Question_Description.Sections}}
                                                    <div class="col-md-12">@{{& Value}}</div>
                                                @{{/Question_Description.Sections}}
                                                </div>
                                            </div>
                                            <ul class="optn_list" id="parent">
                                                @{{#Answers.Choices}}
                                                <li>
                                                    @{{# Attributes}}
                                                        <input type="radio" name="ans_rdo" value="@{{& id}}" id="ans_@{{& id}}" class="answer_option" data-question-id="@{{& question_id}}">
                                                    @{{/ Attributes}}
                                                    <label for="ans_@{{& id}}"><span></span>
                                                        @{{#Sections}}
                                                        
                                                            @{{& Value}}
                                                        @{{/Sections}}
                                                    </label>
                                                </li>
                                                @{{/Answers.Choices}}                                                
                                            </ul>
                                        <p class="hint_p">
                                            @lang('practice.not_sure_about_the_ans') <a href="#" data-toggle="collapse" data-target="#collapseHint" aria-expanded="false" aria-controls="collapseHint">@lang('practice.hint')</a>
                                        </p>
                                        <div class="collapse hint_clps" id="collapseHint">
                                            <div class="card card-body">
                                                <div class="hint-card">
                                                    <div class="row">
                                                        <div class="col-md-7">
                                                            <div class="rltv_hint">
                                                                <div class="">
                                                                <h5>@lang('practice.hint')</h5>
                                                                    <ul>
                                                                        @{{#Hints.HintList}}
                                                                        <li class="hint" id="hint_li_@{{& index}}" >
                                                                                
                                                                                <div class="lang-dir">     
                                                                                    @{{#Sections}}
                                                                                        <div class="nw_p">@{{& Value}}</div>
                                                                                    @{{/Sections}} 
                                                                                </div>
                                                                        </li>
                                                                        @{{/Hints.HintList}}
                                                                        <a href="javascript:;" id="view_more_link" class="view_more_btn">View More</a>
                                                                        <a href="javascript:;" id="view_less_link" class="view_more_btn" style="display:none;">View Less</a>
                                                                        <div class="clearfix"></div>
                                                                    </ul>
                                                                    </div>
                                                            </div>
                                                        </div>
                                                    <div class="col-md-5"><img src="{{ asset('assets/eduplaycloud/image/hint_img.png') }}" align="" class="img-fluid"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        @{{/Questions}}
                                        @{{/.}} 
                                        </script>
                                        <script src="https://cdnjs.cloudflare.com/ajax/libs/mustache.js/3.0.1/mustache.min.js"></script>

                                        <a href="javascript:void(0);" class="rprt_prblm_btn" data-toggle="modal" data-target="#Report_A_Problem" data-dismiss="modal">@lang('practice.report_a_problem')</a>
                                        @include('practice.report_a_problem')
                                        <input type="hidden" id="hidden_que_id" />
                                        
                                        <div class="clearfix"></div>
                                    </div>
                                    
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <div class="form-group mrgn-bt-70 mrgn-tp-30">
                                        <!--get quesiton index by this hidden field--->
                                        <input type="hidden" id="question_index" value="0">
                                        <style>
                                            
                                        </style>

                                        <hr>


                                        <ul class="exam-pagination">
                                            @if (isset($IsExam))
                                                @foreach (Session()->get('jsonQuesions') as $key => $question)
                                                <li>
                                                    <button type="button" @if( $key == 0) disabled='disabled' @endif  question-index="{{ $key }}" class="assignment-pagination-btn" >{{ $key + 1 }}</button>
                                                </li>
                                                @endforeach
                                            @endif
                                            <li>
                                                <button type="button" id="next_button" class=" navigation-btn next-btn">@lang('practice.next') </button>
                                            </li>
                                        </ul>
                                        <form id="finishForm">
                                            <input type="hidden" name="totalQuestion" id="totalQuestion" value="{{$questionCount}}">
                                            <input type="hidden" name="totalMinutes" id="totalMinutes">
                                            <input type="hidden" id="spen_time" value="">
                                            <input type="hidden" name="exerciseid" id="exerciseid" value="{{ $exerciseid }}">
                                            <input type="hidden" name="rightanscount" id="rightanscount" value="0"/>
                                            <input type="hidden" name="exerciseset_url" id="exerciseset_url" value="{{$exerciseset_url}}"/>
                                                                                            <input type="hidden" name="practice_token" id="practice_token" value="{{str_random()}}">
                                            <meta name="csrf-token" content="{{ csrf_token() }}" />
                                        </form>                                            
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                @else 
                    <div class="panel-body ">
                        <p>@lang('practice.no_questions_available')</p>
                    </div>

                @endif
                </div>
            </div>
        </div>
    </div>
    </div>
</div>
<!---End Content-->
@endsection

@push('inc_script')
@include('authenticated.includes.pugin-footer')
<script type="text/javascript" src="{{ asset('assets/eduplaycloud/customs/js/jquery-validate/jquery.validate.min.js') }}"></script>
<script src="{{ asset('assets/eduplaycloud/customs/js/questions-answare.js') }}"></script>
<script src="{{ asset('assets/eduplaycloud/customs/js/finish-practice.js') }}"></script>
<!-- rendering the template -->
<script type='text/javascript'>
    
  
    
    $(document).ready(function(){
        setTimeout(function(){
            hideAllMorehint();
        },500);
    });

    //Hide all more hint.
    function hideAllMorehint(){
        hint = $('.hint').length;
        if(hint > 1) {
            $('.hint').each(function(hint,val){
                if(val.id != 'hint_li_1'){
                    $('#'+val.id).hide();
                }
            });
        } else {
            $('#view_more_link').hide();
        }
    }

   
    //More hint show.
    $(document).on('click','#view_more_link',function(){
        hintCount += 1
        if(hintCount <= hint){
            $('#hint_li_'+hintCount).slideDown();
        }

        if(hintCount == hint){
            $('#view_more_link').hide();
        }

    });


    function renderToHtml_E(Q) 
    {
        var template = document.getElementById('sample_template').innerHTML;
        var output = Mustache.render(template, Q);
        
        return output;
    }


    //Bradcumps in click on skill categories name and redirect to that page.
      $(document).on('click','.skill-name',function(){
        $('#exercise_form').submit();
    });

    $('.rprt_prblm_btn').on('click',function() {
        $('#description').val('');
        $('#message').html('');
    });


</script>
@endpush


