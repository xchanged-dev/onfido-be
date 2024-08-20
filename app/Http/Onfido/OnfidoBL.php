<?php

namespace App\Http\Onfido;

use Carbon\Carbon;
use GuzzleHttp\Client as HttpClient;
use GuzzleHttp\Exception\ClientException;

class OnfidoBL
{
    public function __construct(
        private $credentials = new OnfidoCredentials,
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

        switch ($product) {
            case 'create_applicant':
                $url .= $this->credentials->create_applicant_url;

                $requestParams['first_name'] = 'Jane';
                $requestParams['last_name'] = 'Consider';
                $requestParams['dob'] = '1990-01-31';
                $requestParams['address'] = [
                    'building_number' => '100',
                    'street' => 'Main Street',
                    "town" => "London",
                    "postcode" => "SW4 6EH",
                    "country" => "GBR"
                ];
                break;

            case 'create_workflow':
                $url .= $this->credentials->create_workflow_url;

                $expiresAt = Carbon::now()->addSeconds(5);

                $requestParams['workflow_id'] = $this->credentials->workflow_id;
                $requestParams['applicant_id'] = $applicant_id;
                $requestParams['link'] = [
                    'completed_redirect_url' => route('completed'),
                    'expired_redirect_url' => route('register', ['is_expired' => true]),
                    'expires_at' => $expiresAt,
                    'language' => 'en_US',
                ];
                break;

            case 'create_sdk_token':
                $url .= $this->credentials->create_sdktoken_url;

                $requestParams['applicant_id'] = $applicant_id;
                break;

            case 'retrieve_workflow':
                $url .= $this->credentials->create_workflow_url . '/' . $params['workflow_run_id'];
                $method = 'get';
                break;

                // case 'register_webhook':
                //     $url .= $this->credentials->register_webhook;

                //     $requestParams['url'] = route('workflow.completed');
                //     $requestParams['enabled'] = true;
                //     $requestParams['events'] = [
                //         'workflow_run.completed'
                //     ];
        }

        try {
            $client = new HttpClient;
            $guzzleParams = [
                'headers' => [
                    'Authorization' => "Token token={$this->credentials->api_key}",
                    'Content-Type' => 'application/json',
                ]
            ];
            if ($method === 'post') {
                $guzzleParams['json'] = $requestParams;

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
