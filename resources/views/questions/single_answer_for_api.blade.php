
<script type="text/javascript" src="{{ asset('assets/js/jquery-1.9.1.js') }}"></script>
<link rel="stylesheet" href="{{asset("assets/css/chessboard-0.3.0.min.css")}}">
<script src="{{asset("assets/js/chessboard-0.3.0.min.js")}}"></script>
<script src="{{asset("assets/js/compile.js")}}"></script>

<script src="{{asset("assets/js/clock.js")}}"></script>
    {{--<script src="{{asset("assets/js/editorfunctions.js")}}"></script>--}}


    <style>

        #html1{
            background-color: white;
        }

    </style>

<div id="html1"   data-url="{{route ('questions.question.savequestionasimage')}}">{!! $answer->details !!}</div>




@foreach ($_POST as $key => $value)
    @php
        echo "Field ".htmlspecialchars($key)." is ".htmlspecialchars($value)."<br>";
    @endphp
@endforeach


<script>

    $( document ).ready(function() {
        console.log( "ready!" );
        chesscompile();
        clock_init();

    });



</script>


