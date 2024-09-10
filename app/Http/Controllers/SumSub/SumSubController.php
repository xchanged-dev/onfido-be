<?php

namespace App\Http\Controllers\SumSub;

use App\Http\Controllers\Controller;
use App\Http\SumSub\SumSubBL;
use Illuminate\Http\Request;

class SumSubController extends Controller
{
    public function __construct(protected SumSubBL $sumsubBL)
    {
    }

    public function index()
    {
        return view('sumsub.index');
    }

    public function run()
    {
        // Save the access token to DB
        $response = $this->sumsubBL->queryAPI('create_access_token');

        if (!$response['result']) {
            return redirect()
                ->route('register')
                ->with('error', 'Error fetching workflow data');
        }

        $accessToken = $response['body']->token;

        return view('sumsub.register', compact('accessToken'));
    }

    public function generateAccessToken()
    {
        $response = $this->sumsubBL->queryAPI('create_access_token');

        if (!$response['result']) {
            return response()->json([
                'status' => 'fail',
                'message' => 'Error generating access token!'
            ]);
        }

        return response()->json([
            'status' => 'success',
            'token' => $response['body']->token
        ]);
    }

    public function getApplicantData()
    {
        $response = $this->sumsubBL->queryAPI('get_applicant_data', '66e019eed2521c08d194b70c');

        if (!$response['result']) {
            return redirect()
                ->route('sumsub.index')
                ->with('error', 'Error fetching applicant data');
        }

        return redirect()
            ->route('sumsub.index')
            ->with('success', 'Applicant fetched successfully');
    }

    public function getApplicantVerificationSteps()
    {
        $response = $this->sumsubBL->queryAPI('get_applicant_verification_steps', '66e019eed2521c08d194b70c');

        info($response);
        if (!$response['result']) {
            return redirect()
                ->route('sumsub.index')
                ->with('error', 'Error fetching applicant verification data');
        }

        return redirect()
            ->route('sumsub.index')
            ->with('success', 'Applicant verification fetched successfully');
    }

    public function getApplicantVerificationResult(Request $request)
    {
        info($request->all());
    }
}
