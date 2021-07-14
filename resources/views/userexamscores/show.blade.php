@extends('layouts.app')

@section('content')

<div class="panel panel-default">
    <div class="panel-heading clearfix">

        <span class="pull-left">
            <h4 class="mt-5 mb-5">{{ isset($title) ? $title : 'Userexamscore' }}</h4>
        </span>

        <div class="pull-right">

            <form method="POST" action="{!! route('userexamscores.userexamscore.destroy', $userexamscore->id) !!}" accept-charset="UTF-8">
            <input name="_method" value="DELETE" type="hidden">
            {{ csrf_field() }}
                <div class="btn-group btn-group-sm" role="group">
                    <a href="{{ route('userexamscores.userexamscore.index') }}" class="btn btn-primary" title="Show All Userexamscore">
                        <span class="glyphicon glyphicon-th-list" aria-hidden="true"></span>
                    </a>

                    <a href="{{ route('userexamscores.userexamscore.create') }}" class="btn btn-success" title="Create New Userexamscore">
                        <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                    </a>
                    
                    <a href="{{ route('userexamscores.userexamscore.edit', $userexamscore->id ) }}" class="btn btn-primary" title="Edit Userexamscore">
                        <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
                    </a>

                    <button type="submit" class="btn btn-danger" title="Delete Userexamscore" onclick="return confirm(&quot;Delete Userexamscore??&quot;)">
                        <span class="glyphicon glyphicon-trash" aria-hidden="true"></span>
                    </button>
                </div>
            </form>

        </div>

    </div>

    <div class="panel-body">
        <dl class="dl-horizontal">
            <dt>User</dt>
            <dd>{{ optional($userexamscore->user)->id }}</dd>
            <dt>Exam</dt>
            <dd>{{ optional($userexamscore->exam)->title }}</dd>
            <dt>Score</dt>
            <dd>{{ $userexamscore->score }}</dd>
            <dt>Totaltimespent</dt>
            <dd>{{ $userexamscore->totaltimespent }}</dd>
            <dt>Created At</dt>
            <dd>{{ $userexamscore->created_at }}</dd>
            <dt>Skill</dt>
            <dd>{{ optional($userexamscore->skill)->skill_name }}</dd>

        </dl>

    </div>
</div>

@endsection