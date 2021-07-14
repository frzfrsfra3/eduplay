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
                <h4 class="mt-5 mb-5">Practiceresults</h4>
            </div>

            <div class="btn-group btn-group-sm pull-right" role="group">
                <a href="{{ route('practiceresults.practiceresult.create') }}" class="btn btn-success" title="Create New Practiceresult">
                    <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                </a>
            </div>

        </div>
        
        @if(count($practiceresults) == 0)
            <div class="panel-body text-center">
                <h4>No Practiceresults Available!</h4>
            </div>
        @else
        <div class="panel-body panel-body-with-table">
            <div class="table-responsive">

                <table class="table table-striped ">
                    <thead>
                        <tr>
                            <th>Question</th>
                            <th>Answeroption</th>
                            <th>Iscorrect</th>
                            <th>Topics</th>
                            <th>Exercise</th>

                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($practiceresults as $practiceresult)
                        <tr>
                            <td>{{ optional($practiceresult->question)->param }}</td>
                            <td>{{ optional($practiceresult->answeroption)->answer_type }}</td>
                            <td>{{ ($practiceresult->iscorrect) ? 'Yes' : 'No' }}</td>
                            <td>{{ optional($practiceresult->topic)->topic_name }}</td>
                            <td>{{ optional($practiceresult->exercise)->id }}</td>

                            <td>

                                <form method="POST" action="{!! route('practiceresults.practiceresult.destroy', $practiceresult->id) !!}" accept-charset="UTF-8">
                                <input name="_method" value="DELETE" type="hidden">
                                {{ csrf_field() }}

                                    <div class="btn-group btn-group-xs pull-right" role="group">
                                        <a href="{{ route('practiceresults.practiceresult.show', $practiceresult->id ) }}" class="btn btn-info" title="Show Practiceresult">
                                            <span class="glyphicon glyphicon-open" aria-hidden="true"></span>
                                        </a>
                                        <a href="{{ route('practiceresults.practiceresult.edit', $practiceresult->id ) }}" class="btn btn-primary" title="Edit Practiceresult">
                                            <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
                                        </a>

                                        <button type="submit" class="btn btn-danger" title="Delete Practiceresult" onclick="return confirm('Delete Practiceresult?')">
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
            {!! $practiceresults->render() !!}
        </div>
        
        @endif
    
    </div>
@endsection