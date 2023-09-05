<?php

use App\Http\Controllers\API\SponsorshipController;
use App\Http\Controllers\API\DoctorController;
use App\Http\Controllers\API\MessageController;
use App\Http\Controllers\API\ReviewController;
use App\Http\Controllers\API\DoctorVoteController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\UserController;

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

Route::get('/doctors', [UserController::class, 'index']);
Route::get('/doctors/{id}', [UserController::class, 'show']);

Route::get('/sponsoredDoctors', [DoctorController::class, 'sponsored']);
Route::get('/allSpecialties', [DoctorController::class, 'allSpecialties']);
Route::get('/searchPerSpecialty', [DoctorController::class, 'searchPerSpecialty']);
Route::get('/searchWithFilter', [DoctorController::class, 'searchWithFilter']);
Route::get('/doctorDetails', [DoctorController::class, 'doctorDetails']);
// Route::post('/processpayment', [DoctorController::class, 'processpayment']);;

Route::post('/storeMessage', [MessageController::class, 'storeMessage']);
Route::post('/storeReview', [ReviewController::class, 'storeReview']);
Route::post('/storeVote', [DoctorVoteController::class, 'storeVote']);
