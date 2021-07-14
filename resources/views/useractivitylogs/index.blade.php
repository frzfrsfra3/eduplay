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
                <h4 class="mt-5 mb-5">Useractivitylogs</h4>
            </div>

            <div class="btn-group btn-group-sm pull-right" role="group"> {{$id}}
                <a href="{{ route('useractivitylogs.useractivitylog.create',$id) }}" class="btn btn-success" title="Create New Useractivitylog">
                    <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                </a>
            </div>

        </div>
        
        @if(count($useractivitylogs) == 0)
            <div class="panel-body text-center">
                <h4>No Useractivitylogs Available!</h4>
            </div>
        @else
        <div class="panel-body panel-body-with-table">
            <div class="table-responsive">

                <table class="table table-striped ">
                    <thead>
                        <tr>
                            <th>Activity</th>
                            <th>Created At</th>
                            <th>Newpoints</th>

                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($useractivitylogs as $useractivitylog)
                        <tr>
                            <td>{{ optional($useractivitylog->activity)->activity_description }}</td>
                            <td>{{ $useractivitylog->created_at }}</td>
                            <td>{{ $useractivitylog->newpoints }}</td>

                            <td>

                                <form method="POST" action="{!! route('useractivitylogs.useractivitylog.destroy', $useractivitylog->id) !!}" accept-charset="UTF-8">
                                <input name="_method" value="DELETE" type="hidden">
                                {{ csrf_field() }}
                                    <div class="btn-group btn-group-xs pull-right" role="group">
                                        <a href="{{ route('useractivitylogs.useractivitylog.show', $useractivitylog->id ) }}" class="btn btn-info" title="Show Useractivitylog">
                                            <span class="glyphicon glyphicon-open" aria-hidden="true"></span>
                                        </a>
                                        {{-- <a href="{{ route('useractivitylogs.useractivitylog.edit', $useractivitylog->id ) }}" class="btn btn-primary" title="Edit Useractivitylog">
                                            <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
                                        </a> --}}

                                        <button type="submit" class="btn btn-danger" title="Delete Useractivitylog" onclick="return confirm(&quot;Delete Useractivitylog?&quot;)">
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
            {!! $useractivitylogs->render() !!}
        </div>
        
        @endif
    
    </div>
@endsection