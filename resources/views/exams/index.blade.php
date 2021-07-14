@extends('authenticated.layouts.default')

@section('header_styles')
    <link href="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.6.1/css/bootstrap4-toggle.min.css" rel="stylesheet">
@endsection

@section('content')

<!--Share By Mail Model-->
<div class="modal fade default_modal wht_bg_mdl" id="share_mail" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="right_contnt text-ar-right">
                            <h3>@lang('exercisesets.mail')</h3>
                            <form class="def_form" action="{{route('mail.assignment')}}" id="share_email_form" method="POST">
                                {{ csrf_field() }}
                                <div class="form-group">
                                    <input type="hidden" id="url" name="url" value=""  class="form-control">
                                </div>
                                <div class="form-group">
                                    <label>@lang('exercisesets.enter_email'): </label>
                                   <input type="email" id="email" name="email" value=""  class="form-control" required>
                                </div>
                                <div class="form-group mrgn-tp-30">
                                    <button type="submit" class="btn btn-primary btn-login drk_bg_btn">@lang('exercisesets.send')</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!---Content-->
<div class="work_page mrgn_top_secn text-ar-right">
	<div class="container">
		<div class="row justify-content-center">
			<div class="col-lg-12">
				<div class="my_private_libray">
					<div class="tbs_of_report tbs_of_report-as">
						<div class="dropdown">
							<button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown">My Assignment
							<span class="caret"></span></button>
							@include('eduplaycloud.users.private-library.menu')
						</div>
					</div>
                    <div class="clearfix"></div>
                    <div class="msgBlock">
                        @if(Session::has('success_message'))
                            <div class="alert alert-success">
                                <span class="glyphicon glyphicon-ok"></span>
                                {!! session('success_message') !!}
                                <button type="button" class="close" data-dismiss="alert" aria-label="close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        @endif
                         @if(Session::has('error_message'))
                            <div class="alert alert-danger">
                                <span class="glyphicon glyphicon-ok"></span>
                                {!! session('error_message') !!}
                                <button type="button" class="close" data-dismiss="alert" aria-label="close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        @endif
                    </div>
					<div class="my_exercise mrgn-tp-50 mrgn-bt-30 my_exercise20">
                        @auth
                            @if ( Auth::User()->hasRole('Teacher') || Auth::User()->hasRole('Learner')  || Auth::User()->hasRole('Admin'))
                                <div class="main_detail_fltr">
                                    <div class="title_with_shrtby">
                                        <div class="float-sm-left filtr_with_titile">
                                            <h4 class="exersc_title">@lang('exam.my_assignments')</h4>
                                            <a href="{{ route('Exams.exam.create.first') }}" class="creat_new">@lang('exam.create_new')</a>
                                            <a class="mrgn_lft_20 collps_fltr" data-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample"><span class="flr-i"></span></a>
                                        </div>
                                        <div class="float-sm-right short_by text-right">
                                            <div class="short_by_select">
                                                <label>@lang('filter.sort_by_title') : </label>
                                                <select class="selectpicker" id="sort-by">
                                                    <option value="Ascending">@lang('filter.ascending')</option>
                                                    <option value="Descending">@lang('filter.descending')</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="clearfix"></div>
                                    <div class="list_of_filter collapse" id="collapseExample">
                                        <div class="card card-body">
                                            <!--Filter Form Apply-->
                                            <form id="filter-form" method="GET">
                                                <div class="mani_menu_list">
                                                    <div class="float-left">
                                                        <a class="open_filter" href="javascript:;"><i class="plus_icn"></i></a>
                                                        <ul class="studnt_list_nm" id="fltered-text-list">
                                                            <!--Filter text append here-->
                                                        </ul>
                                                    </div>
                                                    <div class="float-right clear_all_cls">
                                                        <a href="javascript:;" id="clear_all_btn" class="clear_all_btn">@lang('filter.clear_all')</a>
                                                    </div>
                                                </div>
                                            </form>
                                            <!--End filer form-->
                                            <div class="slct_drop_box">
                                                <ul class="demo-accordion accordionjs " data-active-index="false">
                                                                                                   
                                                    <li>
                                                        <div class="section_cls">
                                                            <h3>@lang('filter.status')</h3>
                                                        </div>
                                                        <div class="class-detail">
                                                            <form  class="def_form">
                                                                <div class="form-group">
                                                                    <div class="df-select">
                                                                        <select class="selectpicker" id="status-name">
                                                                            <option value="Y"  selected>@lang('filter.yes')</option>
                                                                            <option value="N" >@lang('filter.no')</option>                                                                            
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                                <button id="status-apply" type="button" class="btn btn-primary apply_sm_btn">@lang('filter.apply')</button>
                                                            </form>
                                                        </div>
                                                    </li>    
                                                    <li>
                                                        <div class="section_cls">
                                                            <h3>@lang('filter.creation_date')</h3>
                                                        </div>
                                                        <div class="class-detail">
                                                            <form  class="def_form">
                                                                <div class="form-group">
                                                                    <div class="df-select">
                                                                    <input type="text" class="form-control" placeholder="@lang('filter.start_date') " name="startDate" id="startDate">
                                                                    </div>
                                                                </div>
                                                                <div class="form-group">
                                                                    <div class="df-select">
                                                                        <input type="text" class="form-control" placeholder=" @lang('filter.end_date') " name="endDate" id="endDate">
                                                                    </div>
                                                                </div>
                                                                <button id="created-date-apply" type="button" class="btn btn-primary apply_sm_btn">@lang('filter.apply')</button>
                                                            </form>
                                                        </div>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="list_of_exercise mrgn-tp-20">
                                    <div class="row" id ="exam_result">                                        
                                        @if(count($exams) == 0)
                                            <div class="col-sm-12">
                                                <p>@lang('exam.no_exams_available')</p>
                                            </div>
                                        @else
                                            @php $i=1;@endphp
                                            @foreach($exams as $exam)
                                                @php $k=$i%2; $i++ ;@endphp
                                                <div class="col-md-6 col-lg-6 col-xl-3 cusmize-col exam-header-row-{{$k}}">
                                                    <div class="main_info pstn_rltv">
                                                        <div class="main_shr">
                                                            <button type="button" data-exerciseset="{{route('takeexam.index' ,[$exam->id , $exam->class_id($exam->id)  ,"1"])}}" 
                                                                id="share_{{$exam->id}}" onclick="generateEmailUrl(this.id)" data-toggle="modal" data-target="#exercisesets/private" 
                                                                data-toggle="tooltip" title="@lang('exercisesets.share')"
                                                                class="share_link_icn">
                                                            </button>
                                                        </div>
                                                        <div class="info_exercise">
                                                            <img src="assets/eduplaycloud/image/assignment_bg.png" class="img-fluid">
                                                            <div class="right_gnrl_info">
                                                                <ul class="gnrl_info float-right float_ar_left">
                                                                    <li class="messg_lst_i"  data-toggle="tooltip" title="@lang('exam.tool_tip_question')">{{$exam->examquestions()->count()}}</li>
                                                                    <li class="list_i"  data-toggle="tooltip" title="@lang('exam.tool_tip_points')">{{$exam->examquestions()->sum('points')}}</li>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                        <ul class="title_cmbo text-ar-right">
                                                            <li><a>{{ $exam->title != '' ? ucfirst(str_limit($exam->title,'30')) : 'N/A' }}</a></li>
                                                            <li>
                                                                <p>{{ucfirst($exam->examtype)}}</p>
                                                            </li>
                                                            
                                                        </ul>
                                                        <div class="availble">
                                                            <input type="checkbox" id="toggle{{$exam->id}}" data-toggle="toggle" data-on="{{ Lang::get('exam.available') }}" data-off="{{ Lang::get('exam.not_available') }}" data-onstyle="success" data-offstyle="danger" @if($exam->isavailable =='Y') ? checked : '' @endif onchange="togalswitch({{$exam->id}})" data-size="xs">
                                                            {{--  @if($exam->isavailable =='N')
                                                                <p id="notAvailable">{{ Lang::get('exam.not_available') }}</p>
                                                            @else
                                                                <p id="Available">{{ Lang::get('exam.available') }}</p>
                                                            @endif  --}}
                                                        </div>
                                                        <style>
                                                            .generate_wt_icn::before {
                                                                display: none !important;
                                                                width: 0;
                                                            }
                                                        </style>
                                                        <ul class="editable_list">
                                                            <li><a href="javascript:;"  class="view_icn" data-id="{{ $exam->id }}">@lang('exam.view')</a></li>
                                                            <li><a class="edit_wt_icn" href="{{ route('exams.exam.edit', array($exam->id,$exams->currentPage()) ) }}">@lang('exam.edit')</a></li>
                                                            <li><a href="javascript:;" class="export_icn" data-id="{{ $exam->id }}">@lang('exam.export')</a></li>
                                                            {{--  <li><a class="export_icn" href="{{ route('exams.exam.exportExam',$exam->id) }}">Export</a></li>  --}}
                                                            <li><a class="delet_wt_icn" href="#"  onclick="isconfirm({{ $exam->id }});">@lang('exam.delete')</a></li>
                                                            
                                                        </ul>
                                                        @if ( $exam->examtype == "practice")
                                                            <a href="{{ route('games.generate.exam.code' , $exam->id) }}" class="creat_new" style="font-size: 11px !important">Generate game code</a>
                                                        @endif
                                                        {{-- <a href="{{ route('practice.index', $exam->id ) }}" class="creat_new assign_take m3">@lang('exam.take_assignment')</a> --}}
                                                    </div>
                                                </div>
                                            @endforeach
                                        @endif
                                        
                                        </div>
                                    </div>
                                    <div class="float-right">{{ $exams->links() }} </div>
                                </div>
                            @endif
                        @endauth
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<!---End Content-->

<!--publish-to-class-->
<div class="modal fade default_modal wht_bg_mdl" id="publish_cls" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="right_contnt text-ar-right">
                            <h3>@lang("exam.select_class")</h3>
                            <form class="def_form">
                                <div class="form-group">
                                    <div class="df-select">
                                        <select class="selectpicker">
                                            <option>@lang('exam.grade')</option>
                                            <option>@lang('exam.grade')1</option>
                                            <option>@lang('exam.grade')2</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group publis_mrgn">
                                    <button type="button" class="btn btn-primary btn-login">@lang('exam.publish')</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!--view-modal-->
<div class="modal fade width-700-model default_modal wht_bg_mdl" id="view_modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            @include('exams.show')
            {{--  <div class="modal-body">
            </div>  --}}
        </div>
    </div>
</div>

<!--Export-modal-->
<div class="modal fade width-700-model default_modal wht_bg_mdl" data-backdrop="static" data-keyboard="false" id="export_modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <button type="button" class="close" onclick="location.reload();" data-dismiss="modal" aria-label="Close"></button>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="right_contnt invite_mdl text-ar-right">
                            <h3>@lang('exam.pdf_details')</h3>
                            @if(isset($exam->id))
                                <form id="exportPdfForm" class="" method="post" action="{{ route('exams.exam.exportExam',$exam->id) }}">
                                    @csrf
                                    <input type="hidden" id="hiddenSrc" name="hiddenSrc" value="" />
                                    <div class="form-group">
                                        <label>@lang('exam.school_name')</label>
                                        <input type="text" id="schoolName" name="schoolName" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <label>@lang('exam.teacher_name')</label>
                                        <input type="text" id="teacherName" name="teacherName" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <label>@lang('exam.learner_name')</label>
                                        <input type="text" id="learnerName" name="learnerName" class="form-control">
                                    </div>
                                    <div id="randerData"></div>
                                    <div class="form-group">
                                        <button type="submit" id="genaratePdf" class="btn btn-primary btn-login drk_bg_btn">@lang('exam.genarate_pdf')</button>
                                    </div>
                                </form>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

<?php /*Load jquery to footer section*/ ?>
@push('inc_script')
<script src="{{ asset('assets/eduplaycloud/js/accordion.js') }}"></script>
<script src="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.6.1/js/bootstrap4-toggle.min.js"></script>
@endpush

<?php /*Load jquery to footer section*/ ?>
@push('inc_jquery')
<script src="{{ asset('assets/eduplaycloud/customs/js/block-ui/jquery.blockUI.js') }}"></script>
<script src="{{ asset('assets/eduplaycloud/customs/js/filter/my-assignment-filter.js') }}"></script>
<script src="{{ asset('assets/eduplaycloud/customs/js/filter/save-filter.js') }}"></script>
<script src="{{ asset('assets/eduplaycloud/js/functions.js') }}"></script>
<script>
    $(window).bind("pageshow", function() { // update hidden input field $('#formid')[0].reset(); });
        $("#sort-by").val(0).selectpicker("refresh");
    });
    /*accordian*/
    jQuery(document).ready(function($){
        $(".demo-accordion").accordionjs();
    });
</script>
<script>
   $(function () {
       $('#startDate').datetimepicker({
           format: 'DD-MM-YYYY',
           maxDate: 'now',
           /*debug: true*/
       });
       $('#endDate').datetimepicker({
           format: 'DD-MM-YYYY',
           useCurrent: false,
           maxDate: 'now'
       });
       $("#startDate").on("dp.change", function (e) {
           $('#endDate').data("DateTimePicker").minDate(e.date);
       });
       $("#endDate").on("dp.change", function (e) {
           $('#startDate').data("DateTimePicker").maxDate(e.date);
       });
   });
</script>

{{--<script src="https://html2canvas.hertzen.com/dist/html2canvas.min.js"></script>--}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/0.4.1/html2canvas.min.js"></script> 
@include('authenticated.includes.render_script')

<script>
    $(document).ready(function(){




        $.ajaxSetup({
          headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
        });
        // view dateils model
        $(document).on('click','.view_icn',function(){
            var exam_id = $(this).attr("data-id");
            $.ajax({
                method:"GET",
                url: site_url + "/exams/show/" + exam_id,
                datatype: "html",
                beforeSend: function(xhr) {
                    showLoader();
                }
            }).done(function(data) {
                    hideLoader();
                    $('#view_modal').modal('show');
                    $('#view_modal .modal-content').empty().html(data);
                }).fail(function(jqXHR, ajaxOptions, thrownError) {
                    hideLoader();
                    swal('No response from the server.', {
                        closeOnClickOutside: false,
                        icon: 'info',
                    }).then(function() {
                        // location.reload();
                    });
                });
        });

        // View Export Model
        $(document).on('click','.export_icn',function(){
            var exam_id = $(this).attr("data-id");
            var formAction = $('#exportPdfForm').attr('action');
            formAction = formAction.substr(0, formAction.lastIndexOf("/"));
            formAction = formAction + '/'+exam_id;
            $('#exportPdfForm').attr('action',formAction);
            $.ajax({
                method:"GET",
                url: site_url + "/exams/exportExam/" + exam_id,
                datatype: "html",
                beforeSend: function(xhr) {
                    showLoader();
                }
            }).done(function(data) {
                    $('#export_modal').modal('show');
                    setTimeout(function() { 
                        $('#randerData').html(data);
                        onExportDataLoad();
                        setTimeout(function() {
                            $("#htmlSrcData").val($("#previewExamExport").html());
                            $('#randerData').hide();
                            hideLoader();
                        },5000);
                     }, 5000);
                }).fail(function(jqXHR, ajaxOptions, thrownError) {
                    hideLoader();
                    swal('No response from the server.', {
                        closeOnClickOutside: false,
                        icon: 'info',
                    }).then(function() {
                        // location.reload();
                    });
                });
        });

        $("#exportPdfForm").validate({
            rules: {
                schoolName: {
                    required: true,
                },
                teacherName: {
                    required: true,
                },
                learnerName: {
                    required: true,
                },
            },
            messages: {

            }
        });
    });

    function isconfirm(id){
        swal({
            text: "@lang('exam.sure_exam')",
            icon: "warning",
            buttons: [
              '@lang("exam.cancel_it")',
              '@lang("exam.sure")'
            ],
            dangerMode: true,
          }).then(function(isConfirm) {
            if (isConfirm) {
                @if(count($exams) > 0)
                    window.location.href = site_url+'/exams/exam/'+id;
                @endif
            }
          })
      }
</script>

{{-- Export PDF SCRIPT --}}
<script type='text/javascript'>		
    // render code
    function renderToHtml_E(Q) {
        var template = document.getElementById('sample_template_ExamDetails').innerHTML;
        var output = Mustache.render(template, Q);
        return output;
    }

    function onExportDataLoad()
    {
        var json_details_exam = $('#jsonDivExamDetails').data('json');
        // Set A B C D string in Answare choices by jQuery.
        var count = 0;
        $(json_details_exam).each(function(key,value){
            $(value.Questions).each(function(qkey,questions){

                questions.question_count = ++count;
                var i = 65;
                $(questions.Answers.Choices).each(function(ckey,choices){
                    // console.log(String.fromCharCode((i+ckey)));
                    choices.string = String.fromCharCode((i+ckey));
                    
                });
            });
        });
        // console.log(json_details_exam);
        setTimeout(function(){ 
            pRunExamExportPage(json_details_exam);
                // total mark logic
            total();    // call below function
            setTimeout(function() { 
                htmlSrcData();
            }, 1000);
        }, 100);
    }

    function pRunExamExportPage(json_details_exam) {
        var data = json_details_exam;
        var previewFrame = document.getElementById('previewExamExport');
        var static_parserOutputObjExamDetail = data;
        var static_plugin_parserOutputObj = renderPluginsinObj(static_parserOutputObjExamDetail);
        var finalObj = static_plugin_parserOutputObj;

        previewFrame.innerHTML = renderToHtml_E(finalObj);
        reInitiate();
    }

    // Load Html Data
    function htmlSrcData(){
        $('#previewExamExport iframe').each(function(index){
            var youtubeSrc = $(this).attr('src');
            $(this).parent().html('<div>Video : ' + youtubeSrc +'</div>');											
        });

        $('#previewExamExport audio').each(function(index){

            $('.audiocaption').parent().remove();
            var audioSrc = $(this).children().attr('src');
            $(this).parent().parent().html('<div">Audio : ' + audioSrc +'</div>');
            $(this).parent('.Section').remove();

        });
        
        $('#previewExamExport canvas').each(function(index){
            var EleId = $(this).attr('id');
            var srcImg = canvasToImg(EleId);
            $(this).parent().html("<img id='"+EleId+"_canvas' src='"+srcImg+"' alt='from canvas'/>");
        });

        $('#previewExamExport svg').each(function(index){
            var svgEleId = $(this).attr('id');
            var svgText = $(this).parent().html();
            drawInlineSVG(this,svgText,svgEleId);
        });


        //Html to canvas for Maths.
        $('#previewExamExport .math').each(function(index){

            $(this).attr('id',index + '_math');
            $(this).attr('style','align:left');
            $(this).attr('align','left');
            // console.log($(this));
            html2canvas($(this), {
                onrendered: function(canvas) {
                    theCanvas = canvas;
                    canvas.setAttribute('id', index + '_math_canvas');
                    $('#'+index + '_math').parent().html(canvas);
                    var srcImg = canvasToImg(index + '_math_canvas');
                    $('#'+index + '_math_canvas').parent().html("<img src='"+srcImg+"' alt='from canvas' style='align:left'/>");
                }
            });							
        });

        // Html to canvas for TextBox.
        $('#previewExamExport .textBox.Section').each(function(index){
            $(".textBox.Section").	parent().html('<span style="display: block;">Result</span><p class="text-field" style="height: 40px;outline: none !important; width: 200px;display: inline-block; border: 1px solid #cccccc !important;padding: 5px 10px;"></p>');
        });

        // Html to canvas for TextBox.
        $('#previewExamExport .chess').each(function(index){
            $(".chess").parent().parent().parent().parent().parent().addClass('custom-chess');
        });

        

    }

    function drawInlineSVG(that,rawSVG,svgEleId) {

        var svg = new Blob([rawSVG], {type:"image/svg+xml;charset=utf-8"}),
            domURL = self.URL || self.webkitURL || self,
            url = domURL.createObjectURL(svg),
            img = new Image;
            img.setAttribute("crossOrigin", 'Anonymous');
            img.onload = function () {
                domURL.revokeObjectURL(url);
                $(that).parent().html(this);
            };

            var reader = new FileReader();
            reader.readAsDataURL(svg); 
            reader.onloadend = function() {
                var base64data = reader.result;

                // call svgString2Image function
                svgString2Image(svgEleId,base64data, 200, 200, 'png');

                img.src = base64data;

            }
    }

    function svgString2Image(svgEleId,svgString, width, height, format) {
        // set default for format parameter
        format = format ? format : 'png';
        // SVG data URL from SVG string
        //var svgData = 'data:image/svg+xml;base64,' + btoa(unescape(encodeURIComponent(svgString)));
        var svgData = svgString;
            // console.log(svgData);
        // create canvas in memory(not in DOM)
        var canvas = document.createElement('canvas');
            $('#' + svgEleId).parent().append(canvas);
            canvas.setAttribute('id',svgEleId + '_canvas');
        // get canvas context for drawing on canvas
        var context = canvas.getContext('2d');
        // set canvas size
        canvas.width = width;
        canvas.height = height;
        // create image in memory(not in DOM)
        var image = new Image();
        // later when image loads run this
        image.onload = function () { // async (happens later)
            // clear canvas
            context.clearRect(0, 0, width, height);
            // draw image with SVG data to canvas
            context.drawImage(image, 0, 0, width, height);
            // snapshot canvas as png
            var pngData = canvas.toDataURL('image/' + format);
            $('#' + svgEleId).parent().parent().html("<img id='"+svgEleId+"_canvas' src='"+pngData+"' alt='from canvas'/>")
            // pass png data URL to callback
        }; // end async
        // start loading SVG data into in memory image
        image.src = svgData;
    }

    $('.markClass').on('change', function() {
        total();    // call below function
    });

    // Total Points
    function total() {
        var sum = 0;
        $(".markClass").each(function(){
            sum += +$(this).val();
        });
        $("#totalMarks").text(sum);
        $("#totalMarksHidden").attr('value',sum);
    }

    // mark require validation
    $(".markClass").each(function() {
        var element = $(this);
        if (element.val() == "") {
            $(this).attr('required',true);
        }
        else{
            $(this).attr('required',false);
        }
    });

    function canvasToImg(id){
        // console.log(id);
        var c=document.getElementById(id);
        return c.toDataURL("image/png");
    }

    function togalswitch(examid){
        var mode= $('#toggle'+examid).prop('checked');
        $.ajax({
            type:'POST',
            url: site_url + "/exams/updateExamStatus/"+ examid,
            data: {
                "_token": "{{ csrf_token() }}",
                mode: mode,
                examid: examid
            },
            success:function(data)
            {
                var responseBlock ='<div class="alert alert-success">'+
                                    '<span class="glyphicon glyphicon-ok"></span>'+
                                    '{{Lang::get('exam.statusUpdate')}}'
                                        +'<button type="button" class="close" data-dismiss="alert" aria-label="close">'+
                                    '<span aria-hidden="true">&times;</span>'+
                                '</button>'+
                                '</div>';
                $(document).find('.msgBlock').html(responseBlock);
            }
        });
    }
</script>
<script>
    //Email send in exersice id get.
    function generateEmailUrl(id){
    $('#url').val($('#'+id).attr('data-exerciseset'));
    $('#share_mail').modal('show');
}

//Develop by WC
$(document).ready(function(){

    $("#share_email_form").validate({
        rules: {
            email: {
                required: true,
                email: true
            },
        },
        messages: {

        }
    });
})

</script>
@endpush