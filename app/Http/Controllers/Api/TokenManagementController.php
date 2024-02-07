<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Laravel\Passport\Client as OClient;

class TokenManagementController extends Controller
{
    public function getTokenAndRefreshToken(OClient $oClient, $params)
    {
        $response = Http::asForm()->post(env('APP_URL').'/oauth/token', [
            'grant_type' => 'client_credentials',
            'client_id' => $oClient->id,
            'client_secret' => $oClient->secret,
            'username' => $params['username'],
            'password' => 'Carlotta19761977',
            'scope' => '*',
        ]);

        return json_decode((string) $response->getBody(), true);
    }

    public function refreshToken(Request $request)
    {
        $refresh_token = $request->header('RefreshToken');
        $oClient = OClient::where('password_client', 1)->first();

        $response = Http::asForm()->post(env('APP_URL').'/oauth/token', [
            'grant_type' => 'refresh_token',
            'refresh_token' => $refresh_token,
            'client_id' => $oClient->id,
            'client_secret' => $oClient->secret,
            'scope' => '*',
        ]);

        $result = json_decode($response->getBody());

        if(isset($result->error))
            return response()->json(['message'=>$result->hint], 401);
        else
            return json_decode((string) $response->getBody(), true);
    }
}
