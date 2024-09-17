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
        $response = $this->postJson('/api/url', [
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
        $response = $this->get('/api/abc123');

        // Se verifica que la respuesta redirige al URL original
        $response->assertRedirect('https://example.com');
    }



    // Prueba para devolver todas las URLs
    public function test_get_all_urls()
    {
        // Crea algunas URLs de ejemplo en la base de datos
        Url::factory()->create([
            'original_url' => 'https://example.com',
            'short_url' => 'abc123'
        ]);

        Url::factory()->create([
            'original_url' => 'https://another-example.com',
            'short_url' => 'def456'
        ]);

        // Envía una solicitud GET a la ruta /api/urls
        $response = $this->getJson('/api/urls');

        // Verifica que el status sea 200 OK y que la respuesta contenga las URLs
        $response->assertStatus(200)
            ->assertJsonCount(2)
            ->assertJsonFragment([
                'original_url' => 'https://example.com',
                'short_url' => 'abc123'
            ])
            ->assertJsonFragment([
                'original_url' => 'https://another-example.com',
                'short_url' => 'def456'
            ]);
    }


    // Prueba para eliminar un URL
    public function test_delete_url()
    {
        // Crea una URL en la base de datos
        $url = Url::factory()->create([
            'original_url' => 'https://example.com',
            'short_url' => 'abc123'
        ]);

        // Verifica que el URL existe
        $this->assertDatabaseHas('urls', [
            'id' => $url->id,
            'original_url' => 'https://example.com',
            'short_url' => 'abc123'
        ]);

        // Envía una solicitud DELETE para eliminar el URL
        $response = $this->deleteJson("/api/url/{$url->id}");

        // Verifica que el status sea 200 OK
        $response->assertStatus(200);

        // Verifica que el URL ya no exista en la base de datos
        $this->assertDatabaseMissing('urls', [
            'id' => $url->id
        ]);
    }
}
