@extends('layouts/popup')
@section('header_styles')
    <link rel="stylesheet" href="{{ asset('assets/css/signup.css') }}">
@stop
{{-- Page title --}}
@section('title')
    Sign up
    @parent
@stop

@section('content')
    <div class="container">
    <div class="row" style="text-align: center;">
        <img src="{{ asset('assets/images/') }}/logo-signup.png">
    </div>
    <form method="post" action="{{ route('signup_2') }}" accept-charset="UTF-8" id="form_sign1" name="form_sign2" >
        {{ csrf_field() }}
        @if($disciplines->count()==0 )
        @else

            <p id="resultBday"></p>
            <div class="row" id="signup-2" style="padding-right: 20px;">

                @if ($errors->any())
                    <ul class="alert alert-danger">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                @endif

                <ul>
                    <li class="col-lg-12 col-sm-12 col-xs-12 li-title" > profile:</li>
                        <li class="col-lg-2 col-sm-2 col-xs-12 li-date-label" >
                       <label for="bday">   Date of barth : </label>   </li>
                    <li class="col-lg-4 col-sm-4 col-xs-12">


                            <input type="date" id="bday" name="bday" class="form-control input-dob" style="" required onchange="submitBday()"  placeholder="dob">
                    </li>
                    <li class="col-lg-6 col-sm-6 col-xs-12">

                        <input type="email" id="parentemail" name="parentemail" class="form-control pmail" style=" -webkit-box-shadow:none ;"   placeholder="Parent E-mail...">
                    </li>

                </ul></div>

                    <div class="row" id="signup-2" style="padding-right: 20px;">
                        <ul>
                            <li class="col-lg-12 col-sm-12 col-xs-12 li-title" > Interset:</li>
                @foreach($disciplines as $discipline)
                        <li class="col-sm-4 col-xs-12"> <div class="check_area_2">
                                @php if (strlen($discipline->discipline_name)>23) {$ln='pnl-left-long';} else {$ln='';} @endphp
                                <div class="pnl-left {{$ln}}" data-toggle="tooltip" data-placement="top" title="{{$discipline->discipline_name}}">{{ strlen($discipline->discipline_name) > 35 ? substr($discipline->discipline_name,0,32)."..." : $discipline->discipline_name }}</div>
                                <div class="pnl-right"><div class="chk_container">
                                        <input  type="checkbox" id="bit_discipline[{{$discipline->id}}]" name="bit_discipline[{{$discipline->id}}]" class="regular-checkbox" />
                                        <label for="bit_discipline[{{$discipline->id}}]"></label></div></div>
                            </div>
                        </li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="row" style="text-align: center">
            <a href="#" style="text-decoration: none">
            <button class="btn-orange" type="submit"  >@lang('auth.NEXT') >|</button>
            </a>
        </div>
    </form> </div>
@endsection

@section('footer_scripts')

    <script>

        function submitBday() {

            var Q4A = "Your birthday is: ";
            var Bdate = document.getElementById('bday').value;
            var Bday = +new Date(Bdate);
            Q4A += Bdate + ". You are " + ~~ ((Date.now() - Bday) / (31557600000));
            var theBday = document.getElementById('resultBday');
         //   theBday.innerHTML = Q4A;
            var age=((Date.now() - Bday) / (31557600000));
            if (age <=13) {
                $("#parentemail").prop('required',true);
            }
            else {
                $("#parentemail").prop('required',false);
            }

        }
        $(document).ready(function(){
            $('[data-toggle="tooltip"]').tooltip();
        });
    </script>
@endsection