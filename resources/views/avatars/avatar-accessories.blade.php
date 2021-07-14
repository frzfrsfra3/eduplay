@extends('layouts.admin')
@section('header_styles')
@endsection
@section('content')

    @if(Session::has('success_message'))
        <div class="alert alert-success">
            <span class="glyphicon glyphicon-ok"></span>
            {!! session('success_message') !!}

            <button type="button" class="close" data-dismiss="alert" aria-label="close">
                <span aria-hidden="true">&times;</span>
            </button>

        </div>
    @endif

    <div class="panel panel-default">

        <div class="panel-heading clearfix">

            <div class="pull-left">
                <h4 class="mt-5 mb-5">Skills</h4>
            </div>

            <div class="btn-group btn-group-sm pull-right" role="group">
                <a href="{{ route('avatars.accessories.create') }}" class="btn btn-success" title="Create New Avatar Accessories">
                    <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                </a>
            </div>

        </div>
        
        @if(count($avatarAccessories) == 0)
            <div class="panel-body text-center">
                <h4>No Skills Available!</h4>
            </div>
        @else
        <div class="panel-body panel-body-with-table">
            <div class="table-responsive">

                <table class="table table-striped ">
                    <thead>
                        <tr>
                            {{-- <th>Avatar Image</th> --}}
                            <th>Accessories Image</th>
                            <th>Points</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($avatarAccessories as $accessories)
                        <tr>
                            {{-- <td><img src="{{ asset('assets/eduplaycloud/image/'.$accessories->avatar->image) }}" width="100px"></td> --}}
                            <td><img src="{{ asset('assets/eduplaycloud/image/'.$accessories->image) }}" width="100px"></td>
                            <td>{{ $accessories->points }}</td>
                            <td>
                                <form method="POST" action="{!! route('avatars.accessories.destroy', $accessories->id) !!}" accept-charset="UTF-8">
                                <input name="_method" value="DELETE" type="hidden">
                                {{ csrf_field() }}
                                    <div class="btn-group btn-group-xs pull-right" role="group">
                                        <a href="{{ route('avatars.accessories.edit', $accessories->id ) }}" class="btn btn-primary" title="Edit Avatar Accessories">
                                          <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
                                        </a>
                                        <button type="submit" class="btn btn-danger" title="Delete Avatar" onclick="return confirm(&quot;Delete Avatar?;&quot;)">
                                            <span class="glyphicon glyphicon-trash" aria-hidden="true"></span>
                                        </button>
                                    </div>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>

            </div>
        </div>

        <div class="panel-footer">
            {!! $avatarAccessories->render() !!}
        </div>
        
        @endif
    
    </div>
@endsection