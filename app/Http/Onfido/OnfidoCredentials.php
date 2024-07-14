<?php

namespace App\Http\Onfido;

class OnfidoCredentials
{
    public function __construct(
        public $url = 'https://api.us.onfido.com/v3.6',
        public $api_key = 'api_sandbox_us.Q1CtxKwJQO0.nmv4e70-ksMlkOUlkFAMG-nqkoLQcVKy',
        public $workflow_id = 'ebbd09b2-6a6b-4a11-9e6e-62598df1bbf8',

        public $create_applicant_url = '/applicants',
        public $create_workflow_url = '/workflow_runs',
        public $create_sdktoken_url = '/sdk_token'
    ) {
    }
}
