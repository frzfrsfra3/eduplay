@extends('layouts/app')
@section('header_styles')
    <!-- Knowledgemap CSS  ============================================ -->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/knowledgemap.css') }}">
@endsection

@section('top')
    <div class="panel-heading clearfix">
        <div class="container">
            <ul style="list-style-type: none; padding:0;">
                <li style=" float: left;">


                    <h4 style="color: #fff;">   <a href="{{ route('disciplines.discipline.index') }}" style="color: #fff;" >Explore </a> -{{ $discipline->discipline_name}}:
                <span style="font-size: 10px"   >Published v.{{$lastversion}}</span> </h4></li>
                <li style="  float: right; padding-top: 10px; padding-left: 10px;">

                    <ul class="breadcrumb-edu">
                        <li><a href="{{ route('knowledgemap.index', $discipline->id ) }}"  class="active-edu" >Knowledgemap</a></li>
                        @if (Auth::user())
                            @if (Auth::user ()->can ('collaborate', $discipline))
                        <li><a href="{{ route('collaboration.index', $discipline->id ) }}" >Collaborate</a></li>

                          @endif
                            @endif

                    </ul>
                </li>
            </ul>
        </div>
    </div>
@endsection
@section('content')

    <div id="htmdata" class="alert alert-danger" style=" display:none"></div>
    <div id="maindiv" class="container">
               <div class="row">
            <div id="skillcategoriesdiv" class="col-md-4 col-lg-4" align="left" style="position: relative;">

                       <div>
                    <ul style="list-style: none; padding: 0;" >
                        <li style=" display: inline; float: left; padding-top: 5px"><h4>Skill category</h4></li>
                    </ul>
                </div>
                 <div style="clear: both;  ">
                    <ul  >
                        <ol id="ol_categories"    class="list-group list-group-flush" style="padding:0; margin:0;">

                            @foreach ($skillcategories as  $skillcategory)
                                <div id="html_skillcategory{{$skillcategory->id}}" >
                                @include ('knowledgemap.oneskillcategory',  $skillcategory )
                                </div>
                           @endforeach
                        </ol>
                    </ul>
                   </div>
            </div>
            <div id="skilldiv" class="col-md-8 col-lg-8" align="left">

               <h4> Introduction :</h4>{{$discipline->description}}

                @foreach ($skillcategories as  $skillcategory)
                    @php($skills=$skillcategory->skillofsameversion($lastversion )->get())
                <div class="row" id="div-{{$skillcategory->id}}">
                    <button id="acc_btn{{$skillcategory->id}}" class="accordion"><b>{{$skillcategory->skill_category_name}}</b>
                       <span style="font-size: 10px ; font-size: 11px ;color: #00c4f9;"> {{$skills->count().' Skills'}} </span>

                    </button>
                    <nav class="panel" id="nav{{$skillcategory->id}}">
                        <ol id="cat{{$skillcategory->id}}" data-ol="ol2"
                            class="list-group" class="vertical" class="panel"  style="padding:0 0 2px; margin:0;">
                            {{$skillcategory->skill_category_decsription}}
                            <br>
                            @foreach($skills as $skill)
                                <div id="html_skill{{$skill->id}}" >
                                @include ('knowledgemap.oneskill', [ $skill,  ])
                                </div>
                            @endforeach

                        </ol>
                    </nav>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection


@section('footer_scripts')
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
        $('#maindiv').scroll(function() {
            $('#skillcategoriesdiv').css('top', $(this).scrollTop());
        });




        $(document).ready(function () {

            $(".a_cat").on('click', function(event) {
                skill_categoryid =$(this).data('a_skillcategoryid');
                idnav = "nav"+ skill_categoryid;
              //  alert (idnav)
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
              //  location.hash  ="#nav"+skill_categoryid;
                location.href="#div-"+skill_categoryid;

            });

        })


        </script>




@endsection