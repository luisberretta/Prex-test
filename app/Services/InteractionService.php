<?php

namespace App\Services;

use App\Repositories\InteractionRepository;
use Illuminate\Http\Request;

class InteractionService {

    private InteractionRepository $interactionRepository;

    public function __construct(InteractionRepository $interactionRepository) {
        $this->interactionRepository = $interactionRepository;
    }

    public function logInteraction(Request $request, $service, $responseCode, $responseBody): void {
        $this->interactionRepository->createInteraction($request, $service, $responseCode, $responseBody);
    }
}
