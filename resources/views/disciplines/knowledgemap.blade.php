@section('header_styles')

    <!-- Knowledgemap CSS  ============================================ -->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/knowledgemap.css') }}">

@endsection

<script>

    function myFunction(id) {
        if($('#collapse'+id).is(":hidden"))
        {
            $('#collapse'+id).toggle('slow');
        }
            location.hash="#loop"+id;
    }

    function colleping(id) {
        if($('#collapse'+id).is(":hidden"))
        {
            $('#collapse'+id).toggle('slow');
        }
        else {
            $('#collapse'+id).toggle('hide');
        }
    }

    function getdata () {
       var t = document.getElementById("grade_id");
       var selectedText = t.options[t.selectedIndex].id;
    }
</script>


@extends('layouts/app')

@section('top')
    <div class="panel-heading clearfix">
        <div class="container">
            <ul style="list-style-type: none; padding:0;">
                <li style=" float: left;"><h4 style="color: #fff;">Explore -{{$discipline->discipline_name}}:</h4> </li>
                <li style="  float: right; padding-top: 10px; padding-left: 10px;">

                    <ul class="breadcrumb-edu">
                        <li><a href="{{ route('disciplines.getknowledgemap', $discipline->id ) }}" class="active-edu"  >Knowledgemap</a></li>
                        <li><a href="{{ route('collaboration.index', $discipline->id ) }}" >Collaborate</a></li>

                    </ul>
                </li>
            </ul>
        </div>
    </div>
@endsection

@section('content')
    <div class="container" >

        <div class="col-md-4"></div>

        <div class="col-md-4">

            <div id="filter" align="left" class="col-md-4" class="form-group {{ $errors->has('grade_id') ? 'has-error' : '' }}"></div>

                 <form method="POST" action="{{  route('disciplines.getknowledgemap', $discipline->id )  }}" accept-charset="UTF-8" id="filter_form" name="filter_form" >
                    <input name="_token" type="hidden" value="{{ csrf_token() }}"/>
                    <select class="form-control" id="grade_id"  name="grade_id" onchange="this.form.submit()" >
                        <option disabled selected value="-1"  > -- select a grade -- </option>
                        <option id="0" value="0"  {{ $oldgradeid == 0 ? 'selected' : '' }}  >Select All Grades</option>
                         @foreach ($grades as $key => $grade)
                            <option id="{{$grade->id}}" value=" {{$grade->id}}" {{ $oldgradeid == $grade->id ? 'selected' : '' }}>
                                {{ $grade->grade_name }}
                            </option>
                         @endforeach
                    </select>
                 </form>
            <div class="col-md-4"></div>
            </div>
    </div>

    <div class="container" data-spy="scroll"  data-target="#myScrollspy">

        <div class="row">
            <nav  id="myScrollspy" class="col-md-4">
            <div  id="skillcategoriesdiv"  align="left" >
                <ul class="nav nav-pills nav-stacked" >
                    <li>skill categories</li>
                             @if(count($skillcategories) == 0)
                    @else
                        @foreach($skillcategories as $skillcategory)
                            <div  class="panel-heading"> <a  onclick="myFunction('{{$skillcategory->id}}')"      href="#" >
                                    {{$skillcategory->skill_category_name.'   '}}</a> </div>
                        @endforeach
                    @endif
                </ul>
            </div>

            </nav>
            <div  id="skilldiv"  class="col-md-8 "   align="center">

                @if(count($skills) == 0)
                @else
                    @php
                        $category_id=0;
                    foreach($skills as $skill) {
                         if ($category_id  != 0 && $category_id  != $skill->skillcategory['id'] ) {
                            echo ( "</div>");
                            echo ( "</div>");
                            echo ( "</div>");
                        }

                       if ($category_id  != $skill->skillcategory['id'] ) {
                       $category_id =$skill->skillcategory['id'] ;
                       $category_name=$skill->skillcategory['skill_category_name'];
                     echo(" <div class='panel panel-default' align='left'> " );
                     echo(" <div class='panel-heading' id='loop".$skill->skillcategory['id']."'> ");
                     echo ( "<h4 class='panel-title'> ");
                     echo ("<a data-toggle='collapse' href='#".$skill->skillcategory['id']."'  class='container-fluid' onclick=colleping('".$skill->skillcategory['id']."')  ><b>" . $category_name .
                     " </b> :".$skill->skillcategory['skill_category_decsription']."</a></h4>");

                     echo ( "<div class='panel-heading'>");
                  //   echo ( "  <h4 class='panel-title'>" );
                     echo ( "<a data-toggle='collapse' href='#'collapse'" .$skill->skillcategory['id']."'   ><b></b></a> ");
                     echo ( "   </h4>" );
                     echo ( "  </div> ");
                     echo ( "  <div id='collapse".$skill->skillcategory['id']."' class='panel-collapse collapse'> " );
                       }

                     echo ("<div   class='panel panel-default'>");
                     echo ("<div id='". $skill->grade_id."'  align='right'     >" );
                     echo ( " <li  list-style-type='none'  class ='gradediv''>" . getgradename( $skill->grade_id ) ."</li></div>" );

                     echo ( "     <div class='panel-body'  class='border-bottom border-gray' ><i>". $skill->skill_name ."</i> : " .$skill->skill_description."</div>");
                     echo ( "</div>");

                    //  echo ( "     <div class='panel-body'>". $skill->skill_description ."</div>");
          }

                    echo ( "</div>");
                    echo ( "</div>");
                     echo ( "</div>");
                    @endphp
                @endif
            </div>

        </div>
    </div>
@endsection
