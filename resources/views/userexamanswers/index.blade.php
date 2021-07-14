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
                <h4 class="mt-5 mb-5">Userexamanswers</h4>
            </div>

            <div class="btn-group btn-group-sm pull-right" role="group">
                <a href="{{ route('userexamanswers.userexamanswer.create') }}" class="btn btn-success" title="Create New Userexamanswer">
                    <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                </a>
            </div>

        </div>
        
        @if(count($userexamanswers) == 0)
            <div class="panel-body text-center">
                <h4>No Userexamanswers Available!</h4>
            </div>
        @else
        <div class="panel-body panel-body-with-table">
            <div class="table-responsive">

                <table class="table table-striped ">
                    <thead>
                        <tr>
                            <th>Answerdate</th>
                            <th>User</th>
                            <th>Exam</th>
                            <th>Attempt Number</th>
                            <th>Question</th>
                            <th>Answer</th>
                            <th>Timespent</th>
                            <th>Iscorrect</th>
                            <th>Teachermark</th>
                            <th>Pointsgained</th>
                            <th>Gameid</th>

                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($userexamanswers as $userexamanswer)
                        <tr>
                            <td>{{ $userexamanswer->answerdate }}</td>
                            <td>{{ optional($userexamanswer->user)->id }}</td>
                            <td>{{ optional($userexamanswer->exam)->title }}</td>
                            <td>{{ $userexamanswer->attempt_number }}</td>
                            <td>{{ optional($userexamanswer->question)->details }}</td>
                            <td>{{ optional($userexamanswer->answer)->id }}</td>
                            <td>{{ $userexamanswer->timespent }}</td>
                            <td>{{ $userexamanswer->iscorrect }}</td>
                            <td>{{ $userexamanswer->teachermark }}</td>
                            <td>{{ $userexamanswer->pointsgained }}</td>
                            <td>{{ $userexamanswer->gameid }}</td>

                            <td>

                                <form method="POST" action="{!! route('userexamanswers.userexamanswer.destroy', $userexamanswer->id) !!}" accept-charset="UTF-8">
                                <input name="_method" value="DELETE" type="hidden">
                                {{ csrf_field() }}

                                    <div class="btn-group btn-group-xs pull-right" role="group">
                                        <a href="{{ route('userexamanswers.userexamanswer.show', $userexamanswer->id ) }}" class="btn btn-info" title="Show Userexamanswer">
                                            <span class="glyphicon glyphicon-open" aria-hidden="true"></span>
                                        </a>
                                        <a href="{{ route('userexamanswers.userexamanswer.edit', $userexamanswer->id ) }}" class="btn btn-primary" title="Edit Userexamanswer">
                                            <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
                                        </a>

                                        <button type="submit" class="btn btn-danger" title="Delete Userexamanswer" onclick="return confirm(&quot;Delete Userexamanswer?&quot;)">
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
            {!! $userexamanswers->render() !!}
        </div>
        
        @endif
    
    </div>
@endsection