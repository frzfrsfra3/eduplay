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
             <div id="skilldiv" style="float:left">

              {{$discipline->description}}

             </div>

                 @if (Auth::user())
                     @if (Auth::user ()->can ('collaborate', $discipline))

                         <div style="float: right ;margin-right: 14px ; margin-top: 5px" >
                             <a href="{{ route('collaboration.index', $discipline->id ) }}" class="button btn btn-edubtn" >Collaborate</a></div>

                     @endif
                 @endif


            <div  style="float: right;padding-right: 15px">

                <select id="groupbyselection" class="selectpicker selectgroup"  data-style="btn-primary"  style="border-radius: 25px">
                    <option value="1" selected>Grouped by grades</option>
                    <option value="2" >Grouped by skill categories</option>

                </select>


             </div>
             </div>

                 @foreach ($grades as  $grade)
                     <div class="row">
                 <b><div class="grades">    {{$grade->grade_name}}<br>  </div></b>
                         @php ( $i=0 ) @endphp

                @foreach ($skillcategories as  $skillcategory)

                             @php

                                 $skills=$skillcategory->skillofsameversion($lastversion )->get();
                                 $skills=$skills->where('grade_id', '=' ,$grade->id);
                                   $showgride=0;
                                    if ($skills ->count()<>0) $i++
                               //  dd($skills->count());
                             @endphp

                     @include ('knowledgemap.oneskillcategory', [ $skillcategory ,$grade ,$skills ,$showgride ,$i])

                @endforeach
                     </div>


                @endforeach


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
          if (slectedid==2) {
              window.location.href = "{{route('knowledgemap.skillcategories.index',$discipline->id)}}";

          }

        });

    </script>

    <script>
        $(document).ready(function(){
            $('[data-toggle="tooltip"]').tooltip();
        });
    </script>


@endsection