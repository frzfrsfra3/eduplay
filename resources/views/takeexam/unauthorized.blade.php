
@extends('layouts.app')


@section ('top')

    @php
        if ($classexam) {

        $exam =$classexam->exam ;
        $classid=$classexam->class_id;

        }
       else {
     $exam =null ;
    $classid=null;
     }
    @endphp

    @include('takeexam.navigation',[$exam   ,  $classid])
@endsection

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card card-default">
                <div class="card-header">Need to design a nice page for unauthorized</div>

                <div class="card-body">
                    You are not authorized , to take this exam .
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
