@extends('layouts.admin')

@section('content')

<div class="panel panel-default">
    <div class="panel-heading clearfix">

        <span class="pull-left">
            <h4 class="mt-5 mb-5">{{ isset($user->name) ? $user->name : 'User' }}</h4>
        </span>

        <div class="pull-right">

            <form method="POST" action="{!! route('users.user.destroy', $user->id) !!}" accept-charset="UTF-8">
            <input name="_method" value="DELETE" type="hidden">
            {{ csrf_field() }}
                <div class="btn-group btn-group-sm" role="group">
                    <a href="{{ route('users.user.index') }}" class="btn btn-primary" title="Show All User">
                        <span class="glyphicon glyphicon-th-list" aria-hidden="true"></span>
                    </a>

                    <a href="{{ route('users.user.create') }}" class="btn btn-success" title="Create New User">
                        <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                    </a>
                    
                    <a href="{{ route('users.user.edit', $user->id ) }}" class="btn btn-primary" title="Edit User">
                        <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
                    </a>

                    <button type="submit" class="btn btn-danger" title="Delete User" onclick="return confirm(&quot;Delete User??&quot;)">
                        <span class="glyphicon glyphicon-trash" aria-hidden="true"></span>
                    </button>
                </div>
            </form>

        </div>

    </div>

    <div class="panel-body">
        <dl class="dl-horizontal">
            <dt>Name</dt>
            <dd>{{ $user->name }}</dd>
            <dt>Email</dt>
            <dd>{{ $user->email }}</dd>
            <dt>Provider</dt>
            <dd>{{ $user->provider }}</dd>
            <dt>Provider</dt><dd>{{ optional($user->provider)->id }}</dd>
            <dt>Mobile</dt>
            <dd>{{ $user->mobile }}</dd>
            <dt>Gender</dt>
            <dd>{{ $user->gender }}</dd>
            <dt>Password</dt>
            <dd>{{ $user->password }}</dd>
            <dt>User Image</dt>
            <dd>{{ $user->user_image }}</dd>
            <dt>Isactive</dt>
            <dd>{{ ($user->isactive) ? 'Yes' : 'No' }}</dd>
            <dt>Lastloggedon</dt>
            <dd>{{ $user->lastloggedon }}</dd>
            <dt>Registeredon</dt>
            <dd>{{ $user->registeredon }}</dd>
            <dt>Isverified</dt>
            <dd>{{ ($user->isverified) ? 'Yes' : 'No' }}</dd>
            <dt>Islearner</dt>
            <dd>{{ ($user->islearner) ? 'Yes' : 'No' }}</dd>
            <dt>Isteacher</dt>
            <dd>{{ ($user->isteacher) ? 'Yes' : 'No' }}</dd>
            <dt>Isparent</dt>
            <dd>{{ ($user->isparent) ? 'Yes' : 'No' }}</dd>
            <dt>Role Type</dt>
            <dd>{{ optional($user->roleType)->id }}</dd>
            <dt>Grade</dt>
            <dd>{{ optional($user->grade)->grade_name }}</dd>
            <dt>School</dt>
            <dd>{{ optional($user->school)->school_name }}</dd>
            <dt>Parent</dt>
            <dd>{{ optional($user->parent)->id }}</dd>
            <dt>Country</dt>
            <dd>{{ optional($user->country)->country_name }}</dd>
            <dt>Uilanguage</dt>
            <dd>{{ optional($user->uilanguage)->id }}</dd>
            <dt>Dob</dt>
            <dd>{{ $user->dob }}</dd>
            <dt>Phone</dt>
            <dd>{{ $user->phone }}</dd>
            <dt>Parentmail</dt>
            <dd>{{ $user->parentmail }}</dd>
            <dt>Isapproved Byparent</dt>
            <dd>{{ ($user->isapproved_byparent) ? 'Yes' : 'No' }}</dd>
            <dt>Isintroinfo Displayed</dt>
            <dd>{{ ($user->isintroinfo_displayed) ? 'Yes' : 'No' }}</dd>
            <dt>Passwordtoken</dt>
            <dd>{{ $user->passwordtoken }}</dd>
            <dt>Registeredby</dt>
            <dd>{{ $user->registeredby }}</dd>
            <dt>Totalpoints</dt>
            <dd>{{ $user->totalpoints }}</dd>
            <dt>Remember Token</dt>
            <dd>{{ $user->remember_token }}</dd>
            <dt>Created At</dt>
            <dd>{{ $user->created_at }}</dd>
            <dt>Updated At</dt>
            <dd>{{ $user->updated_at }}</dd>

        </dl>

    </div>
</div>

@endsection