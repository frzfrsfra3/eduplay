@extends('layouts.app')

@section('content')

<div class="panel panel-default">
    <div class="panel-heading clearfix">

        <span class="pull-left">
            <h4 class="mt-5 mb-5">{{ isset($title) ? $title : 'Question' }}</h4>
        </span>

        <div class="pull-right">

            <form method="POST" action="{!! route('questions.question.destroy', $question->id) !!}" accept-charset="UTF-8">
            <input name="_method" value="DELETE" type="hidden">
            {{ csrf_field() }}
                <div class="btn-group btn-group-sm" role="group">
                    <a href="{{ route('questions.question.index') }}" class="btn btn-primary" title="Show All Question">
                        <span class="glyphicon glyphicon-th-list" aria-hidden="true"></span>
                    </a>

                    <a href="{{ route('questions.question.create') }}" class="btn btn-success" title="Create New Question">
                        <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                    </a>

                    <a href="{{ route('questions.question.edit', $question->id ) }}" class="btn btn-primary" title="Edit Question">
                        <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
                    </a>

                    <button type="submit" class="glyphicon glyphicon-qrcode" title="Delete Question" onclick="return confirm('Delete Question?')">
                        <span class="glyphicon glyphicon-qrcode" aria-hidden="true"></span>
                    </button>
                </div>
            </form>

        </div>

    </div>
    <div class="container">
        <div class="panel-body">
            <dl class="dl-horizontal ">
                <dt>Details</dt>
                <dd>{!!  $question->details !!} </dd>
                <dt>Questiontype</dt>
                <dd>{{ $question->questiontype }}</dd>
                <dt>Skill</dt>
                <dd>{{ optional($question->skill)->skill_name }}</dd>
                <dt>Skillcategory</dt>
                <dd>{{ optional($question->skillcategory)->skill_category_name }}</dd>
                <dt>Maxtime</dt>
                <dd>{{ $question->maxtime }}</dd>
                <dt>Mintime</dt>
                <dd>{{ $question->mintime }}</dd>
                <dt>Exercise</dt>
                <dd>{{ optional($question->exercise)->title }}</dd>
                <dt>Difficultylevel</dt>
                <dd>{{ $question->difficultylevel }}</dd>
                <dt>Hint</dt>
                <dd>{{ $question->hint }}</dd>
                <dt>Created At</dt>
                <dd>{{ $question->created_at }}</dd>
                <dt>Updated At</dt>
                <dd>{{ $question->updated_at }}</dd>

            </dl>

        </div>
    </div>
</div>
@endsection