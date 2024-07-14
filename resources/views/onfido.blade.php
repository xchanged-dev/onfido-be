@extends('layout.app')

@section('content')
    <div class="container vw-100 vh-100">
        <div class="d-flex justify-content-center h-100 py-5" id="onfido-mount"></div>
    </div>
@endsection

@section('script')
    <script src="https://sdk.onfido.com/v14.30.0" charset="utf-8"></script>
    <script type="module">
        $(document).ready(function() {
            Onfido.init({
                token: '{{ $sdkToken }}',
                containerId: 'onfido-mount',
                onComplete: function(data) {
                    // window.location.replace("{{ route('completed') }}");
                },
                onError: function(data) {
                    console.log('onfido error: ', data);
                },
                workflowRunId: '{{ $workflowId }}',
            })
        })
    </script>
@endsection
