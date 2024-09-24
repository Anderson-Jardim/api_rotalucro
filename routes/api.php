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



// Protected Routes
Route::group(['middleware' => ['auth:sanctum']], function() {
    
    Route::post('/lercorrida', [LerCorridaController::class, 'store']);
    Route::get('/lercorrida', [LerCorridaController::class, 'index']);


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

    // Post
    Route::get('/posts', [PostController::class, 'index']); // all posts
    Route::post('/posts', [PostController::class, 'store']); // create post
    Route::get('/posts/{id}', [PostController::class, 'show']); // get single post
    Route::put('/posts/{id}', [PostController::class, 'update']); // update post
    Route::delete('/posts/{id}', [PostController::class, 'destroy']); // delete post

    // Comment
    Route::get('/posts/{id}/comments', [CommentController::class, 'index']); // all comments of a post
    Route::post('/posts/{id}/comments', [CommentController::class, 'store']); // create comment on a post
    Route::put('/comments/{id}', [CommentController::class, 'update']); // update a comment
    Route::delete('/comments/{id}', [CommentController::class, 'destroy']); // delete a comment

    // Like
    Route::post('/posts/{id}/likes', [LikeController::class, 'likeOrUnlike']); // like or dislike back a post
    
    
});