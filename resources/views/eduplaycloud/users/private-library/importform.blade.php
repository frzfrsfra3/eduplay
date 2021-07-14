@extends('authenticated.layouts.default')
@section('content')
<div class="main_content">
    <div class="container">
    <div class="add_child_cls">
    <div class="row justify-content-center">
        <div class="col-lg-11">
            <nav aria-label="tp-breadcm" class="tp-breadcm">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{route('exercisesets.exerciseset.private')}}">@lang('exerciseset_show.my_private_exercise')</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{ $exerciseset->title }}</li>
                </ol>
            </nav>
            <div class="inner_add_child text-ar-right">
                    <ul class="tabs_menu summary-tbs nav nav-pills mb-3 mrgn_tbs_less" id="pills-tab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="summary-tab" data-toggle="pill" href="#summary" role="tab" aria-controls="summary" aria-selected="true">@lang('exerciseset_show.summary')</a>
                        </li>
                        @if(Auth::user()->id == $exerciseset->createdby)
                        <li class="nav-item">
                            <a class="nav-link" id="detail-tab" data-toggle="pill" href="#detail" role="tab" aria-controls="detail" aria-selected="false">@lang('exerciseset_show.details')</a>
                        </li>
                        
                        <li class="nav-item">
                            <a class="nav-link " id="simple_editor-tab" data-toggle="pill" href="#simple_editor" role="tab" aria-controls="simple_editor" aria-selected="false">@lang('exerciseset_show.simple_editor')</a>
                        </li>
                        @endif
                        {{--  Not In Scope  --}}
                        {{--  <li class="nav-item">
                            <a class="nav-link" id="advance_editor-tab" data-toggle="pill" href="#advance_editor" role="tab" aria-controls="advance_editor" aria-selected="false">@lang('exerciseset_show.advance_editor')</a>
                        </li>  --}}
                    </ul>
                <h6>@lang('exerciseset_form.import_bulk')</h6>
                <form id="import_form" method="POST" action="{{route('exercisesets.importform.store')}}" enctype="multipart/form-data">
                    <input type="hidden" name="exercise_id" id="exercise_id" value="{{$exerciseset->id}}">
                    @csrf
                    {{-- <input name="_method" type="hidden" value="PUT"> --}}
                    <div class="row">
                        <!----JSON section---->
                        <div class="col-md-12">
                            <div class="form-group mrgn-bt-30">
                                <label>@lang('exerciseset_form.json') :</label>
                                <textarea class="form-control required" name="josn"  id="josn" rows="8" onkeyup="checkJsonFormat(this.id);">{{ old('josn', optional($exerciseset)->josn) }}</textarea>
                                {{-- <div class="error" id="json_input_error">{{ $errors->first('josn') }}</div> --}}
                                
                                <div class="add_section_cls text-right text-ar-left">
                                    <a href="{{ asset('assets/eduplaycloud/import-bulk/josn-structure.json') }}" class="add_section_btn" download>@lang('exerciseset_form.download_format')</a>
                                </div>
                            </div>
                        </div>

                        <!----Perameter section---->
                        <div class="col-md-6">
                            <div class="pramtr_file">
                                <input type="file" class="form-control" name="parameter[]" id="parameter_file" multiple="multiple" accept=".csv,text/csv" onchange="getParameterName(this.id,{{$file_size}})">
                                <span class="custm_btn" aria-hidden="true">@lang('exerciseset_form.parameters')</span>
                                <span class="filenme" aria-hidden="true"></span>
                                <label for="parameter_file" generated="true" class="error"></label>
                            </div>
                            <p class="upld-note" id="pera_selected"></p>
                            {{--  <p class="upld-note"><span>@lang('exerciseset_form.note'): </span>@lang('exerciseset_form.parameter_note')</p>
                            <label id="perameter_error" class="error"></label>  --}}
                        </div>
                        
                        <!----Image section---->
                        <div class="col-md-6">
                            <div class="pramtr_file">
                                <input type="file" class="form-control filesize" name="image[]" id="image_1" multiple="multiple" accept="image/*" placeholder="upload_image" onchange="getImageName(this.id,{{$file_size}})">
                                <span class="custm_btn" aria-hidden="true">@lang('exerciseset_form.images')</span>
                                <span class="filenme" aria-hidden="true"></span>
                            </div>
                            <p class="upld-note" id="img_selected"></p>
                            {{--  <p class="upld-note"><span>@lang('exerciseset_form.note'): </span> @lang('exerciseset_form.image_note')</p>
                            <label id="image_error" class="error"></label>  --}}
                        </div>

                        <p id="sizeError" style="display:none; color:#FF0000;">@lang('myassest.files_error')</p>
                        <p id="errorCSV" style="display:none; color:#FF0000;">@lang('exerciseset_form.errorCSV')</p>
                        <p id="errorImg" style="display:none; color:#FF0000;">@lang('exerciseset_form.errorImg')</p>
                        <!----Button section---->
                        <div class="col-md-12">
                            @if ($errors->any())
                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                            @endif
                            {{-- @if ($errors->any()) --}}
                                {{-- <div class="alert alert-danger">
                                    <ul> --}}
                                        {{-- @foreach ($errors as $error) --}}
                                            {{-- <li>{{ $error }}</li> --}}
                                            {{-- {!! implode('', $errors->all('<li>:message</li>')) !!} --}}
                                        {{-- @endforeach --}}
                                    {{-- </ul> --}}
                                {{-- </div> --}}
                            {{-- @endif --}}
                            <div class="clearfix"></div><br/>
                            <div class="form-group mrgn-bt-30">
                                <a href="{{route('exercisesets.exerciseset.private')}}" class="btn btn-primary cancel-btn">@lang('exerciseset_form.cancel')</a>
                                <button type="submit" class="btn btn-primary add_btn" id="import_btn" disabled> @lang('exerciseset_form.import') </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    </div>
    </div>
</div>

@endsection

<?php /*Load jquery to footer section*/ ?>
@push('inc_script')

@endpush

<?php /*Load jquery to footer section*/ ?>
@push('inc_jquery')
<script type="text/javascript" src="{{ asset('assets/eduplaycloud/customs/js/pages/private-library/import-bluk.js') }}"></script>

<script>
var exercise_id = $('#exercise_id').val();

var totalsize = {{$file_size}};

//Redirect to summary page.
$(document).on('click','#summary-tab',function(){
    window.location.href = site_url + '/exercisesets/show/'+exercise_id+'/1#summary';
});

//Redirect to Details page.
$(document).on('click','#detail-tab',function(){
    window.location.href = site_url + '/exercisesets/show/'+exercise_id+'/1#detail';
});


//Redirect to simple editor page.
$(document).on('click','#simple_editor-tab',function(){
    window.location.href = site_url + '/exercisesets/show/'+exercise_id+'/1#simple_editor';
});

</script>
@endpush