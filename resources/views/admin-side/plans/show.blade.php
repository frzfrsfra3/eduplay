@extends('layouts.admin')

@section('content')
    @include('admin-side.plans.messages')
    <div class="panel panel-default">

        <div class="panel-heading clearfix">
            
            <span class="pull-left">
                <h4 class="mt-5 mb-5">{{ $plan->name }} | Plan Customization</h4>
            </span>

            <div class="btn-group btn-group-sm pull-right" role="group">
                <a href="{{ route('plans.index') }}" class="btn btn-primary" title="Show All plan">
                    <span class="glyphicon glyphicon-th-list" aria-hidden="true"></span>
                </a>
            </div>

        </div>

        <div class="panel-body">

            <form method="POST" action="{{ route('plans.update' , [$plan->id]) }}" accept-charset="UTF-8" id="create_plan_form" name="create_plan_form" class="form-horizontal" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="_method" value="PUT">
                @include('admin-side.plans.form')
                <div class="form-group">
                    <div class="col-md-offset-2 col-md-10">
                        <input formtarget="" class="btn btn-primary" type="submit" value="Save Changes">
                    </div>
                </div>
            </form>

            <hr>

            <h4>Plan Options</h4>

            <form action="{{ route('insert_plan_option') }}" method="post">
                @csrf
                <input type="hidden" name="plan_id" value="{{ $plan->id }}">
                <div class="row" style="padding: 10px;">
                    <div class="col-md-6">
                        <label for="opiton_id">Select an option:</label>
                        <select name="opiton_id" id="" class="form-control">
                            @foreach ($options as $category => $categoryOptions)
                                <optgroup label="{{ $category }}">
                                    @foreach ($categoryOptions as $id => $label)
                                        <option value="{{ $id }}">{{ $label }}</>
                                    @endforeach
                                </optgroup>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label for="">Set a value or add details: (optional)</label>
                        <input class="form-control" name="value" type="text">
                    </div>
                    <div class="col-md-12" style="margin:10px;">
                        <button class="btn btn-primary">add</button>
                    </div>
                </div>
            </form>

            <div class="table-responsive">
                <table class="table table-striped ">
                    <thead>
                        <tr>
                            <th>Option</th>
                            <th>value</th>
                            <th>Control</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($plan->plan_options as $plan_option)
                            <tr>
                                <td>{{ $plan_option->option->category }} | {{ $plan_option->option->label }}</td>
                                <td>
                                    <span id="option-{{ $plan_option->id }}-value">
                                        @if( empty($plan_option->value))
                                            <i>NULL</i>
                                        @else 
                                            {{ $plan_option->value }}
                                        @endif
                                        <button class="btn btn-link value-edit-btn" value="{{ $plan_option->id }}"> edit </button>
                                    </span>

                                    <form action="{{ route('update_plan_option') }}" method="POST" class="form-inline" style="display: none" id="option-{{ $plan_option->id }}-edit-form">
                                        @csrf
                                        <input type="hidden" name="plan_option_id" value="{{ $plan_option->id }}">
                                        <input class="form-control" name="value" type="text" value="{{ $plan_option->value }}">
                                        <button class="btn btn-primary">Update</button>
                                    </form>
                                </td>
                                <td>
                                    <form action="{{ route('delete_plan_option')}}" method="POST">
                                        @csrf
                                        <input type="hidden" name="plan_option_id" value="{{ $plan_option->id }}">
                                        <button class="btn btn-danger">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
        </div>
    </div>
    
@section('footer_scripts2')
<script>
    $(document).ready(function(){
        $('.value-edit-btn').click(function(){
            var id = $(this).val();
            console.log(id);
            $('#option-' + id + '-value').fadeOut(10, function(){
                $('#option-' + id + '-edit-form').fadeIn();
            });
            
        });
    });
</script>
@endsection

@endsection
