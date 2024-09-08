@extends('layout.app')

@section('content')
    <div class="container vw-100 vh-100">
        <div class='d-flex justify-content-center h-100 py-5' id="sumsub-websdk-container"></div>
    </div>
@endsection

@section('script')
    <script src="https://static.sumsub.com/idensic/static/sns-websdk-builder.js"></script>
    <script type="module">
        $(document).ready(function() {
            launchWebSdk();
            getNewAccessToken();
        })

        function launchWebSdk(accessToken, applicantEmail, applicantPhone, customI18nMessages) {
            let snsWebSdkInstance = snsWebSdk
                .init(
                    '{{ $accessToken }}',
                    // token update callback, must return Promise
                    // Access token expired
                    // get a new one and pass it to the callback to re-initiate the WebSDK
                    () => this.getNewAccessToken()
                )
                .withConf({
                    lang: "en", //language of WebSDK texts and comments (ISO 639-1 format)
                    // email: applicantEmail, // Input real user email
                    // phone: applicantPhone, // Input real user phone
                    theme: "dark" | "light",
                })
                .withOptions({
                    addViewportTag: false,
                    adaptIframeHeight: true
                })
                // see below what kind of messages WebSDK generates
                .on("idCheck.onStepInitiated", (payload) => {
                    console.log("onStepInitiated", payload);
                })
                .on("idCheck.onStepCompleted", (payload) => {
                    console.log("onStepCompleted", payload);
                })
                .on("idCheck.onApplicantSubmitted", (payload) => {
                    window.replace = "{{ route('register') }}"
                })
                .on("idCheck.onError", (error) => {
                    console.log("onError", error);
                })
                .build();

            // you are ready to go:
            // just launch the WebSDK by providing the container element for it
            snsWebSdkInstance.launch("#sumsub-websdk-container");
        }

        function getNewAccessToken() {
            axios.get("{{ route('sumsub.generateAcessToken') }}")
                .then(function(response) {
                    return response['data']['token'];
                })
                .catch(function(error) {
                    console.log(error);
                });
        }
    </script>
@endsection
