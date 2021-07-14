@push('inc_css')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
@endpush


<div class="all_editor_cls">
    <div class="row">
        <div class="col-sm-4">
            <h4 class="simple_editor">@lang('simple_editor.title')</h4>
        </div>
        <div class="col-sm-8 text-sm-right text-ar-left">
            {{-- <button type="button" class="btn btn-primary" id="priview_btn">Priview</button> --}}
            <a href="javascript:;" class="add_partner" id="add_parameter">@lang('simple_editor.add_parameter')</a>
            <a href="javascript:;" class="add_partner" id="remove_parameter" style="display:none;">@lang('simple_editor.remove_parameter')</a>
            {{-- <a href="#" class="conver_to_problem m3">@lang('simple_editor.conver_to_problem')</a> --}}
        </div>
    </div>
    <div class="question_edit mrgn-tp-20">
        <form class="def_form nw_cnvrsn_form" id="simple_editor_form" method="POST" action="{{ route('exercisesets.exerciseset.import',$exerciseset->id) }}" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="json_details"id="hidden_json_details" value =""/>
        <div class="row">
            <div class="col-md-7">
                <div class="accordion tp-accordian" id="main_nw_accordian" style="display:none;">
                    <div class="card">
                        <div class="card-header" id="headingnw">
                            <button class="btn_blue_line" type="button" data-toggle="collapse" data-target="#collapsenw" aria-expanded="true" aria-controls="collapsenw">
                                <span class="minus_cls"></span>
                                <span class="plus_cls">+</span>
                            </button>
                            <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#collapsenw" aria-expanded="true" aria-controls="collapsenw">@lang('simple_editor.parameters')</button>
                        </div>
                        <div id="collapsenw" class="collapse show" aria-labelledby="headingnw" data-parent="#main_nw_accordian">
                            <div class="card-body main-accordian-body">
                                <div class="inner_collps_body mrgn-bt-30">
                                    <ul id="param_ul_list">
                                        <li class="list_of_exersize" style="display:block;">
                                            <div class="form-group">
                                                <div class="row">
                                                    <div class="col-md-12 col-lg-12 col-xl-12">
                                                         <div class="pramtr_file" id="myassets_parameter_block">
                                                          <input type="hidden" class="form-control" name="parameter" data-name="" id="parameter_file" accept=".csv,text/csv">
                                                          <span class="custm_btn pera_1" id="pera_1" data-mode="create" data-option="perameter" data-mode="create" data-optionsection="1" data-type="csv" data-question_count="1" onclick="showAsset(this.id);" data-toggle="modal" data-target="#plugin_assets" aria-hidden="true">@lang('simple_editor.choose_file')</span>
                                                          <span id="perameter_1" class="filenme"></span>
                                                        </div>
                                                        <label for="parameter_file" generated="true" class="error"></label>

                                                        <div class="pramtr_file" id="brows_parameter_block">
                                                          <input type="file" class="form-control" name="parameter_brows" id="parameter_file_brows" accept=".csv,text/csv">
                                                          <span class="custm_btn" aria-hidden="true">@lang('simple_editor.brows_file')</span>
                                                          <span id="perameter_brows" class="filenme" aria-hidden="true"></span>
                                                        </div>                            
                                                         <label for="parameter_file_brows" id="pera_error" generated="true" class="error"></label>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="accordion tp-accordian" id="main_accordian">
                    <div class="card question-div">
                        <div class="card-header" id="headingOne">
                            <button class="btn_blue_line" type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                <span class="minus_cls"></span>
                                <span class="plus_cls">+</span>
                            </button>
                            <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">@lang('simple_editor.question')</button>
                        </div>
                        <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#main_accordian">
                            <div class="card-body main-accordian-body">
                                <div class="inner_collps_body mrgn-bt-30">
                                    <ul id="que_ul_list">
                                        <li class="list_of_exersize" id="que_li_1" data-quid="1">
                                            <div class="form-group">
                                                <div class="row">
                                                    <div class="col-md-5 col-lg-5 col-xl-3">
                                                        <div class="df-select">
                                                                
                                                            <select class="selectpicker question_1_section_1_type required" name="question[1][section_type]" id="que_section_type_1"  data-question_id="1" data-que_section_count="1" onchange="changeQueSectionType(this.id, this.value)">
                                                                {{-- <option value="">Section Type</option> --}}
                                                                @foreach($sectionType as $key => $type)
                                                                    <option value="{{$key}}">
                                                                        @if ($type == 'Text')
                                                                            @lang("simple_editor.text")
                                                                        @elseif ($type == 'Image')
                                                                            @lang("simple_editor.img")
                                                                        @elseif ($type == 'Video')
                                                                            @lang("simple_editor.video")
                                                                        @elseif ($type == 'Audio')
                                                                            @lang("simple_editor.audio")
                                                                        @elseif ($type == "Plugins")
                                                                            @lang("simple_editor.plugins")    
                                                                        @else 
                                                                            {{$type}}
                                                                        @endif
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                            
                                                            <select style="display:none" class="dflt_slctpckr" id="que_span_detail_1" data-mode="create"  data-part="question" data-question_id="1" data-que_section_count="1" onchange="changePluginType(this.id, this.value)">
                                                                <option value="">@lang('simple_editor.select_plugin')</option>
                                                                <option value="clock"> @lang('simple_editor.clock')</option>
                                                                <option value="chess"> @lang('simple_editor.chess')</option>
                                                                <option value="video"> @lang('simple_editor.video')</option>
                                                                <option value="audio" > @lang('simple_editor.audio')</option>
                                                                <option value="image" > @lang('simple_editor.image')</option>
                                                                <option value="table"> @lang('simple_editor.table')</option>
                                                                <option value="textbox"> @lang('simple_editor.textbox')</option>
                                                                <option value="flowchart">@lang('simple_editor.flowChart')</option>
                                                                <option value="math"> @lang('simple_editor.math')</option>
                                                                <option value='chart'>@lang('simple_editor.chart')</option>
                                                            </select>
                                                        </div>
                                                        <div class="questn_circl">
                                                        <span title="" style="cursor:pointer;display:none;" id="que_plugin_span_detail_1" onclick="showQuePluginList(1)">
                                                            <i class="fa fa-question-circle-o"></i>
                                                        </span>
                                                        </div> 
                                                    </div>
                                                    
                                                    <div class="col-md-7 col-lg-7 col-xl-9" id="que_section_type_div_1">
                                                        <textarea class="form-control question_1_section required"
                                                        {{-- check language of excercise --}}
                                                        @if ( $exerciseset->language_id ==3 ) style="direction:rtl" @endif
                                                        @if ( $exerciseset->language_id !=3 ) style="direction:ltr" @endif
                                                        data-quid="1"  name="question[1][description]" id="que_description_1" placeholder="@lang('simple_editor.description')"></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                            {{-- <button type="button" class="close_icon" id="que_clear_btn_1" data-quecount="1" onclick="deleteQueSection(this.id)"></button> --}}
                                        </li>
                                    </ul>
                                    <div class="add_section_cls text-right text-ar-left">
                                        <a href="javascript:;" class="add_section_btn" data-question_id="1" id="que_add_section_btn">+ @lang('simple_editor.add_section')</a>
                                    </div>
                                </div>
                                <div class="accordion accordi_inr_pdng as_line" id="subcategories_accordion">
                                    <div class="card-header" id="subheading_one">
                                        <button class="btn_blue_line" type="button" data-toggle="collapse" data-target="#collapse_sub1" aria-expanded="true" aria-controls="collapse_sub1">
                                            <span class="minus_cls"></span>
                                            <span class="plus_cls">+</span>
                                        </button>
                                        <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#collapse_sub1" aria-expanded="true" aria-controls="collapse_sub1">@lang('simple_editor.answers')</button>
                                    </div>
                                    <div id="collapse_sub1" class="show_line collapse show" aria-labelledby="subheading_one" data-parent="#subcategories_accordion">
                                        <div class="inner-collaps-content">
                                            <div id="ans_div">
                                                <div id="ans_option_1" class="question_1_answer_div" data-option_count="1">
                                                    <ul id="ans_option_1_ul_list">
                                                        <li class="list_of_exersize" id="ans_option_1_li_1">
                                                            <div class="form-group">
                                                                <div class="row">
                                                                    <div class="col-md-5 col-lg-5 col-xl-4 aaa">
                                                                        <div class="answer_pdng right_ans">
                                                                             <div class="text_wt_icon">
                                                                                <p class="name_answer correct_answer" id="ans_option_1_text">@lang('simple_editor.a')</p>
                                                                            </div>
                                                                            <div class="df-select">
                                                                                <select class="selectpicker question_1_answer_1_section_1_type required" name="answer[op_1][1][section_type]" id="ans_option_1_section_type_1" data-question_count="1" data-option_count="1" data-ans_section_count="1" data-ques_ans_section_count="1" onchange="changeAnsSectionType(this.id, this.value)">
                                                                                    {{-- <option value="">Section Type</option> --}}
                                                                                    @foreach($sectionType as $key => $type)
                                                                                    <option value="{{$key}}">
                                                                                            @if ($type == 'Text')
                                                                                                @lang("simple_editor.text")
                                                                                            @elseif ($type == 'Image')
                                                                                                @lang("simple_editor.img")
                                                                                            @elseif ($type == 'Video')
                                                                                                @lang("simple_editor.video")
                                                                                            @elseif ($type == 'Audio')
                                                                                                @lang("simple_editor.audio")
                                                                                            @elseif ($type == "Plugins")
                                                                                                @lang("simple_editor.plugins")    
                                                                                            @else 
                                                                                                {{$type}}
                                                                                            @endif
                                                                                        </option>
                                                                                    @endforeach
                                                                                </select>

                                                                                <select style="display:none" class="dflt_slctpckr" id="ans_1_span_detail_1" data-mode="create"  data-part="answer" data-answer_id="1" data-ans_section_count="1" onchange="changePluginType(this.id, this.value)">
                                                                                    <option value="">@lang('simple_editor.select_plugin')</option>
                                                                                    <option value="clock"> @lang('simple_editor.clock')</option>
                                                                                    <option value="chess"> @lang('simple_editor.chess')</option>
                                                                                    <option value="video"> @lang('simple_editor.video')</option>
                                                                                    <option value="audio" > @lang('simple_editor.audio')</option>
                                                                                    <option value="image" > @lang('simple_editor.image')</option>
                                                                                    <option value="table"> @lang('simple_editor.table')</option>
                                                                                    <option value="textbox"> @lang('simple_editor.textbox')</option>
                                                                                    <option value="flowchart">@lang('simple_editor.flowChart')</option>
                                                                                    <option value="math"> @lang('simple_editor.math')</option>
                                                                                    <option value='chart'>@lang('simple_editor.chart')</option>
                                                                                </select>
                                                                            </div>
                                                                            <div class="questn_circl">
                                                                                <span title="" style="cursor:pointer;display:none;" id="ans_plugin_1_span_detail_1" onclick="showQuePluginList(1)">
                                                                                    <i class="fa fa-question-circle-o"></i>
                                                                                </span>
                                                                            </div> 
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-7 col-lg-7 col-xl-8" id="ans_option_1_section_type_div_1">
                                                                        <textarea class="form-control question_1_answer_1_section lang-dir required" name="answer[op_1][1][description]" id="ans_option_1_description_1" data-option_count="1" data-ans_section_count="1" data-ques_ans_section_count="1" placeholder="@lang('simple_editor.description')"></textarea>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            {{-- <button type="button" class="close_icon"></button> --}}
                                                        </li>
                                                    </ul>
                                                    <div class="checkbox_action">
                                                        <div class="custom-control custom-checkbox wihtut_bg_ck float-left float_ar_right">
                                                            <input name="correct" value="1" id="is_correct_1" type="radio" class="custom-control-input question_1_answer_1_is_checked" checked data-option_count="1" onchange="selectCorrectAns(this.id)">
                                                            <label class="custom-control-label" for="is_correct_1">@lang('simple_editor.is_correct')</label>
                                                        </div>
                                                        <div class="add_section_cls float-right float_ar_left">
                                                            <a href="javascript:;" class="add_section_btn" id="ans_option_1_add_section_btn" data-option_count="1" data-question_count="1" data-section_count="1" onclick="addMoreAnsOptionSection(this.id)">+ @lang('simple_editor.add_section')</a>
                                                        </div>
                                                    </div>
                                                    <div class="clearfix"></div>
                                                </div>
                                            </div>
                                            <div class="add_section_cls mrgn-tp-40 mrgn-bt-30">
                                                <a href="javascript:;" class="add_section_btn" data-question_count="1" id="add_more_ans_btn">+ @lang('simple_editor.add_more_answers')</a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-header" id="subheading_Two">
                                        <button class="btn_blue_line" type="button" data-toggle="collapse" data-target="#collapse_sub2" aria-expanded="false" aria-controls="collapse_sub2">
                                            <span class="minus_cls"></span>
                                            <span class="plus_cls">+</span>
                                        </button>
                                        <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#collapse_sub2" aria-expanded="false" aria-controls="collapse_sub2">@lang('simple_editor.hint')</button>
                                    </div>
                                    <div id="collapse_sub2" class="collapse show" aria-labelledby="subheading_Two" data-parent="#subcategories_accordion">
                                        <div class="inner-collaps-content hint_cls">
                                            <div id="hint_div">
                                                <div id="hint_1" class="question_1_hint_div" data-option_count="1">
                                                    <ul id="hint_1_ul_list">
                                                        <li class="list_of_exersize pdng_70_lft " id="hint_1_li_1">
                                                            <div class="form-group">
                                                                <div class="row">
                                                                    <div class="col-md-5 col-lg-5 col-xl-4">
                                                                        <div class="answer_pdng right_ans">
                                                                            <div class="text_wt_icon">
                                                                                <p class="name_hint" id="hint_1_text">H1</p>
                                                                            </div>
                                                                            <div class="df-select">
                                                                                
                                                                                <select class="selectpicker question_1_hint_1_section_1_type" name="hint[1][1][section_type]" id="hint_1_section_type_1" data-hint_count="1" data-question_count="1" data-hint_section_count="1" onchange="changeHintSectionType(this.id, this.value)">
                                                                                    @foreach($sectionType as $key => $type)
                                                                                    <option value="{{$key}}">
                                                                                            @if ($type == 'Text')
                                                                                                @lang("simple_editor.text")
                                                                                            @elseif ($type == 'Image')
                                                                                                @lang("simple_editor.img")
                                                                                            @elseif ($type == 'Video')
                                                                                                @lang("simple_editor.video")
                                                                                            @elseif ($type == 'Audio')
                                                                                                @lang("simple_editor.audio")
                                                                                            @elseif ($type == "Plugins")
                                                                                                @lang("simple_editor.plugins")
                                                                                            @else 
                                                                                                {{$type}}
                                                                                            @endif
                                                                                        </option>
                                                                                    @endforeach
                                                                                </select>
                                                                            </div>

                                                                            <select  style="display:none" class="dflt_slctpckr" id="hint_1_span_detail_1" data-mode="create"  data-part="hint" data-hint_id="1" data-hint_section_count="1" onchange="changePluginType(this.id, this.value)">
                                                                                <option value="">@lang('simple_editor.select_plugin')</option>
                                                                                <option value="clock"> @lang('simple_editor.clock')</option>
                                                                                <option value="chess"> @lang('simple_editor.chess')</option>
                                                                                <option value="video"> @lang('simple_editor.video')</option>
                                                                                <option value="audio" > @lang('simple_editor.audio')</option>
                                                                                <option value="image" > @lang('simple_editor.image')</option>
                                                                                <option value="table"> @lang('simple_editor.table')</option>
                                                                                <option value="textbox"> @lang('simple_editor.textbox')</option>
                                                                                <option value="flowchart">@lang('simple_editor.flowChart')</option>
                                                                                <option value="math"> @lang('simple_editor.math')</option>
                                                                                <option value='chart'>@lang('simple_editor.chart')</option>
                                                                            </select>
                                                                            <div class="questn_circl">
                                                                                <span title="" style="cursor:pointer;display:none;" id="hint_plugin_1_span_detail_1" onclick="showQuePluginList(1)">
                                                                                        <i class="fa fa-question-circle-o"></i>
                                                                                </span>
                                                                            </div> 
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-7 col-lg-7 col-xl-8" id="hint_1_section_type_div_1">
                                                                        <textarea class="form-control lang-dir question_1_hint_1_section" name="hint[1][1][description]" id="hint_1_description_1" data-hint_count="1" data-question_count="1" data-hint_section_count="1" placeholder="@lang('simple_editor.description')"></textarea>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            {{-- <button type="button" class="close_icon" ></button> --}}
                                                        </li>
                                                    </ul>
                                                    <div class="add_section_cls text-right text-ar-left">
                                                        <a href="javascript:;" class="add_section_btn" id="hint_1_add_section_btn" data-question_count="1" data-hintcount="1" data-hint_section_count="1" onclick="addMoreHintSection(this.id)">+ @lang('simple_editor.add_section')</a>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="add_section_cls mrgn-tp-40 mrgn-bt-30">
                                                <a href="javascript:;" class="add_section_btn"  data-question_count="1" data-hint_section_count="1" id="add_more_hint_btn">+ @lang('simple_editor.add_more_hints')</a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-header" id="subheading_Three">
                                        <button class="btn_blue_line" type="button" data-toggle="collapse" data-target="#collapse_sub3" aria-expanded="false" aria-controls="collapse_sub3">
                                            <span class="minus_cls"></span>
                                            <span class="plus_cls">+</span>
                                        </button>
                                        <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#collapse_sub3" aria-expanded="false" aria-controls="collapse_sub3"> @lang('simple_editor.attributes')</button>
                                    </div>
                                    <div id="collapse_sub3" class="collapse" aria-labelledby="subheading_Three" data-parent="#subcategories_accordion">
                                        <div class="inner-collaps-content attribut_cls">
                                            <ul>
                                                <li class="list_of_exersize pdng_70_lft">
                                                    <ul class="prsn-action-rdio">
                                                        <li><label class="difclt-lbl">@lang('simple_editor.difficulty_level')</label></li>
                                                        <li>
                                                            <div class="rdio rdio-primary">
                                                                <input type="radio" name="difficultylevel" value="easy" id="Easy" checked="checked">
                                                                <label for="Easy">@lang('simple_editor.easy')</label>
                                                            </div>
                                                        </li>
                                                        <li>
                                                            <div class="rdio rdio-primary">
                                                                <input type="radio" name="difficultylevel" value="medium" id="Medium" >
                                                                <label for="Medium">@lang('simple_editor.medium')</label>
                                                            </div>
                                                        </li>
                                                        <li>
                                                            <div class="rdio rdio-primary">
                                                                <input type="radio" name="difficultylevel" value="hard"  id="Hard" >
                                                                <label for="Hard">@lang('simple_editor.hard')</label>
                                                            </div>
                                                        </li>
                                                    </ul>
                                                </li>
                                                <li class="list_of_exersize pdng_70_lft">
                                                    <div class="range_slider">
                                                    <div class="row">
                                                        {{-- <div class="col-md-5 col-lg-5 col-xl-4">
                                                            <label>@lang('simple_editor.avg_time_to_answer')</label>
                                                        </div> --}}
                                                        {{-- <div id="ranged-value" class="rng_sldr" ></div> --}}
                                                        <div class="col-md-6 range_input">
                                                            <label>@lang('simple_editor.min_time')</label>
                                                            <input type="text" class="form-control" id="min_time" name="min_time" value="0" >
                                                        </div>
                                                        <div class="col-md-6 range_input">
                                                            <label>@lang('simple_editor.max_time')</label>
                                                            <input type="text" class="form-control" id="max_time" name="max_time" value="60" >
                                                        </div>
                                                    </div>
                                                    </div>
                                                </li>
                                                <li class="list_of_exersize pdng_70_lft">
                                                    <div class="form-group">
                                                        <input type="text" class="form-control" name="tags" id="tags" placeholder="@lang('simple_editor.tag')">
                                                    </div>
                                                </li>
                                                <li class="list_of_exersize pdng_70_lft"></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            {{-- New script for question --}}

            <div class="col-md-5" style="margin-top: 0px;">
                    <div class="priew_section " id="sidebar">
                        <div class="heading_priew">
                            <h4>@lang('simple_editor.preview')</h4>
                        </div>
                        <div class="priew_body lang-dir ">
                             {{-- With Render Js --}}
                             <div id="csv-div" class="csv-div hide">
                                
                                <pre>
                                <code>
                                <table class="csv-table">
                                    <tbody class="csv-table-body" id="csv_pre_tbl_body" >
                                                                                        
                                    </tbody>
                                </table>
                                </code>
                                </pre>
                            </div>
                            <div id="question_preview">
                            
                            </div>
                            <div class="clearfix"></div>
                        </div>
                    </div>
            </div>
     
        @php
            if (isset($exerciseset->language['language']))  {
                $lang = $exerciseset->language['language'];
            } else {
                $lang = "English";
            }
        @endphp
        
        <script id="question_preview_template" type="text/html">
            @{{#.}}
            @{{#Questions}}
            <div class="question_ans @if($lang == "Arabic") ar_question_ans @endif">
                <div id="csv-div" class="csv-div hide">
                    <p>@lang("simple_editor.preview")</p>
                    <pre>
                    <code>
                    <table class="csv-table">
                        <tbody class="csv-table-body" id="csv_pre_tbl_body" >
                                                                            
                        </tbody>
                    </table>
                    </code>
                    </pre>
                </div>
                <p>@lang("simple_editor.question")</p>
                <div class="lang-dir">
                    @{{#Question_Description.Sections}}
                    <div class="text-new-line" >@{{& Value}}</div>
                    @{{/Question_Description.Sections}}
                </div>
                <div id="preview_ans_option_div">
                    <ul class="optn_list">
                        @{{#Answers.Choices}}
                        <li> @{{#Attributes}}
                                @{{#IsCorrect}}
                                <div class="coorect_prvew"></div>
                                @{{/IsCorrect}}
                             @{{/Attributes}} 
                           <div class="lang-dir">     
                                @{{#Sections}}
                                <div class="nw_p">@{{& Value}}</div>
                                @{{/Sections}} 
                            </div>
                        </li>
                        @{{/Answers.Choices}}
                    </ul>
                </div>
            </div>
            <div class="hint_sec @if($lang == "Arabic") ar_hint_sec @endif">
                <h4 id="preview_hint_title" style="display:;">@lang("simple_editor.hint")</h4>
                <div id="preview_hint_div">
                    <ul>
                        @{{#Hints.HintList}}
                        <li class="">
                                <div class="lang-dir">     
                                    @{{#Sections}}
                                        <div class="nw_p">@{{& Value}}</div>
                                    @{{/Sections}} 
                                </div>
                        </li>
                        @{{/Hints.HintList}}
                        <div class="clearfix"></div>
                    </ul>
                </div>
            </div>
        @{{/Questions}}
        @{{/.}}
    </script>
            <div class="col-md-12 mrgn-tp-30 mrgn-bt-20">
                <button type="button" class="btn btn-primary cancel-btn cncle-prfct" id="cancel_que_btn">@lang('simple_editor.cancel')</button>
                <input type="submit" class="btn btn-primary add_btn add-prfct" value="@lang('simple_editor.save_create_new')">
                {{-- <button type="button" data-toggle="modal" data-target="#create_exersis" data-dismiss="modal" class="btn btn-primary add_btn add-prfct">Submit</button> --}}
            </div>
        </div>
        </form>
    </div>
</div>



<?php /*Load jquery to footer section*/ ?>
@push('inc_script')

@endpush

<?php /*Load jquery to footer section*/ ?>
@push('inc_jquery')
{{-- //inclued pug in js --}}
@include('authenticated.includes.render_script')
<script type="text/javascript" src="{{ asset('assets/eduplaycloud/customs/js/pages/private-library/simple-editor.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/eduplaycloud/customs/js/pages/private-library/custom-question-json.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/plugin.js') }}"></script>

<script>



// $.getScript("{{ asset('assets/eduplaycloud/customs/js/pages/private-library/simple-editor.js') }}");
var sectionArr = <?php echo json_encode($sectionType); ?>;

// --------------------------------------------------------------------------
//Onchage in csv priview


//-----------CSV-----------------

function csvFileRender(){
    $(document).ready(function() {
        $.ajax({
            type: "GET",
            url: $('#parameter_file').val(),
            dataType: "text",
            success: function(data) {processData(data);}
        });
    });  
}

$(document).ready(function() {
      

// The event listener for the file upload
document.getElementById('parameter_file_brows').addEventListener('change', upload, false);

// The Drop event listener for the file upload.
document.getElementById('parameter_file_brows').addEventListener('drop', upload, false);

// Method that checks that the browser supports the HTML5 File API
        function browserSupportFileUpload() {
        var isCompatible = false;
        if (window.File && window.FileReader && window.FileList && window.Blob) {
            isCompatible = true;
        }
            return isCompatible;
        }

// Method that reads and processes the selected file
  function upload(evt) {
    if (!browserSupportFileUpload()) {
        alert('The File APIs are not fully supported in this browser!');
        } else {
                        //Check file uploading size.
                        var csvMaxSize = {{ env('MY_ASSETS_CSV_SIZE', 120000) }};
                        
                        $('#parameter_file').removeClass('required');

                        if(this.files[0].size > csvMaxSize ){
                            $('#parameter_file_brows').empty();
                            $('#pera_error').empty();
                            $('#pera_error').append(this.files[0].name + " of csv @lang('myassest.file_size_more_than')" + (csvMaxSize / 1000) + "KB");
                        } else {

                            $("#perameter_brows").text(this.files[0].name);
                            var data = null;
                            var file = evt.target.files[0];

                            var extension = file.name.replace(/^.*\./, '');
                            // console.log(extension)
                            if(extension === 'csv'){
                                    var reader = new FileReader();
                                    reader.readAsText(file);
                                    reader.onload = function(event) {
                                            $('#csv-div').show();

                                            var csvData = event.target.result;

                                            processData(csvData);
                                    };
                                    reader.onerror = function() {
                                            alert('Unable to read ' + file.fileName);
                                    };
                            } else {
                                    swal("@lang('simple_editor.cancelled')", "@lang('simple_editor.select_only_csv_file')", "error");
                                    $('#parameter_file').val('');
                                    $("#csv_pre_tbl_body").empty();
                            }
                        }


        }
    }
});

function processData(csvData) {
        var data = null;

        $('#csv-div').show();

        var csvArray = csvData.split("\n");
        var formattedString = [];
        //This is for Replace parameter value.
        var csvRows = [];
        var csvHeaderString = [];
        var csvRowsValue = [];

        for(i=0;i < csvArray.length;i++){
            formattedString.push('<tr><td>' + csvArray[i].split(",").join("</td><td>") + '</td></tr>');
            
            csvRows.push(csvArray[i].split(","));

            if(i == 0){
                csvHeaderString = csvArray[i].split(",");
            } else {
                var splitCell = csvArray[i].split(",");
                //Skip blank cell in row.
                if(jQuery.inArray("",splitCell) !== 0){
                    csvRowsValue.push(csvArray[i]);
                }
            }
        }

        //CSV preview in append rows.
        $("#csv_pre_tbl_body").empty();
        for(i=0;i <= 5;i++){    
            $("#csv_pre_tbl_body").append(formattedString[i]); 
        }
            //This is for Replace parameter value.
            var randKey = Math.floor(Math.random()*csvRowsValue.length);
            if(randKey === -1){
                randKey = 0
            }
            var item = csvRowsValue[randKey];
            var splitItem = item.split(","); 

            for (i = 0; i < csvHeaderString.length; ++i)
            {
                // var outString = csvHeaderString[i].replace(/[`' '~!@#%^&*()_|+\-=?;:'",.<>\{\}\[\]\\\/]/gi, '').toLowerCase();
                var outString = csvHeaderString[i].trim();
                finalcsvArray[outString] = splitItem[i];
            }
        // console.log(finalcsvArray);
  
}


// $(document).ready(function() {

// // The event listener for the file upload
// document.getElementById('parameter_file').addEventListener('change', upload, false);

// // The Drop event listener for the file upload.
// document.getElementById('parameter_file').addEventListener('drop', upload, false);

// // Method that checks that the browser supports the HTML5 File API
//         function browserSupportFileUpload() {
//         var isCompatible = false;
//         if (window.File && window.FileReader && window.FileList && window.Blob) {
//             isCompatible = true;
//         }
//             return isCompatible;
//         }

// // Method that reads and processes the selected file
// function upload() {


//         //     var data = null;
//         //     var file = $('#parameter_file').val();

//         //     var reader = new FileReader();
            
//         //     reader.readAsText(file);
//         //     reader.onload = function(event) {
//         //     $('#csv-div').show();
            
//         //     console.log(reader);

//         //     var csvData = event.target.result;  

//         //     var csvArray = csvData.split("\n");
//         //     var formattedString = [];
//         //     //This is for Replace parameter value.
//         //     var csvRows = [];
//         //     var csvHeaderString = [];
//         //     var csvRowsValue = [];

//         //     for(i=0;i < csvArray.length;i++){
//         //         formattedString.push('<tr><td>' + csvArray[i].split(",").join("</td><td>") + '</td></tr>');
                
//         //         csvRows.push(csvArray[i].split(","));
//         //         if(i == 0){
//         //             csvHeaderString = csvArray[i].split(",");
//         //         } else {
//         //             csvRowsValue.push(csvArray[i]);
//         //         }
//         //     }

//         //     //CSV preview in append rows.
//         //     $("#csv_pre_tbl_body").empty();
//         //     for(i=0;i <= 5;i++){    
//         //         $("#csv_pre_tbl_body").append(formattedString[i]); 
//         //     }
//         //         //This is for Replace parameter value.
//         //         var randKey = Math.floor(Math.random()*csvRowsValue.length);
//         //         if(randKey === -1){
//         //             randKey = 0
//         //         }
//         //         var item = csvRowsValue[randKey];
//         //         var splitItem = item.split(","); 

//         //         for (i = 0; i < csvHeaderString.length; ++i)
//         //         {
//         //             // var outString = csvHeaderString[i].replace(/[`' '~!@#%^&*()_|+\-=?;:'",.<>\{\}\[\]\\\/]/gi, '').toLowerCase();
//         //             var outString = csvHeaderString[i].trim();
//         //             finalcsvArray[outString] = splitItem[i];
//         //         }
//         //     // console.log(finalcsvArray);
//         // };
//         // reader.onerror = function() {
//         //     alert('Unable to read ' + file.fileName);
//         // };
//     }
// });


///------------------------------

// For Validation & Submit Form
$(document).ready(function() {
    $("#min_time").on('keyup',function() {
        
        var min = $("#min_time").val();
        var max = $('#max_time').val();

        if (min <= max) {
            $('#max_time').removeClass("error");
            $('#max_time').addClass("valid");
            $('label[for="max_time"]').text('');
        }
    });

    $("#max_time").on('keyup',function() {
        
        var min = $("#min_time").val();
        var max = $('#max_time').val();

        if (max >= min) {
            $('#min_time').removeClass("error");
            $('#min_time').addClass("valid");
            $('label[for="min_time"]').text('');
        }
    });


    $("#simple_editor_form").validate({
        ignore: "",
        rules: {
            min_time: {
                required: true,
                max: function () {
                    
                    return parseInt($('#max_time').val());
                }
            },
            max_time: {
                required: true,
                min: function () {
                    
                    return parseInt($('#min_time').val());
                }
            }
        },
        submitHandler: function(form) {
            form.submit();
        }
    });

    $("#parameter_file").change(function(){
        $("#perameter_1").text(this.files[0].name);
    });
});

// For Create QuestionPreview
function createQuePreview()
{

}
//
$(document).ready(function(){
    $(window).scroll(function () {
        if($(window).scrollTop() > 260) {
            $('#sidebar').addClass('fixed');
            $('#sidebar').css('top','80px');
        }

        else if ($(window).scrollTop() <= 260) {
            $('#sidebar').removeClass('fixed');
            $('#sidebar').css('top','');
        }
        if ($('#sidebar').offset().top + $("#sidebar").height() > $("footer").offset().top) {
            $('#sidebar').css('top',-($("#sidebar").offset().top + $("#sidebar").height() - $("footer").offset().top));
        }
    });
});

</script>
@endpush