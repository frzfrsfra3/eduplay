@auth
    <script>
        parent.$.fancybox.close();
        parent.location = "/home";
    </script>
@endauth
@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card card-default">
                <div class="card-header">Need to design a nice page for unauthorized</div>

                <div class="card-body">
                    You are not authorized
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
