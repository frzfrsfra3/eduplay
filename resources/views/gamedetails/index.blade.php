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
                <h4 class="mt-5 mb-5">Gamedetails</h4>
            </div>

            <div class="btn-group btn-group-sm pull-right" role="group">
                <a href="{{ route('gamedetails.gamedetail.create') }}" class="btn btn-success" title="Create New Gamedetail">
                    <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                </a>
            </div>

        </div>
        
        @if(count($gamedetails) == 0)
            <div class="panel-body text-center">
                <h4>No Gamedetails Available!</h4>
            </div>
        @else
        <div class="panel-body panel-body-with-table">
            <div class="table-responsive">

                <table class="table table-striped ">
                    <thead>
                        <tr>
                            <th>Platform</th>
                            <th>Game</th>

                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($gamedetails as $gamedetail)
                        <tr>
                            <td>{{ optional($gamedetail->platform)->id }}</td>
                            <td>{{ optional($gamedetail->game)->id }}</td>

                            <td>

                                <form method="POST" action="{!! route('gamedetails.gamedetail.destroy', $gamedetail->id) !!}" accept-charset="UTF-8">
                                <input name="_method" value="DELETE" type="hidden">
                                {{ csrf_field() }}

                                    <div class="btn-group btn-group-xs pull-right" role="group">
                                        <a href="{{ route('gamedetails.gamedetail.show', $gamedetail->id ) }}" class="btn btn-info" title="Show Gamedetail">
                                            <span class="glyphicon glyphicon-open" aria-hidden="true"></span>
                                        </a>
                                        <a href="{{ route('gamedetails.gamedetail.edit', $gamedetail->id ) }}" class="btn btn-primary" title="Edit Gamedetail">
                                            <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
                                        </a>

                                        <button type="submit" class="btn btn-danger" title="Delete Gamedetail" onclick="return confirm(&quot;Delete Gamedetail?&quot;)">
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
            {!! $gamedetails->render() !!}
        </div>
        
        @endif
    
    </div>
@endsection