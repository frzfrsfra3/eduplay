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
                <h4 class="mt-5 mb-5">Xp Points</h4>
            </div>

            <div class="btn-group btn-group-sm pull-right" role="group">
                <a href="{{ route('xp_points.xp_point.create') }}" class="btn btn-success" title="Create New Xp Point">
                    <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                </a>
            </div>

        </div>
        
        @if(count($xpPoints) == 0)
            <div class="panel-body text-center">
                <h4>No Xp Points Available!</h4>
            </div>
        @else
        <div class="panel-body panel-body-with-table">
            <div class="table-responsive">

                <table class="table table-striped ">
                    <thead>
                        <tr>
                            <th>Activity Name</th>
                            <th>Point</th>

                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($xpPoints as $xpPoint)
                        <tr>
                            <td>{{ $xpPoint->activity_name }}</td>
                            <td>{{ $xpPoint->point }}</td>

                            <td>

                                <form method="POST" action="{!! route('xp_points.xp_point.destroy', $xpPoint->id) !!}" accept-charset="UTF-8">
                                <input name="_method" value="DELETE" type="hidden">
                                {{ csrf_field() }}

                                    <div class="btn-group btn-group-xs pull-right" role="group">
                                        <a href="{{ route('xp_points.xp_point.show', $xpPoint->id ) }}" class="btn btn-info" title="Show Xp Point">
                                            <span class="glyphicon glyphicon-open" aria-hidden="true"></span>
                                        </a>
                                        <a href="{{ route('xp_points.xp_point.edit', $xpPoint->id ) }}" class="btn btn-primary" title="Edit Xp Point">
                                            <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
                                        </a>

                                        <button type="submit" class="btn btn-danger" title="Delete Xp Point" onclick="return confirm('Delete Xp Point')">
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
            {!! $xpPoints->render() !!}
        </div>
        
        @endif
    
    </div>
@endsection