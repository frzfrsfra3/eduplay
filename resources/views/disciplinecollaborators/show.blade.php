@extends('layouts.default')

@section('content')

<div class="panel panel-default">
    <div class="panel-heading clearfix">

        <span class="pull-left">
            <h4 class="mt-5 mb-5">{{ isset($title) ? $title : 'Disciplinecollaborator' }}</h4>
        </span>

        <div class="pull-right">

            <form method="POST" action="{!! route('disciplinecollaborators.disciplinecollaborator.destroy', $disciplinecollaborator->id) !!}" accept-charset="UTF-8">
            <input name="_method" value="DELETE" type="hidden">
            {{ csrf_field() }}
                <div class="btn-group btn-group-sm" role="group">
                    <a href="{{ route('disciplinecollaborators.disciplinecollaborator.index') }}" class="btn btn-primary" title="Show All Disciplinecollaborator">
                        <span class="glyphicon glyphicon-th-list" aria-hidden="true"></span>
                    </a>

                    <a href="{{ route('disciplinecollaborators.disciplinecollaborator.create') }}" class="btn btn-success" title="Create New Disciplinecollaborator">
                        <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                    </a>
                    
                    <a href="{{ route('disciplinecollaborators.disciplinecollaborator.edit', $disciplinecollaborator->id ) }}" class="btn btn-primary" title="Edit Disciplinecollaborator">
                        <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
                    </a>

                    <button type="submit" class="btn btn-danger" title="Delete Disciplinecollaborator" onclick="return confirm(&quot;Delete Disciplinecollaborator??&quot;)">
                        <span class="glyphicon glyphicon-trash" aria-hidden="true"></span>
                    </button>
                </div>
            </form>

        </div>

    </div>

    <div class="panel-body">
        <dl class="dl-horizontal">
            <dt>Discipline</dt>
            <dd>{{ optional($disciplinecollaborator->discipline)->id }}</dd>
            <dt>User</dt>
            <dd>{{ optional($disciplinecollaborator->user)->id }}</dd>
            <dt>Message</dt>
            <dd>{{ $disciplinecollaborator->message }}</dd>
            <dt>Iscoordinator</dt>
            <dd>{{ ($disciplinecollaborator->iscoordinator) ? 'Yes' : 'No' }}</dd>
            <dt>Approvalstatus</dt>
            <dd>{{ $disciplinecollaborator->approvalstatus }}</dd>
            <dt>Created At</dt>
            <dd>{{ $disciplinecollaborator->created_at }}</dd>

        </dl>

    </div>
</div>

@endsection