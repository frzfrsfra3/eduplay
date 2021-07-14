<!--Report A Problem Modal-->
<div class="modal fade default_modal wht_bg_mdl report_a_problem" id="Report_A_Problem" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="right_contnt text-ar-right">
                            <h3>@lang('practice.report_a_problem')</h3>
                            <p class="modal_p mrgn-bt-25">@lang('practice.you_can_tell_us')</p>
                            <form class="def_form" id="report_form">
                                <div class="form-group">
                                    <div class="rdio rdio-primary">
                                        <input name="problem" value="1" id="rdo_1" type="radio" checked="">
                                        <label for="rdo_1" style="color:black;">@lang('practice.the_answer_is_wrong')</label>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="rdio rdio-primary">
                                        <input name="problem" value="2" id="rdo_2" type="radio" checked="">
                                        <label for="rdo_2" style="color:black;">@lang('practice.i_caught_a_typo')</label>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="rdio rdio-primary">
                                        <input name="problem" value="3" id="rdo_3" type="radio" checked="">
                                        <label for="rdo_3" style="color:black;">@lang('practice.the_question_or_hints')</label>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="rdio rdio-primary">
                                        <input name="problem" value="4" id="rdo_4" type="radio" checked="">
                                        <label for="rdo_4" style="color:black;">@lang('practice.somthing_went_wrong')</label>
                                    </div>
                                </div>
                                <p class="modal_p mrgn-bt-25 mrgn-tp-35 gry_p">@lang('practice.alternatively')</p>
                                <div class="form-group">
                                    <input type="text" id="description" name="description" class="form-control" placeholder="@lang('practice.description_of_issue')" >
                                </div>
                                <input type="hidden" id="question_id"/>
                                <div class="form-group mrgn-tp-25">
                                    <button type="button" id="btn" onclick="submitReport()" class="btn btn-primary btn-login">@lang('practice.submit')</button>
                                </div>
                                <meta name="csrf-token" content="{{ csrf_token() }}" />
                                
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">

    function submitReport() { // Submit form via AJAX
        //console.log($('#hidden_que_id').val());
        $('#message').html('');
        $("#btn").text(message['please_wait']);
        $("#btn").attr('disabled',true);
        var URL = '{{ route("practice/report-problem")}}';
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            type : 'POST',
            url : URL,
            data : {'description' : $('#description').val() ,'problem' :$("input[name='problem']:checked").val(),'excersice_id' : $('#exerciseid').val(),'questionId': $('#hidden_que_id').val()} ,
            success:function(result){
                $("#btn").text(message['submit']);
                $("#btn").removeAttr('disabled');
                if (result.error == false) { // If Mail sended
                    //$('#message').html("<font color='green'>"+result.message+"</font>");
                    $('#message').html('<div class="alert alert-success"><i class="fa fa-check-square-o" aria-hidden="true"></i>'+result.message+' !!<button type="button" class="close" data-dismiss="alert" aria-label="close"><span aria-hidden="true">&times;</span></button></div>');

                    setTimeout(function(){ $('#Report_A_Problem').modal('toggle'); }, 100);
                } else {
                    $('#message').html('<div class="alert alert-danger"><i class="fa fa-check-square-o" aria-hidden="true"></i>'+result.message+' !!<button type="button" class="close" data-dismiss="alert" aria-label="close"><span aria-hidden="true">&times;</span></button></div>');
                }
                
            }
        });
    }
</script>
