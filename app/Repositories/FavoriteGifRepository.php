<?php

namespace App\Repositories;

use App\Models\FavoriteGif;
use Illuminate\Http\Request;

class FavoriteGifRepository {
    public function createFavoriteGif(Request $request): void {
        FavoriteGif::create([
            'gif_id' => $request->input('gif_id'),
            'alias' => $request->input('alias'),
            'user_id' => $request->input('user_id'),
        ]);
    }
}
