@extends('layouts.admin')
@section('header_styles')
@endsection
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

     @if(Session::has('error_message'))
        <div class="alert alert-danger">
            <span class="glyphicon glyphicon-ok"></span>
            {!! session('error_message') !!}

            <button type="button" class="close" data-dismiss="alert" aria-label="close">
                <span aria-hidden="true">&times;</span>
            </button>

        </div>
    @endif

    <div class="panel panel-default">

        <div class="panel-heading clearfix">

            <div class="pull-left">
                <h4 class="mt-5 mb-5">Exercisesets</h4>
            </div>

            <div class="btn-group btn-group-sm pull-right" role="group">
                <a href="{{ route('admin.exercise.create') }}" class="btn btn-success" title="Create Exercise">
                    <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                </a>
            </div>

        </div>
        
        @if(count($exercisesets) == 0)
            <div class="panel-body text-center">
                <h4>No Exercisesets Available!</h4>
            </div>
        @else
        <div class="panel-body panel-body-with-table">
            <div class="table-responsive">

                <table class="table table-striped ">
                    <thead>
                        <tr>
                            <th>Exercise Title</th>
                            <th>Discipline</th>
                            <th>Grade</th>
                            <th>Language</th>
                            <th>Createdby</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($exercisesets as $exercise)
                        <tr>
                            <td>{{ optional($exercise)->title }}</td>
                            <td>{{ optional($exercise->discipline)->discipline_name }}</td>
                            <td>{{ optional($exercise->grade)->grade_name }}</td>
                            <td>{{ optional($exercise->language)->language }}</td>
                            <td>{{ optional($exercise->owner)->name }}</td>

                            <td>

                                <form method="POST" action="{!! route('admin.exercise.destroy', $exercise->id) !!}" accept-charset="UTF-8">
                                <input name="_method" value="DELETE" type="hidden">
                                {{ csrf_field() }}

                                    <div class="btn-group btn-group-xs pull-right" role="group">
                                        <a href="{{ route('admin.exercise.show', $exercise->id ) }}" class="btn btn-info" title="Show Exercise">
                                            <span class="glyphicon glyphicon-open" aria-hidden="true"></span>
                                        </a>
                                        <a href="{{ route('admin.exercise.edit', $exercise->id ) }}" class="btn btn-primary" title="Edit Exercise">
                                            <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
                                        </a>

                                        <button type="submit" class="btn btn-danger" title="Delete Exercise" onclick="return confirm(&quot;Delete Skill?;&quot;)">
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
            {!! $exercisesets->render() !!}
        </div>
        
        @endif
    
    </div>
@endsection