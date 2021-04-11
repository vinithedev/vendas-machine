<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers;
use Illuminate\Support\Facades\Auth;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/clients', [Controllers\ClientController::class, 'store']);
Route::get('/clients/{id}', [Controllers\ClientController::class, 'show']);
Route::get('/clients', [Controllers\ClientController::class, 'pedidos']);

Route::post('/products', [Controllers\ProductController::class, 'store']);
Route::get('/products/{id}', [Controllers\ProductController::class, 'show']);

Route::post('/order', [Controllers\OrderController::class, 'store']);
Route::get('/order/file', [Controllers\OrderController::class, 'dlfile']);

Route::fallback(function(){
    return response()->json([
        'message' => 'Pagina nao encontrada'], 404);
});