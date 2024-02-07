<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Passport\Client as OClient;
use App\Http\Controllers\Api\TokenManagementController;

class AuthenticationController extends Controller
{
    private $tokenManagement;

    public function __construct(TokenManagementController $tokenManagement)
    {
        $this->tokenManagement = $tokenManagement;
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function login(Request $request)
    {
        $params = ['username' => $request->username, 'password' => ($request->password)];

        if (Auth::attempt($params)) {
            // successfull authentication
            $user = User::find(Auth::user()->id);



            $oClient = OClient::where('password_client', 1)->first();
            $result = $this->tokenManagement->getTokenAndRefreshToken($oClient, $params);
            return $result;
            $result['access_token'] = $user->createToken('access_token')->accessToken;

            return response()->json([
                'token' => $result['access_token'],
                'expires_in' => $result['expires_in'],
                'refresh_token' =>$result['refresh_token'],
                'user' => $user,
            ], 200);
        } else {
            // failure to authenticate
            return response()->json([
                'success' => false,
                'message' => 'Failed to authenticate.',
            ], 401);
        }
    }
}
