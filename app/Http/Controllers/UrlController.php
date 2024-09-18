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

    // Método para devolver la URL original usando el short URL
    public function getOriginalUrl($short_url)
    {
        // Buscar el URL original en la base de datos
        $url = Url::where('short_url', $short_url)->firstOrFail();

        // Devolver la URL original en formato JSON
        return response()->json([
            'original_url' => $url->original_url
        ], 200);
    }

    // Método para devolver todas las URLs
    public function listurls()
    {
        $urls = Url::all();  // Obtener todas las URLs
        return response()->json($urls, 200);  // Devolver como JSON


    }

    // Método para eliminar un URL
    public function delete($id)
    {
        $url = Url::findOrFail($id);
        $url->delete();

        return response()->json(['message' => 'URL deleted successfully']);
    }
}
