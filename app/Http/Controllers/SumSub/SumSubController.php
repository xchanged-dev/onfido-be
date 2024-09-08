<?php

namespace App\Http\Controllers\SumSub;

use App\Http\Controllers\Controller;
use App\Http\SumSub\SumSubBL;
use Illuminate\Http\Request;

class SumSubController extends Controller
{
    public function __construct()
    {
    }

    public function index()
    {
        $sumsubBL = new SumSubBL;

        // Save the access token to DB
        $generateTokenResponse = $sumsubBL->queryAPI('create_access_token');

        if (!$generateTokenResponse['result']) {
            return redirect()
                ->route('register')
                ->with('error', 'Error fetching workflow data');
        }

        $accessToken = $generateTokenResponse['body']->token;

        return view('sumsub.register', compact('accessToken'));
    }

    public function generateAccessToken(Request $request)
    {
        $sumsubBL = new SumSubBL;

        $generateTokenResponse = $sumsubBL->queryAPI('create_access_token');

        if (!$generateTokenResponse['result']) {
            return redirect()
                ->route('register')
                ->with('error', 'Error fetching workflow data');
        }

        return response()->json([
            'token' => $generateTokenResponse['body']->token
        ]);
    }
}
