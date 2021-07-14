<div class="mrgn_btm_100">
    <h6 class="basic_title">My Subscriptions</h6>
</div>
    <ul class="tabs_menu nav nav-pills mb-3" id="myTab1" role="tablist">
        @php $isFirst = true; @endphp
        @foreach ($user->roles as $role)
        <li class="nav-item" role="presentation">
            <a class="nav-link @if ($isFirst) active @php $isFirst = false; @endphp @endif" id="{{ $role->name }}-tab" data-toggle="tab" href="#{{ $role->name }}" role="tab" aria-controls="{{ $role->name }}" aria-selected="true">{{ $role->name }}</a>
        </li>
        @endforeach
    </ul>
    <div class="tab-content" id="myTab1Content">
        @php $isFirst = true; @endphp
        @foreach ($user->roles as $role)
            <div class="tab-pane fade @if ($isFirst) active show @php $isFirst = false; @endphp @endif" id="{{ $role->name }}" role="tabpanel" aria-labelledby="{{ $role->name }}-tab">
                @php
                    $subscriptions = App\Models\UserSubscriptions::getByUserAndRole($user->id, $role->id)
                @endphp
                @if ( count($subscriptions) == 0 )
                    <h1>No Subsription found for Role {{ $role->name }}</h1>
                @endif
                <div class="row">
                    @foreach ($subscriptions as $subscription)
                        @php
                                $plan = $subscription->plan;
                            @endphp
                            <div class="col-md-5 plan-template">
                                <div class="card mb-4 box-shadow">
                                    <div class="card-header">
                                        <h2 class="my-0 font-weight-normal">{{ $plan->name }}</h2>
                                    </div>
                                    <div class="card-body">
                                        <span>{{ $plan->description }}</span>
                                        <h1 class="card-title pricing-card-title">
                                            @if ( $plan->price == 0)
                                                FREE
                                            @elseif ( $plan->price == -1 )
                                                Contact us
                                            @else 
                                                ${{ $plan->price }} <small class="text-muted">/ mo</small>
                                            @endif
                                        </h1>
                                        <ul>
                                            @php 
                                                // Initialize Plans Options Array // Classify By Category
                                                $options_array = [];
                                                foreach ($plan->plan_options as $plan_option) {
                                                    $options_array[$plan_option->option->category][$plan_option->option->label] = $plan_option->value;
                                                }
                                            @endphp

                                            @foreach ($options_array as $category => $options)
                                                <h5>{{ $category }}</h5>
                                                @foreach ($options as $label => $value)
                                                    <li>{{ $label }}
                                                        @if ( !empty($value))
                                                            (
                                                                @switch(strtolower($label))
                                                                    @case("disk drive")
                                                                        {{ $value }} MB
                                                                        @break
                                                                    @default
                                                                        {{ $value }}
                                                                @endswitch
                                                            )
                                                        @endif
                                                    </li>
                                                @endforeach
                                            @endforeach
                                        </ul>
                                        <div class="btn-group">
                                            <button type="button" class="btn btn-login">Unsubscribe</button>
                                            <button type="button" class="btn btn-login">Upgrade</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                    @endforeach
                </div>
            </div>
        @endforeach
        
    </div>


