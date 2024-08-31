<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Symfony\Component\Routing\Route as RoutingRoute;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/dashboard', [DashboardController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');
Route::post('/dashboard', [DashboardController::class, 'joinClass'])->middleware(['auth', 'verified'])->name('dashboard.joinClass');
Route::post('/dashboard/zoomlink', [DashboardController::class, 'joinOnline'])->middleware(['auth', 'verified'])->name('dashboard.joinOnline');


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});



Route::get('/admin', function () {
    return Inertia::render('Admin/ClassControles');
})->name('class_controles');



// Route::get('/payments', function () {
//     return Inertia::render('Payment');
// })->name('payments');

Route::get('/payments', [PaymentController::class, 'index'])->name('payments');
Route::post('/payments', [PaymentController::class, 'store'])->name('payments.upload');

Route::get('/test', function () {
    return Inertia::render('Admin/AdminPanel');
})->name('test');


require __DIR__.'/auth.php';
