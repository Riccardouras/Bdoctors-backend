<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\DoctorController;
use App\Http\Controllers\Admin\ReviewController;
use App\Http\Controllers\Admin\SponsorshipController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return redirect('http://localhost:5174');
});


Route::middleware(['auth'])
    ->prefix('admin') //definisce il prefisso "admin/" per le rotte di questo gruppo
    ->name('admin.') //definisce il pattern con cui generare i nomi delle rotte cioè "admin.qualcosa"
    ->group(function () {
        Route::get('/', [DoctorController::class, 'stats'])->name('doctors.stats');

        Route::get('doctors/messages', [DoctorController::class, 'messages'])->name('doctors.messages');
        Route::get('doctors/reviews', [DoctorController::class, 'reviews'])->name('doctors.reviews');

        Route::resource('doctors', DoctorController::class);

        Route::get('sponsorship', [SponsorshipController::class, 'showForm'])->name('sponsorship.form');
        Route::post('sponsorship/payment', [SponsorshipController::class, 'payment'])->name('sponsorship.payment');
        Route::post('sponsorship/processpayment', [SponsorshipController::class, 'processpayment'])->name('sponsorship.processpayment');
    });


// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

require __DIR__ . '/auth.php';
