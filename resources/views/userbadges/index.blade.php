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
                <h4 class="mt-5 mb-5">Userbadges</h4>
            </div>

            <div class="btn-group btn-group-sm pull-right" role="group">
                <a href="{{ route('userbadges.userbadge.create') }}" class="btn btn-success" title="Create New Userbadge">
                    <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                </a>
            </div>

        </div>
        
        @if(count($userbadges) == 0)
            <div class="panel-body text-center">
                <h4>No Userbadges Available!</h4>
            </div>
        @else
        <div class="panel-body panel-body-with-table">
            <div class="table-responsive">

                <table class="table table-striped ">
                    <thead>
                        <tr>
                            <th>User</th>
                            <th>Badge</th>
                            <th>Dateacquired</th>

                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($userbadges as $userbadge)
                        <tr>
                            <td>{{ optional($userbadge->user)->id }}</td>
                            <td>{{ optional($userbadge->badge)->badgetitle }}</td>
                            <td>{{ $userbadge->dateacquired }}</td>

                            <td>

                                <form method="POST" action="{!! route('userbadges.userbadge.destroy', $userbadge->id) !!}" accept-charset="UTF-8">
                                <input name="_method" value="DELETE" type="hidden">
                                {{ csrf_field() }}

                                    <div class="btn-group btn-group-xs pull-right" role="group">
                                        <a href="{{ route('userbadges.userbadge.show', $userbadge->id ) }}" class="btn btn-info" title="Show Userbadge">
                                            <span class="glyphicon glyphicon-open" aria-hidden="true"></span>
                                        </a>
                                        <a href="{{ route('userbadges.userbadge.edit', $userbadge->id ) }}" class="btn btn-primary" title="Edit Userbadge">
                                            <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
                                        </a>

                                        <button type="submit" class="btn btn-danger" title="Delete Userbadge" onclick="return confirm(&quot;Delete Userbadge?&quot;)">
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
            {!! $userbadges->render() !!}
        </div>
        
        @endif
    
    </div>
@endsection