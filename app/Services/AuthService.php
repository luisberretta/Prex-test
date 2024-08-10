<?php

namespace App\Services;

use Illuminate\Support\Facades\Auth;

class AuthService {

    public function login(array $credentials): array {
        if (!Auth::attempt($credentials)) {
            return [
                'status' => 401,
                'body' => json_encode(['message' => 'Unauthorized'])
            ];
        }

        $access_token['token'] = auth()->user()->createToken('Personal Access Token')->accessToken;

        return [
            'status' => 200,
            'body' => json_encode(['access_token' => $access_token['token']])
        ];
    }
}
