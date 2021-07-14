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
                <h4 class="mt-5 mb-5">Classexams</h4>
            </div>

            <div class="btn-group btn-group-sm pull-right" role="group">
                <a href="{{ route('classexams.classexam.create') }}" class="btn btn-success" title="Create New Classexam">
                    <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                </a>
            </div>

        </div>
        
        @if(count($classexams) == 0)
            <div class="panel-body text-center">
                <h4>No Classexams Available!</h4>
            </div>
        @else
        <div class="panel-body panel-body-with-table">
            <div class="table-responsive">

                <table class="table table-striped ">
                    <thead>
                        <tr>
                            <th>Class</th>
                            <th>Exam</th>
                            <th>Addedon</th>

                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($classexams as $classexam)
                        <tr>
                            <td>{{ optional($classexam->courseclass)->id }}</td>
                            <td>{{ optional($classexam->exam)->id }}</td>
                            <td>{{ $classexam->addedon }}</td>

                            <td>

                                <form method="POST" action="{!! route('classexams.classexam.destroy', $classexam->id) !!}" accept-charset="UTF-8">
                                <input name="_method" value="DELETE" type="hidden">
                                {{ csrf_field() }}

                                    <div class="btn-group btn-group-xs pull-right" role="group">
                                        <a href="{{ route('classexams.classexam.show', $classexam->id ) }}" class="btn btn-info" title="Show Classexam">
                                            <span class="glyphicon glyphicon-open" aria-hidden="true"></span>
                                        </a>
                                        <a href="{{ route('classexams.classexam.edit', $classexam->id ) }}" class="btn btn-primary" title="Edit Classexam">
                                            <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
                                        </a>

                                        <button type="submit" class="btn btn-danger" title="Delete Classexam" onclick="return confirm(&quot;Delete Classexam?&quot;)">
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
            {!! $classexams->render() !!}
        </div>
        
        @endif
    
    </div>
@endsection