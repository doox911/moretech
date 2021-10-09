<?php

use App\Http\Controllers\MetaDataController;
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

Route::get('catalogs', [MetaDataController::class, 'getCatalogs']);
Route::post('run_query', [MetaDataController::class, 'runQuery']);
