@extends('layouts.app')
@section('header_styles')
    <link rel="stylesheet" href="{{ asset('assets/css/nestable.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/eduplay.css') }}">




@endsection
@section('top')
      @include('myexercisesnavigation' ,[$ispublic=0])
@endsection
@section('content')

    <div class="panel panel-default">

        <div class="container">
            <div class="panel-body">
                <div class="row">
                <div class="col-lg-8">
                    <a href="#" data-url="{{ route('exercisesets.buy', $exerciseset->id ) }}"
                       id="buy" onclick="buy()" class="btn btn-primary" title="buy this!!!" >
                       Buy this {{$exerciseset->title}}</a>

                </div>
                </div>
    </div>
    </div>
    </div>
@endsection

@section('footer_scripts')
    <script>
    function buy() {
    var url=$('#buy').data("url");

        $.ajax({
        type: "post",
        dataType: "text",
        url: url,
        data: {
        "_token": "{{ csrf_token() }}",
        },
        success: function (response) {

            console.log(response);
            location.href='{{route('exercisesets.exerciseset.summary',[$exerciseset->id,$ispublic=1])}}';

        },
        error: function(jqXHR, textStatus, errorThrown) {
        //   console.log("AJAX error : " + JSON.stringify(err, null, 2));
        console.log('jqXHR:');
        console.log(jqXHR);
        console.log('textStatus:');
        console.log(textStatus);
        console.log('errorThrown:');
        console.log(errorThrown);
        }
        })


    }
    </script>
@endsection

