<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Url;
use Illuminate\Support\Str;

class UrlController extends Controller
{

    /**
     * @OA\Post(
     *     path="/api/url",
     *     summary="Acorta una URL",
     *     description="Genera una URL corta para un URL original",
     *     operationId="storeUrl",
     *     tags={"URL"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"original_url"},
     *             @OA\Property(property="original_url", type="string", example="https://example.com")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="URL acortada creada",
     *         @OA\JsonContent(
     *             @OA\Property(property="short_url", type="string", example="abc123")
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Solicitud inválida"
     *     )
     * )
     */
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

     /**
     * @OA\Get(
     *     path="/api/url/{short_url}",
     *     summary="Obtiene la URL original desde una URL corta",
     *     description="Devuelve la URL original a partir de la URL acortada",
     *     operationId="getOriginalUrl",
     *     tags={"URL"},
     *     @OA\Parameter(
     *         name="short_url",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="string"),
     *         description="La URL corta"
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="URL original devuelta",
     *         @OA\JsonContent(
     *             @OA\Property(property="original_url", type="string", example="https://example.com")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="URL no encontrada"
     *     )
     * )
     */
    public function getOriginalUrl($short_url)
    {
        // Buscar el URL original en la base de datos
        $url = Url::where('short_url', $short_url)->firstOrFail();

        // Devolver la URL original en formato JSON
        return response()->json([
            'original_url' => $url->original_url
        ], 200);
    }


    /**
     * @OA\Get(
     *     path="/api/urls",
     *     summary="Listar todas las URLs",
     *     description="Devuelve todas las URLs acortadas almacenadas en la base de datos",
     *     operationId="listUrls",
     *     tags={"URL"},
     *     @OA\Response(
     *         response=200,
     *         description="Lista de URLs",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(
     *                 @OA\Property(property="id", type="integer", example=1),
     *                 @OA\Property(property="original_url", type="string", example="https://example.com"),
     *                 @OA\Property(property="short_url", type="string", example="abc123"),
     *                 @OA\Property(property="created_at", type="string", format="date-time", example="2023-09-17T12:34:56.000000Z"),
     *                 @OA\Property(property="updated_at", type="string", format="date-time", example="2023-09-17T12:34:56.000000Z")
     *             )
     *         )
     *     )
     * )
     */
    public function listurls()
    {
        $urls = Url::all();  // Obtener todas las URLs
        return response()->json($urls, 200);  // Devolver como JSON


    }

     /**
     * @OA\Delete(
     *     path="/api/url/{id}",
     *     summary="Eliminar una URL",
     *     description="Elimina una URL acortada de la base de datos",
     *     operationId="deleteUrl",
     *     tags={"URL"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="El ID de la URL que se va a eliminar",
     *         @OA\Schema(type="integer", example=1)
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="URL eliminada con éxito",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="URL deleted successfully")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="URL no encontrada"
     *     )
     * )
     */
    public function delete($id)
    {
        $url = Url::findOrFail($id);
        $url->delete();

        return response()->json(['message' => 'URL deleted successfully']);
    }
}
