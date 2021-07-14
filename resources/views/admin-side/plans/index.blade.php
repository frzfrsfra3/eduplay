@auth
    <script>
        parent.$.fancybox.close();
        parent.location = "/plans";
    </script>
@endauth
@extends('layouts.admin')

@section('content')
    @include('admin-side.plans.messages')

    <div class="panel panel-default">

        <div class="panel-heading clearfix">

            <div class="pull-left">
                <h4 class="mt-5 mb-5">Plans</h4>
            </div>

            <div class="btn-group btn-group-sm pull-right" role="group">
                <a href="{{ route('plans.create') }}" class="btn btn-success" title="Create New plan">
                    <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                </a>
            </div>

        </div>
        
        @if(count($plans) == 0)
            <div class="panel-body text-center">
                <h4>No plans Available!</h4>
            </div>
        @else
        <div class="panel-body panel-body-with-table">
            <div class="table-responsive">

                <table class="table table-striped ">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Price</th>
                            <th>Visibility</th>
                            <th>Control</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($plans as $plan)
                        <tr>
                            <td><a href="{{ route('plans.show' , [$plan->id] ) }}">[{{ $plan->role->name }}] {{ $plan->name }}</a></td>
                            <td>${{ $plan->price }}</td>
                            <td>{{ $plan->visibility }}</td>
                            <td>
                                <form action="{{ route('plans.destroy' , $plan->id)}}" method="POST" style="display: inline">
                                    @csrf
                                    <input type="hidden" name="_method" value="DELETE">
                                    <a href="{{ route('plans.show' , [$plan->id] ) }}" class="btn btn-primary">View</a>
                                    <button class="btn btn-danger">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>

            </div>
        </div>

        <div class="panel-footer">
            {!! $plans->render() !!}
        </div>
        
        @endif
    
    </div>
@endsection