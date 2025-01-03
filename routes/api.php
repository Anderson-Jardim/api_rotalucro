<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\InfooneController;
use App\Http\Controllers\MeslucrosController;
use App\Http\Controllers\ClasscorridasController;
use App\Http\Controllers\LerCorridaController;
use App\Http\Controllers\LerCorridaCardController;
use App\Http\Controllers\MonthlyEarningsController;
use App\Http\Controllers\UpdateTotalLucroonSaidaController;

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
// Public routes
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::get('/images/{filename}', function ($filename) {
    return response()->file(public_path('images/' . $filename));
});


// Protected Routes
Route::group(['middleware' => ['auth:sanctum']], function() {
    
    Route::post('/lercorrida', [LerCorridaController::class, 'store']);
    Route::get('/lercorrida', [LerCorridaController::class, 'index']);

    Route::post('/lercorridacard', [LerCorridaCardController::class, 'store']);
    Route::get('/lercorridacard', [LerCorridaCardController::class, 'index']);

    Route::post('/subtract-from-lucro', [MonthlyEarningsController::class, 'subtractFromLucro']);
    Route::post('/add-saida-lucro', [UpdateTotalLucroonSaidaController::class, 'store']);
    Route::get('/get-saida-lucro', [UpdateTotalLucroonSaidaController::class, 'getUserSaidas']);
    
    
    Route::post('/reset-monthly-earnings', [MonthlyEarningsController::class, 'resetMonthlyEarnings']);
    Route::post('/monthly-earnings', [MonthlyEarningsController::class, 'store']);
    Route::get('/monthly-earnings', [MonthlyEarningsController::class, 'index']);


    Route::post('/expenses', [ExpenseController::class, 'addExpenses']);
    Route::get('/expenses', [ExpenseController::class, 'getExpenses']);
    Route::put('/expenses/{id}', [ExpenseController::class, 'updateExpense']);


    Route::post('/infoone', [InfooneController::class, 'createInfoone']);
    Route::get('/infoone', [InfooneController::class, 'getInfoone']);
    Route::put('/infoone/{id}', [InfooneController::class, 'update']);
   
   
    Route::post('/meslucros', [MeslucrosController::class, 'createMeslucros']);
    Route::get('/meslucros', [MeslucrosController::class, 'getMeslucros']);
    Route::put('/meslucros/{id}', [MeslucrosController::class, 'updateMeslucros']);


    Route::post('/classcorridas', [ClasscorridasController::class, 'createClasscorridas']);
    Route::get('/classcorridas', [ClasscorridasController::class, 'getClasscorridas']);
    Route::put('/classcorridas/{id}', [ClasscorridasController::class, 'updateClasscorridas']);


    
    
    // User
    Route::get('/user', [AuthController::class, 'user']);
    Route::put('/user', [AuthController::class, 'update']);
    Route::post('/logout', [AuthController::class, 'logout']);


    

    
});