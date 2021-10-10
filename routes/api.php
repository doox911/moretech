<?php

use App\Http\Controllers\Api\V1\AuthController;
use App\Http\Controllers\MetaDataController;
use App\Http\Middleware\Login;
use App\Http\Middleware\ValidationDataOfUser;
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

Route::prefix('v1')
  ->group(function() {
    Route::prefix('auth')
      ->group(function() {

        /**
         * Вход в систему
         */
        Route::post('/login', [AuthController::class, 'login'])->middleware(Login::class)->name('login');

        /**
         * Регистрация нового пользователя(Для тестирования)
         */
        Route::post('/register', [AuthController::class, 'register'])->middleware(ValidationDataOfUser::class);

        /**
         * Вход в систему с refresh token
         */
        Route::post('/refresh', [AuthController::class, 'refresh']);
      });
  });

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
