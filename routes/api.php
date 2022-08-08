<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FeaturesController;

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




/**get current applicants counts */
Route::get('getCompensation', [FeaturesController::class, 'getCompensation']);

Route::post('addNew', [FeaturesController::class, 'addNew']);

Route::put('updateRecord/{id}', [FeaturesController::class, 'updateRecord']);

Route::get('filter', [FeaturesController::class, 'filter']);

Route::get('getSingle/{id}', [FeaturesController::class, 'getSingle']);

Route::get('sortDesc', [FeaturesController::class, 'sortDesc']);

Route::get('sortAsc', [FeaturesController::class, 'sortAsc']);

Route::post('avgCity', [FeaturesController::class, 'avgCity']);

Route::post('avgRole', [FeaturesController::class, 'avgRole']);








