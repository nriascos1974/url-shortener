<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Url;
use Illuminate\Support\Str;

class UrlController extends Controller
{
    // Método para crear y acortar el URL
    public function store(Request $request)
    {
        $validated = $request->validate([
            'original_url' => 'required|url',
        ]);

        $shortUrl = Str::random(8);

        Url::create([
            'original_url' => $validated['original_url'],
            'short_url' => $shortUrl
        ]);

        return response()->json(['short_url' => $shortUrl], 201);
    }

    // Método para redirigir usando el short URL
    public function redirect($short_url)
    {
        $url = Url::where('short_url', $short_url)->firstOrFail();

        /* Almacenamos el resultado de la consulta en caché durante 60 minutos
        $url = Cache::remember("short_url_{$short_url}", 60, function () use ($short_url) {
            return Url::where('short_url', $short_url)->firstOrFail();
        });*/

        return redirect($url->original_url);
    }
}
