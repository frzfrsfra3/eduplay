@extends('layouts.app')

@section('header_styles')
    <style>
        .underlined_div {
            border-bottom:solid  1px #b9bbbe ;
        }

        .btn-circle {
            width: 50px;
            height: 28px;
            text-align: center;
            padding: 2px 2px;
            font-size: 13px;
            line-height: 1.428571429;
            border-radius: 15px;
        }

    </style>
@endsection


@section('content')

    <div class="container">
        <div class="row">
            <div id="skillcategoriesdiv" class="col-md-12">
                @if(count($skillcategories) == 0)
                    <div class="panel-body text-center">
                        <h4>No Skills category Available!</h4>
                    </div>
                @else

                    <div>
                        <sapn>{{$discipline_name}}</sapn>
                        <code>Published Version: {{$lastversion}}</code>
                    </div>
                    <div>
                        <ol id="ol_categories" class="simple_with_animation1 " class="list-group list-group-flush">
                            @foreach ($skillcategories as  $skillcategory)

                                <div id="html_skillcategory{{$skillcategory->id}}" >
                                @include ('publishing.oneskillcategory', [ $skillcategory,  ])
                                </div>
                            @endforeach
                        </ol>
                    </div>
            </div>
        </div>
        <div class="row">
            <div id="skilldiv" class="col-md-12 ">
                <div ><b>Skills :</b></div>
                @foreach ($skillcategories as  $skillcategory)
                    <ol id="cat{{$skillcategory->id}}" data-ol="ol2" class="simple_with_animation"
                        class="list-group" class="vertical" class="panel" >
                        @php($skills=$skillcategory->skillofsameversion($lastversion )->get())
                        @foreach($skills as $skill)
                            <div id="html_skill{{$skill->id}}" >
                            @include ('publishing.oneskill', [ $skill  ])
                            </div >

                        @endforeach
                    </ol>
                @endforeach
            </div>



        </div>

        <div class="row">
            <div id="skillcategoriesdiv" class="col-md-12" align="center">
                <input id="disciplineid" value="{{$disciplineid}}" type="hidden">
                <button id="publish" type="button"
                        class="edit-button btn btn-primary ">Publsih

                </button>
                <br>
            </div>
            <div id="skilldiv" class="col-md-12 " align="left">
                <div id="htmdata" class="alert alert-danger" style=" display:none"></div>
            </div>
        </div>
            <div class="panel-footer" align="center">
                {!! $skillcategories->render() !!}
            </div>
        </div>
    </div>
        @endif
        @endsection

        @section('footer_scripts')

            <script>
                $('#publish').click(function () {
                    var id = $('#disciplineid').val();
                    var x = " 'dddd' " + id;
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
                            $('#htmdata').show();

                            $('#htmdata').html(response);

                        }
                    })
                });
            </script>

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
                function reject(url,skillid) {


                    $.ajax({
                        type: "GET",
                        dataType: "html",
                        url: url,
                        data: {
                            "_token": "{{ csrf_token() }}",
                        },
                        success: function (response) {

                            $('#html_skill'+skillid).html(response);
                            console.clear();
                        }
                    })
                }

            </script>


            <script>
                function reject_category(url,skillid) {


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





        @endsection