<?php

namespace App\Repositories;

use App\Models\Interaction;
use Illuminate\Http\Request;

class InteractionRepository {

    public function createInteraction(Request $request, $service, $responseCode, $responseBody): void {
        Interaction::create([
            'user_id' => auth()->id(),
            'service' => $service,
            'request_body' => json_encode($request->all()),
            'response_code' => $responseCode,
            'response_body' => $responseBody,
            'ip_address' => $request->ip(),
        ]);
    }
}
