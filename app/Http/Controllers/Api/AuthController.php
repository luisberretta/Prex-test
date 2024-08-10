<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\AuthService;
use App\Services\InteractionService;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    private InteractionService $interactionService;
    private AuthService $authService;

    public function __construct(InteractionService $interactionService, AuthService $authService) {
        $this->interactionService = $interactionService;
        $this->authService = $authService;
    }

    public function login(Request $request) {
        $validated = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        $response = $this->authService->login($validated);
        $this->interactionService->logInteraction($request, 'login', $response['status'], $response['body']);

        return response()->json(json_decode($response['body']));
    }
}
