@extends('errors.layout')

@section('title', 'Page Expired')

@section('message')
    The page has expired due to inactivity.
    <br/><br/>
    It seems your session has been expired due to inactivity.
    <br/><br/>
    Please <a href="{{ route('welcome') }}">Click here</a> to  go to Homepage.
@stop
