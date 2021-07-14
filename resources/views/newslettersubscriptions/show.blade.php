@extends('layouts.app')

@section('content')

<div class="panel panel-default">
    <div class="panel-heading clearfix">

        <span class="pull-left">
            <h4 class="mt-5 mb-5">{{ isset($title) ? $title : 'Newslettersubscription' }}</h4>
        </span>

        <div class="pull-right">

            <form method="POST" action="{!! route('newslettersubscriptions.newslettersubscription.destroy', $newslettersubscription->id) !!}" accept-charset="UTF-8">
            <input name="_method" value="DELETE" type="hidden">
            {{ csrf_field() }}
                <div class="btn-group btn-group-sm" role="group">
                    <a href="{{ route('newslettersubscriptions.newslettersubscription.index') }}" class="btn btn-primary" title="Show All Newslettersubscription">
                        <span class="glyphicon glyphicon-th-list" aria-hidden="true"></span>
                    </a>

                    <a href="{{ route('newslettersubscriptions.newslettersubscription.create') }}" class="btn btn-success" title="Create New Newslettersubscription">
                        <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                    </a>
                    
                    <a href="{{ route('newslettersubscriptions.newslettersubscription.edit', $newslettersubscription->id ) }}" class="btn btn-primary" title="Edit Newslettersubscription">
                        <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
                    </a>

                    <button type="submit" class="btn btn-danger" title="Delete Newslettersubscription" onclick="return confirm(&quot;Delete Newslettersubscription??&quot;)">
                        <span class="glyphicon glyphicon-trash" aria-hidden="true"></span>
                    </button>
                </div>
            </form>

        </div>

    </div>

    <div class="panel-body">
        <dl class="dl-horizontal">
            <dt>Email</dt>
            <dd>{{ $newslettersubscription->email }}</dd>
            <dt>Subscribedon</dt>
            <dd>{{ $newslettersubscription->subscribedon }}</dd>

        </dl>

    </div>
</div>

@endsection