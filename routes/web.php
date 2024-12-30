<?php
use App\Http\Controllers\ClassControlsController;
use App\Http\Controllers\ClassFeeController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MoreClassesController;
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


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/dashboard', [DashboardController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');
Route::post('/dashboard/zoomlink', [DashboardController::class, 'joinOnline'])->middleware(['auth', 'verified'])->name('dashboard.joinOnline');

Route::get('/payments', [PaymentController::class, 'index'])->name('payments');
Route::post('/payments', [PaymentController::class, 'store'])->name('payments.upload');

Route::get('/extra-lessons', function () {
        return Inertia::render('ExtraLessons');
    })->name('extra_lessons');

Route::get('/resources', function () {
    return Inertia::render('Resources');
})->name('resources');

Route::get('/class-controls', [ClassControlsController::class, 'index'])->name('class_controls');
Route::post('/class-controls/video-list-update', [ClassControlsController::class, 'updateClassVideoList'])->name('class_controls.video_list_update');
Route::post('/class-controls/addclass', [ClassControlsController::class, 'addNewClass'])->name('class_controls.add_video');
Route::patch('/class-controls/updateclass', [ClassControlsController::class, 'updateclass'])->name('class_controls.update_class');
Route::post('/class-controls/addnewvideo', [ClassControlsController::class, 'addNewVideo'])->name('class_controls.new_video');
Route::post('/class-controls/addTute', [ClassControlsController::class, 'addTute'])->name('class_controls.new_tute');
Route::delete('/class-controls/deleteTute', [ClassControlsController::class, 'deleteTute'])->name('class_controls.delete_tute');
Route::delete('/class-controls/deleteClass', [ClassControlsController::class, 'deleteClass'])->name('class_controls.delete_class');

// Route::get('/payments', function () {
//     return Inertia::render('Payment');
// })->name('payments');

Route::get('/classfees', [ClassFeeController::class, 'index'])->name('classfees');
Route::patch('/classfees', [ClassFeeController::class, 'acceptPayment'])->name('classfees.accept');
Route::patch('/classfees/undo-payment', [ClassFeeController::class, 'undoPayment'])->name('classfees.undo');
Route::delete('/classfees/delete/slips', [ClassFeeController::class, 'clearSlipTable'])->name('');

Route::get('/more-classes', [MoreClassesController::class, 'index'])->name('classinfo');


require __DIR__.'/auth.php';
