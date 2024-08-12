<?php

namespace App\Repositories;

use App\Models\FavoriteGif;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

class FavoriteGifRepository {
    public function createFavoriteGif(Request $request): array {
        try {
            FavoriteGif::create([
                'gif_id' => $request->input('gif_id'),
                'alias' => $request->input('alias'),
                'user_id' => $request->input('user_id'),
            ]);
            return [
                'status' => 201,
                'body' => null
            ];
        } catch (QueryException $e) {
            return [
                'status' => 500,
                'body' => $e->getMessage()
            ];
        }
    }
}
