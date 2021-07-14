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
                <h4 class="mt-5 mb-5">Examquestions</h4>
            </div>

            <div class="btn-group btn-group-sm pull-right" role="group">
                <a href="{{ route('examquestions.examquestion.create') }}" class="btn btn-success" title="Create New Examquestion">
                    <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                </a>
            </div>

        </div>
        
        @if(count($examquestions) == 0)
            <div class="panel-body text-center">
                <h4>No Examquestions Available!</h4>
            </div>
        @else
        <div class="panel-body panel-body-with-table">
            <div class="table-responsive">

                <table class="table table-striped ">
                    <thead>
                        <tr>
                            <th>Exam</th>
                            <th>Question</th>
                            <th>Sort Order</th>

                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($examquestions as $examquestion)
                        <tr>
                            <td>{{ optional($examquestion->exam)->id }}</td>
                            <td>{{ optional($examquestion->question)->id }}</td>
                            <td>{{ $examquestion->sort_order }}</td>

                            <td>

                                <form method="POST" action="{!! route('examquestions.examquestion.destroy', $examquestion->id) !!}" accept-charset="UTF-8">
                                <input name="_method" value="DELETE" type="hidden">
                                {{ csrf_field() }}

                                    <div class="btn-group btn-group-xs pull-right" role="group">
                                        <a href="{{ route('examquestions.examquestion.show', $examquestion->id ) }}" class="btn btn-info" title="Show Examquestion">
                                            <span class="glyphicon glyphicon-open" aria-hidden="true"></span>
                                        </a>
                                        <a href="{{ route('examquestions.examquestion.edit', $examquestion->id ) }}" class="btn btn-primary" title="Edit Examquestion">
                                            <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
                                        </a>

                                        <button type="submit" class="btn btn-danger" title="Delete Examquestion" onclick="return confirm(&quot;Delete Examquestion?&quot;)">
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
            {!! $examquestions->render() !!}
        </div>
        
        @endif
    
    </div>
@endsection