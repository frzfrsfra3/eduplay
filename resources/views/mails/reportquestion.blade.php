<!DOCTYPE html>
<html>
<head>
    <title>Welcome Email</title>
</head>

<body>
<h2>Welcome to the site</h2>
<br/>

<b>Mrs {{$question->exercise->owner->name}}</b><br>

You have question report for your excercie  <a href="{{ route('exercisesets.exerciseset.show',[$question->exercise->id, $ispublic=0]) }}">{{$question->exercise->title}}</a>
<br><br>
<b>the question is </b>
<br><br>
{!! $question->details !!}
<b>Question message report is</b>
<br>

{!! $textreport !!}





</body>

</html>