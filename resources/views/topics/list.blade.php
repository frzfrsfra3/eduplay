@extends('layouts.app')

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
                <h4 class="mt-5 mb-5">Topics</h4>
            </div>

            <div class="btn-group btn-group-sm pull-right" role="group">
                <a href="{{ route('topics.topic.create') }}" class="btn btn-success" title="Create New Topic">
                    <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                </a>
            </div>

        </div>
        
        @if(count($topics) == 0)
            <div class="panel-body text-center">
                <h4>No Topics Available!</h4>
            </div>
        @else
        <div class="panel-body panel-body-with-table">
            <div class="table-responsive">

                <table class="table table-striped ">
                    <thead>
                        <tr>
                            <th>Topic Name</th>
                            <th>Discipline</th>
                            <th>Approve Status</th>
                            <th>Publish Status</th>
                            <th>Createdby</th>
                            <th>Updatedby</th>

                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($topics as $topic)
                        <tr>
                            <td>{{ $topic->topic_name }}</td>
                            <td>{{ optional($topic->discipline)->discipline_name }}</td>
                            <td>{{ $topic->approve_status }}</td>
                            <td>{{ $topic->publish_status }}</td>
                            <td>{{ $topic->createdby }}</td>
                            <td>{{ $topic->updatedby }}</td>

                            <td>

                                <form method="POST" action="{!! route('topics.topic.destroy', $topic->id) !!}" accept-charset="UTF-8">
                                <input name="_method" value="DELETE" type="hidden">
                                {{ csrf_field() }}

                                    <div class="btn-group btn-group-xs pull-right" role="group">
                                        <a href="{{ route('topics.topic.show', $topic->id ) }}" class="btn btn-info" title="Show Topic">
                                            <span class="glyphicon glyphicon-open" aria-hidden="true"></span>
                                        </a>
                                        <a href="{{ route('topics.topic.edit', $topic->id ) }}" class="btn btn-primary" title="Edit Topic">
                                            <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
                                        </a>

                                        <button type="submit" class="btn btn-danger" title="Delete Topic" onclick="return confirm('Delete Topic?')">
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
            {!! $topics->render() !!}
        </div>
        
        @endif
    
    </div>
@endsection