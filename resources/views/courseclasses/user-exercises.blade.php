


<div  class=" class-scroll-list  class-scroll-style">
<div id=""   style="border-top: 1px solid rgba(129,166,174,0.64)"></div>
@php
$user= Auth::user();
$myexercises=$user->myexercises()->get();
$courseclassexercises= $courseclass->exercises()->get();
$purchasedexercises=$user->exercises()->get();
$myexercises=$myexercises->merge($purchasedexercises);
$myexercises=$myexercises->diff($courseclassexercises);
$myexercises->unique();

@endphp

    <div id="list-exercises" >
@foreach($myexercises as $myexercise)
        @include('courseclasses.exercise' ,$myexercise)

@endforeach
    </div>


<div >




</div>
</div>
