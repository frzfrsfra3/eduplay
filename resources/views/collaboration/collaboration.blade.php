@extends('layouts.app')
@section('header_styles')
    <!-- Knowledgemap CSS  ============================================ -->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/knowledgemap.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/exam.css') }}">


@endsection

@section('top')
   @include('disciplinenavigation')
@endsection


@section('content')

    @php
        $color = array(
            1 => "#3ec1de",
            2 => "#49abe1",
            3 => "#5a87e5",

            );

    @endphp

    <div id="htmdata" class="alert alert-danger" style=" display:none"></div>

    @if(Session::has('message_text'))
        <div class="alert alert-success">
            <i class="fa fa-info-circle" aria-hidden="true"></i>
            {!! session('message_text') !!}

            <button type="button" class="close" data-dismiss="alert" aria-label="close">
                <span aria-hidden="true">&times;</span>
            </button>

        </div>
    @endif

    @if(Session::has('message_error'))
        <div class="alert alert-danger">
            <i class="fa fa-info-circle" aria-hidden="true"></i>
            {!! session('message_error') !!}
            <button type="button" class="close" data-dismiss="alert" aria-label="close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif


    <div id="maindiv" class="container">
               <div class="row">
            <div id="skillcategoriesdiv" class="col-xl-4 col-md-4 col-lg-4 clear-padding-left-right" align="left" style="position: relative;">


                    <ul style="list-style: none; " >
                        <li class="box-title ">Skill category</li>
                        <li style=" display: inline; float: right; padding-right: 7%; ">
                            <button id="addnewskillcategory" class="addnewskillcategory2" type="button"
                                    onclick="" data-toggle="modal" data-target="#addnewskillcategoryModal"
                                    data-discipline_id="{{$discipline->id}}">+
                            </button></li>
                    </ul>

                 <div style="clear: both;  ">


                         <div class=" scroll-list-collaboration scroll-style " >
                        <ol id="ol_categories"   class="simple_with_animation1 " class="list-group list-group-flush" style="padding:0 ; margin:0 7px 0 0 ;">
                            @php($i=0)
                            @foreach ($skillcategories as  $skillcategory)
                                @php  ($i++)
                                <div id="html_skillcategory{{$skillcategory->id}}" >
                                @include ('collaboration.oneskillcategory', [ $skillcategory,$message_text ,$i  ])
                                </div>
                           @endforeach
                        </ol>
                         </div>
                     </div>
            </div>

            <div id="skilldiv" class="col-xl-8 col-md-8 col-lg-8 clear-padding-left-right" align="left">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    @if (Auth::user())
                        @if (Auth::user ()->can ('collaborate', $discipline))

                            <div style="float: right ;margin-left: 5px" >
                                <a href="{{ route('knowledgemap.index', $discipline->id ) }}"  class="button btn btn-edubtn" >Knowledgemap</a>
                            </div>

                        @endif
                    @endif
                @can ('coordinate', $discipline)

                <li style=" display: inline;  padding-right: 0%; float: right; margin-bottom: 3px; ">
                <a href="{{route('publishing.discipline.publish',$discipline->id ) }}" id="publish{{$discipline->id}}"  type="button"
                onclick=""     class="publishbutton    btn" >Publish </a></li>
                @endcan
               <li class="box-title "> {{$discipline->description}}</li>
                </div>
                @foreach ($skillcategories as  $skillcategory)
                    @php($skills=$skillcategory->skillofsameversion($lastversion )->get())

                    <div class="col-md-12 col-sm-12 col-xs-12" id="div-{{$skillcategory->id}}" >
                    <nav  class=" accordion col-md-12 col-sm-12 col-xs-12"  style="background-color: {{$color[rand(1,3)]}};" >
                    <a id="acc_btn{{$skillcategory->id}}"  >
                        <div class="col-md-6 col-sm-12 col-xs-12" >
                       <b>{{$skillcategory->skill_category_name}}</b>&nbsp&nbsp&nbsp
                        </div>
                        <div class="col-md-5 col-sm-9 col-xs-9" style="text-align: right" >
                       <span style="font-size: 10px "> {{$skills->count().' Skills'}} </span>
                        @if ( $skillcategory->count_of_skill_children($lastversion )>0 )
                        <span class="neweditskill" >&nbsp {{$skillcategory->count_of_skill_children($lastversion )}}  new or edited </span>
                        @endif
                        </div>
                    </a>
                    </nav>
                    <nav class="panel col-md-12 col-sm-12 col-xs-12 " id="nav{{$skillcategory->id}}">
                        <ol id="cat{{$skillcategory->id}}" data-ol="ol2" class="simple_with_animation"
                            class="list-group" class="vertical" class="panel"  style="padding:0 15px 0 2px; margin:0;">
                            <li class="add-new-skill-button col-md-9 col-sm-12 col-xs-12" style="padding-top: 8px">

                                <span class="skill-cat-description" >  {{$skillcategory->skill_category_decsription}}</span>
                            </li>
                            <li class="add-new-skill-button col-md-3 col-sm-12 col-xs-12 " style="text-align: right">
                            <button id="but{{$skillcategory->id}}"  type="button"
                                onclick=""     class="addnewskillcategory"
                                data-toggle="modal" class="addbutton btn" data-target="#myModal"
                                    data-skillcategory_id="{{$skillcategory->id}}">
                                Add new skill
                            </button>
                            </li>


                            @foreach($skills as $skill)

                                @include ('collaboration.oneskill', [ $skill,  ])

                            @endforeach

                        </ol>

                    </nav>

                        </div>
                @endforeach


            </div>
        </div>

        <!-- Modal --------------------------------------------------------------------------------------------------------------------------------------->
        <div class="modal fade" id="myModal" role="dialog">
            @include ('collaboration.createskillmodalform')
        </div>
        <!-- Modal ---------------------------------------------------------------------------------------------------------------------------------------------->

        <!-- edit modal skill ------------------------------------------------------------------------------------------------------------------------------------->

        <div class="modal fade" id="editskillModal" role="dialog">
            @include ('collaboration.editskillmodal')

        </div>

        <!-- Modal --------------------------------------------------------------------------------------------------------------------------------------->
        <div class="modal fade" id="addnewskillcategoryModal" role="dialog">
            @include ('collaboration.createskillcatmodalform')
        </div>
        <!-- Modal ---------------------------------------------------------------------------------------------------------------------------------------------->


    </div>
@endsection
@section('footer_scripts')
    <script>
        var adjustment;
        var group = $("ol.simple_with_animation1").sortable({
            group: 'simple_with_animation1',
            delay: 500,
            distance: 0
        })
    </script>
    <script>
        $('#create_skill_form').submit(function (event) {
            $('#myModal').modal('hide');
        });

        $('#edit_skill_form').submit(function (event) {
            $('#editskillModal').modal('hide');

        });

        $('#myModal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget) // Button that triggered the modal
            var recipient = button.data("skillcategory_id") // Extract info from data-* attributes
            // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
            // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
            var modal = $(this)
            modal.find('#skill_category_id').val(recipient)
            modal.find('#skill_description').val('')
            modal.find('#id_from').val(1)
        })


        $('#editskillModal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget) // Button that triggered the modal
            var recipient = button.data("skill_id") // Extract info from data-* attributes
            // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
            // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
            var modal = $(this)
            modal.find('#origin_id').val(recipient)
            modal.find('#id_from').val(2)

        });


        $('#addnewskillcategoryModal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget) // Button that triggered the modal
            var recipient = button.data("discipline_id") // Extract info from data-* attributes
            // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
            // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
            var modal = $(this)
            modal.find('#discipline_id').val(recipient)
            modal.find('#origin_id').val(recipient)
            modal.find('#id_from').val(1)

        });


        $('#editskillcategoryModal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget) // Button that triggered the modal
            var recipient = button.data("skill_category_id") // Extract info from data-* attributes
            // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
            // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
            var modal = $(this)
            modal.find('#origin_id').val(recipient)
            modal.find('#id_from').val(2)

        });

    </script>

    <script>

        function edit_skill(skill_url) {


            $.ajax({
                type: "GET",
                dataType: "html",
                url: skill_url,

                data: {
                    "_token": "{{ csrf_token() }}",
                },
                success: function (response) {
                    $('#htmlid').html(response);
                }
            })
        }


        function edit_skill_category(skill_cat_url) {

            $.ajax({
                type: "GET",
                dataType: "html",
                url: skill_cat_url,

                data: {
                    "_token": "{{ csrf_token() }}",
                },
                success: function (response) {
                    $('#html_skillcategory').html(response);
                }
            })
        }

    </script>

    <script>
        var adjustment;

        var group = $("ol.simple_with_animation").sortable({
            group: 'simple_with_animation',
            delay: 500,
            distance: 0,

// animation on drop
            onDrop: function ($item, container, _super) {
                var $clonedItem = $('<li/>').css({height: 0});

                $item.before($clonedItem);


                var data = group.sortable("serialize").get();
                var jsonString = JSON.stringify(data, null, ' ');

                jsonString = jsonString.replace("[\n" +
                    " [", "[");
                jsonString = jsonString.replace("]\n" +
                    "]", "]");
                jsonString = jsonString.replace("{},", "");
                jsonString = jsonString.replace("],\n" + " [", ",");

                console.log((jsonString));
                $.ajax({
                    type: "POST",
                    url: "{!! route('collaborationController.sortskill') !!}",
                    data: {
                        "_token": "{{ csrf_token() }}",
                        "jsonString": jsonString
                    },
                    success: function () {
                        console.log("data sent");
                    }
                })

//   $clonedItem.animate({'height': $item.height()});
                $item.animate($clonedItem.position(), function () {
                    $clonedItem.detach();
                    _super($item, container);
                });
            },

// set $item relative to cursor position
            onDragStart: function ($item, container, _super) {
                var offset = $item.offset(),
                    pointer = container.rootGroup.pointer;
                adjustment = {
                    left: pointer.left - offset.left,
                    top: pointer.top - offset.top
                };
                _super($item, container);
            },
            onDrag: function ($item, position) {
                $item.css({
                    left: position.left - adjustment.left,
                    top: position.top - adjustment.top
                });
            }
        });

    </script>
    <script>
        var acc = document.getElementsByClassName("accordion");
        var i;

        for (i = 0; i < acc.length; i++) {

            acc[i].addEventListener("click", function () {
                this.classList.toggle("active");
                var panel = this.nextElementSibling;
                if (panel.style.maxHeight) {
                    panel.style.maxHeight = null;
                } else {
                    panel.style.maxHeight = panel.scrollHeight + "px";
                }
            });
        }
    </script>


    <script>
        $('#maindiv').scroll(function() {
            $('#skillcategoriesdiv').css('top', $(this).scrollTop());
        });

        $(".addbutton").click(function () {
            var panel = $(this).closest('nav');
            var panel = $(this).closest('nav');
            idnav = ($(this).closest('nav').attr('id'));
            h = (document.getElementById(idnav).scrollHeight);
            $(".addbutton").closest('nav').css('maxHeight', '');
            $(".addbutton").closest('nav').css('maxHeight', h + "px");
        });

    </script>

    <script>
    </script>

    <script>
        function addali(skillcategory) {
         //
            //   alert('skill category  id =' + skillcategory);

            var ol = document.getElementById(skillcategory).parentNode;

            var olid = ol.id;
            var lasliId = (ol.lastElementChild.id);
            var li = document.createElement("li");
            li.appendChild(document.createTextNode(""));
            li.setAttribute("id", "element4"); // added line
            li.setAttribute("data-paranet", "xx");
            li.setAttribute("data-id1", "c9");
            li.setAttribute("class", "list-group-item");
            ol.appendChild(li);


        }

        function addspan(skillid) {

            var editspanexist = document.getElementById("sapn" + skillid);
            if ($("#span" + skillid).length) {

                //        "the span exist");
            }
            else {
                // create a new span
                var butonid = "spanbuton" + skillid
                var li = document.getElementById(butonid).parentNode;
                var span = document.createElement("span");
                span.appendChild(document.createTextNode(".."));
                span.setAttribute("id", "span" + skillid);
                linebreak = document.createElement("br");
                li.appendChild(linebreak);
                li.appendChild(span);
            }

        }

    </script>


    <script>

        $(document).ready(function () {
            idnav = "nav{!! session('skill_category_id') !!}";
            h = (document.getElementById(idnav).scrollHeight);
            $("#acc_btn{!! session('skill_category_id') !!}").addClass( "active" );
            var panel = document.getElementById(idnav);
            panel.style.maxHeight = panel.scrollHeight + "px";

        });


        $(document).ready(function () {

            $(".a_cat").on('click', function(event) {
                skill_categoryid =$(this).data('a_skillcategoryid');
                idnav = "nav"+ skill_categoryid;
                h = (document.getElementById(idnav).scrollHeight);
                var panel = document.getElementById(idnav);
              // alert("#acc_btn"+skill_categoryid)

                if (panel.style.maxHeight) {
                    $("#acc_btn"+skill_categoryid).removeClass( "active" );
                    panel.style.maxHeight = null;
                } else {
                    $("#acc_btn"+skill_categoryid).addClass( "active" );
                    panel.style.maxHeight = panel.scrollHeight + "px";
                }
             //   location.hash="#nav"+skill_categoryid;
                location.href="#div-"+skill_categoryid;
 });

        });


    </script>


    {{--/*
    Publishing scripts
    --------------------------------------------------------------------------------
    */--}}

    <script>
        function accept(url,skillid) {

            var  skill_parent_id=$(this).data('skill_parent_id');

            $.ajax({
                type: "GET",
                dataType: "html",
                url: url,
                data: {
                    "_token": "{{ csrf_token() }}",
                },
                success: function (response) {

                    $('#html_skill'+skillid).html(response);
                }
            })
        }

    </script>


    <script>
        function accept_category(url,skillid) {

            var  skill_parent_id=$(this).data('skill_parent_id');

            $.ajax({
                type: "GET",
                dataType: "html",
                url: url,
                data: {
                    "_token": "{{ csrf_token() }}",
                },
                success: function (response) {

                    $('#html_skillcategory'+skillid).html(response);
                }
            })
        }

    </script>


    <script>
        function reject(url,skillcategory_id) {

            console.log(url);
            $.ajax({
                type: "GET",
                dataType: "html",
                url: url,
                data: {
                    "_token": "{{ csrf_token() }}",
                },
                success: function (response) {

                    $('#html_skill'+skillcategory_id).html(response);
                    console.clear();
                }
            })
        }

    </script>


    <script>
        function reject_category(url,skillcategory_id) {


            $.ajax({
                type: "GET",
                dataType: "html",
                url: url,
                data: {
                    "_token": "{{ csrf_token() }}",
                },
                success: function (response) {

                    $('#html_skillcategory'+skillcategory_id).html(response);
                }
            })
        }

    </script>


    <script>
        function publish(discipline_id) {

            var id = discipline_id;
          //  var x = " 'dddd' " + id;
            var url = '{{ route("publishing.discipline.publish", ":id") }}';
            url = url.replace(':id', id);
            //   alert (  url)
            $.ajax({
                type: "GET",
                dataType: "html",
                url: url,
                data: {
                    "_token": "{{ csrf_token() }}",
                },
                success: function (response) {


                }
            })
        }
        //---------------------- End Publsihing Scripts *------------------------------
    </script>

    <script>
        $(document).ready(function(){
            $('[data-toggle="tooltip"]').tooltip();
        });
    </script>

@endsection