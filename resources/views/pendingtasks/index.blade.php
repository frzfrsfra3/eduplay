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

            <div class="btn-group btn-group-sm pull-right" role="group">
                <a href="{{ route('pendingtasks.pendingtask.create') }}" class="btn btn-success" title="Create New Pendingtask">
                    <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                </a>
            </div>

        
        @if(count($pendingtasks) == 0)
            <div class="panel-body text-center">
                <h4>No Pending Tasks Available!</h4>
            </div>
        @else
        <div class="panel-body panel-body-with-table">
            <div class="table-responsive">

                <table class="table table-striped " >
                    <thead>
                        <tr>
                            <th>User</th>
                            <th>Sender</th>
                            <th>Pending Task</th>
                            <th>Status</th>

                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($pendingtasks as $pendingtask)
                        <tr>
                            <td>{{ optional($pendingtask->user)->name }}</td>
                            <td>{{ optional($pendingtask->sender)->name }}</td>
                            <td>{{ $pendingtask->pending_task_description }}</td>
                            <td>{{ $pendingtask->status }}</td>

                            <td>

                                <form method="POST" action="{!! route('pendingtasks.pendingtask.destroy', $pendingtask->id) !!}" accept-charset="UTF-8">
                                <input name="_method" value="DELETE" type="hidden">
                                {{ csrf_field() }}

                                    <div class="btn-group btn-group-xs pull-right" role="group">
                                        <a href="{{ route('pendingtasks.pendingtask.show', $pendingtask->id ) }}" class="btn btn-info" title="Show Pendingtask">
                                            <span class="glyphicon glyphicon-open" aria-hidden="true"></span>
                                        </a>
                                        <a href="{{ route('pendingtasks.pendingtask.edit', $pendingtask->id ) }}" class="btn btn-primary" title="Edit Pendingtask">
                                            <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
                                        </a>

                                        <button type="submit" class="btn btn-danger" title="Delete Pendingtask" onclick="return confirm('Delete Pendingtask?')">
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
            {!! $pendingtasks->render() !!}
        </div>
        
        @endif
    
    </div>
@endsection