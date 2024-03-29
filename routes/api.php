<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserController;

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

Route::post('/user', [UserController::class, 'register']);
Route::middleware('auth:sanctum')->get('/user', [UserController::class, 'read']);
Route::middleware('auth:sanctum')->put('/user', [UserController::class, 'update']);
Route::middleware('auth:sanctum')->delete('/user', [UserController::class, 'delete']);

Route::post('/user/token', [UserController::class, 'authenticate']);
Route::middleware('auth:sanctum')->delete('/user/token', [UserController::class, 'deleteToken']);
