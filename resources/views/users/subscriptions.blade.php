@extends('layouts.admin')

@section('content')

<div class="panel panel-default">
    <div class="panel-heading clearfix">

        <span class="pull-left">
            <h4 class="mt-5 mb-5">{{ isset($user->name) ? $user->name : 'User' }}</h4>
        </span>
        <div class="pull-right">
            <a href="{{ route('users.user.index') }}" class="btn btn-primary" title="Show All User">
                <span class="glyphicon glyphicon-th-list" aria-hidden="true"></span>
            </a>
        </div>
    </div>
    <div class="panel-body" style="padding:10px;">
        @if(count($user->subscriptions) == 0)
            <div class="alert alert-info">There is no subscription found for this user!</div>
        <hr>
        @endif
        <h4>User Subscriptions</h4>

        <form action="{{ route('subscriptions.store' , ['user' => $user->id]) }}" method="post">
            @csrf
            <input type="hidden" name="user_id" value="{{ $user->id }}">
            <div class="row" style="padding: 10px;">
                <div class="col-md-6">
                    <label for="plan_id">Select an option:</label>
                    <select name="plan_id" id="" class="form-control">
                        @php
                            // Classify options by role name
                            $options = [];
                            foreach ($plans as $plan) {
                                $options[$plan->role->name][$plan->id] = $plan->name;
                            }
                        @endphp
                        @foreach ($options as $role => $rolePlans)
                            <optgroup label="{{ $role }}">
                                @foreach ($rolePlans as $id => $label)
                                    <option value="{{ $id }}">{{ $label }}</>
                                @endforeach
                            </optgroup>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-6">
                    <label for="">Months:</label>
                    <input class="form-control" name="months" type="number" value="1" min="1">
                </div>
                <div class="col-md-12" style="margin:10px;">
                    <button class="btn btn-primary">add</button>
                </div>
            </div>
        </form>

        <div class="table-responsive">
            <table class="table table-striped ">
                <thead>
                    <tr>
                        <th>Plan</th>
                        <th>Subscribed at</th>
                        <th>Expired at</th>
                        <th>Control</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($user->subscriptions as $subscription)
                        <tr>
                            <td>[{{ $subscription->plan->role->name }}] {{ $subscription->plan->name }}</td>
                            <td>{{ $subscription->subscribed_at }}</td>
                            <td>{{ $subscription->expired_at }}</td>
                            <td>
                                <form action="{{ route('subscriptions.destroy' , ['user' => $user->id , 'subscription' => $subscription->id])}}" method="POST">
                                    @csrf
                                    <input type="hidden" name="_method" value="DELETE">
                                    <button class="btn btn-danger">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection