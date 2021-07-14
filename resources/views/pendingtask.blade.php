<div class="badges_obtained">@lang('home.badges_obtaineded')</div>

@if ($allbadges )

    @php

        if (strlen($allbadges->badgeimageurl) >0 && File::exists(public_path()."\assets\images\badges\\".$allbadges->badgeimageurl)) {$uimg= $allbadges->badgeimageurl;}
    else{$uimg= 'default.png';}
    @endphp

    <div class="badges_images"><img src="{{ asset('assets/images/badges/'.$uimg) }}"></div>
    <div class="badges_date"  style="padding-left: 15px;padding-right: 15px">@lang('home.date_acquired') : {{date('d - M - Y', strtotime( $allbadges->pivot->dateacquired ))}}</div>
@else <div class="badges_images"><img src="{{ asset('assets/images/badges/default.png') }}"></div>
@endif


<a href="{{route ('users.user.profile',Auth::user()->id)}}">
    <div style="clear:both; padding: 5px 0 10px 0; padding-left: 15px;padding-right: 15px">
        <div class="btn-greenbutton-homepage">@lang('home.My Profile')</div>

    </div>
</a>




<div class="badges_obtained">Pending Tasks</div>
<div id="fourth-element" style="clear:both;  padding-left: 15px;padding-right: 15px;margin: 10px 0">

        @if(count($pendings) == 0)
            <div class="panel-body text-center">
                <h4>No Pending Tasks Available!</h4>
            </div>
        @else

                @foreach($pendings as $pending)
                    <div style="margin: 3px 0 3px">
                        <a href="{{$pending->pending_task_action}}" data-toggle="tooltip" title="{{$pending->pending_task_description}}">
                            <i class="fa fa-angle-right " aria-hidden="true"></i>
                            {{ strlen($pending->pending_task_description) > 33 ? substr($pending->pending_task_description,0,31)."..." : $pending->pending_task_description }}

                        </a>
                    </div>
                @endforeach

        @endif



</div>