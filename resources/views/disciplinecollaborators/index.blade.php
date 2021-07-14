@extends('layouts.admin')

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
                <h4 class="mt-5 mb-5">Disciplines Collaborators</h4>
            </div>

            <div class="btn-group btn-group-sm pull-right" role="group">
                <a href="{{ route('disciplinecollaborators.disciplinecollaborator.create') }}" class="btn btn-success" title="Create New Disciplinecollaborator">
                    <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                </a>
            </div>

        </div>
        
        @if(count($disciplinecollaborators) == 0)
            <div class="panel-body text-center">
                <h4>No Disciplines Collaborators Available!</h4>
            </div>
        @else
        <div class="panel-body panel-body-with-table">
            <div class="table-responsive">

                <table class="table table-striped ">
                    <thead>
                        <tr>
                            <th>Discipline</th>
                            <th>User</th>
                            <th>IsCoordinator</th>
                            <th>Approval Status</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($disciplinecollaborators as $disciplinecollaborator)
                        <tr>
                            <td>{{ optional($disciplinecollaborator->discipline)->discipline_name }}</td>
                            <td>{{ optional($disciplinecollaborator->user)->name }}</td>
                            <td>{{ optional($disciplinecollaborator)->iscoordinator }}</td>
                            <td>{{ optional($disciplinecollaborator)->approvalstatus }}</td>
                            <td>

                                <form method="POST" action="{!! route('disciplinecollaborators.disciplinecollaborator.destroy', $disciplinecollaborator->id) !!}" accept-charset="UTF-8">
                                <input name="_method" value="DELETE" type="hidden">
                                {{ csrf_field() }}

                                    <div class="btn-group btn-group-xs pull-right" role="group">
                                        <a href="{{ route('disciplinecollaborators.disciplinecollaborator.show', $disciplinecollaborator->id ) }}" class="btn btn-info" title="Show Disciplinecollaborator">
                                            <span class="glyphicon glyphicon-open" aria-hidden="true"></span>
                                        </a>
                                        <a href="{{ route('disciplinecollaborators.disciplinecollaborator.edit', $disciplinecollaborator->id ) }}" class="btn btn-primary" title="Edit Disciplinecollaborator">
                                            <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
                                        </a>

                                        <button type="submit" class="btn btn-danger" title="Delete Disciplinecollaborator" onclick="return confirm(&quot;Delete Disciplinecollaborator?&quot;)">
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
            {!! $disciplinecollaborators->render() !!}
        </div>
        
        @endif
    
    </div>
@endsection