<?php

use App\Http\Controllers\FileController;
use App\Http\Controllers\FileDownloadController;
use App\Http\Controllers\FileLinkController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\LogoutController;
use App\Http\Controllers\PlanController;
use App\Http\Controllers\StripePaymentIntentController;
use App\Http\Controllers\SubscriptionController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::post('/login', LoginController::class);
Route::get('/plans', [PlanController::class, 'index']);

Route::get('/files/{file::uuid}/get-download-link', FileDownloadController::class);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', [UserController::class, 'show']);
    Route::get('/user/usage', [UserController::class, 'usage']);

    Route::post('/logout', LogoutController::class);
    Route::get('/files', [FileController::class, 'index']);
    Route::post('/files', [FileController::class, 'store']);
    Route::delete('/files/{file:uuid}', [FileController::class, 'destroy']);
    Route::post('/files/signed', [FileController::class, 'signed']);

    Route::get('/subscriptions/intent', StripePaymentIntentController::class);
    Route::post('/subscriptions/store', [SubscriptionController::class, 'store']);
    Route::patch('/subscriptions/swap', [SubscriptionController::class, 'update']);

    Route::post('/files/{file:uuid}/links', [FileLinkController::class, 'store']);
});
