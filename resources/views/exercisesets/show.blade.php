@extends('layouts.app')
@section('header_styles')
    <link rel="stylesheet" href="{{ asset('assets/css/nestable.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/eduplay.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap-confirm-delete.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/star-rating.css') }}">
    <style>.mce-menu {position:fixed !important}
    .control-label{padding: 5px 0 0 2px}
    </style>
@endsection
@section('top')



                   @include('myexercisesnavigation' ,[$ispublic=0])


@endsection

@section('content')

<div class="panel panel-default">

    <div class="container">
        <div class="exerciseset-form" id="exerciseset-form">
            <div class="col-xl-12 col-lg-12 col-sm-12 col-xs-12 all-padding" id="exerciseset-details">
                    <div class="col-xl-12 col-lg-12 col-sm-12 col-xs-12 all-padding"  style="">
                        <div class="col-xl-8 col-lg-8 col-sm-8 col-xs-12 header-title">Description & Details</div>
                        <div class="col-xl-4 col-lg-4 col-sm-4 col-xs-12 header-bottun" >
                                @php if ($exerciseset->publish_status=='public') {$var1="public";$var2="private";} else {$var1="private";$var2="public";} @endphp
                                <a class="btn  btn-edubtn" href="javascript:void(0);" onclick="changeAccess('{{$exerciseset->id}}','{{$var2}}');">&nbsp{{$var1}}</a>
                            <a href="{{ route('exercisesets.exerciseset.importform',$exerciseset->id) }}" id="addanswer"  data-direction="right" class="btn btn-edubtn">+ Import Bulk</a>&nbsp;&nbsp;
                            <a href="{{ route('exercisesets.exerciseset.edit', $exerciseset->id ) }}" class="btn btn-edubtn"  title="Edit Exerciseset">
                                <i class="fa fa-pencil-square-o" aria-hidden="true" style="font-size: 18px"></i>
                            </a>

                            <button type="submit" class="btn btn-edubtn" title="Delete Exerciseset" onclick="return confirm('Delete Exerciseset?')">
                                <i class="fa fa-trash-o"  style="font-size: 20px"></i>
                            </button>
                        </div>
                    </div>
                    @include ('exercisesets.details', [
                                    'exerciseset' => $exerciseset,
                                  ])

            </div>
            <div class="col-xl-12 col-lg-12 col-sm-12 col-xs-12 all-padding">
                <div class="question-button-details-left-align">
                    <a href="#" id="addquestion" data-target="#editskillModal" data-toggle="modal" data-direction="right"
                       class="btn btn-orange-questions show-modal addquestions" data-backdrop="static" data-keyboard="false"
                       data-edit-link="{{ route('questions.question.add_question') }}" style="margin-bottom: 5px !important;  float:left;">+ Create Question</a>

                </div>
                <div >
                    <a href="{{route('passages.passage.index' ,[$exerciseset->id])}}" id="listofpassages"
                       class="btn btn-orange-questions "
                       style="margin-bottom: 5px !important;  float:left;">Passages List</a>

                </div>
            </div>
        <div class="col-xl-12 col-lg-12 col-sm-12 col-xs-12 all-padding" id="questiondiv" >
          {!! $nestquestion !!}  </div>

        <div class="col-xl-12 col-lg-12 col-sm-12 col-xs-12 all-padding">
            <div class="question-button-details-left-align">
                <a href="#" id="addquestion" data-target="#editskillModal" data-toggle="modal" data-direction="right" class="btn btn-orange-questions show-modal addquestions" data-backdrop="static" data-keyboard="false"  data-edit-link="{{ route('questions.question.add_question') }}" style="float:left;">+ Create Question</a>

            </div>


        </div>
    </div>
    </div>
</div>

<div class="modal fade " id="editskillModal" role="dialog"  aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <!-- Modal content-->
        <div class="modal-content ">
            <div class="modal-header">
                <button aria-label="Close" data-dismiss="modal" class="close" type="button"><span aria-hidden="true"><i class="fa fa-times-circle" aria-hidden="true"></i></span></button>
                <h4 id="gridSystemModalLabel" class="modal-title">Question</h4>
            </div>

            <div class="panel-body ">
                @if ($errors->any())
                    <ul class="alert alert-danger">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                @endif

                <form method="POST" action="" id="questionform" accept-charset="UTF-8" enctype="multipart/form-data" id="edit_skill_form" class="form-horizontal">
                    {{ csrf_field() }}

                    <div  id="htmlid"></div>



                </form>
            </div>
        </div>
    </div>
</div>

@endsection

@section('footer_scripts')

    <script src="{{ asset('assets/js/jquery.nestable.js') }}"></script>
    <script src="{{ asset('assets/js/bootstrap-confirm-delete.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/js/star-rating.js') }}"></script>

    <script src="{{asset("assets/js/clock.js")}}"></script>
    <script>

        var $star_rating1 = $('.all-star-rating .fa');
        var SetRatingStar = function() {
            return $star_rating1.each(function() {
                if (parseInt($star_rating1.siblings('input.avg-rating-value').val()) >= parseInt($(this).data('all-rating'))) {
                    return $(this).removeClass('fa-star-o').addClass('fa-star');
                } else {
                    return $(this).removeClass('fa-star').addClass('fa-star-o');
                }
            });
        };
        SetRatingStar();
        $(document).ready(function() {
        });



        //add new question
        $('.addquestions').on('click', function () {
            $('html, body').animate({
                scrollTop: 0
            }, 100);

            $('#gridSystemModalLabel').text("Add Question");
             $.ajax({
                type: "POST",
                dataType: "html",
                url: $('#addquestion').data('edit-link'),
                data: {
                    "_token": "{{ csrf_token() }}",
                    "sid": "{{ $exerciseset->id}}",
                    "ad": "2",
                } ,
                success:function(response) {
                    $('#htmlid').html(response);
                    $(".modal").modal({
                        backdrop: 'static',
                        keyboard: false
                    });

                }
            })
        });


        //add and edit   answer
        function addrecords(id,urli,title,isans){
            $('html, body').animate({
                scrollTop: 0
            }, 100);

            $('#gridSystemModalLabel').text(title);
            $.ajax({
                type: "POST",
                dataType: "html",
                url: urli,
                data: {
                    "_token": "{{ csrf_token() }}",
                    "sid": id,
                    "ans": isans,
                } ,
                success:function(response) {
                    $('#htmlid').html(response);
                    $(".modal").modal({
                        backdrop: 'static',
                        keyboard: false
                    });
                }
            })
        };

        // acction insert and update question
        $('#questionform').submit(function( event ) {

            tinyMCE.triggerSave();
            event.preventDefault();
            var form = $('#questionform')[0];

            // Create an FormData object
            var data = new FormData(form);

            $.ajax({
                url: $('#btnSave').data('edit-link'),
                type: 'POST',

                enctype: 'multipart/form-data',
                data: data,
                    : false,
                contentType: false,
                cache: false,
                "_token": "{{ csrf_token() }}",


                success: function( response ) {
                    if($('#maxtime').length){

                        $('.modal').modal('hide')
                        if ($("#qid").text() === '0') {
                            if ($('#noquestion').length) {
                                $('#noquestion').remove();
                            }
                            $("#nestable").append(response)
                        }
                        else {
                            $('#ques' + $("#qid").text()).html($('#details').val())
                        }
                    }
                    else{

                        $('.modal').modal('hide')
                        var t=$("#question_id").val();
                        var st="collapse"+t;

                        $('#answerModal').modal('hide')

                        if ($("#aid").text() === '0') {
                            $("#"+st).append(response)
                        }
                        else {
                            $('#ans' + $("#aid").text()).html(response)


                        }
                    }
                },
            })
        });

        //delete question and related answer
        function deletequestion(id,url,tid){


            if (confirm('Are you sure you want to delete this?')) {
                $.ajax({
                    type: "delete",
                    dataType: "html",
                    url: url,
                    data: {
                        "_token": "{{ csrf_token() }}",
                        "qid": id,

                    } ,
                    success:function(response) {
                        if (tid == 1) {
                            $('#que_ans' + id).remove();
                        }
                        if (tid==2) {
                            $('#re_ans' + id).remove();
                        }
                        alert(response)

                    }
                })
            }


        }
    </script>

    <script>
        function myFunction(val) {
            document.getElementById("timeslider").innerHTML = val;
        }




        $(document).ready(function(){

            $('.delete_botton').click(function(){

                var urli = $(this).attr('data-link-title');

                $.confirm({
                    'title'		: 'Delete Confirmation',
                    'message'	: 'You are about to delete this item.',
                    'buttons'	: {
                        'Yes'	: {
                            'class'	: 'blue',
                            'action': function(){
                                $.ajax({
                                    type: "delete",
                                    dataType: "html",
                                    url: urli,
                                    data: {
                                        "_token": "{{ csrf_token() }}",
                                    } ,
                                    success:function(response) {
                                        $('#' + response).remove();
                                    }
                                })
                            }
                        },
                        'No'	: {
                            'class'	: 'gray',
                            'action': function(){}	// Nothing to do in this case. You can as well omit the action property.
                        }
                    }
                });

            });

        });

        $(document).ready(function(){
            $('[data-toggle="tooltip"]').tooltip();
        });

        $( document ).ready(function() {
            console.log( "ready!" );

            clock_init();

        });

    </script>
@endsection

