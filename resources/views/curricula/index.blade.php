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
                <h4 class="mt-5 mb-5">Curricula Grade List</h4>
            </div>

            <div class="btn-group btn-group-sm pull-right" role="group">
                <a href="{{ route('curricula.curriculum.create') }}" class="btn btn-success" title="Create New Curriculum">
                    <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                </a>
            </div>

        </div>
        
        @if(count($curricula) == 0)
            <div class="panel-body text-center">
                <h4>No Curricula Grade Lists Available!</h4>
            </div>
        @else
        <div class="panel-body panel-body-with-table">
            <div class="table-responsive">

                <table class="table table-striped ">
                    <thead>
                        <tr>
                            <th>Grade List Name</th>

                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($curricula as $curriculum)
                        <tr>
                            <td>{{ $curriculum->curriculum_gradelist_name }}</td>

                            <td>

                                <form method="POST" action="{!! route('curricula.curriculum.destroy', $curriculum->id) !!}" accept-charset="UTF-8">
                                <input name="_method" value="DELETE" type="hidden">
                                {{ csrf_field() }}

                                    <div class="btn-group btn-group-xs pull-right" role="group">
                                        <a href="{{ route('curricula.curriculum.show', $curriculum->id ) }}" class="btn btn-info" title="Show Curriculum">
                                            <span class="glyphicon glyphicon-open" aria-hidden="true"></span>
                                        </a>
                                        <a href="{{ route('curricula.curriculum.edit', $curriculum->id ) }}" class="btn btn-primary" title="Edit Curriculum">
                                            <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
                                        </a>

                                        <button type="submit" class="btn btn-danger" title="Delete Curriculum" onclick="return confirm('Delete Curriculum?')">
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
            {!! $curricula->render() !!}
        </div>
        
        @endif
    
    </div>
@endsection