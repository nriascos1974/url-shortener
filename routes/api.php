<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UrlController;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

//Ruta para crear url corta
Route::post('/url', [UrlController::class, 'store']);

//Ruta para eliminar URL
Route::delete('/url/{id}', [UrlController::class, 'delete']);

//Ruta para devolver todas las URL cortas creadas
Route::get('/urls', [UrlController::class, 'listurls']);

//Ruta para devolver la URL original con la ruta corta enviada
Route::get('/url/{short_url}', [UrlController::class, 'getOriginalUrl']);
