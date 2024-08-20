<?php

namespace App\Http\Controllers\Onfido;

use App\Http\Controllers\Controller;
use App\Http\Onfido\OnfidoBL;
use App\Models\Onfido\OnfidoCredential;
use Illuminate\Http\Request;

class OnfidoController extends Controller
{
    public function index(Request $request)
    {
        $expiredMessage = isset($request->is_expired) ? 'Token expired! Please try again!' : '';
        return view('register', compact('expiredMessage'));
    }

    public function run()
    {
        $onfidoBL = new OnfidoBL;
        $onfidoData = OnfidoCredential::first();
        $workflowData = json_decode($onfidoData->workflow);
        $workflowId = $workflowData->id;
        $sdkToken = $workflowData->sdk_token;

        $params = ['workflow_run_id' => $workflowId];

        $workflowResponse = $onfidoBL->queryAPI('retrieve_workflow', '', $params);

        info($workflowResponse);

        return view('onfido', compact('workflowId', 'sdkToken'));
    }

    public function register()
    {
        $onfidoBL = new OnfidoBL;

        $applicantResponse = $onfidoBL->queryAPI('create_applicant');

        // save applicant response in database

        if (!$applicantResponse['result']) {
            info(json_encode(['applicant' => $applicantResponse['body']]));
            return redirect()
                ->route('register')
                ->with('error', 'Error saving applicant\'s data');
        }

        OnfidoCredential::create([
            'applicant' => json_encode($applicantResponse['body'])
        ]);

        info(json_encode(['applicant' => $applicantResponse['body']]));

        return redirect()
            ->route('register')
            ->with('success', 'Applicant created successfully');
    }

    public function create_workflow()
    {
        $onfidoBL = new OnfidoBL;

        $onfidoData = OnfidoCredential::first();
        $applicantId = json_decode($onfidoData->applicant)->id;

        $workflowResponse = $onfidoBL->queryAPI('create_workflow', $applicantId);

        if (!$workflowResponse['result']) {
            info(json_encode(['workflow' => $workflowResponse['body']]));
            return redirect()
                ->route('register')
                ->with('error', 'Error fetching workflow data');
        }
        info(json_encode(['workflow' => $workflowResponse['body']]));

        // $sdkTokenResponse = $onfidoBL->queryAPI('create_sdk_token', $applicantId);

        // if (!$sdkTokenResponse['result']) {
        //     info(json_encode(['sdktoken' => $sdkTokenResponse['body']]));
        //     return redirect()
        //         ->route('register')
        //         ->with('error', 'Error fetching sdk token\'s data');
        // }
        // info(json_encode(['sdktoken' => $sdkTokenResponse['body']]));

        $onfidoData->update([
            'workflow' => json_encode($workflowResponse['body']),
            // 'sdk_token' => $sdkTokenResponse['body']->token
        ]);

        return redirect()
            ->route('register')
            ->with('success', 'Workflow created successfully');
    }

    public function completed(Request $request)
    {
        try {
            info($request->getContent());
            return view('completed');
        } catch (\Exception $e) {
            info($e->getMessage());
        }
    }

    public function workflowCompleted()
    {
        return redirect()->route('completed')->with('success', 'Verification successfully completed');
    }

    /**
     * @todo add workflow
     */
}
