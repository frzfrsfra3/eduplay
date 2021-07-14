@extends('layouts.app')

@section('content')

<div class="panel panel-default">
    <div class="panel-heading clearfix">

        <span class="pull-left">
            <h4 class="mt-5 mb-5">{{ isset($title) ? $title : 'Userinterest' }}</h4>
        </span>

        <div class="pull-right">

            <form method="POST" action="{!! route('userinterests.userinterest.destroy', $userinterest->id) !!}" accept-charset="UTF-8">
            <input name="_method" value="DELETE" type="hidden">
            {{ csrf_field() }}
                <div class="btn-group btn-group-sm" role="group">
                    <a href="{{ route('userinterests.userinterest.index') }}" class="btn btn-primary" title="Show All Userinterest">
                        <span class="glyphicon glyphicon-th-list" aria-hidden="true"></span>
                    </a>

                    <a href="{{ route('userinterests.userinterest.create') }}" class="btn btn-success" title="Create New Userinterest">
                        <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                    </a>
                    
                    <a href="{{ route('userinterests.userinterest.edit', $userinterest->id ) }}" class="btn btn-primary" title="Edit Userinterest">
                        <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
                    </a>

                    <button type="submit" class="btn btn-danger" title="Delete Userinterest" onclick="return confirm(&quot;Delete Userinterest??&quot;)">
                        <span class="glyphicon glyphicon-trash" aria-hidden="true"></span>
                    </button>
                </div>
            </form>

        </div>

    </div>

    <div class="panel-body">
        <dl class="dl-horizontal">
            <dt>Discipline</dt>
            <dd>{{ optional($userinterest->discipline)->discipline_name }}</dd>
            <dt>User</dt>
            <dd>{{ optional($userinterest->user)->id }}</dd>
            <dt>Created At</dt>
            <dd>{{ $userinterest->created_at }}</dd>

        </dl>

    </div>
</div>

@endsection