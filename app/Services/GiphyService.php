<?php

namespace App\Services;

use App\Repositories\FavoriteGifRepository;
use GuzzleHttp\Client;
use Psr\Http\Message\ResponseInterface;

use Illuminate\Http\Request;

class GiphyService {

    private Client $client;
    private string $gifUrl = 'https://api.giphy.com/v1/gifs/';
    private FavoriteGifRepository $favoriteGifRepository;

    public function __construct(FavoriteGifRepository $favoriteGifRepository) {
        $this->client = new Client();
        $this->favoriteGifRepository = $favoriteGifRepository;
    }

    public function searchGifs($query, $limit = 10, $offset = 5): ResponseInterface {
        return $this->client->get( $this->gifUrl . 'search', [
            'query' => [
                'api_key' => env('GIPHY_API_KEY'),
                'q' => $query,
                'limit' => $limit,
                'offset' => $offset
            ]
        ]);
    }

    public function getGifById($id): ResponseInterface {
        return $this->client->get( $this->gifUrl . $id, [
            'query' => [
                'api_key' => env('GIPHY_API_KEY'),
            ]
        ]);
    }

    public function saveGif(Request $request): void {
        $this->favoriteGifRepository->createFavoriteGif($request);
    }
}
