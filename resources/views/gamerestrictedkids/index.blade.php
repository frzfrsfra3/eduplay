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
                <h4 class="mt-5 mb-5">Gamerestrictedkids</h4>
            </div>

            <div class="btn-group btn-group-sm pull-right" role="group">
                <a href="{{ route('gamerestrictedkids.gamerestrictedkid.create') }}" class="btn btn-success" title="Create New Gamerestrictedkid">
                    <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                </a>
            </div>

        </div>
        
        @if(count($gamerestrictedkids) == 0)
            <div class="panel-body text-center">
                <h4>No Gamerestrictedkids Available!</h4>
            </div>
        @else
        <div class="panel-body panel-body-with-table">
            <div class="table-responsive">

                <table class="table table-striped ">
                    <thead>
                        <tr>
                            <th>Kid</th>
                            <th>Game</th>
                            <th>Restricted By</th>
                            <th>Isactive</th>

                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($gamerestrictedkids as $gamerestrictedkid)
                        <tr>
                            <td>{{ optional($gamerestrictedkid->kid)->id }}</td>
                            <td>{{ optional($gamerestrictedkid->game)->id }}</td>
                            <td>{{ optional($gamerestrictedkid->restrictedBy)->id }}</td>
                            <td>{{ $gamerestrictedkid->isactive }}</td>

                            <td>

                                <form method="POST" action="{!! route('gamerestrictedkids.gamerestrictedkid.destroy', $gamerestrictedkid->id) !!}" accept-charset="UTF-8">
                                <input name="_method" value="DELETE" type="hidden">
                                {{ csrf_field() }}

                                    <div class="btn-group btn-group-xs pull-right" role="group">
                                        <a href="{{ route('gamerestrictedkids.gamerestrictedkid.show', $gamerestrictedkid->id ) }}" class="btn btn-info" title="Show Gamerestrictedkid">
                                            <span class="glyphicon glyphicon-open" aria-hidden="true"></span>
                                        </a>
                                        <a href="{{ route('gamerestrictedkids.gamerestrictedkid.edit', $gamerestrictedkid->id ) }}" class="btn btn-primary" title="Edit Gamerestrictedkid">
                                            <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
                                        </a>

                                        <button type="submit" class="btn btn-danger" title="Delete Gamerestrictedkid" onclick="return confirm(&quot;Delete Gamerestrictedkid?&quot;)">
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
            {!! $gamerestrictedkids->render() !!}
        </div>
        
        @endif
    
    </div>
@endsection