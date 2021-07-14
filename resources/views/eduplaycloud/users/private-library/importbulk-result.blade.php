@extends('authenticated.layouts.default')
@section('content')
<div class="main_content">
    <div class="container">
        <div class="add_child_cls">
            <div class="row justify-content-center">
                <div class="col-lg-12">
                        {{-- <div class="info-mn-txt">@lang('exerciseset_form.result_title')</div> --}}
                    <div class="card result-scn">
                        <div class="card-header bg-info text-white">@lang('exerciseset_form.result')</div>
                                <div class="card-body json-error-scn">                
                                @foreach($results as $key => $result)
                                    @if($result['status'] === Lang::get('controller.success'))
                                        <div class="deatil_panneel_privt inner_pannel panel panel-default">
                                            <div class="panel-heading" role="tab" id="headingOne_{{ $key }}">
                                                <div class="panel-title">
                                                    <a role="button" data-toggle="collapse" href="#collapseOne_{{ $key }}" class="susc-msg-bg" aria-expanded="true" aria-controls="collapseOne_{{ $key }}">
                                                        {{ $key }} : {{ $result['status'] }}
                                                    </a>
                                                </div>
                                            </div>
                                            <div id="collapseOne_{{ $key }}" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne_{{ $key }}">
                                                <div class="panel-body">
                                                    <p class="susc-msg">
                                                        {{ $result['message'] }}
                                                    </p> 
                                                </div>
                                            </div>
                                        </div>
                                    @else 
                                        <div class="deatil_panneel_privt inner_pannel panel panel-default">
                                            <div class="panel-heading" role="tab" id="headingOne_{{ $key }}">
                                                <div class="panel-title">
                                                    <a role="button" data-toggle="collapse" href="#collapseOne_{{ $key }}" class="error-msg-jsn-bg" aria-expanded="true" aria-controls="collapseOne_{{ $key }}">
                                                        {{ $key }} :  {{ $result['status'] }}
                                                    </a>
                                                </div>
                                            </div>
                                            <div id="collapseOne_{{ $key }}" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne_{{ $key }}">
                                                <div class="panel-body">
                                                    <p class="error-msg-jsn">{{ $result['property'] }}{{ $result['message'] }}</p>
                                                    <p>
                                                        {{ $result['json'] }}
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    @endif                                        
                                @endforeach
                            </div>
                        </div>
                        <!----Button section---->
                        <div class="col-md-12">
                            <div class="clearfix"></div><br/>
                            <div class="form-group mrgn-bt-30">
                                <a href="{{ route('exercisesets.exerciseset.show',['exerciseset' => $exercise_id ,'ispublic' => 1,'#detail']) }}" class="btn btn-primary add_btn">@lang('exerciseset_form.show')</a>
                                <a href="{{ route('exercisesets.exerciseset.importform',$exercise_id) }}" class="btn btn-primary add_btn">@lang('exerciseset_form.import_bulk')</a>
                            </div>
                        </div> 
                    </div>        
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

<?php /*Load jquery to footer section*/ ?>
@push('inc_script')

@endpush

<?php /*Load jquery to footer section*/ ?>
@push('inc_jquery')
    
@endpush