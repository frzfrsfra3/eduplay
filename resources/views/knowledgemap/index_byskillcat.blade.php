@extends('layouts/app')
@section('header_styles')
    <!-- Knowledgemap CSS  ============================================ -->
 <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/knowledgemap.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/eduplay.css') }}">

    <link rel="stylesheet" href="{{ asset('assets/css/knowledgemap_updated.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap-select.min.1.7.5.css') }}">
@endsection

@section('top')
    @include('disciplinenavigation')
@endsection
@section('content')

    <div id="htmdata" class="alert alert-danger" style=" display:none"></div>
    <div id="maindiv" class="container">
        <div class="row">
            <div id="skilldiv" class="" style="alignment: left;float: left">

                {{$discipline->description}}<br>
            </div>

            @if (Auth::user())
                @if (Auth::user ()->can ('collaborate', $discipline))

                    <div style="float: right ;margin-right: 14px ; margin-top: 5px" ><a href="{{ route('collaboration.index', $discipline->id ) }}" class="button btn btn-edubtn" >Collaborate</a></div>

                @endif
            @endif

            <div  class="groupby">

                <select id="groupbyselection" class="selectpicker selectgroup"  data-style="btn-primary" >
                    <option value="1" >Grouped by grades</option>
                    <option value="2" selected >Grouped by skill categories</option>

                </select>


            </div>
        </div>
        <div class="row">

            @php ( $i=0 ) @endphp
                @foreach ($skillcategories as  $skillcategory)
                             @php
                                 $skills=$skillcategory->skillofsameversion($lastversion )->get();
                                    $showgride=1;
                                    $i++;
                               //  dd($skills->count());
                             @endphp
                     @include ('knowledgemap.oneskillcategory', [ $skillcategory  ,$skills ,$showgride ,$i])

                @endforeach


        </div>
    </div>
@endsection


@section('footer_scripts')
    <script type="text/javascript" src="{{ asset('assets/js/bootstrap-select.min.1.7.5.js') }}"></script>
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

    <script>
        $('#groupbyselection').on('changed.bs.select', function (e , clickedIndex) {
            // do something...
            var slectedid=  $('#groupbyselection').val();
            if (slectedid==1) {
                window.location.href = "{{route('knowledgemap.index',$discipline->id)}}";

            }

        });

    </script>

    <script>
        $(document).ready(function(){
            $('[data-toggle="tooltip"]').tooltip();
        });
    </script>


@endsection