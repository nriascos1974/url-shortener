<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Url;
use Illuminate\Support\Str;

class UrlController extends Controller
{
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

    public function redirect($short_url)
    {
        $url = Url::where('short_url', $short_url)->firstOrFail();
        return redirect($url->original_url);
    }
}
