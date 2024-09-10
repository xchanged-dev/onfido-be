<?php

namespace App\Http\SumSub;

class SumSubCredentials
{
    public function __construct(
        public $url = 'https://api.sumsub.com',
        public $api_key = 'sbx:2hI7OY9uJL55RKunhX9UGsfu.mswOFiUoKDPnPYe6sHfRWgAgwKOluV2L',
        public $secret = 'l1WW8MKZHe7lNVYNrs5U9b9Ba4s08HIY',

        public $create_sdktoken_url = '/resources/accessTokens',
        public $get_applicant_data_url = '/resources/applicants'
    ) {
    }
}
