<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{ CardController, ColumnController };

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

// Model Paths
Route::get('/columns', [ColumnController::class, 'index' ]);
Route::post('/columns', [ColumnController::class, 'store' ]);
Route::get('/columns/{id}', [ColumnController::class, 'show' ]);
Route::delete('/columns/{id}', [ColumnController::class, 'destroy' ]);
Route::post('/columns/{id}', [ColumnController::class, 'update' ]);

Route::get('/cards', [CardController::class, 'index' ]);
Route::post('/cards', [CardController::class, 'store' ]);
Route::get('/cards/{id}', [CardController::class, 'show' ]);
Route::delete('/cards/{id}', [CardController::class, 'destroy' ]);
Route::post('/cards/{id}', [CardController::class, 'update' ]);
