<?php

namespace Tests\Unit;

use App\Http\Controllers\Api\GiphyController;
use App\Services\GiphyService;
use App\Services\InteractionService;
use Illuminate\Http\Request;
use Mockery;
use PHPUnit\Framework\TestCase;

class GiphyControllerTest extends TestCase
{
    /**
     * A basic unit test example.
     */
    public function testSearchReturnsExpectedResults()
    {
        // Crear mocks de los servicios
        $mockGiphyService = Mockery::mock(GiphyService::class);
        $mockInteractionService = Mockery::mock(InteractionService::class);

        // Definir el comportamiento esperado del servicio de Giphy
        $expectedResults = [
            'data' => [
                [
                    'id' => '1',
                    'url' => 'http://giphy.com/gif1',
                    'title' => 'Funny Gif'
                ],
                [
                    'id' => '2',
                    'url' => 'http://giphy.com/gif2',
                    'title' => 'Another Funny Gif'
                ]
            ]
        ];

        $mockGiphyService->shouldReceive('searchGifs')
            ->with('funny')
            ->andReturn($expectedResults);

        // Simular la interacción guardada (no necesitamos que haga nada, solo verificar que se llama)
        $mockInteractionService->shouldReceive('createInteraction')
            ->once();

        // Crear la instancia del controlador usando los mocks
        $controller = new GiphyController($mockGiphyService, $mockInteractionService);

        // Crear un request simulado
        $request = Request::create('/search', 'GET', ['query' => 'funny']);

        // Llamar al método search y obtener la respuesta
        $response = $controller->index($request);

        // Verificar que la respuesta sea la esperada
        $this->assertEquals(200, $response->status());
        $this->assertEquals($expectedResults, $response->getData(true));
    }
}
