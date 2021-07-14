@extends('layouts.admin')

@section('content')

    <div class="panel panel-default">

        <div class="panel-heading clearfix">

            <div class="pull-left">
                <h4 class="mt-5 mb-5">Disciplines - Curriculum</h4>
            </div>

            <div class="btn-group btn-group-sm pull-right" role="group">
                <a href="{{ route('disciplines.discipline.create') }}" class="btn btn-success" title="Create New Discipline">
                    <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                </a>
            </div>

        </div>

        @if(count($disciplines) == 0)
            <div class="panel-body text-center">
                <h4>No Disciplines - Curriculum Available!</h4>
            </div>
        @else
            <div class="panel-body panel-body-with-table">
                <div class="table-responsive">

                    <table class="table table-striped ">
                        <thead>
                        <tr>
                            <th>Discipline Curriculum Name</th>

                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($disciplines as $discipline)
                            <tr>
                                <td>{{ $discipline->discipline_name }}</td>

                                <td>

                                    <form method="POST" action="{!! route('disciplines.discipline.destroy', $discipline->id) !!}" accept-charset="UTF-8">
                                        <input name="_method" value="DELETE" type="hidden">
                                        {{ csrf_field() }}

                                        <div class="btn-group btn-group-xs pull-right" role="group">
                                            <a href="{{ route('disciplines.discipline.show', $discipline->id ) }}" class="btn btn-info" title="Show Discipline">
                                                <span class="glyphicon glyphicon-open" aria-hidden="true"></span>
                                            </a>
                                            <a href="{{ route('disciplines.discipline.edit', $discipline->id ) }}" class="btn btn-primary" title="Edit Discipline">
                                                <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
                                            </a>

                                            <button type="submit" class="btn btn-danger" title="Delete Discipline" onclick="return confirm('Delete Discipline?')">
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

            </div>

            @endif

        </div>
    @endsection