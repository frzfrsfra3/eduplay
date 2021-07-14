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
                <h4 class="mt-5 mb-5">Grades</h4>
            </div>

            <div class="btn-group btn-group-sm pull-right" role="group">
                <a href="{{ route('grades.grade.create') }}" class="btn btn-success" title="Create New Grade">
                    <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                </a>
            </div>

        </div>
        
        @if(count($grades) == 0)
            <div class="panel-body text-center">
                <h4>No Grades Available!</h4>
            </div>
        @else
        <div class="panel-body panel-body-with-table">
            <div class="table-responsive">

                <table class="table table-striped ">
                    <thead>
                        <tr>
                            <th>Grade Name</th>
                            <th>Curriculum</th>
                            <th>Createdby</th>

                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($grades as $grade)
                        <tr>
                            <td>{{ $grade->grade_name }}</td>
                            <td>{{ optional($grade->curriculum)->curriculum_gradelist_name }}</td>
                            <td>{{ $grade->createdby }}</td>

                            <td>

                                <form method="POST" action="{!! route('grades.grade.destroy', $grade->id) !!}" accept-charset="UTF-8">
                                <input name="_method" value="DELETE" type="hidden">
                                {{ csrf_field() }}

                                    <div class="btn-group btn-group-xs pull-right" role="group">
                                        <a href="{{ route('grades.grade.show', $grade->id ) }}" class="btn btn-info" title="Show Grade">
                                            <span class="glyphicon glyphicon-open" aria-hidden="true"></span>
                                        </a>
                                        <a href="{{ route('grades.grade.edit', $grade->id ) }}" class="btn btn-primary" title="Edit Grade">
                                            <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
                                        </a>

                                        <button type="submit" class="btn btn-danger" title="Delete Grade" onclick="return confirm('Delete Grade?')">
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
            {!! $grades->render() !!}
        </div>
        
        @endif
    
    </div>
@endsection