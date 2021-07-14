@extends('layouts.app')

@section('content')

<div class="panel panel-default">
    <div class="panel-heading clearfix">

        <span class="pull-left">
            <h4 class="mt-5 mb-5">{{ isset($title) ? $title : 'Userexamanswer' }}</h4>
        </span>

        <div class="pull-right">

            <form method="POST" action="{!! route('userexamanswers.userexamanswer.destroy', $userexamanswer->id) !!}" accept-charset="UTF-8">
            <input name="_method" value="DELETE" type="hidden">
            {{ csrf_field() }}
                <div class="btn-group btn-group-sm" role="group">
                    <a href="{{ route('userexamanswers.userexamanswer.index') }}" class="btn btn-primary" title="Show All Userexamanswer">
                        <span class="glyphicon glyphicon-th-list" aria-hidden="true"></span>
                    </a>

                    <a href="{{ route('userexamanswers.userexamanswer.create') }}" class="btn btn-success" title="Create New Userexamanswer">
                        <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                    </a>
                    
                    <a href="{{ route('userexamanswers.userexamanswer.edit', $userexamanswer->id ) }}" class="btn btn-primary" title="Edit Userexamanswer">
                        <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
                    </a>

                    <button type="submit" class="btn btn-danger" title="Delete Userexamanswer" onclick="return confirm(&quot;Delete Userexamanswer??&quot;)">
                        <span class="glyphicon glyphicon-trash" aria-hidden="true"></span>
                    </button>
                </div>
            </form>

        </div>

    </div>

    <div class="panel-body">
        <dl class="dl-horizontal">
            <dt>Answerdate</dt>
            <dd>{{ $userexamanswer->answerdate }}</dd>
            <dt>User</dt>
            <dd>{{ optional($userexamanswer->user)->id }}</dd>
            <dt>Exam</dt>
            <dd>{{ optional($userexamanswer->exam)->title }}</dd>
            <dt>Attempt Number</dt>
            <dd>{{ $userexamanswer->attempt_number }}</dd>
            <dt>Question</dt>
            <dd>{{ optional($userexamanswer->question)->details }}</dd>
            <dt>Answer</dt>
            <dd>{{ optional($userexamanswer->answer)->id }}</dd>
            <dt>Timespent</dt>
            <dd>{{ $userexamanswer->timespent }}</dd>
            <dt>Iscorrect</dt>
            <dd>{{ $userexamanswer->iscorrect }}</dd>
            <dt>Teachermark</dt>
            <dd>{{ $userexamanswer->teachermark }}</dd>
            <dt>Pointsgained</dt>
            <dd>{{ $userexamanswer->pointsgained }}</dd>
            <dt>Gameid</dt>
            <dd>{{ $userexamanswer->gameid }}</dd>
            <dt>User Agent</dt>
            <dd>{{ $userexamanswer->user_agent }}</dd>

        </dl>

    </div>
</div>

@endsection