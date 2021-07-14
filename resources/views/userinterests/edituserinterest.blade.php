@extends('layouts.app')


@section('top')

    <div class="panel-heading clearfix">
        <div class="container">
            @include('explorenavigation',[$active=4])
        </div>
    </div>
@endsection
@section('content')

    <div class="panel panel-default">
  
     {{--   <div class="panel-heading clearfix">

            <div class="pull-left">
                <h4 class="mt-5 mb-5">{{ !empty($title) ? $title : 'Userinterest' }}</h4>
            </div>
            <div class="btn-group btn-group-sm pull-right" role="group">

                <a href="{{ route('userinterests.userinterest.index') }}" class="btn btn-primary" title="Show All Userinterest">
                    <span class="glyphicon glyphicon-th-list" aria-hidden="true"></span>
                </a>

                <a href="{{ route('userinterests.userinterest.create') }}" class="btn btn-success" title="Create New Userinterest">
                    <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                </a>

            </div>
        </div>--}}

        <div class="panel panel-default">
            <div class="container" >

            @if ($errors->any())
                <ul class="alert alert-danger">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            @endif
                <div class=" col-xl-6 col-lg-6 col-sm-6 col-xs-12  disipline_box" style="margin-top: 10px">
            <form method="GET" action="{{ route('userinterests.userinterest.updateinterests') }}" id="edit_userinterest_form" name="edit_userinterest_form" accept-charset="UTF-8" class="form-horizontal">
            {{ csrf_field() }}
            <input name="_method" type="hidden" value="PUT">
            @include ('userinterests.form_updated', [
                                        'userinterest' => $userinterest,
                                      ])

                <div class="form-group">
                    <div class="col-md-offset-2 col-md-10">
                        <input class="btn btn-primary" type="submit" value="Update & Start practice">
                    </div>
                </div>
         </form>
                </div>
                <div class=" col-xl-6 col-lg-6 col-sm-6 col-xs-12  disipline_box" style="border: solid 1px; margin-top: 10px">
                    <div class="col-xl-12 col-lg-12 col-sm-12 col-xs-12">
                        <label style="padding-top: 7px">Choose the language Pack in order to get questions as per selected language</label>
                    </div>
                    <div class="col-xl-12 col-lg-12 col-sm-12 col-xs-12">
                        <label style="padding-top: 7px">Choose the curriculum </label>
                    </div>
                    <div class="col-xl-12 col-lg-12 col-sm-12 col-xs-12">
                        <label style="padding-top: 7px">Grade is generally field as per your general preferences <br>
                        Fill in case you want to customize this</label>
                    </div>
                    <div class="col-xl-12 col-lg-12 col-sm-12 col-xs-12">
                        <label style="padding-top: 7px">
                            Choose either the collection of free Excercise sets or form your private library

                        </label>
                    </div>
                </div>

        </div>
    </div>

@endsection
@section('footer_scripts')

    <script>





        $('#discipline_id').change(function(){
            console.log( "You clicked a paragraph!" );
            var id=$(this).val();
            if (id  == null ) id=0;
            getgrades (id);


        });



        function getgrades( id1 ) {
          //  alert( id );
            var url="{{ url('/exercisesets/getgrades')}}/"+id1;
        if (id1!=0) {

            $.get(url,
                function(data) {
                    var grades = $('#grade_id');
                    grades.empty();
                    grades.append("<option value=''>" + "Select grade" + "</option>");
                    $.each(data, function(index, element) {
                        grades.append("<option value='"+ element.id +"'>" + element.grade_name + "</option>");
                    });
                });



        }

        else {
            var grades = $('#grade_id');
            grades.empty();
        }



        }

    </script>
  @endsection