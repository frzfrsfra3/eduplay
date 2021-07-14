@extends('layouts.admin')

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

        <span class="pull-left">
            <h4 class="mt-5 mb-5">Database Cleaner</h4>
        </span>
    </div>

    <div class="panel-body">

    <table class="table table-striped ">
      <thead>
          <tr>
              <th>Table name</th>
              <th>Action Note</th>
              <th></th>
          </tr>
      </thead>
      <tbody>
        <tr>
          <td>answeroptions</td>
          <td>
            <small>it will delete answeroption that do not have parent question.</small>
          </td>
          <td>
            <div class="btn-group btn-group-xs pull-right" role="group">
               <a href="{{route('admin.answer.clean')}}" class="btn btn-primary" title="Do Clean">
                 Do clean
              </a>
            </div>  
          </td>
        </tr>
         <tr>
          <td>questions</td>
           <td>
            <small>it will delete questions that do not have parent exercise.</small>
          </td>
          <td>
            <div class="btn-group btn-group-xs pull-right" role="group">
               <a href="{{route('admin.questions.clean')}}" class="btn btn-primary" title="Do Clean">
                 Do clean
              </a>
            </div>  
          </td>
        </tr>
         <tr>
          <td>exercise</td>
           <td>
            <small>it will delete exercise that do not have parent user.</small>
          </td>
          <td>
            <div class="btn-group btn-group-xs pull-right" role="group">
               <a href="{{route('admin.exercise.clean')}}" class="btn btn-primary" title="Do Clean">
                 Do clean
              </a>
            </div>  
          </td>
        </tr>
      </tbody>
    </table>
   </div>
</div>

@endsection