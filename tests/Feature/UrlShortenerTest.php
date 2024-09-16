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
        $response = $this->postJson('/url', [
            'original_url' => 'https://example.com'
        ]);

        
        $response->assertStatus(201)
                 ->assertJsonStructure(['short_url']);
    }

    // Prueba para verificar la redirección del URL acortado
    public function test_redirect_to_original_url()
    {
        // Crear un URL acortado en la base de datos
        $url = Url::create([
            'original_url' => 'https://example.com',
            'short_url' => 'abc123'
        ]);

        // Verificar que redirige al URL original
        $response = $this->get('/abc123');

        $response->assertRedirect('https://example.com');
    }
}
