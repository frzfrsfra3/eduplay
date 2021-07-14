@extends('layouts.app')

@section('content')

<div class="panel panel-default">
    <div class="panel-heading clearfix">

        <span class="pull-left">
            <h4 class="mt-5 mb-5">{{ isset($title) ? $title : 'Badge' }}</h4>
        </span>

        <div class="pull-right">

            <form method="POST" action="{!! route('badges.badge.destroy', $badge->id) !!}" accept-charset="UTF-8">
            <input name="_method" value="DELETE" type="hidden">
            {{ csrf_field() }}
                <div class="btn-group btn-group-sm" role="group">
                    <a href="{{ route('badges.badge.index') }}" class="btn btn-primary" title="Show All Badge">
                        <span class="glyphicon glyphicon-th-list" aria-hidden="true"></span>
                    </a>

                    <a href="{{ route('badges.badge.create') }}" class="btn btn-success" title="Create New Badge">
                        <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                    </a>
                    
                    <a href="{{ route('badges.badge.edit', $badge->id ) }}" class="btn btn-primary" title="Edit Badge">
                        <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
                    </a>

                    <button type="submit" class="btn btn-danger" title="Delete Badge" onclick="return confirm(&quot;Delete Badge??&quot;)">
                        <span class="glyphicon glyphicon-trash" aria-hidden="true"></span>
                    </button>
                </div>
            </form>

        </div>

    </div>

    <div class="panel-body">
        <dl class="dl-horizontal">
            <dt>Badgetitle</dt>
            <dd>{{ $badge->badgetitle }}</dd>
            <dt>Badgedescription</dt>
            <dd>{{ $badge->badgedescription }}</dd>
            <dt>Badgeimageurl</dt>
            <dd>{{ $badge->badgeimageurl }}</dd>
            <dt>Points</dt>
            <dd>{{ $badge->points }}</dd>
            <dt>Badgeorder</dt>
            <dd>{{ $badge->badgeorder }}</dd>
            <dt>Isactive</dt>
            <dd>{{ ($badge->isactive) ? 'Yes' : 'No' }}</dd>
            <dt>Badge Condition</dt>
            <dd>{{ $badge->badge_condition }}</dd>
            <dt>Addedon</dt>
            <dd>{{ $badge->addedon }}</dd>
            <dt>Updated At</dt>
            <dd>{{ $badge->updated_at }}</dd>

        </dl>

    </div>
</div>

@endsection