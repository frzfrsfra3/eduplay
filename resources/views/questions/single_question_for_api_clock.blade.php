
{{--<script src="https://code.jquery.com/jquery-1.9.1.min.js"></script>--}}
<script type="text/javascript" src="{{ asset('assets/js/jquery-1.9.1.js') }}"></script>
{{-- <link rel="stylesheet" href="{{asset("assets/css/chessboard-0.3.0.min.css")}}">
  <script src="{{asset("assets/js/chessboard-0.3.0.min.js")}}"></script>--}}
<script src="{{asset("assets/js/compile.js")}}"></script>

<script src="{{asset("assets/js/clock.js")}}"></script>
{{--<script src="{{asset("assets/js/editorfunctions.js")}}"></script>--}}


<style>

    #html1{
        background-color: white;
    }

</style>


<canvas id="canvas" width="200" height="200"
        style="background-color:#333">
</canvas>

<script>
    var canvas = document.getElementById("canvas");
    var ctx = canvas.getContext("2d");
    var radius = canvas.height / 2;
    ctx.translate(radius, radius);
    radius = radius * 0.90
    drawClock();

    function drawClock() {
        drawFace(ctx, radius);
        drawNumbers(ctx, radius);
        drawTime(ctx, radius);

    }

    function drawFace(ctx, radius) {
        var grad;
        ctx.beginPath();
        ctx.arc(0, 0, radius, 0, 2*Math.PI);
        ctx.fillStyle = 'white';
        ctx.fill();
        grad = ctx.createRadialGradient(0,0,radius*0.95, 0,0,radius*1.05);
        grad.addColorStop(0, '#622711');
        grad.addColorStop(0.5, 'white');
        grad.addColorStop(1, '#0e3307');
        ctx.strokeStyle = grad;
        ctx.lineWidth = radius*0.1;
        ctx.stroke();
        ctx.beginPath();
        ctx.arc(0, 0, radius*0.1, 0, 2*Math.PI);
        ctx.fillStyle = '#fe9f2e';
        ctx.fill();
    }

    function drawNumbers(ctx, radius) {
        var ang;
        var num;
        ctx.font = radius*0.15 + "px arial";
        ctx.textBaseline="middle";
        ctx.textAlign="center";
        for(num = 1; num < 13; num++){
            ang = num * Math.PI / 6;
            ctx.rotate(ang);
            ctx.translate(0, -radius*0.85);
            ctx.rotate(-ang);
            ctx.fillText(num.toString(), 0, 0);
            ctx.rotate(ang);
            ctx.translate(0, radius*0.85);
            ctx.rotate(-ang);
        }
    }

    function drawTime(ctx, radius){
        var now = new Date();
        var hour = now.getHours();
        var minute = now.getMinutes();
        var second = now.getSeconds();
        //hour
        hour = 5;
        minute = 7;
        second = 2;

        hour=hour%12;
        hour=(hour*Math.PI/6)+
            (minute*Math.PI/(6*60))+
            (second*Math.PI/(360*60));
        drawHand(ctx, hour, radius*0.5, radius*0.07);
        //minute
        minute=(minute*Math.PI/30)+(second*Math.PI/(30*60));
        drawHand(ctx, minute, radius*0.8, radius*0.07);
        // second
        second=(second*Math.PI/30);
        drawHand(ctx, second, radius*0.9, radius*0.02);
    }

    function drawHand(ctx, pos, length, width) {
        ctx.beginPath();
        ctx.lineWidth = width;
        ctx.lineCap = "round";
        ctx.moveTo(0,0);
        ctx.rotate(pos);
        ctx.lineTo(0, -length);
        ctx.stroke();
        ctx.rotate(-pos);
    }
</script>




<div id="html1"   data-url="{{route ('questions.question.savequestionasimage')}}">{!! $question->details !!}</div>

<div  id="preview"  aria-labelledby="preview-tab">...
</div>



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


