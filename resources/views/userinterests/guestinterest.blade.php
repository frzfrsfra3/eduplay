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
            <form method="get" action="{{ route('userinterests.userinterest.updateinterests') }}" id="edit_userinterest_form" name="edit_userinterest_form" accept-charset="UTF-8" class="form-horizontal">
            {{ csrf_field() }}
            <input name="_method" type="hidden" value="get">
            @include ('userinterests.form_updated', [
                                        'userinterest' => null,
                                      ])

                <div class="form-group">
                    <div class="col-md-offset-2 col-md-10">
                        <input class="btn btn-primary" type="submit" value="Start practice">
                    </div>
                </div>
         </form>
                </div>
                <div class=" col-xl-6 col-lg-6 col-sm-6 col-xs-12  disipline_box" style="border: solid 1px; margin-top: 10px">
                    <div class="col-xl-12 col-lg-12 col-sm-12 col-xs-12">
                        <label style="padding-top: 7px">Choose the language Pack in order to get questions as per selected language</label>
                    </div>
                    <div class="col-xl-12 col-lg-12 col-sm-12 col-xs-12">
                        <label style="padding-top: 7px">Choose one discipline </label>
                    </div>
                    <div class="col-xl-12 col-lg-12 col-sm-12 col-xs-12">
                        <label style="padding-top: 7px">Grade is generally field as per your general preferences <br>
                        Fill in case you want to customize to this discipline</label>
                    </div>

                </div>

        </div>
    </div>
    </div>

@endsection
@section('footer_scripts')

    <script>





        $('#discipline_id').change(function(){
            
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