<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TrashController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/register',[TrashController::class,'registerUser']);
Route::post('/login',[TrashController::class,'loginUser']);
Route::get('/delete/{id}',[TrashController::class,'deleteUser']);
Route::get('/trash_all_user',[TrashController::class,'trash_all_user']);
Route::get('/trash_user',[TrashController::class,'trash_user']);
Route::get('/trash_restore/{id}',[TrashController::class,'trash_restore']);
Route::get('/trash_permanent_delete/{id}',[TrashController::class,'trash_permanent_delete']);