@extends('layout.app')

@section('content')
    <div class="container-fluid bg-secondary vw-100 vh-100">
        <div class="row">
            <div class="col-md-12">
                @include('layout.sessionmsg')
            </div>
        </div>
        <div class="d-flex align-items-center justify-content-center gap-2 h-100">
            <form action="{{ route('sumsub.getApplicant') }}" method="post">
                @csrf
                <button class="btn btn-light align-middle" type="submit">
                    Get Applicant
                </button>
            </form>

            <form action="{{ route('sumsub.getApplicantVerificationSteps') }}" method="post">
                @csrf
                <button class="btn btn-light align-middle" type="submit">
                    Get Applicant Verification Steps
                </button>
            </form>

            <a class="initiateOnfidoBtn btn btn-primary align-middle" href="{{ route('sumsub.register') }}">
                Run SumSub
            </a>
        </div>
    </div>
@endsection
