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

Route::prefix('/datasource')->group(static function () {
  Route::get('', [MetaDataController::class, 'getDataSources']);
  Route::post('', [MetaDataController::class, 'storeDataSource']);
});

Route::prefix('/data_operation')->group(static function () {
  Route::get('', [MetaDataController::class, 'getDataOperations']);
  Route::post('', [MetaDataController::class, 'storeDataOperation']);
});

Route::post('/download_task_file', [MetaDataController::class, 'downloadTaskFile']);

Route::get('catalogs', [MetaDataController::class, 'getCatalogs']);
Route::get('datasets', [MetaDataController::class, 'getDatasets']);
Route::post('run_query', [MetaDataController::class, 'runQuery']);
