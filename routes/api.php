<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ApiController;

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
Route::get('/extracurriculars', [ApiController::class, 'index'])
    ->name('extracurriculars.index');

Route::get('extracurriculars/{id}', [ApiController::class, 'show']);

Route::post('/extracurriculars', [ApiController::class, 'store'])
    ->name('extracurriculars.store');

Route::put('/extracurriculars/{id}', [ApiController::class, 'update'])
    ->name('extracurriculars.update');

Route::delete('/extracurriculars/{id}', [ApiController::class, 'destroy'])
    ->name('extracurriculars.destroy');

Route::get('/extracurriculars/create', [ApiController::class, 'create'])
    ->name('extracurriculars.create');


