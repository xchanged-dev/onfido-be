@extends('layout.app')

@section('content')
    <div class="container-fluid bg-secondary vw-100 vh-100">
        <div class="row">
            <div class="col-md-12">
                @include('layout.sessionmsg')
            </div>
        </div>
        <div class="d-flex align-items-center justify-content-center gap-2 h-100">
            <h1 class="text-light">Completed</h1>
        </div>
    </div>
@endsection
