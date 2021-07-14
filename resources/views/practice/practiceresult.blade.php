<!---Content-->

<style>
    button.navigation-btn {
        display: inline-block;
        padding: 5px 20px;
        border: 0;
        cursor: pointer;
        border-radius: 5px;
        outline: 0 !important;
        box-shadow: 0 !important;
        transition: all 0.2s ease 0s;
        background-color: #00b2f0;
        color: #fff;
        max-width: 100%;
    }

    .practice-header {
        padding-top: 6px;
        background-color: #fff;
        box-shadow: 3px 3px 27px 0 rgb(0 0 0 / 20%);
    }

    .finish-message{ 
        text-align: center;
        font-family: 'Raleway', sans-serif;
        padding:20px;
        margin: 20px;
    }

    .practice-results{
        text-align: center;
        padding:0;
        margin: 0;
    }

    .practice-results  li{
        width: 200px;
        padding: 10px !important;
        background: #fff;
        box-shadow: 10px 10px 9px #eee;
        margin: 5px;
        color: #70dbff;
        text-align: center;
        font-family: 'Raleway', sans-serif;
        display: inline-block;
        border-top: 15px solid #70dbff;
    }

    .practice-results li h3{ 
        color: inherit;
        text-align: center;
        font-size: 36px;
        font-family: 'consolas', sans-serif;
        margin: 20px 20px 0px 20px;
        padding-top: 4px;
}

    }
     .practice-results li p{ 
        font-family: 'Raleway', sans-serif;
        text-align: center;
        font-weight: bold;
        font-size: 11px;
        padding: 10px;
        color: #fff;
        margin: 0;

    }
    .practice-results li#correct{ 
        border-top: 15px solid #5dbf58;
        color : #5dbf58;
    }

    .practice-results li#incorrect{ 
        border-top: 15px solid #e26b67;
        color: #e26b67;
    }
    
</style>


<div class="full-width practice-nav">
    {{-- Header --}}
    <div class="row practice-header">
        <div class="col-md-3 col-xs-5 col-sm-5">
            <a class="navbar-brand" href="{{route('exercisesets.exerciseset.private')}}">
                <img src="{{ asset('assets/eduplaycloud/image/logo.svg') }}" alt="" class="logo">
            </a>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-xl-9 mx-auto">
        
        <h2 class="finish-message">{{ $message }} @if (Auth::user()) {{ $username }}@endif !</h2> 
        <ul class="practice-results">
            <li id="correct">
            <h3>{{ $currectAnswers }}/{{ $totalQuestion }}</h3>
                <p>@lang('practice.correct_answers')</p>
            </li>
            <li id="incorrect">
            <h3>{{ $inCurrectAnswers}}/{{ $totalQuestion }}</h3>
                <p>@lang('practice.incorrect_answers')</p>
            </li>
            <li>
                <h3>{{ $totalMins }}</h3>
                <p>@lang('practice.minutes_taken')</p>
            </li>
        </ul>
    </div>
</div>

<div class="row">
    <div class="col-xl-9 mx-auto">
        <div class="top_d_bx">
            <div class="row">
                <h3>{{ !empty($exerciseset)  ? $exerciseset->topics->topic_name : ''  }}</h3>
            </div>
            @if(isset($discpline->description)) 
                <p>
                    {{ $discpline->description }}
                </p>
            @endif
            <a href="{{ route('explore.exerciseset') }}" class="btn btn-primary add_btn">@lang('practice.close')</a>
            @auth
                <a href="{{route('practice.answer.report',[$practice_token])}}" class="btn btn-primary add_btn mrg-right-15">@lang('practice.view_report')</a>
            @endauth
            <a href="javascript:void(0)" onclick="location.reload();" class="btn btn-primary add_btn mrg-right-15">@lang('practice.practice_again')</a>
        </div>
    </div>
</div>                
<!---End Content-->
  