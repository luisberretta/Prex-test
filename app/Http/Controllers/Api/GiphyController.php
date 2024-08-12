<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\GiphyService;
use App\Services\InteractionService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class GiphyController extends Controller {
    private InteractionService $interactionService;
    private GiphyService $giphyService;

    public function __construct(GiphyService $giphyService, InteractionService $interactionService) {
        $this->giphyService = $giphyService;
        $this->interactionService = $interactionService;
    }

    public function index(Request $request): JsonResponse {

        $validator = Validator::make($request->all(), [
            'query' => 'required|string',
            'limit' => 'nullable|integer',
            'offset' => 'nullable|integer',
        ]);
        if ($validator->fails()) {
            $responseBody = ['error' => $validator->errors()];
            $this->interactionService->logInteraction($request, 'search', 422, json_encode($responseBody));
            return response()->json($responseBody, 422);
        }

        $input = $validator->validated();

        $response = $this->giphyService->searchGifs($input);

        $this->interactionService->logInteraction($request, 'search', 200, $response->getBody());

        return response()->json(json_decode($response->getBody(), true));
    }

    public function show($id, Request $request): JsonResponse {
        $response = $this->giphyService->getGifById($id);
        $this->interactionService->logInteraction($request, 'show', $response->getStatusCode(), $response->getBody());

        return response()->json(json_decode($response->getBody(), true), $response->getStatusCode());
    }

    public function store(Request $request) {
        $validator = Validator::make($request->all(), [
            'gif_id' => 'required|integer',
            'alias' => 'required|string',
            'user_id' => 'required|integer',
        ]);
        if ($validator->fails()) {
            $responseBody = ['error' => $validator->errors()];
            $this->interactionService->logInteraction($request, 'save', 422, json_encode($responseBody));
            return response()->json($responseBody, 422);
        }

        $response = $this->giphyService->saveGif($request);
        $this->interactionService->logInteraction($request, 'save', $response['status'], $response['body']);
        return response()->json($response['body'], $response['status']);
    }
}
