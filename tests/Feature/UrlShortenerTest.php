<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Url;

class UrlShortenerTest extends TestCase
{
    use RefreshDatabase; // Limpia la base de datos entre pruebas

    // Prueba para verificar que un URL se acorta correctamente
    public function test_store_url()
    {
        // Se envia una solicitud POST a la ruta para crear un URL
        $response = $this->postJson('/url', [
            'original_url' => 'https://example.com'
        ]);

        // Se verifica que el estado de respuesta sea 201 (creado)
        $response->assertStatus(201);


       // Se verifica que la respuesta JSON tenga la estructura correcta
       $response->assertJsonStructure(['short_url']);

    }

    // Prueba para verificar la redirección del URL acortado
    public function test_redirect_to_original_url()
    {
        // Se crea un URL acortado en la base de datos
        $url = Url::create([
            'original_url' => 'https://example.com',
            'short_url' => 'abc123'
        ]);

        /// Se envia una solicitud GET para redirigir al URL acortado
        $response = $this->get('/abc123');

        // Se verifica que la respuesta redirige al URL original
        $response->assertRedirect('https://example.com');
    }
}
