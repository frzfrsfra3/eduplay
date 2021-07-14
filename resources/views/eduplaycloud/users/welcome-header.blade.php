<div class="pg-content">
    <div class="inner_profile_pdng">
        <div class="row">
            <div class="col-md-{{ count($pendings) > 0 ? '7' : '12'}} orng_bg_trnprnt">
                <div class="welcom_proflie">
                    <h4>@lang('home.welcome_to_edu')</h4>
                    <p>@lang('home.play_learn')</p>
                    <div class="prgress-tp">
                    <div class="progress" data-percentage="{{ $user->calculate_profile($profile) }}">
                    <div class="cdev" data-percent="{{ $user->calculate_profile($profile) }}" data-duration="1000" data-color="#fff,#00b2f0"></div>
                        <div class="progress-value">
                            <div class="img-prgres">
                                @php
                                    $user=Auth::user();
                                @endphp
                                @if(strtolower($user->provider) == 'facebook' || strtolower($user->provider) == 'google')
                                    <img src="{{ $user->user_image }}" alt="{{ $user->name }}">
                                @elseif(isset($user->user_image) && !empty($user->user_image))
                                    @if (strlen($user->user_image) > 0 && File::exists(public_path()."/assets/images/profiles/".$user->user_image))
                                        <img src="{{ asset('assets/images/profiles') }}/{{  $user->user_image }}" alt="{{ $user->name }}">
                                    @else
                                        <img src="{{ asset('uploads/profile') }}/proflie_welcome.png" alt="{{ $user->name }}">
                                    @endif
                                @else
                                    <img src="{{ asset('uploads/profile') }}/proflie_welcome.png" alt="{{ $user->name }}">
                                @endif
                            </div>
                        </div>
                    </div>
                    </div>
                    <div class="profle_line">
                        <p class="name_brdr">{{ Auth::user()->name }}</p>
                        <p>{{ $user->calculate_profile($profile) }}% @lang('home.completed')</p>
                    </div>
                </div>
            </div>
            @if(count($pendings) > 0)
            <div class="col-md-5 dark_orng_bd">
                <div class="initial_task text-ar-right">
                    <h3>@lang('home.intial_tasks') ( {{ round($totalTaskPr,2) }}% )</h3>
                    <ul class="complete_task plain_bullets">
                        @foreach($pendings as $pending)
                        <li>
                            @if($pending->status == 'done')
                                <div class="pie doneTask"></div>
                            @else
                                <div class="pie"></div>
                            @endif
                            @php
                                // Only for /user/profile/id
                                if ($pending->pending_task_description == 'Complete your profile') {
                                    $curl=explode("/",$pending->pending_task_action);
                                    if ($curl[1]=='users')
                                    {
                                        if ($curl[2]=='profile')
                                        {
                                            $profile="/users/profile/".$curl[3];
                                        }
                                    }
                                }
                            @endphp

                            @if($pending->pending_task_action ==='/invitefriend/eduplaycloud')
                                <a href="" data-toggle="modal" data-target="#myModal">@lang('messages.invite_your_friend_to_use_eduplaycloud')</a>
                            @else
                                <a @if($pending->pending_task_action ==='/get/to/know') ? target="_blank" : '' @endif href="@if($pending->pending_task_action ==='/courseclasses/myclasses')
                                    {{ url('/courseclasses/myclasses') }}
                                @elseif($pending->pending_task_action ==='/explore/classes')
                                {{ url('/explore/classes') }}
                                @elseif($pending->pending_task_action ==='/exercisesets/private')
                                {{ url('/exercisesets/private') }}
                                @elseif($pending->pending_task_action ==='/get/to/know')
                                {{ url('/get/to/know') }}
                                @elseif($pending->pending_task_action ==='/invitefriend/eduplaycloud')
                                {{ $pending->pending_task_action }}
                                @else
                                    {{ url($profile) }}
                                @endif">

                                @if ($pending->pending_task_description == 'Complete your profile')
                                    @lang('messages.complete_your_profile')
                                @elseif ($pending->pending_task_description == 'Create or buy an exercise set')
                                    @lang('messages.create_or_buy_an_exercise_set')
                                @elseif (strtolower($pending->pending_task_description) == strtolower('Create a Class'))
                                    @lang('messages.create_a_class')
                                @elseif (strtolower($pending->pending_task_description) == strtolower('Join a Class'))
                                    @lang('messages.join_a_class')
                                @elseif ($pending->pending_task_description == 'Add an exercise set to your class')
                                    @lang('messages.add_an_exercise_set_to_your_class')
                                @elseif ($pending->pending_task_description == 'invite learners')
                                    @lang('messages.invite_learners')
                                @else
                                    @if ($pending->pending_task_description == 'Get to Know EduPlayCloud')
                                        @lang('messages.get_to_know_eduPlayCloud')
                                    @else
                                        {{ $pending->pending_task_description}}
                                    @endif
                                @endif
                            @endif
                        </a>
                            {{-- <a href="{{ url($pending->pending_task_action) }}">{{ $pending->pending_task_description}}</a> --}}
                        </li>
                        @endforeach
                    </ul>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>

@push('inc_jquery')
<script>
 $(document).ready(function(){
        $('html, body').animate({
            scrollTop: $(".container .row .row").offset().top
        }, 1000);
 });
</script>
@endpush