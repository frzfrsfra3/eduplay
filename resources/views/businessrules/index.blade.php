@extends('layouts.app')

@section('content')

    @if(Session::has('success_message'))
        <div class="alert alert-success">
            <span class="glyphicon glyphicon-ok"></span>
            {!! session('success_message') !!}

            <button type="button" class="close" data-dismiss="alert" aria-label="close">
                <span aria-hidden="true">&times;</span>
            </button>

        </div>
    @endif

    <div class="panel panel-default">

        <div class="panel-heading clearfix">

            <div class="pull-left">
                <h4 class="mt-5 mb-5">Businessrules</h4>
            </div>

            <div class="btn-group btn-group-sm pull-right" role="group">
                <a href="{{ route('businessrules.businessrule.create') }}" class="btn btn-success" title="Create New Businessrule">
                    <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                </a>
            </div>

        </div>
        
        @if(count($businessrules) == 0)
            <div class="panel-body text-center">
                <h4>No Businessrules Available!</h4>
            </div>
        @else
        <div class="panel-body panel-body-with-table">
            <div class="table-responsive">

                <table class="table table-striped ">
                    <thead>
                        <tr>
                            <th>Businessrule Name</th>
                            <th>Businessrule Condition</th>
                            <th>Isactive</th>

                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($businessrules as $businessrule)
                        <tr>
                            <td>{{ $businessrule->businessrule_name }}</td>
                            <td>{{ $businessrule->businessrule_condition }}</td>
                            <td>{{ ($businessrule->isactive) ? 'Yes' : 'No' }}</td>

                            <td>

                                <form method="POST" action="{!! route('businessrules.businessrule.destroy', $businessrule->id) !!}" accept-charset="UTF-8">
                                <input name="_method" value="DELETE" type="hidden">
                                {{ csrf_field() }}

                                    <div class="btn-group btn-group-xs pull-right" role="group">
                                        <a href="{{ route('businessrules.businessrule.show', $businessrule->id ) }}" class="btn btn-info" title="Show Businessrule">
                                            <span class="glyphicon glyphicon-open" aria-hidden="true"></span>
                                        </a>
                                        <a href="{{ route('businessrules.businessrule.edit', $businessrule->id ) }}" class="btn btn-primary" title="Edit Businessrule">
                                            <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
                                        </a>

                                        <button type="submit" class="btn btn-danger" title="Delete Businessrule" onclick="return confirm(&quot;Delete Businessrule?&quot;)">
                                            <span class="glyphicon glyphicon-trash" aria-hidden="true"></span>
                                        </button>
                                    </div>

                                </form>
                                
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>

            </div>
        </div>

        <div class="panel-footer">
            {!! $businessrules->render() !!}
        </div>
        
        @endif
    
    </div>
@endsection