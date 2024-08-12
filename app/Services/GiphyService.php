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

    public function searchGifs($input): ResponseInterface {
        return $this->client->get( $this->gifUrl . 'search', [
            'query' => [
                'api_key' => env('GIPHY_API_KEY'),
                'q' => $input['query'],
                'limit' => array_key_exists('limit', $input) ? $input['limit'] : 5,
                'offset' => array_key_exists('offset', $input) ? $input['offset'] : 5
            ]
        ]);
    }

    public function getGifById($id): ResponseInterface {
        return $this->client->get( $this->gifUrl . $id, [
            'query' => [
                'api_key' => env('GIPHY_API_KEY'),
            ],
            'http_errors' => false
        ]);
    }

    public function saveGif(Request $request): array {
        return $this->favoriteGifRepository->createFavoriteGif($request);
    }
}
