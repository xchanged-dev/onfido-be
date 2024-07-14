@extends('layout.app')

@section('content')
    <div class="container-fluid bg-secondary vw-100 vh-100">
        <div class="row">
            <div class="col-md-12">
                @include('layout.sessionmsg')
            </div>
        </div>
        <div class="d-flex align-items-center justify-content-center gap-2 h-100">
            <form action="{{ route('register.applicant') }}" method="post">
                @csrf
                <button class="btn btn-light align-middle" type="submit">
                    Create Applicant
                </button>
            </form>

            <form action="{{ route('create.workflow') }}" method="post">
                @csrf
                <button class="btn btn-light align-middle" type="submit">
                    Create Workflow
                </button>
            </form>

            <a class="initiateOnfidoBtn btn btn-primary align-middle" href="{{ route('run.onfido') }}">
                Run Onfido
            </a>
        </div>
    </div>
@endsection
