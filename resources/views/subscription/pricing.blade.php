@section('header_styles')
<style>

    .plan-template .card{
        border: 0;
        box-shadow: 3px 4px 12px #ddd;
        text-align: center;
    }

    .plan-template .card-header{
        border: 0;
        background: #ff9128;
        color : #fff;
        text-transform: uppercase;
        letter-spacing: 4px;
        
    }

    .plan-template .card-header h2{
        font-size: 21px !important;
        font-weight: lighter;
    }

    .plan-template ul{
        text-align: left;
        padding:0;
    }

    .plan-template ul li{
        padding-left: 15px;
        list-style-type: none;
    }

</style>
@endsection

<section class="for_did_you_know own_exercises sec_with_mrgn bld_tlt">
    <div class="container">
        <div class="row justify-content-end">
            <div class="col-md-11">
                <div class="row">
                    <div class="col-md-12">
                        <h1 class="black_title">Pricing</h1>

                        <div class="row">

                        @foreach ($plans as $plan)
                            <div class="col-md-4 plan-template">
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
                                        <button type="button" class="btn btn-login btn-block">Get started</button>
                                    </div>
                                </div>
                            </div>
                        @endforeach


                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
