<?php

namespace App\Http\SumSub;

use Carbon\Carbon;
use GuzzleHttp\Client as HttpClient;
use GuzzleHttp\Exception\ClientException;

class SumSubBL
{
    public function __construct(
        private $credentials = new SumSubCredentials(),
        private $response = [],
    ) {
        $this->response['result'] = false;
        $this->response['body'] = '';
    }

    public function queryAPI($product = '', $applicant_id = '', $params = [])
    {
        $url = $this->credentials->url;
        $method = 'post';
        $requestParams = [];
        $signatureData = '';

        switch ($product) {
            case 'create_access_token':
                $requestParams['userId'] = 'HAPPYHAKAAYAHOOYEPEE1234567890';
                $requestParams['levelName'] = 'basic-kyc-level';

                $url .= $this->credentials->create_sdktoken_url . '?' . http_build_query($requestParams);

                $signatureData = time() . strtoupper($method) . $this->credentials->create_sdktoken_url . '?' . http_build_query($requestParams);
                break;

            case 'get_applicant_data':
                $method = 'get';
                $requestParams['applicantId'] = $applicant_id;

                $url .= $this->credentials->get_applicant_data_url . "/{$applicant_id}/one";
                $signatureData = time() . strtoupper($method) . $this->credentials->get_applicant_data_url . "/{$applicant_id}/one";
                break;

            case 'get_applicant_verification_steps':
                $method = 'get';
                $requestParams['applicantId'] = $applicant_id;

                $url .= $this->credentials->get_applicant_data_url . "/{$applicant_id}/requiredIdDocsStatus";
                $signatureData = time() . strtoupper($method) . $this->credentials->get_applicant_data_url . "/{$applicant_id}/requiredIdDocsStatus";
                break;
        }

        try {
            $client = new HttpClient;

            info($signatureData);
            $accessSig = hash_hmac('sha256', $signatureData, $this->credentials->secret);
            $guzzleParams = [
                'headers' => [
                    'X-App-Token' => $this->credentials->api_key,
                    'X-App-Access-Sig' => $accessSig,
                    'X-App-Access-Ts' => time(),
                ]
            ];
            if ($method === 'post') {
                $response = $client->post($url, $guzzleParams);
            } elseif ($method === 'get') {
                $response = $client->get($url, $guzzleParams);
            }

            $output = json_decode($response->getBody()->getContents());

            $this->response['result'] = true;
            $this->response['body'] = $output;

            return $this->response;
        } catch (ClientException $ce) {
            $response = $ce->getResponse();
            $output = json_decode($response->getBody()->getContents());
            info(json_encode($response));

            $this->response['result'] = false;
            $this->response['body'] = $output;

            return $this->response;
        } catch (\Exception $e) {
            $this->response['result'] = false;
            $this->response['body'] = $e->getMessage();

            return $this->response;
        }
    }
}
