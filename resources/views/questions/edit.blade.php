@extends('authenticated.layouts.default')

@section('header_styles')
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<style>
 .text-new-line {white-space: pre-wrap;}
</style>
@endsection

@section('content')
@push('inc_jquery')
{{-- //inclued pug in js --}}

  

@endpush
@push('inc_css')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
@endpush
<div class="work_page mrgn_top_secn mrgn-bt-60 exercesi_block text-ar-right">
    <div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-12">
            <div class="pdng_60_lft">
                <nav aria-label="tp-breadcm" class="tp-breadcm">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{route('exercisesets.exerciseset.private')}}">@lang('exerciseset_show.my_private_exercise')</a></li>
                        <li class="breadcrumb-item active" aria-current="page">{{ $exerciseset->title }}</li>
                    </ol>
                </nav>
                @if(Session::has('success_message'))
                    <div class="alert alert-success">
                        <i class="fa fa-check-square-o" aria-hidden="true"></i>
                        {!! session('success_message') !!}
                        <button type="button" class="close" data-dismiss="alert" aria-label="close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    {{--<br />--}}
                @endif
                 @if(Session::has('unexpected_error'))
                    <div class="alert alert-success">
                        <i class="fa fa-check-square-o" aria-hidden="true"></i>
                        {!! session('unexpected_error') !!}
                        <button type="button" class="close" data-dismiss="alert" aria-label="close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    {{--<br />--}}
                @endif
                <div class="simple_ed_cls mrgn-tp-10 mrgn-bt-5">
                    <ul class="tabs_menu nav nav-pills mb-3 mrgn_tbs_less" id="pills-tab" role="tablist">
                        <li class="nav-item">
                        <a class="nav-link " id="summary-tab"  href="{{ route('exercisesets.exerciseset.show',array($question->exercise_id,'1#summary')) }}" aria-selected="true">@lang('exerciseset_show.summary')</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="detail-tab" href="{{ route('exercisesets.exerciseset.show',array($question->exercise_id,'1#detail')) }}" aria-selected="false">@lang('exerciseset_show.details')</a>
                        </li>
                        {{-- <li class="nav-item">
                            <a class="nav-link " id="simple_editor-tab" data-toggle="pill" href="#simple_editor" role="tab" aria-controls="simple_editor" aria-selected="false">@lang('exerciseset_show.simple_editor')</a>
                        </li> --}}
                        <li class="nav-item" style="display:block;">
                            <a class="nav-link active" id="edit_simple_editor-tab" data-toggle="pill" href="#edit_simple_editor" role="tab" aria-controls="edit_simple_editor" aria-selected="false">@lang('exerciseset_show.simple_editor')</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link " id="myAssest-tab" href="{{ route('myassets')}}">@lang('exerciseset_show.my_assets')</a>
                        </li>
                        {{--  Not In Scope  --}}
                        {{--  <li class="nav-item">
                            <a class="nav-link" id="advance_editor-tab" data-toggle="pill" href="#advance_editor" role="tab" aria-controls="advance_editor" aria-selected="false">@lang('exerciseset_show.advance_editor')</a>
                        </li>  --}}
                    </ul>
                    <div class="tp_tab_cntnt tab-content bbbb" id="pills-tabContent">
                        
                        
                        <div class="tab-pane fade show active simple_editor" id="edit_simple_editor" role="tabpanel" aria-labelledby="edit_simple_editor-tab">
                            <div id="">
                                <style>
    
                                    img{width: 100%;}
                                    </style>
                                    
                                <div class="all_editor_cls">
                                    <div class="row">
                                        <div class="col-sm-4">
                                            <h4 class="simple_editor">@lang('simple_editor.edit_simple_editor')</h4>
                                        </div>
                                        <div class="col-sm-8 text-sm-right text-ar-left">
                                            {{-- <button type="button" class="btn btn-primary j_gnrt" id="j_gnrt">JSON Generate</button> --}}
                                            {{-- <button type="button" class="btn btn-primary" id="edit_priview_btn">Priview</button> --}}
                                            <a href="javascript:;" class="add_partner" id="edit_add_parameter">@lang('simple_editor.add_parameter')</a>
                                            <a href="javascript:;" class="add_partner" id="edit_remove_parameter" style="display:none;">@lang('simple_editor.remove_parameter')</a>
                                            <a href="#edit_" class="conver_to_problem m3">@lang('simple_editor.conver_to_problem')</a>
                                        </div>
                                    </div>
                                    <div class="question_edit mrgn-tp-20">
                                        <form class="def_form nw_cnvrsn_form" id="edit_simple_editor_form" method="POST" action="{{route('questions.question.update_question',optional($question)->id)}}" enctype="multipart/form-data">
                                        @csrf
                                        
                                        <input type="hidden" value="{{ $question->exercise_id }}" name="hidden_exercise_id"/>
                                        <div class="row">
                                            @php 
                                                $json = json_decode($question->json_details); 
                                                $url = asset("assets/eduplaycloud/upload/exercisesset/user-".\Auth::user()->id);
                                                $optionName = range('A', 'Z');
                                            @endphp
                                            <input name="json_details_hidden" id="edit_hidden_json_details" value="{{ $question->json_details }}"  type="hidden"/>
                                            {{-- <input name="json_details_hidden" id="edit_hidden_json_details" value="{{ $question->paramRenderQuestion() }}"  type="hidden"/> --}}
                                            @foreach($json->Questions as $qkey => $item)
                                            <div class="col-md-7">
                                                <div class="accordion tp-accordian" id="edit_main_nw_accordian" style="display:none;">
                                                    <div class="card">
                                                        <div class="card-header" id="edit_headingnw">
                                                            <button class="btn_blue_line" type="button" data-toggle="collapse" data-target="#edit_collapsenw" aria-expanded="true" aria-controls="collapsenw">
                                                                <span class="minus_cls"></span>
                                                                <span class="plus_cls">+</span>
                                                            </button>
                                                            <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#edit_collapsenw" aria-expanded="true" aria-controls="collapsenw">@lang('simple_editor.parameters')</button>
                                                        </div>
                                                        <div id="edit_collapsenw" class="collapse show" aria-labelledby="edit_headingnw" data-parent="#edit_main_nw_accordian">
                                                            <div class="card-body main-accordian-body">
                                                                <div class="inner_collps_body mrgn-bt-30">
                                                                    <ul id="edit_param_ul_list">
                                                                        <li class="list_of_exersize" style="display:block;">
                                                                            <div class="form-group">
                                                                                <div class="row">
                                                                                    @foreach ($json->Parameters as $pmkey => $param)
                                                                                    <div class="col-md-12 col-lg-12 col-xl-12" id="edit_myassets_parameter_block">
                                                                                        <div class="pramtr_file">                                                          
                                                                                            @if (isset($param->value->filepath) && $param->value->filepath != "" )
                                                                                                    @php   
                                                                                                    $path = $param->value->filepath . "?version=" . time();
                                                                                                    @endphp
                                                                                            @else 
                                                                                            @php
                                                                                                    $path = "";
                                                                                                    @endphp
                                                                                            @endif
                                                                                            <input type="hidden" name="parameter" data-name="{{ $param->value->filename }}" id="edit_parameter_file" value="{{ $path  }}" accept="text/csv">
                                                                                            {{-- <input type="hidden" name="parameter_file_path" id="parameter_file_path" value="{{ $path }}">
                                                                                            <input type="hidden" class="form-control" name="parameter_file_remove" value="{{ $param->value->filename }}"> --}}
                                                                                            <span class="custm_btn pera_1" id="pera_1" data-mode="edit" data-option="perameter"
                                                                                                data-optionsection="1" data-type="csv" data-question_count="1" onclick="showAsset(this.id);"
                                                                                                data-toggle="modal" data-target="#plugin_assets">@lang('simple_editor.choose_file')</span>

                                                                                            <span id="edit_param_1" class="filenme" aria-hidden="true">{{$param->value->filename}}</span>
                                                                                        </div>
                                                                                        <a href="{{ $path }}" id="csv-download-btn" class="btn btn-sm btn-info dwnld-icn-cia" title="@lang('simple_editor.download_csv_file')"></a>
                                                                                        <label for="edit_parameter_file" generated="true" class="error"></label>
                                                                                    </div>
                                                                                    <div class="col-md-12 col-lg-12 col-xl-12" id="parameter_brows_section">
                                                                                      <div class="pramtr_file">
                                                                                        <input type="file" class="form-control" name="parameter_brows" id="edit_parameter_file_brows" accept=".csv,text/csv">
                                                                                        <span class="custm_btn" id="brows_pera_span" aria-hidden="true">@lang('simple_editor.brows_file')</span>
                                                                                        <span id="edit_perameter_brows" class="filenme" aria-hidden="true"></span>
                                                                                      </div>                            
                                                                                      <label for="edit_parameter_file_brows" id="edit_pera_error" generated="true" class="error"></label>
                                                                                    </div>
                                                                                    @endforeach
                                                                                </div>
                                                                            </div>
                                                                        </li>
                                                                    </ul>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="accordion tp-accordian" id="edit_main_accordian">
                                                    <div class="card edit-question-div">
                                                        <div class="card-header" id="edit_headingOne">
                                                            <button class="btn_blue_line" type="button" data-toggle="collapse" data-target="#edit_collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                                                <span class="minus_cls"></span>
                                                                <span class="plus_cls">+</span>
                                                            </button>
                                                            <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#edit_collapseOne" aria-expanded="true" aria-controls="collapseOne">@lang('simple_editor.question')</button>
                                                        </div>
                                                        <div id="edit_collapseOne" class="collapse show" aria-labelledby="edit_headingOne" data-parent="#edit_main_accordian">
                                                            <div class="card-body main-accordian-body">
                                                                @if($item->Question_Description)
                                                                <div class="inner_collps_body mrgn-bt-30">
                                                                    <ul id="edit_que_ul_list">
                                                                        @foreach($item->Question_Description->Sections as $qskey => $qsection)
                                                                            <li class="list_of_exersize" id="edit_que_li_{{$qskey+1}}" data-quecount="{{$qskey+1}}">
                                                                                <div class="form-group">
                                                                                    <div class="row">
                                                                                        <div class="col-md-5 col-lg-5 col-xl-3">
                                                                                            <div class="df-select">
                                                                                                <select class="selectpicker edit_question_1_section_{{$qskey+1}}_type" name="question[{{$qskey+1}}][section_type]" data-question_id="{{$qkey+1}}" id="edit_que_section_type_{{$qskey+1}}" data-que_section_count="{{$qskey+1}}" onchange="changeQueSectionType(this.id, this.value)">
                                                                                                    
                                                                                                    <option value="text"  @if($qsection->SectionType == 'text') selected @endif> @lang('simple_editor.text')</option>
                                                                                                    <option value="image" @if($qsection->SectionType == 'Plugin' && !isset($qsection->Attributes->sectiontype)  && $qsection->Plugin == 'image') selected @endif>@lang('simple_editor.img')</option>
                                                                                                    <option value="video" @if($qsection->SectionType == 'Plugin' && !isset($qsection->Attributes->sectiontype)  && $qsection->Plugin == 'video') selected @endif> @lang('simple_editor.video')</option>
                                                                                                    <option value='audio' @if($qsection->SectionType == 'Plugin' && !isset($qsection->Attributes->sectiontype)  && $qsection->Plugin == 'audio') selected @endif>@lang('simple_editor.audio')</option>
                                                                                                    <option value="plugin" @if($qsection->SectionType == 'Plugin' && isset($qsection->Attributes->sectiontype)  && $qsection->Attributes->sectiontype == 'plugin') selected @endif >@lang('simple_editor.plugins')</option>
                                                                                                    {{-- @foreach($sectionType as $key => $type)
                                                                                                        <option value="{{$key}}" @if(isset($qsection->Attributes->sectiontype) &&  $qsection->Attributes->sectiontype == $key) selected @endif>
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
                                                                                                    @endforeach --}}
                                                                                                </select>
                                                                                                
                                                                                            </div>
                                                                                                @php
                                                                                                    $dis = "none";
                                                                                                @endphp
                                                                                                @if(isset($qsection->Attributes->sectiontype) &&  $qsection->Attributes->sectiontype == 'plugin' && isset($qsection->Plugin))
                                                                                                    @php
                                                                                                        $dis = "block";
                                                                                                    @endphp
                                                                                                    <select style="display:{{$dis}};" class="dflt_slctpckr" id="edit_que_span_detail_{{$qskey+1}}"  data-mode='edit' data-part="question" data-question_id="1" data-que_section_count="{{$qskey+1}}" onchange="changePluginType(this.id, this.value)">
                                                                                                        <option value="">@lang('simple_editor.select_plugin')</option>
                                                                                                        <option value="clock" {{ $qsection->Plugin  == 'clock' ? 'selected' : '' }}> @lang('simple_editor.clock')</option>
                                                                                                        <option value="chess" {{ $qsection->Plugin  == 'chess' ? 'selected' : '' }}> @lang('simple_editor.chess')</option>
                                                                                                        <option value="video" {{ $qsection->Plugin  == 'video' ? 'selected' : '' }}> @lang('simple_editor.video')</option>
                                                                                                        <option value="audio" {{ $qsection->Plugin  == 'audio' ? 'selected' : '' }} > @lang('simple_editor.audio')</option>
                                                                                                        <option value="image" {{ $qsection->Plugin  == 'image' ? 'selected' : '' }} > @lang('simple_editor.image')</option>
                                                                                                        <option value="table" {{ $qsection->Plugin  == 'table' ? 'selected' : '' }}> @lang('simple_editor.table')</option>
                                                                                                        <option value="textbox" {{ $qsection->Plugin  == 'textBox' ? 'selected' : '' }}> @lang('simple_editor.textbox')</option>
                                                                                                        <option value="flowchart" {{ $qsection->Plugin  == 'flow' ? 'selected' : '' }}>@lang('simple_editor.flowChart')</option>
                                                                                                        <option value="math" {{ $qsection->Plugin  == 'math' ? 'selected' : '' }}> @lang('simple_editor.math')</option>
                                                                                                        <option value="chart" {{ $qsection->Plugin  == 'chart' ? 'selected' : '' }}>@lang('simple_editor.chart')</option>
                                                                                                    </select>
                                                                                                    @if(isset($qsection->Attributes->sectiontype) && $qsection->Plugin == 'audio')
                                                                                                        <a href="javaScript:void(0);" class="replce-vlue audio_edit_que_span_detail_{{$qskey+1}}" id="audio_edit_que_span_detail_{{$qskey+1}}" data-mode='edit' data-option="question" data-optionsection="" data-type="audio" data-question_count="{{$qskey+1}}" onclick="showAsset(this.id);" data-toggle="modal" data-target="#plugin_assets">@lang('simple_editor.choose_audio')</a>
                                                                                                    @endif
                                                                                                    @if(isset($qsection->Attributes->sectiontype) && $qsection->Plugin == 'image')
                                                                                                        <a href="javaScript:void(0);" class="replce-vlue image_edit_que_span_detail_{{$qskey+1}}" id="image_edit_que_span_detail_{{$qskey+1}}" data-mode='edit' data-option="question" data-optionsection="" data-type="image" data-question_count="{{$qskey+1}}" onclick="showAsset(this.id);" data-toggle="modal" data-target="#plugin_assets">@lang('simple_editor.choose_image')</a>
                                                                                                    @endif
                                                                                                    <div class="questn_circl">
                                                                                                        <span onclick="showQuePluginList(1)" title="" style="cursor:pointer;display:{{$dis}};" id="edit_que_plugin_span_detail_{{$qskey+1}}">
                                                                                                            <i class="fa fa-question-circle-o"></i>
                                                                                                        </span>
                                                                                                    </div>
                                                                                                @else
                                                                                                    <select style="display:none;" class="dflt_slctpckr" id="edit_que_span_detail_{{$qskey+1}}" data-mode="edit"  data-part="question" data-question_id="1" data-que_section_count="{{$qskey+1}}" onchange="changePluginType(this.id, this.value)" class="dflt_slctpckr">
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
                                                                                                        <span onclick="showQuePluginList(1)" title="" style="cursor:pointer;display:none;" id="edit_que_plugin_span_detail_{{$qskey+1}}">
                                                                                                            <i class="fa fa-question-circle-o"></i>
                                                                                                        </span>
                                                                                                    </div> 
                                                                                                @endif
                                                                                        </div>
                                                                                        <div class="col-md-7 col-lg-7 col-xl-9" id="edit_que_section_type_div_{{$qskey+1}}">
                                                                                            @if(strtolower($qsection->SectionType) == 'text')
                                                                                                <textarea class="form-control lang-dir edit_question_{{$qkey+1}}_section required " name="question[{{$qskey+1}}][description]" data-quid="{{$qskey+1}}" id="edit_que_description_{{$qskey+1}}" placeholder="@lang('simple_editor.description')">{{$qsection->Value}}</textarea>
                                                                                            @else
                                                                                                @if($qsection->SectionType == "Plugin")
                                                                                                    @if(!isset($qsection->Attributes->sectiontype) &&  $qsection->Plugin == 'image')
                                                                                                        {{-- Normal Image --}}
                                                                                                        @php
                                                                                                            $qimageExp = 'src:';
                                                                                                            $queImageCaption = explode($qimageExp, $qsection->Value);
                                                                                                            
                                                                                                            if(count($queImageCaption) > 1){
                                                                                                                $qusname = pathinfo($queImageCaption[1],PATHINFO_FILENAME);
                                                                                                                $qusext = pathinfo($queImageCaption[1],PATHINFO_EXTENSION);
                                                                                                                
                                                                                                                $questionimageFile = $qusname.'.'. $qusext;
                                                                                                            } else {
                                                                                                                $questionimageFile = '';
                                                                                                            }

                                                                                                        @endphp
                                                                                                        <div class="pramtr_file">
                                                                                                            <input type="hidden" class="form-control " name="question[{{$qskey+1}}][imagename]" data-quid="{{$qskey+1}}" id="edit_que_description_{{$qskey+1}}" accept="image/*" placeholder="Upload Image" value="{{isset($qsection->Value) && $qsection->Value != '' ? $qsection->Value : ''}}">

                                                                                                            <input type="hidden" class="form-control edit_question_{{$qkey+1}}_section" data-quid="{{$qskey+1}}" name="question[{{$qskey+1}}][image]" id="que_image_{{$qskey+1}}" accept="image/*" data-sectionvalue="{{$qsection->Value}}" data-sectioncaption="{{$questionimageFile}}">

                                                                                                            <span class="custm_btn image_edit_que_span_detail_{{$qskey+1}}" id="ques_choose_image_{{$qskey+1}}" data-mode='edit' data-option="question" data-optionsection="" data-type="image" data-question_count="{{$qskey+1}}" onclick="showAsset(this.id);" data-toggle="modal" data-target="#plugin_assets" aria-hidden="true" >@lang('simple_editor.choose_image')</span>
                                                                                                            <span class="filenme" id="filename_{{$qskey+1}}" aria-hidden="true">{{$questionimageFile}}</span>
                                                                                                        </div>
                                                                                                        <label for="que_image_{{$qskey+1}}" generated="true" class="error"></label>

                                                                                                        @if(isset($qsection->Value) && $qsection->Value != '')
                                                                                                            <a href="{{$url}}/image/{{ $questionimageFile }}" class="btn btn-sm btn-info dwnld-icn-cia que_image_{{$qskey+1}}"  title="@lang('simple_editor.image_download')"  target="_blank" download></a>
                                                                                                        @endif
                                                                                                    @elseif(!isset($qsection->Attributes->sectiontype) && $qsection->Plugin == 'video')

                                                                                                        {{-- Normal Video --}}    
                                                                                                        <textarea class="form-control lang-dir edit_question_{{$qkey+1}}_section required videourl" data-quid="{{$qskey+1}}" name="question[{{$qskey+1}}][video]" id="que_video_{{$qskey+1}}" placeholder="Paste embed link here. To generate embed link,1. Open video in youtube 2. Click on share and select embed 3. Copy src link and paste here" onpaste="getQueVideoPreview(this.id)" onkeyup="getQueVideoPreview(this.id)" onchange="getQueVideoPreview(this.id)">{{$qsection->Value}}</textarea>
                                                                                                        <label for="que_video_{{$qskey+1}}" generated="true" class="error"></label>
                                                                                                    @elseif(!isset($qsection->Attributes->sectiontype) && $qsection->Plugin == 'audio')
                                                                                                        {{-- Normal Audio --}}
                                                                                                        @php
                                                                                                            $qusaudioimageUrl = explode("src:",$qsection->Value);
                                                                                                            
                                                                                                            if(count($qusaudioimageUrl) > 1){
                                                                                                                $qusaudioname = pathinfo($qusaudioimageUrl[1],PATHINFO_FILENAME);
                                                                                                                $qusaudioext = pathinfo($qusaudioimageUrl[1],PATHINFO_EXTENSION);

                                                                                                                $qusaudiofile = $qusaudioname.'.'. $qusaudioext;
                                                                                                            } else {
                                                                                                                $qusaudiofile = '';
                                                                                                            }
                                                                                                        @endphp
                                                                                                        <div class="pramtr_file">
                                                                                                            <input type="hidden" class="form-control" name="question[{{$qskey+1}}][audioname]" id="edit_audio_que_description_{{$qskey+1}}" value="{{isset($qsection->Value) && $qsection->Value != '' ? $qsection->Value : ''}}">
                                                                                                            <input type="hidden" class="form-control edit_question_{{$qkey+1}}_section " name="question[{{$qskey+1}}][audio]" id="que_audio_{{$qskey+1}}" data-quid="{{$qskey+1}}"  data-sectionvalue="{{$qsection->Value}}" data-sectioncaption="{{$qusaudiofile}}"> 
                                                                                                            <span class="custm_btn  audio_edit_que_span_detail_{{$qskey+1}}" id="audio_{{$qskey+1}}" data-mode='edit' data-option="question" data-optionsection="" data-type="audio" data-question_count="{{$qskey+1}}" onclick="showAsset(this.id);" data-toggle="modal" data-target="#plugin_assets" aria-hidden="true">@lang('simple_editor.choose_audio')</span>
                                                                                                            <span class="filenme" id="audio_filename_{{$qskey+1}}" aria-hidden="true">{{$qusaudiofile}}</span>
                                                                                                        </div>
                                                                                                        <label for="que_audio_{{$qskey+1}}" generated="true" class="error"></label>
                                                                                                        @if(isset($qsection->Value) && $qsection->Value != '')
                                                                                                        <a href="{{$url}}/audio/{{ $qusaudiofile }}" class="btn btn-sm btn-info dwnld-icn-cia  que_image_{{$qskey+1}}" title="@lang('simple_editor.audio_download')"  target="_blank" download></a>
                                                                                                        @endif
                                                                                                    @else
                                                                                                       {{-- Plugin --}}     
                                                                                                       <textarea class="form-control lang-dir edit_question_{{$qkey+1}}_section required " name="question[{{$qskey+1}}][description]" data-quid="{{$qskey+1}}" id="edit_que_description_{{$qskey+1}}" placeholder="@lang('simple_editor.description')">@if(isset($qsection->Attributes->sectionvalue)) {{$qsection->Attributes->sectionvalue}} @else {{ $qsection->Value }}@endif</textarea>
                                                                                                       @if(isset($qsection->Plugin) && $qsection->Plugin == 'image')
                                                                                                            @if(isset($qsection->Value) && $qsection->Value != '')
                                                                                                                @php 
                                                                                                                    $imageUrl = explode("src:",$qsection->Value)
                                                                                                                @endphp
                                                                                                                <a href="{{$imageUrl[1]}} " class="btn btn-sm btn-info dwnld-icn-cia" title="@lang('simple_editor.image_download')"  target="_blank" download></a>
                                                                                                            @endif    
                                                                                                        @elseif(isset($qsection->Plugin) && $qsection->Plugin == 'audio')
                                                                                                            @if(isset($qsection->Value) && $qsection->Value != '')
                                                                                                                @php 
                                                                                                                    $audioUrl = explode("src:",$qsection->Value)
                                                                                                                @endphp
                                                                                                                    <a href="{{$audioUrl[1]}} " class="btn btn-sm btn-info dwnld-icn-cia" title="@lang('simple_editor.audio_download')"  target="_blank" download></a>
                                                                                                            @endif
                                                                                                        @endif
                                                                                                    @endif    
                                                                                                @endif
                                                                                            @endif  
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                @if(!$loop->first)
                                                                                <button type="button" class="close_icon" id="que_clear_btn_{{$qskey+1}}" data-quecount="{{$qskey+1}}" onclick="deleteQueSection(this.id)"></button>
                                                                                @endif
                                                                                {{-- <button type="button" class="close_icon" id="edit_que_clear_btn_1" data-quecount="1" onclick="deleteQueSection(this.id)"></button> --}}
                                                                            </li>
                                                                        @endforeach
                                                                    </ul>
                                                                    <div class="add_section_cls text-right text-ar-left">
                                                                        <a href="javascript:;" class="add_section_btn" data-question_id="{{$qkey+1}}" id="edit_que_add_section_btn" onclick="addQueSection(this.id)">+ @lang('simple_editor.add_section')</a>
                                                                    </div>
                                                                </div>
                                                                @endif
                                                                <div class="accordion accordi_inr_pdng as_line" id="edit_subcategories_accordion">
                                                                    <div class="card-header" id="edit_subheading_one">
                                                                        <button class="btn_blue_line" type="button" data-toggle="collapse" data-target="#edit_collapse_sub1" aria-expanded="true" aria-controls="collapse_sub1">
                                                                            <span class="minus_cls"></span>
                                                                            <span class="plus_cls">+</span>
                                                                        </button>
                                                                        <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#edit_collapse_sub1" aria-expanded="true" aria-controls="collapse_sub1">@lang('simple_editor.answers')</button>
                                                                    </div>
                                                                    <div id="edit_collapse_sub1" class="show_line collapse show" aria-labelledby="edit_subheading_one" data-parent="#edit_subcategories_accordion">
                                                                        <div class="inner-collaps-content">
                                                                            <div id="edit_ans_div">
                                                                                @if($item->Answers->Choices)
                                                                                @foreach($item->Answers->Choices as $akey => $ans)
                                                                                <div class="ans_option edit_question_{{ $qkey+1}}_answer_div" id="edit_ans_option_{{$akey+1}}" data-anscount="{{$akey+1}}" data-option_count="{{$akey+1}}">
                                                                                    <ul id="edit_ans_option_{{$akey+1}}_ul_list">
                                                                                        @foreach ($ans->Sections as $skey => $asection)
                                                                                        <li class="list_of_exersize" id="edit_ans_option_{{$akey+1}}_li_{{$skey+1}}" data-ans_sec_count="{{$skey+1}}">
                                                                                            <div class="form-group">
                                                                                                <div class="row">
                                                                                                    <div class="col-md-5 col-lg-5 col-xl-4">
                                                                                                        <div class="answer_pdng rmv_btn_cls right_ans">
                                                                                                            @if (!$loop->parent->first && $loop->first)
                                                                                                            <button type="button" class="close_icon" id="edit_ans_option_clear_btn_{{$akey+1}}" data-option_count="{{$akey+1}}" onclick="deleteAnsOption(this.id)"></button>
                                                                                                            @endif
                                                                                                            <div class="text_wt_icon">
                                                                                                                @if($loop->first)
                                                                                                                <p class="name_answer @if($ans->Attributes->IsCorrect) correct_answer @endif" id="edit_ans_option_{{$akey+1}}_text">{{$optionName[$akey]}}</p>
                                                                                                                <input type="hidden"  id="ans_edit_question_{{$qkey+1}}_answer_{{$akey+1}}_section_{{$skey+1}}_type" value="@if(isset($asection->id)) {{ $asection->id }} @endif"/>
                                                                                                                @endif
                                                                                                            </div>
                                                                                                            <div class="df-select">
                                                                                                                <select id="edit_ans_option_{{$akey+1}}_section_type_{{$skey+1}}" class="selectpicker edit_question_{{$qkey+1}}_answer_{{$akey+1}}_section_{{$skey+1}}_type" name="answer[op_{{$akey+1}}][{{$skey+1}}][section_type]" id="edit_ans_option_{{$akey+1}}_section_type_{{$skey+1}}" data-option_count="{{$akey+1}}" data-question_count="{{$qkey+1}}" data-ans_section_count="{{$skey+1}}" data-ques_ans_section_count="{{$skey+1}}" onchange="changeAnsSectionType(this.id, this.value)">
                                                                                                                        <option value="text"  @if($asection->SectionType == 'text') selected @endif> @lang('simple_editor.text')</option>
                                                                                                                        <option value="image" @if($asection->SectionType == 'Plugin' && !isset($asection->Attributes->sectiontype)  && $asection->Plugin == 'image') selected @endif>@lang('simple_editor.img')</option>
                                                                                                                        <option value="video" @if($asection->SectionType == 'Plugin' && !isset($asection->Attributes->sectiontype)  && $asection->Plugin == 'video') selected @endif> @lang('simple_editor.video')</option>
                                                                                                                        <option value='audio' @if($asection->SectionType == 'Plugin' && !isset($asection->Attributes->sectiontype)  && $asection->Plugin == 'audio') selected @endif>@lang('simple_editor.audio')</option>
                                                                                                                        <option value="plugin" @if($asection->SectionType == 'Plugin' && isset($asection->Attributes->sectiontype)  && $asection->Attributes->sectiontype == 'plugin') selected @endif >@lang('simple_editor.plugins')</option>
                             
                                                                                                                    
                                                                                                                    {{-- @foreach($sectionType as $key => $type) --}}
                                                                                                                        {{-- <option value="{{$key}}" @if(isset($asection->Attributes->sectiontype) &&  $asection->Attributes->sectiontype == $key) selected @endif >@if ($type == 'Text')
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
                                                                                                                        @endif</option> --}}
                                                                                                                    {{-- @endforeach --}}
                                                                                                                </select>
                                                                                                            </div>
                                                                                                                @php
                                                                                                                    $dis = "none";
                                                                                                                @endphp
                                                                                                                @if(isset($asection->Attributes->sectiontype) &&  $asection->Attributes->sectiontype == 'plugin' && isset($asection->Plugin))
                                                                                                                    @php
                                                                                                                        $dis = "block";
                                                                                                                    @endphp
                                                                                                                    <select style="display:{{$dis}};" class="dflt_slctpckr" id="edit_ans_{{$akey+1}}_span_detail_{{$skey+1}}" data-mode="edit"  data-part="answer" data-answer_id="{{$akey+1}}" data-ans_section_count="{{$skey+1}}" onchange="changePluginType(this.id, this.value)">
                                                                                                                        <option value="clock" {{ $asection->Plugin  == 'clock' ? 'selected' : '' }}> @lang('simple_editor.clock')</option>
                                                                                                                        <option value="chess" {{ $asection->Plugin  == 'chess' ? 'selected' : '' }}> @lang('simple_editor.chess')</option>
                                                                                                                        <option value="video" {{ $asection->Plugin  == 'video' ? 'selected' : '' }}> @lang('simple_editor.video')</option>
                                                                                                                        <option value="audio" {{ $asection->Plugin  == 'audio' ? 'selected' : '' }} > @lang('simple_editor.audio')</option>
                                                                                                                        <option value="image" {{ $asection->Plugin  == 'image' ? 'selected' : '' }} > @lang('simple_editor.image')</option>
                                                                                                                        <option value="table" {{ $asection->Plugin  == 'table' ? 'selected' : '' }}> @lang('simple_editor.table')</option>
                                                                                                                        <option value="textbox" {{ $asection->Plugin  == 'textBox' ? 'selected' : '' }}> @lang('simple_editor.textbox')</option>
                                                                                                                        <option value="flowchart" {{ $asection->Plugin  == 'flow' ? 'selected' : '' }}>@lang('simple_editor.flowChart')</option>
                                                                                                                        <option value="math" {{ $asection->Plugin  == 'math' ? 'selected' : '' }}> @lang('simple_editor.math')</option>
                                                                                                                        <option value="chart" {{ $asection->Plugin  == 'chart' ? 'selected' : '' }}>@lang('simple_editor.chart')</option>
                                                                                                                    </select>

                                                                                                                    @if(isset($asection->Attributes->sectiontype) && $asection->Plugin == 'audio')
                                                                                                                        <a href="javaScript:void(0);" class="replce-vlue audio_edit_ans_{{$akey+1}}_span_detail_{{$skey+1}}" id="audio_edit_ans_{{$akey+1}}_span_detail_{{$skey+1}}" data-mode='edit' data-option="answer" data-optionsection="{{$skey+1}}" data-type="audio" data-question_count="{{$akey+1}}" onclick="showAsset(this.id);" data-toggle="modal" data-target="#plugin_assets">@lang('simple_editor.choose_audio')</a>
                                                                                                                    @endif
                                                                                                                    @if(isset($asection->Attributes->sectiontype) && $asection->Plugin == 'image')
                                                                                                                        <a href="javaScript:void(0);" class="replce-vlue image_edit_ans_{{$akey+1}}_span_detail_{{$skey+1}}" id="image_edit_ans_{{$akey+1}}_span_detail_{{$skey+1}}" data-mode='edit' data-option="answer" data-optionsection="{{$skey+1}}" data-type="image" data-question_count="{{$akey+1}}" onclick="showAsset(this.id);" data-toggle="modal" data-target="#plugin_assets">@lang('simple_editor.choose_image')</a>
                                                                                                                    @endif
                                                                                                                    <div class="questn_circl">
                                                                                                                        <span onclick="showQuePluginList(1)" title="" style="cursor:pointer;display:{{$dis}};" id="edit_ans_plugin_{{$akey+1}}_span_detail_{{$skey+1}}">
                                                                                                                            <i class="fa fa-question-circle-o"></i>
                                                                                                                        </span>
                                                                                                                    </div>
                                                                                                                @else 

                                                                                                                <select style="display:none;" class="dflt_slctpckr" id="edit_ans_{{$akey+1}}_span_detail_{{$skey+1}}" data-mode="edit"  data-part="answer" data-answer_id="{{$akey+1}}" data-ans_section_count="{{$skey+1}}" onchange="changePluginType(this.id, this.value)">
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
                                                                                                                    <span onclick="showQuePluginList(1)" title="" style="cursor:pointer;display:none;" id="edit_ans_plugin_{{$akey+1}}_span_detail_{{$skey+1}}">
                                                                                                                        <i class="fa fa-question-circle-o"></i>
                                                                                                                    </span>
                                                                                                                </div>
                                                                                                                @endif

                                                                                                        </div>
                                                                                                    </div>
                                                                                                <div class="col-md-7 col-lg-7 col-xl-8" id="edit_ans_option_{{$akey+1}}_section_type_div_{{$skey+1}}">
                                                                                                        @if(strtolower($asection->SectionType) == 'text')
                                                                                                            <textarea class="form-control lang-dir edit_question_{{$qkey+1}}_answer_{{$akey+1}}_section required " name="answer[op_{{$akey+1}}][{{$skey+1}}][description]" id="edit_ans_option_{{$akey+1}}_description_{{$skey+1}}" data-option_count="{{$akey+1}}" data-question_count="{{$qkey+1}}" data-ans_section_count="{{$skey+1}}" data-ques_ans_section_count="{{$skey+1}}" placeholder="@lang('simple_editor.description')">{{$asection->Value}}</textarea>
                                                                                                        @else
                                                                                                            @if($asection->SectionType == "Plugin")
                                                                                                                @if(!isset($asection->Attributes->sectiontype) && $asection->Plugin == 'image')
                                                                                                                    @php 
                                                                                                                        $ansimageUrl = explode("src:",$asection->Value);
                                                                                                                        
                                                                                                                        if(count($ansimageUrl) > 1){
                                                                                                                            $ansimgname = pathinfo($ansimageUrl[1],PATHINFO_FILENAME);
                                                                                                                            $ansimgext = pathinfo($ansimageUrl[1],PATHINFO_EXTENSION);

                                                                                                                            $ansimageFile = $ansimgname.'.'. $ansimgext;
                                                                                                                        } else {
                                                                                                                            $ansimageFile = '';
                                                                                                                        }

                                                                                                                    @endphp
                                                                                                                    <div class="pramtr_file">
                                                                                                                        <input type="hidden" class="form-control" name="answer[op_{{$akey+1}}][{{$skey+1}}][imagename]" accept="image/*" placeholder="Upload Image" value="{{isset($asection->Value) && $asection->Value != '' ? $asection->Value : ''}}">
                                                                                                                        <input type="hidden" class="prmtr_sn form-control edit_question_1_answer_{{$akey+1}}_section" name="answer[op_{{$akey+1}}][{{$skey+1}}][image]" id="edit_ans_option_{{$akey+1}}_image_{{$skey+1}}" data-option_count="{{$akey+1}}" data-question_count="{{$qkey+1}}" data-ans_section_count="{{$skey+1}}" data-ques_ans_section_count="{{$skey+1}}" data-sectionvalue="{{$asection->Value}}" data-sectioncaption="@if(isset($ansimageFile)){{$ansimageFile}}@endif">
                                                                                                                        <span class="custm_btn image_edit_que_span_detail_{{$akey+1}}" id="ans_choose_{{$akey+1}}_image_{{$skey+1}}" data-mode='edit' data-option="answer" data-optionsection="{{$skey+1}}" data-type="image" data-question_count="{{$akey+1}}" onclick="showAsset(this.id);" data-toggle="modal" data-target="#plugin_assets" aria-hidden="true">@lang('simple_editor.choose_image')</span>
                                                                                                                        <span class="filenme" id="ans_filename_{{$akey+1}}_image_{{$skey+1}}" aria-hidden="true">{{$ansimageFile}}</span>
                                                                                                                    </div>
                                                                                                                    <label for="ans_option_{{$akey+1}}_image_{{$skey+1}}" generated="true" class="error"></label>
                                                                                                                 
                                                                                                                    <a href="{{$url}}/image/{{ $ansimageFile }}" class="btn btn-sm btn-info dwnld-icn-cia edit_ans_option_{{$akey+1}}_image_{{$skey+1}}" title="@lang('simple_editor.image_download')" target="_blank" download></a>

                                                                                                                @elseif(!isset($asection->Attributes->sectiontype) && $asection->Plugin == 'video')
                                                                                                                    <textarea class="form-control lang-dir edit_question_1_answer_{{$akey+1}}_section required videourl" name="answer[op_{{$akey+1}}][{{$skey+1}}][video]" id="edit_ans_option_{{$akey+1}}_video_{{$skey+1}}" placeholder="Paste embed link here. To generate embed link,1. Open video in youtube 2. Click on share and select embed 3. Copy src link and paste here" onpaste="getAnsVideoPreview(this.id)" data-option_count="{{$akey+1}}" data-question_count="{{$qkey+1}}" data-ans_section_count="{{$skey+1}}" data-ques_ans_section_count="{{$skey+1}}" onkeyup="getAnsVideoPreview(this.id)" onchange="getAnsVideoPreview(this.id)">{{$asection->Value}}</textarea>
                                                                                                                    <label for="ans_option_{{$akey+1}}_video_{{$skey+1}}" generated="true" class="error"></label>
                                                                                                                @elseif(!isset($asection->Attributes->sectiontype) && $asection->Plugin == 'audio')
                                                                                                                    @php
                                                                                                                        $ansaudioimageUrl = explode("src:",$asection->Value);
                                                                                                                        if(count($ansaudioimageUrl) > 1){
                                                                                                                            $ansaudioname = pathinfo($ansaudioimageUrl[1],PATHINFO_FILENAME);
                                                                                                                            $ansaudioext = pathinfo($ansaudioimageUrl[1],PATHINFO_EXTENSION);
                
                                                                                                                            $ansaudiofile = $ansaudioname.'.'. $ansaudioext;
                                                                                                                        } else {
                                                                                                                            $ansaudiofile = '';
                                                                                                                        }
                                                                                                                    @endphp

                                                                                                                    <div class="pramtr_file">
                                                                                                                    <input type="hidden" class="form-control" name="answer[op_{{$akey+1}}][{{$skey+1}}][audioname]" accept="image/*" placeholder="Upload Image" value="{{isset($asection->Value) && $asection->Value != '' ? $asection->Value : ''}}">
                                                                                                                    <input type="hidden" class="form-control edit_question_1_answer_{{$akey+1}}_section" name="answer[op_{{$akey+1}}][{{$skey+1}}][audio]" id="edit_ans_option_{{$akey+1}}_audio_{{$skey+1}}" accept="audio/*" placeholder="Upload Audio" data-option_count="{{$akey+1}}" data-question_count="{{$qkey+1}}" data-ans_section_count="{{$skey+1}}" data-ques_ans_section_count="{{$skey+1}}" data-sectionvalue="{{$asection->Value}}" data-sectioncaption="@if(isset($ansaudiofile)){{$ansaudiofile}}@endif">
                                                                                                                    <span class="custm_btn audio_edit_que_span_detail_{{$akey+1}}" id="ans_choose_{{$akey+1}}_audio_{{$skey+1}}" data-mode='edit' data-option="answer" data-optionsection="{{$skey+1}}" data-type="audio" data-question_count="{{$akey+1}}" onclick="showAsset(this.id);" data-toggle="modal" data-target="#plugin_assets" aria-hidden="true">@lang('simple_editor.choose_audio')</span>
                                                                                                                    <span class="filenme" id="ans_filename_{{$akey+1}}_audio_{{$skey+1}}" aria-hidden="true">{{$ansaudiofile}}</span>
                                                                                                                    </div><label for="ans_option_{{$akey+1}}_audio_{{$skey+1}}" generated="true" class="error"></label>
                                                                                                                    @if(isset($asection->Value) && $asection->Value != '')
                                                                                                                        <a href="{{$url}}/audio/{{ $ansaudiofile }}" class="btn btn-sm btn-info dwnld-icn-cia edit_ans_option_{{$akey+1}}_audio_{{$skey+1}}" title="@lang('simple_editor.audio_download')"  target="_blank" download></a>
                                                                                                                    @endif
                                                                                                                @else
                                                                                                                    <textarea class="form-control lang-dir edit_question_1_answer_{{$akey+1}}_section required " name="answer[op_{{$akey+1}}][{{$skey+1}}][description]" id="edit_ans_option_{{$akey+1}}_description_{{$skey+1}}" data-option_count="{{$akey+1}}" data-question_count="{{$qkey+1}}" data-ans_section_count="{{$skey+1}}" data-ques_ans_section_count="{{$skey+1}}" placeholder="@lang('simple_editor.description')" oninput="getAnsOptionPreview(this.id)">@if(isset($asection->Attributes->sectionvalue)) {{$asection->Attributes->sectionvalue}} @else {{ $asection->Value }} @endif</textarea>

                                                                                                                    @if(isset($asection->Plugin) && $asection->Plugin == 'image')
                                                                                                                        @if(isset($asection->Value) && $asection->Value != '')
                                                                                                                            @php 
                                                                                                                                $imageUrl = explode("src:",$asection->Value)
                                                                                                                            @endphp
                                                                                                                            <a href="{{$imageUrl[1]}} " class="btn btn-sm btn-info dwnld-icn-cia" title="@lang('simple_editor.image_download')"  target="_blank" download></a>
                                                                                                                        @endif    
                                                                                                                    @elseif(isset($asection->Plugin) && $asection->Plugin == 'audio')
                                                                                                                        @if(isset($asection->Value) && $asection->Value != '')
                                                                                                                            @php 
                                                                                                                                $audioUrl = explode("src:",$asection->Value)
                                                                                                                            @endphp
                                                                                                                                <a href="{{$audioUrl[1]}} " class="btn btn-sm btn-info dwnld-icn-cia" title="@lang('simple_editor.audio_download')"  target="_blank" download></a>
                                                                                                                        @endif
                                                                                                                    @endif                                                                                                            
                                                                                                                @endif
                                                                                                            @endif
                                                                                                        @endif
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                            {{-- <button type="button" class="close_icon"></button> --}}
                                                                                            @if(!$loop->first)
                                                                                            <button type="button" class="close_icon" id="edit_ans_{{$akey+1}}_clear_btn_{{$skey+1}}" data-question_count="{{$qkey+1}}" data-option_count="{{$akey+1}}" data-ans_section_count="{{$skey+1}}" onclick="deleteAnsSection(this.id)"></button>
                                                                                            @endif
                                                                                        </li>
                                                                                        @endforeach
                                                                                    </ul>
                                                                                    <div class="checkbox_action">
                                                                                        <div class="custom-control custom-checkbox wihtut_bg_ck float-left float_ar_right">
                                                                                            <input name="correct" value="{{$akey+1}}" id="edit_is_correct_{{$akey+1}}" type="radio" class="custom-control-input" @if($ans->Attributes->IsCorrect) checked @endif data-option_count="{{$akey+1}}" onchange="selectCorrectAns(this.id)">
                                                                                            <label class="custom-control-label" for="edit_is_correct_{{$akey+1}}">@lang('simple_editor.is_correct')</label>
                                                                                        </div>
                                                                                        <div class="add_section_cls float-right float_ar_left">
                                                                                            <a href="javascript:;" class="add_section_btn" id="edit_ans_option_{{$akey+1}}_add_section_btn" data-question_count="{{$qkey+1}}" data-option_count="{{$akey+1}}" data-ans_section_count="{{$skey+1}}" data-ques_ans_section_count="{{$skey+1}}" data-section_count="{{$skey+1}}"  onclick="addMoreAnsOptionSection(this.id)">+ @lang('simple_editor.add_section')</a>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="clearfix"></div>
                                                                                </div>
                                                                                @endforeach
                                                                                @endif
                                                                            </div>
                                                                            <div class="add_section_cls mrgn-tp-40 mrgn-bt-30">
                                                                                <a href="javascript:;" class="add_section_btn" id="edit_add_more_ans_btn" data-question_count="{{ $qkey+1}}"  data-section_count="{{count($item->Answers->Choices)}}"  onclick="addMoreAnswer(this)">+ @lang('simple_editor.add_more_answers')</a>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="card-header" id="edit_subheading_Two">
                                                                        <button class="btn_blue_line" type="button" data-toggle="collapse" data-target="#edit_collapse_sub2" aria-expanded="false" aria-controls="collapse_sub2">
                                                                            <span class="minus_cls"></span>
                                                                            <span class="plus_cls">+</span>
                                                                        </button>
                                                                        <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#edit_collapse_sub2" aria-expanded="false" aria-controls="collapse_sub2">@lang('simple_editor.hint')</button>
                                                                    </div>
                                                                    <?php 
                                                                        
                                                                    ?>
                                                                    @if (count($item->Hints->HintList) > 0 && isset($item->Hints->HintList[0]->Sections[0]->Value) && $item->Hints->HintList[0]->Sections[0]->Value != "")
                                                                        @php
                                                                            $collapseCls = "show_line collapse show";
                                                                        @endphp
                                                                    @else
                                                                        @php
                                                                            $collapseCls = "collapse";
                                                                        @endphp
                                                                    @endif
                                                                    <div id="edit_collapse_sub2" class="{{ $collapseCls }}" aria-labelledby="edit_subheading_Two" data-parent="#edit_subcategories_accordion">
                                                                        <div class="inner-collaps-content hint_cls">
                                                                            <div id="edit_hint_div">
                                                                            @if($item->Hints)
                                                                                @foreach($item->Hints->HintList as $hlkey => $hlval)
                                                                            <div class="hint_option edit_question_{{ $qkey+1 }}_hint_div" id="edit_hint_{{$hlkey+1}}" data-hint_count="{{$hlkey+1}}" data-option_count="{{$hlkey+1}}">
                                                                                    <ul id="edit_hint_{{$hlkey+1}}_ul_list">
                                                                                        @foreach($hlval->Sections as $hskey => $hsection)
                                                                                        <li class="list_of_exersize pdng_70_lft" id="edit_hint_{{$hlkey+1}}_li_{{$hskey+1}}" data-hint_count="{{$hlkey+1}}" data-hint_section_count="{{$hskey+1}}">
                                                                                            <div class="form-group">
                                                                                                <div class="row">
                                                                                                    <div class="col-md-5 col-lg-5 col-xl-4">
                                                                                                        <div class="answer_pdng rmv_btn_cls right_ans">
                                                                                                            @if (!$loop->parent->first && $loop->first)
                                                                                                            <button type="button" class="close_icon" id="edit_clear_hint_btn_{{$hlkey+1}}" data-hint_count="{{$hlkey+1}}" onclick="removeHint(this.id)"></button>
                                                                                                            @endif
                                                                                                            <div class="text_wt_icon">
                                                                                                                @if($loop->first)
                                                                                                                <p class="name_hint" id="hint_{{$hlkey+1}}_text">H{{$hlkey+1}}</p>
                                                                                                                @endif
                                                                                                            </div>
                                                                                                            <div class="df-select">
                                                                                                                <select class="selectpicker edit_question_1_hint_{{$hlkey+1}}_section_{{$hskey+1}}_type"  data-question_count="{{$qkey+1}}" name="hint[{{$hlkey+1}}][{{$hskey+1}}][section_type]" id="edit_hint_{{$hlkey+1}}_section_type_{{$hskey+1}}" data-hint_count="{{$hlkey+1}}" data-hint_section_count="{{$hskey+1}}" onchange="changeHintSectionType(this.id, this.value)">
                                                                                                                        <option value="text"  @if($hsection->SectionType == 'text') selected @endif> @lang('simple_editor.text')</option>
                                                                                                                        <option value="image" @if($hsection->SectionType == 'Plugin' && !isset($hsection->Attributes->sectiontype)  && $hsection->Plugin == 'image') selected @endif>@lang('simple_editor.img')</option>
                                                                                                                        <option value="video" @if($hsection->SectionType == 'Plugin' && !isset($hsection->Attributes->sectiontype)  && $hsection->Plugin == 'video') selected @endif> @lang('simple_editor.video')</option>
                                                                                                                        <option value='audio' @if($hsection->SectionType == 'Plugin' && !isset($hsection->Attributes->sectiontype)  && $hsection->Plugin == 'audio') selected @endif>@lang('simple_editor.audio')</option>
                                                                                                                        <option value="plugin" @if($hsection->SectionType == 'Plugin' && isset($hsection->Attributes->sectiontype)  && $hsection->Attributes->sectiontype == 'plugin') selected @endif >@lang('simple_editor.plugins')</option>
                                                                                                                   
                                                                                                                    {{-- @foreach($sectionType as $key => $type)
                                                                                                                        <option value="{{$key}}" @if(isset($hsection->Attributes->sectiontype) &&  $hsection->Attributes->sectiontype == $key) selected @endif>@if ($type == 'Text')
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
                                                                                                                        @endif</option>
                                                                                                                    @endforeach --}}
                                                                                                                </select>
                                                                                                            </div>
                                                                                                                @php
                                                                                                                    $dis = "none";
                                                                                                                @endphp
                                                                                                                @if(isset($hsection->Attributes->sectiontype) &&  $hsection->Attributes->sectiontype == 'plugin' && isset($asection->Plugin))
                                                                                                                    @php
                                                                                                                        $dis = "block";
                                                                                                                    @endphp

                                                                                                                    <select style="display:{{$dis}};" class="dflt_slctpckr" id="edit_{{$hlkey+1}}_hint_span_detail_{{$hskey+1}}" data-mode="edit"  data-part="hint" data-hint_id="{{$hskey+1}}" data-hint_section_count="{{$hskey+1}}" onchange="changePluginType(this.id, this.value)">
                                                                                                                        <option value="clock" {{ $hsection->Plugin  == 'clock' ? 'selected' : '' }}> @lang('simple_editor.clock')</option>
                                                                                                                        <option value="chess" {{ $hsection->Plugin  == 'chess' ? 'selected' : '' }}> @lang('simple_editor.chess')</option>
                                                                                                                        <option value="video" {{ $hsection->Plugin  == 'video' ? 'selected' : '' }}> @lang('simple_editor.video')</option>
                                                                                                                        <option value="audio" {{ $hsection->Plugin  == 'audio' ? 'selected' : '' }} > @lang('simple_editor.audio')</option>
                                                                                                                        <option value="image" {{ $hsection->Plugin  == 'image' ? 'selected' : '' }} > @lang('simple_editor.image')</option>
                                                                                                                        <option value="table" {{ $hsection->Plugin  == 'table' ? 'selected' : '' }}> @lang('simple_editor.table')</option>
                                                                                                                        <option value="textbox" {{ $hsection->Plugin  == 'textBox' ? 'selected' : '' }}> @lang('simple_editor.textbox')</option>
                                                                                                                        <option value="flowchart" {{ $hsection->Plugin  == 'flow' ? 'selected' : '' }}>@lang('simple_editor.flowChart')</option>
                                                                                                                        <option value="math" {{ $hsection->Plugin  == 'math' ? 'selected' : '' }}> @lang('simple_editor.math')</option>
                                                                                                                        <option value="chart" {{ $hsection->Plugin  == 'chart' ? 'selected' : '' }}>@lang('simple_editor.chart')</option>
                                                                                                                    </select>

                                                                                                                    @if(isset($asection->Attributes->sectiontype) && $hsection->Plugin == 'audio')
                                                                                                                        <a href="javaScript:void(0);" class="replce-vlue audio_edit_{{$hlkey+1}}_hint_span_detail_{{$hskey+1}}" id="audio_edit_{{$hlkey+1}}_hint_span_detail_{{$hskey+1}}" data-mode='edit' data-option="answer" data-optionsection="{{$hskey+1}}" data-type="audio" data-question_count="{{$hlkey+1}}" onclick="showAsset(this.id);" data-toggle="modal" data-target="#plugin_assets">@lang('simple_editor.choose_audio')</a>
                                                                                                                    @endif
                                                                                                                    @if(isset($asection->Attributes->sectiontype) && $hsection->Plugin == 'image')
                                                                                                                        <a href="javaScript:void(0);" class="replce-vlue image_edit_{{$hlkey+1}}_hint_span_detail_{{$hskey+1}}" id="image_edit_{{$hlkey+1}}_hint_span_detail_{{$hskey+1}}" data-mode='edit' data-option="answer" data-optionsection="{{$hskey+1}}" data-type="image" data-question_count="{{$hlkey+1}}" onclick="showAsset(this.id);" data-toggle="modal" data-target="#plugin_assets">@lang('simple_editor.choose_image')</a>
                                                                                                                    @endif
                                                                                                                    <div class="questn_circl">
                                                                                                                        <span onclick="showQuePluginList(1)" title="" style="cursor:pointer;display:{{$dis}};" id="edit_plugin_{{$hlkey+1}}_hint_span_detail_{{$hskey+1}}">
                                                                                                                            <i class="fa fa-question-circle-o"></i>
                                                                                                                        </span>
                                                                                                                    </div>  

                                                                                                                @else 

                                                                                                                    <select style="display:none;" class="dflt_slctpckr" id="edit_{{$hlkey+1}}_hint_span_detail_{{$hskey+1}}" data-mode="edit"  data-part="hint" data-hint_id="{{$hskey+1}}" data-hint_section_count="{{$hskey+1}}" onchange="changePluginType(this.id, this.value)">
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
                                                                                                                        <span onclick="showQuePluginList(1)" title="" style="cursor:pointer;display:none;" id="edit_plugin_{{$hlkey+1}}_hint_span_detail_{{$hskey+1}}">
                                                                                                                            <i class="fa fa-question-circle-o"></i>
                                                                                                                        </span>
                                                                                                                    </div> 
                                                                                                                @endif
                                                                                                        </div>
                                                                                                    </div>
                                                                                                    <div class="col-md-7 col-lg-7 col-xl-8" id="edit_hint_{{$hlkey+1}}_section_type_div_{{$hskey+1}}">
                                                                                                        @if(strtolower($hsection->SectionType) == 'text')
                                                                                                            <textarea class="form-control lang-dir edit_question_{{$qkey+1}}_hint_{{$hlkey+1}}_section" name="hint[{{$hlkey+1}}][{{$hskey+1}}][description]" id="edit_hint_{{$hlkey+1}}_description_{{$hskey+1}}" data-hint_count="{{$hlkey+1}}" data-question_count="{{$qkey+1}}" data-hint_section_count="{{$hskey+1}}" placeholder="@lang('simple_editor.description')">{{$hsection->Value}}</textarea>
                                                                                                        @else
                                                                                                            @if($hsection->SectionType == "Plugin")
                                                                                                                @if(!isset($hsection->Attributes->sectiontype) && $hsection->Plugin == 'image')
                                                                                                                    @php 
                                                                                                                        $hintimageUrl = explode("src:",$hsection->Value);
                                                                                                                        if(count($hintimageUrl) > 1){
                                                                                                                            $hintname = pathinfo($hintimageUrl[1],PATHINFO_FILENAME);
                                                                                                                            $hintext = pathinfo($hintimageUrl[1],PATHINFO_EXTENSION);
                                                                                                                            $hintimageFile = $hintname.'.'. $hintext;
                                                                                                                        } else {
                                                                                                                            $hintimageFile = '';
                                                                                                                        }
                                                                                                                    @endphp
                                                                                                                
                                                                                                                    <div class="pramtr_file">
                                                                                                                        {{-- <input type="hidden" class="form-control " name="hint[{{$hlkey+1}}][{{$hskey+1}}][imagename]" value="{{isset($hsection->Value) && $hsection->Value != '' ? $hsection->Value : ''}}"> --}}
                                                                                                                        <input type="hidden" class="form-control edit_question_1_hint_{{$hlkey+1}}_section " name="hint[{{$hlkey+1}}][{{$hskey+1}}][image]" id="edit_hint_{{$hlkey+1}}_image_{{$hskey+1}}"  data-hint_count="{{$hlkey+1}}" data-question_count="{{$qkey+1}}" data-hint_section_count="{{$hskey+1}}" data-sectionvalue="{{$hsection->Value}}" data-sectioncaption="{{ $hintimageFile}}">
                                                                                                                        <span class="custm_btn image_edit_que_span_detail_{{$hlkey+1}}" id="hint_choos_{{$hlkey+1}}_image_{{$hskey+1}}" data-mode='edit' data-option="hint" data-optionsection="{{$hskey+1}}" data-type="image" data-question_count="{{$hlkey+1}}" onclick="showAsset(this.id);" data-toggle="modal" data-target="#plugin_assets" aria-hidden="true">@lang('simple_editor.choose_image')</span>
                                                                                                                        <span id="hint_filename_{{$hlkey+1}}_image_{{$hskey+1}}" class="filenme" aria-hidden="true">{{$hintimageFile}}</span>
                                                                                                                    </div>
                                                                                                                    <label for="edit_hint_{{$hlkey+1}}_image_{{$hskey+1}}" generated="true" class="error"></label>
                                                                                                                    @if(isset($hsection->Value) && $hsection->Value != '')
                                                                                                                        <a href="{{$url}}/image/{{ $hintimageFile }}" class="btn btn-sm btn-info dwnld-icn-cia edit_hint_{{$hlkey+1}}_image_{{$hskey+1}}" title="@lang('simple_editor.image_download')" target="_blank" download></a>
                                                                                                                    @endif
                                                                                                        

                                                                                                                @elseif(!isset($hsection->Attributes->sectiontype) && $hsection->Plugin == 'video')
                                                                                                                    <textarea class="form-control lang-dir edit_question_1_hint_{{$hlkey+1}}_section videourl" name="hint[{{$hlkey+1}}][{{$hskey+1}}][video]" id="edit_hint_{{$hlkey+1}}_video_{{$hskey+1}}" data-hint_count="{{$hlkey+1}}" data-question_count="{{$qkey+1}}" data-hint_section_count="{{$hskey+1}}" placeholder="Paste embed link here. To generate embed link,1. Open video in youtube 2. Click on share and select embed 3. Copy src link and paste here" onpaste="getHintVideoPreview(this.id)" onkeyup="getHintVideoPreview(this.id)" onchange="getHintVideoPreview(this.id)">{{$hsection->Value}}</textarea>
                                                                                                                    <label for="edit_hint_{{$hlkey+1}}_video_{{$hskey+1}}" generated="true" class="error"></label>
                                                                                                                @elseif(!isset($hsection->Attributes->sectiontype) && $hsection->Plugin == 'audio')
                                                                                                                    @php
                                                                                                                        $hintaudioimageUrl = explode("src:",$hsection->Value);
                                                                                                                        if(count($hintaudioimageUrl) > 1){
                                                                                                                            $hintaudioname = pathinfo($hintaudioimageUrl[1],PATHINFO_FILENAME);
                                                                                                                            $hintaudioext = pathinfo($hintaudioimageUrl[1],PATHINFO_EXTENSION);
                                                                                                                            $hintaudiofile = $hintaudioname.'.'. $hintaudioext;
                                                                                                                        } else {
                                                                                                                            $hintaudiofile =  '';
                                                                                                                        }
                                                                                                                    @endphp                                                                                                                
                                                                                                                    <div class="pramtr_file">
                                                                                                                        <input type="hidden" class="form-control" name="hint[{{$hlkey+1}}][{{$hskey+1}}][audioname]" value="{{$hsection->Value}}">
                                                                                                                        <input type="hidden" class="form-control edit_question_1_hint_{{$hlkey+1}}_section" name="hint[{{$hlkey+1}}][{{$hskey+1}}][audio]" id="edit_hint_{{$hlkey+1}}_audio_{{$hskey+1}}" data-hint_count="{{$hlkey+1}}" data-question_count="{{$qkey+1}}" data-hint_section_count="{{$hskey+1}}" data-sectionvalue="{{$hsection->Value}}" data-sectioncaption="{{$hintaudiofile}}">
                                                                                                                        <span class="custm_btn audio_edit_que_span_detail_{{$hlkey+1}}" id="hint_choos_{{$hlkey+1}}" data-mode='edit' data-option="hint" data-optionsection="{{$hskey+1}}" data-type="audio" data-question_count="{{$hlkey+1}}" onclick="showAsset(this.id);" data-toggle="modal" data-target="#plugin_assets" aria-hidden="true">@lang('simple_editor.choose_audio')</span>
                                                                                                                        <span class="filenme" id="hint_filename_{{$hlkey+1}}_audio_{{$hskey+1}}" aria-hidden="true">{{$hintaudiofile}}</span>
                                                                                                                    </div>
                                                                                                                    <label for="edit_hint_{{$hlkey+1}}_audio_{{$hskey+1}}" generated="true" class="error"></label>
                                                                                                                    @if(isset($hsection->Value) && $hsection->Value != '')
                                                                                                                    <a href="{{$url}}/audio/{{ $hintaudiofile }}" class="btn btn-sm btn-info dwnld-icn-cia edit_hint_{{$hlkey+1}}_audio_{{$hskey+1}}" title="@lang('simple_editor.audio_download')"  target="_blank" download></a>
                                                                                                                    @endif
                                                                                                                @else
                                                                                                                <textarea class="form-control lang-dir edit_question_1_hint_{{$hlkey+1}}_section " name="hint[{{$hlkey+1}}][{{$hskey+1}}][description]" id="edit_hint_{{$hlkey+1}}_description_{{$hskey+1}}" data-hint_count="{{$hlkey+1}}" data-question_count="{{$qkey+1}}" data-hint_section_count="{{$hskey+1}}" placeholder="@lang('simple_editor.description')">@if(isset($hsection->Attributes->sectionvalue)) {{$hsection->Attributes->sectionvalue}} @else {{ $hsection->Value }} @endif</textarea>
                                                                                                                    @if(isset($hsection->Plugin) && $hsection->Plugin == 'image')
                                                                                                                        @if(isset($hsection->Value) && $hsection->Value != '')
                                                                                                                            @php 
                                                                                                                                $imageUrl = explode("src:",$hsection->Value)
                                                                                                                            @endphp
                                                                                                                            <a href="{{$imageUrl[1]}} " class="btn btn-sm btn-info dwnld-icn-cia" title="@lang('simple_editor.image_download')"  target="_blank" download></a>
                                                                                                                        @endif    
                                                                                                                    @elseif(isset($hsection->Plugin) && $hsection->Plugin == 'audio')
                                                                                                                        @if(isset($hsection->Value) && $hsection->Value != '')
                                                                                                                            @php 
                                                                                                                                $audioUrl = explode("src:",$hsection->Value)
                                                                                                                            @endphp
                                                                                                                                <a href="{{$audioUrl[1]}} " class="btn btn-sm btn-info dwnld-icn-cia" title="@lang('simple_editor.audio_download')"  target="_blank" download></a>
                                                                                                                        @endif
                                                                                                                    @endif
                                                                                                                @endif
                                                                                                            @endif
                                                                                                        @endif
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                            
                                                                                            @if(!$loop->first)
                                                                                            <button type="button" class="close_icon" id="edit_hint_{{$hlkey+1}}_clear_btn_{{$hskey+1}}" data-hintcount="{{$hlkey+1}}" data-hintsectioncount="{{$hskey+1}}" onclick="deleteHintSection(this.id)"></button>
                                                                                            @endif
                                                                                        </li>
                                                                                        @endforeach
                                                                                    </ul>
                                                                                    <div class="add_section_cls text-right text-ar-left">
                                                                                        <a href="javascript:;" class="add_section_btn" id="edit_hint_{{$hlkey+1}}_add_section_btn" data-question_count="1" data-hint_count="{{$hlkey+1}}" data-hintsectioncount="{{count($hlval->Sections)}}"  onclick="addHintSection(this.id)">+ @lang('simple_editor.add_section')</a>
                                                                                    </div>
                                                                                </div>
                                                                                @endforeach
                                                                            @endif
                                                                            </div>
                                                                            <div class="add_section_cls mrgn-tp-40 mrgn-bt-30">
                                                                                <a href="javascript:;" class="add_section_btn" id="edit_add_more_hint_btn" data-hint_count="{{$hlkey+1}}" data-question_count="1" data-hintsectioncount="{{count($hlval->Sections)}}" onclick="addMoreHint(this.id)">+ @lang('simple_editor.add_more_hints')</a>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="card-header" id="edit_subheading_Three">
                                                                        <button class="btn_blue_line" type="button" data-toggle="collapse" data-target="#edit_collapse_sub3" aria-expanded="false" aria-controls="collapse_sub3">
                                                                            <span class="minus_cls"></span>
                                                                            <span class="plus_cls">+</span>
                                                                        </button>
                                                                        <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#edit_collapse_sub3" aria-expanded="false" aria-controls="collapse_sub3">@lang('simple_editor.attributes')</button>
                                                                    </div>
                                                                    <div id="edit_collapse_sub3" class="collapse" aria-labelledby="edit_subheading_Three" data-parent="#edit_subcategories_accordion">
                                                                        <div class="inner-collaps-content attribut_cls">
                                                                            <ul>
                                                                                <li class="list_of_exersize pdng_70_lft">
                                                                                    <ul class="prsn-action-rdio">
                                                                                        <li><label class="difclt-lbl">@lang('simple_editor.difficulty_level')</label></li>
                                                                                        <li>
                                                                                            <div class="rdio rdio-primary">
                                                                                                <input name="difficultylevel" value="easy" id="edit_Easy" type="radio" @if($item->Attributes->Difficulty === 'easy') checked @endif>
                                                                                                <label for="edit_Easy">@lang('simple_editor.easy')</label>
                                                                                            </div>
                                                                                        </li>
                                                                                        <li>
                                                                                            <div class="rdio rdio-primary">
                                                                                                <input name="difficultylevel" value="medium" id="edit_Medium" type="radio" @if($item->Attributes->Difficulty  === 'medium') checked @endif>
                                                                                                <label for="edit_Medium">@lang('simple_editor.medium')</label>
                                                                                            </div>
                                                                                        </li>
                                                                                        <li>
                                                                                            <div class="rdio rdio-primary">
                                                                                                <input name="difficultylevel" value="hard" id="edit_Hard" type="radio" @if($item->Attributes->Difficulty === 'hard') checked @endif>
                                                                                                <label for="edit_Hard">@lang('simple_editor.hard')</label>
                                                                                            </div>
                                                                                        </li>
                                                                                    </ul>
                                                                                </li>
                                                                                <li class="list_of_exersize pdng_70_lft">
                                                                                    <div class="range_slider">
                                                                                    <div class="row">
                                                                                        {{-- <div class="col-md-5 col-lg-5 col-xl-4">
                                                                                            <label>Min & Max Time To Answer</label>
                                                                                        </div> --}}
                                                                                            {{-- <div id="edit_ranged-value" class="rng_sldr" style="width: 250px; margin: 0px;"></div> --}}
                                                                                            <div class="col-md-6 range_input">
                                                                                                <label>@lang('simple_editor.min_time')</label>
                                                                                                <input type="text" class="form-control" id="edit_min_time" name="min_time" value="{{@$item->Attributes->MinTime}}" >
                                                                                            </div>
                                                                                            <div class="col-md-6 range_input">
                                                                                                <label>@lang('simple_editor.max_time')</label>
                                                                                                <input type="text" class="form-control" id="edit_max_time" name="max_time" value="{{@$item->Attributes->MaxTime}}">
                                                                                            </div>
                                                                                    </div>
                                                                                    </div>
                                                                                </li>
                                                                                <li class="list_of_exersize pdng_70_lft">
                                                                                    <div class="form-group">
                                                                                        <input type="text" class="form-control" name="tags" id="edit_tags" placeholder="@lang('simple_editor.tag')" value="{{$item->Attributes->Tag}}">
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

                                            @endforeach
                                            <div class="col-md-5" style="margin-top: 0px;">
                                                <div class="priew_section" id="edit_sidebar">
                                                    <div class="heading_priew">
                                                        <h4>@lang('simple_editor.preview')</h4>
                                                    </div>
                                                    <div class="priew_body lang-dir">
                                                         {{-- With Render Js --}}
                                                         <div id="edit-csv-div" class="csv-div hide">
                                                                
                                                            <pre>
                                                            <code>
                                                            <table class="csv-table">
                                                                <tbody class="csv-table-body" id="edit_csv_pre_tbl_body" >
                                                                                                                    
                                                                </tbody>
                                                            </table>
                                                            </code>
                                                            </pre>
                                                        </div>
                                
                                                        <div id="edit_question_preview">
                                                        
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
                                        <script id="edit_question_preview_template" type="text/html">
                                            
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
                                                <button type="button" class="btn btn-primary cancel-btn cncle-prfct" data-url="{{ route('exercisesets.exerciseset.show',array($question->exercise_id,'1#detail')) }}" id="edit_cancel_que_btn">@lang('simple_editor.cancel')</button>
                                                <input type="submit" class="btn btn-primary add_btn add-prfct" value="@lang('simple_editor.submit')">
                                                {{-- <button type="button" data-toggle="modal" data-target="#edit_create_exersis" data-dismiss="modal" class="btn btn-primary add_btn add-prfct">Submit</button> --}}
                                            </div>
                                        </div>
                                        </form>
                                    </div>
                                </div>
                                
                                
                               
                                
                                
                            </div>
                        </div>
                        {{--<div class="tab-pane fade" id="advance_editor" role="tabpanel" aria-labelledby="advance_editor-tab">

                        </div>--}}
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
</div>
<!-- Plugins List Modal -->
<div class="modal fade default_modal wht_bg_mdl" id="plugin_list_id" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
            <div class="modal-body">
                <div class="row">       
                    @include("eduplaycloud.users.private-library.plugin-list")
                </div>
            </div>
            </div>
        </div>                  
    </div>
    <input type="hidden" id="question_edit_json" value="{{print_r($sectionType)}}">
<!-- Modal -->
<div class="modal fade default_modal wht_bg_mdl plgn_asts" id="plugin_assets" tabindex="-1" role="dialog" aria-hidden="true" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content"> 
            <button type="button" class="close" data-dismiss="modal"  aria-label="Close" onclick="hideModal()"></button>
            <div class="modal-body">
                <div class="row">
                    <input type="hidden" id="section_part">
                    <input type="hidden" id="option_count">
                    <input type="hidden" id="option_section_count">
                    <input type="hidden" id="mode">
                    @include("eduplaycloud.users.private-library.assets-list")
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

<?php /*Load jquery to footer section*/ ?>
@push('inc_jquery')
@include('authenticated.includes.render_script')
<script>
//Still hide modal.
function hideModal(){
    $('#plugin_assets').modal('hide');
    $('body').removeClass('modal-open');
    $('.modal-backdrop').remove();
}

// var sectionArr = $('#question_edit_json').val();
// var sectionArr = <?php echo json_encode($sectionType); ?>;

var sectionArr = {"text":"Text","image":"Image","video":"Video","audio":"Audio","plugin":"Plugins"};

// console.log(sectionArr);
 // This global varible using for parameter value fetch.
 var finalcsvArrayEdit=[];

</script>
@endpush


<?php /*Load jquery to footer section*/ ?>
@push('inc_jquery')
<script>
    function showQuePluginList(id) {
        $('#plugin_list_id').modal('show');
    }

var direction = 'ltr';
$(document).ready(function()
{
            $('#edit_parameter_file').removeClass('required');

            // $('#edit_remove_parameter').on('click',function() {
            //     $('#edit-csv-div').hide();
            //     $('#parameter_file_path').val('');
               
            // });
    
            

            $("#edit_min_time").on('keyup',function() {
        
                var min = $("#edit_min_time").val();
                var max = $('#edit_max_time').val();

                if (min <= max) {
                    $('#edit_max_time').removeClass("error");
                    $('#edit_max_time').addClass("valid");
                    $('label[for="edit_max_time"]').text('');
                }
            });

            
            $("#edit_max_time").on('keyup',function() {
                
                var min = $("#edit_min_time").val();
                var max = $('#edit_max_time').val();

                if (max >= min) {
                    $('#edit_min_time').removeClass("error");
                    $('#edit_min_time').addClass("valid");
                    $('label[for="edit_min_time"]').text('');
                }
            });
   
            // The event listener for the file upload
            // document.getElementById('edit_parameter_file').addEventListener('change', upload, false);

            // Method that checks that the browser supports the HTML5 File API
    // For Language Direction
    @if($exerciseset->language->language == 'Arabic')
        direction = 'rtl';
        $('.priew_body').css({"text-align": "right"});
        $('.priew_body .question_ans').addClass("ar_question_ans");
        $('.priew_body .hint_sec').addClass("ar_hint_sec");
    @endif
    $('.lang-dir').attr('dir', direction);
    // Add Validation Method For Simple Editor
    jQuery.validator.addMethod("videourl", function(value, element) {
        return this.optional(element) || /embed\/([a-zA-Z0-9\-_]+)/.test(value);
    }, "Please specify the correct url");

    var max = "{{config('app.max_file_size')}}";
    jQuery.validator.addMethod("filesize", function(value, element) {
        if(element.files[0].size < 0 || element.files[0].size >= (max * 1000)) {
            return false;
        }
        return true;
    }, "More than 200KB is not acceptable.");
    // --------------------------------------

    var lastPage = $('#last_page').val();
    var lastItem = $('#last_item').val();
    var url = window.location.href; 
    var myString = url.substr(url.lastIndexOf("?") + 1);
    var page_no = myString.substr(myString.indexOf("=") + 1);
    if (myString.indexOf('page') > -1)
    {
        if(lastPage == undefined && lastItem == undefined) {
            stripped = url.substring(0, url.indexOf('=') + '='.length);
            document.location.href= stripped+(page_no - 1);
        } else {
            $('#pills-tab > li > a[href="#detail"]').tab('show');
        }
    }
});



function appendCsvtoTable2(csvData){

    // console.log(csvData);
    // console.log("Hi appendCsvtoTable2");
     $('#edit-csv-div').show();
    var csvArray = csvData.split("\n");
    var formattedString = [];
    //This is for Replace parameter value.
    var csvRows = [];
    var csvHeaderString = [];
    var csvRowsValue = [];


    for(i=0;i < csvArray.length;i++){
        if(csvHeaderString.length == csvArray[i].split(",").length || i == 0) {
            formattedString.push('<tr><td>' + csvArray[i].split(",").join("</td><td>") + '</td></tr>');
        }
        csvRows.push(csvArray[i].split(","));
        if(i == 0){
            csvHeaderString = csvArray[i].split(",");
        } else if(csvHeaderString.length == csvArray[i].split(",").length) {
            csvRowsValue.push(csvArray[i]);
        }
    }
    
    // console.log('Rows ' + csvRows);
    // console.log('header string ' + csvHeaderString);
    // console.log('Rows value ');
    // console.log(csvRowsValue);

    $("#edit_csv_pre_tbl_body").empty();
    for(i=0;i <= 5;i++){
        
        $("#edit_csv_pre_tbl_body").append(formattedString[i]); 
    }

    //This is for Replace parameter value.
    var randKey = Math.floor(Math.random()*csvRowsValue.length);
    if(randKey === -1){
        randKey = 0
    }
    // console.log('randKey 2');
    // console.log(randKey);
    var item = csvRowsValue[randKey];
    // console.log('item  ' + item);
    var splitItem = item.split(","); 
    
    // console.log('splitItem');
    
    for (i = 0; i < csvHeaderString.length; ++i)
    {
         
        //var outString = csvHeaderString[i].replace(/[`' '~!@#%^&*()_|+\-=?;:'",.<>\{\}\[\]\\\/]/gi, '').toLowerCase().trim();
        var outString = csvHeaderString[i].trim();
        
        finalcsvArrayEdit[outString] = splitItem[i];
    } 

    // console.log(finalcsvArrayEdit);
}


// The event listener for the file upload
document.getElementById('edit_parameter_file_brows').addEventListener('change', upload, false);

// The Drop event listener for the file upload.
document.getElementById('edit_parameter_file_brows').addEventListener('drop', upload, false);

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
						
						  $('#edit_parameter_file').removeClass('required');

						if(this.files[0].size > csvMaxSize ){
							$('#edit_parameter_file_brows').empty();
							$('#edit_pera_error').empty();
							$('#edit_pera_error').append(this.files[0].name + " of csv @lang('myassest.file_size_more_than')" + (csvMaxSize / 1000) + "KB");
						} else {

							$("#edit_perameter_brows").text(this.files[0].name);
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
                      
                      //Call csv data display
											appendCsvtoTable2(csvData);
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

// function browserSupportFileUpload() {
//     var isCompatible = false;
//     if (window.File && window.FileReader && window.FileList && window.Blob) {
//         isCompatible = true;
//     }
//     return isCompatible;
// }

        // Method that reads and processes the selected file
// function upload(evt) {
//     $('#csv-download-btn').hide();
//     if (!browserSupportFileUpload()) {
//         alert('The File APIs are not fully supported in this browser!');
//     } else {
//         var data = null;
//         var file = evt.target.files[0];
        
        
//         var extension = file.name.replace(/^.*\./, '');
//         if(extension === 'csv') {
            
//             var reader = new FileReader();
//             reader.readAsText(file);
//             reader.onload = function(event) {
//                 $('#edit-csv-div').show();

//                 var csvData = event.target.result;             
//                 var csvArray = csvData.split("\n");
//                 var formattedString = [];
                
//                 for(i=0;i < csvArray.length;i++){
//                     formattedString.push('<tr><td>' + csvArray[i].split(",").join("</td><td>") + '</td></tr>');
//                 }
                
//                 $("#edit_csv_pre_tbl_body").empty();
//                 for(i=0;i <= 5;i++){
                    
//                     $("#edit_csv_pre_tbl_body").append(formattedString[i]); 
//                 }
                
//             };
//             reader.onerror = function() {
//                 alert('Unable to read ' + file.fileName);
//             };
//         } else {
//             swal("Cancelled", "Select Only CSV file.", "error");
//             $('#parameter_file').val('');
//             $("#edit_csv_pre_tbl_body").empty();
//         }
//     }
// }


</script>
<script type="text/javascript" src="{{ asset('assets/eduplaycloud/customs/js/pages/private-library/edit-simple-editor.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/eduplaycloud/customs/js/pages/private-library/edit-custom-question-json.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/plugin.js') }}"></script>

@endpush
