@extends('layouts.app')

@section('header_styles')
      <link rel="stylesheet" href="{{ asset('assets/css/eduplay.css') }}">
@endsection
@section('top')


        @include('myexercisesnavigation' ,[$ispublic=0])



@endsection

@section('content')

    <div class="panel panel-default">
        <div  class="container">
            <div class="exerciseset-form" id="exerciseset-form">

                <div >
                    <div class="col-xl-6 col-lg-6 col-sm-6 col-xs-12" id="exerciseset-details">
                        <div class="col-xl-12 col-lg-12 col-sm-12 col-xs-12"  style="">
                            <div class="col-xl-8 col-lg-8 col-sm-8 col-xs-12 header-title">Import Questions</div>
                            <div class="col-xl-4 col-lg-4 col-sm-4 col-xs-12" style="text-align: right ;">
                                <a href="{{ route('exercisesets.exerciseset.edit', $exerciseset->id ) }}" class="btn btn-edubtn" title="Edit Exerciseset">
                                    <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
                                </a>
                                <button type="submit" class="btn btn-edubtn" title="Delete Exerciseset" onclick="return confirm('Delete Exerciseset?')">
                                    <i class="fa fa-trash-o"></i>
                                </button>
                            </div>
                        </div>

                        <div class="col-xl-12 col-lg-12 col-sm-12 col-xs-12 main-box" >

                            <div class="col-xl-12 col-lg-12 col-sm-12 col-xs-12 exercise-blue">
                                <div class="col-xl-12 col-lg-12 col-sm-12 col-xs-12 ">
                                    <div class="col-xl-12 col-lg-12 col-sm-12 col-xs-12 exercise-title"> {{ $exerciseset->title }}</div>
                                </div>
                                <div class="col-xl-12 col-lg-12 col-sm-12 col-xs-12 ">

                                    <div class="col-xl-10 col-lg-10 col-sm-10 col-xs-12 exercise-description"> {!!  nl2br($exerciseset->description)  !!}</div>
                                </div>
                            </div>


                            <div class="col-xl-12 col-lg-12 col-sm-12 col-xs-12 exercise-gray">
                                <div class="col-xl-12 col-lg-12 col-sm-12 col-xs-12 ">
                                    <div class="col-xl-3 col-lg-3 col-sm-3 col-xs-4 title">Discipline :</div>
                                    <div class="col-xl-9 col-lg-9 col-sm-9 col-xs-8 title"> {{ optional($exerciseset->discipline)->discipline_name }}</div>
                                </div>

                                <div class="col-xl-12 col-lg-12 col-sm-12 col-xs-12 ">
                                    <div class="col-xl-3 col-lg-3 col-sm-3 col-xs-4 title">Grade :</div>
                                    <div class="col-xl-9 col-lg-9 col-sm-9 col-xs-8 title"> {{ optional($exerciseset->grade)->grade_name }}</div>
                                </div>

                                <div class="col-xl-12 col-lg-12 col-sm-12 col-xs-12 ">
                                    <div class="col-xl-3 col-lg-3 col-sm-3 col-xs-4 title">Language :</div>
                                    <div class="col-xl-9 col-lg-9 col-sm-9 col-xs-8 title"> {{ optional($exerciseset->language)->language }}</div>
                                </div>

                                <div class="col-xl-12 col-lg-12 col-sm-12 col-xs-12 ">
                                    <div class="col-xl-3 col-lg-3 col-sm-3 col-xs-4 title">Price :</div>
                                    <div class="col-xl-9 col-lg-9 col-sm-9 col-xs-8 title">$ {{ $exerciseset->price }}</div>
                                </div>

                                <div class="col-xl-12 col-lg-12 col-sm-12 col-xs-12 ">
                                    <div class="col-xl-3 col-lg-3 col-sm-3 col-xs-4 title-red">Updated At :</div>
                                    <div class="col-xl-9 col-lg-9 col-sm-9 col-xs-8 title-red"> {{ $exerciseset->updated_at }}</div>
                                </div>

                                <div class="col-xl-12 col-lg-12 col-sm-12 col-xs-12 ">
                                    <div class="col-xl-3 col-lg-3 col-sm-3 col-xs-4 title-red">Status :</div>
                                    <div class="col-xl-9 col-lg-9 col-sm-9 col-xs-8 title-red"> {{ $exerciseset->publish_status }}</div>

                                </div>
                                <div class="col-xl-12 col-lg-12 col-sm-12 col-xs-12 ">
                                    <div class="col-lg-12 exerci-head  all-star-rating" style="text-align: right;"><h6>All Rates:
                                            <span class="fa fa-star-o fa-1x " data-all-rating="1"></span>
                                            <span class="fa fa-star-o fa-1x" data-all-rating="2"></span>
                                            <span class="fa fa-star-o fa-1x" data-all-rating="3"></span>
                                            <span class="fa fa-star-o fa-1x" data-all-rating="4"></span>
                                            <span class="fa fa-star-o fa-1x" data-all-rating="5"></span>
                                            <input type="hidden" name="whatever1" class="avg-rating-value" value="{{$exerciseset->averageRating(1)[0]}}">
                                        </h6>

                                    </div>


                                </div>
                            </div>
                        </div>


                    </div>

                    <div class="col-lg-5">
                        <h3>Notes</h3>
                       <h4>This is a sample question / answers mark down syntax:</h4>
                        T: is the max duration<br>
                        D: is the level of difficulty<br>
                        tag: is any tag you want to add to this question<br>
                        H: is for hint.<br>
                        All the previous tags are optional<br>
                        \Q \T:'20' \D:'easy' \tag:'Skill2'<br>
                        \H:'here you type the hint for the answers of this exercise'<br>
                        {<br>
                        First Question how to recognize to respiratory system <img src='test.jpg'> continued value<br>
                        \A \C:'1' asnwer1 option here is displayed<br>
                        \A option2 is here dsiplaye<br>
                        \A answer option 3<br>
                        \A answer option 4<br>
                        }
                    </div>

                </div>

            </div>


            <div class="clear-line">
                <div class="col-xl-12 col-lg-12 col-sm-12 col-xs-12">

                <form method="POST" action="" accept-charset="UTF-8" id="create_exerciseset_form" name="create_exerciseset_form" class="">
                    {{ csrf_field() }}
                    <div class=" " style="padding-bottom: 10px">
                        <label for="title" class="col-md-2 control-label" style="text-align: left">Questions</label>
                        <div class="col-md-12">
                            <div class="col-md-12">
                                <textarea class="" name="details" cols="50" rows="10" id="details" required="true"></textarea>
                                {!! $errors->first('details', '<p class="help-block">:message</p>') !!}
                            </div>
                            <a href="javascript:;" onclick="alert(tinyMCE.get('details').getContent());return false;">[Get  HTML]</a>
                        </div>
                    </div>

                        <div class="col-md-offset-2 col-md-5">

                            <button type="button" class="btn btn-edubtn" data-toggle="button" aria-pressed="false" autocomplete="off" id="import">
                                Import Questions
                            </button>
                        </div>
                </form>
            </div>
            <div id="result"> </div>
            </div>
    </div>
    </div>
@endsection


@section('footer_scripts')
    <script type="text/javascript" src="{{ asset('assets/tinymce/js/tinymce/tinymce.min.js') }}"></script>
    <script>tinymce.init({ selector : "#details",plugins : ['fullscreen','image','media','table','eqneditor','imagetools','question','questionend','questionadd','wordcount'],toolbar: "fullscreen | image | media | table | eqneditor  | alignleft aligncenter alignright alignjustify | removeformat | question | questionend | questionadd | mybutton",menubar: false,

            setup: function(editor) {
                editor.addButton('mybutton', {
                    type: 'splitbutton',
                    text: 'Answer',
                    icon: false,

                    menu: [{
                        text: 'Answer',
                        onclick: function() {
                            editor.insertContent("\\A  ");
                        }
                    }, {
                        text: 'Correct Answer ',
                        onclick: function() {
                            editor.insertContent("\\A   \\C:'1' ");
                        }
                    }]
                });
            },
            filemanager_title:"Responsive Filemanager",
            image_advtab: true,
            external_filemanager_path:"{{ asset('assets/filemanager/') }}/",
            external_plugins: { "filemanager" : "{{ asset('assets/filemanager/plugin.min.js') }}" },
        });</script>

            <script type="text/javascript" src="{{ asset('assets/js/ExcerciseSetparser.js') }}"></script>


    <script type="text/javascript">//<![CDATA[
        $('#import').on('click', function () {
            $('#import').prop('disabled', true);
            (function(){

                parseText();
                //document.getElementById("parse").addEventListener("click", parseText);



                function parseText() {
                    var grammer;
                    try{

                        $.ajax({
                            url: '{{asset('assets/js/ExerciseSetgrammar.js') }}',
                            type: 'get',
                            async: false,dataType: "html",
                            success: function(html) {
                                grammer= html; // here you'll store the html in a string if you want
                               },

                        });


                        var text = $.trim(tinymce.get('details').getContent());
                        text =text.replace(/(<|&lt;)br\s*\/*(>|&gt;)/g," ");
                        text =text.replace(/(<|&lt;)p\s*\/*(>|&gt;)/g," ");
                        text =text.replace(/(<|&lt;)\s*\/*p(>|&gt;)/g," ");
                        text =text.replace("&nbsp;","");

                        var parser = PEG.buildParser(grammer);
                        console.log('parser=');
                        console.log(parser);
                        var result = parser.parse(text);


                      //  document.getElementById("result").textContent = JSON.stringify(result, null, 2);


                        $.ajax({
                            url: '{{ route('exercisesets.exerciseset.import',$exerciseset->id) }}',
                            type: 'POST',
                            dataType: "html",
                            data: {
                                "_token": "{{ csrf_token() }}",
                                "jsonString": JSON.stringify(result, null, 2)
                            },
                            success: function(html) {

                                window.location.href = '{{ route('exercisesets.exerciseset.show',[$exerciseset->id, $public=0]) }}';
                            },

                        });
                    }catch(err){
                        console.log('error');
                        console.log(err.toString());
                        document.getElementById("result").textContent = err;
                        $('#import').prop('disabled', false);
                    }
                }

            })();
        })//]]>

    </script>
@endsection