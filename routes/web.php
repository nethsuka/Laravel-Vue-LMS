<?php

use App\Http\Controllers\ClassControlsController;
use App\Http\Controllers\ClassFeeController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EditResourceController;
use App\Http\Controllers\ExtraLessonsController;
use App\Http\Controllers\MoreClassesController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ResourceControlsController;
use App\Http\Controllers\ResourcesController;
use App\Http\Controllers\StudentControlsController;
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

Route::get('/payments', [PaymentController::class, 'index'])->middleware(['auth', 'verified'])->name('payments');
Route::post('/payments', [PaymentController::class, 'store'])->middleware(['auth', 'verified'])->name('payments.upload');
Route::post('/payments/resource-payment', [PaymentController::class, 'storeResourceSlip'])->middleware(['auth', 'verified'])->name('payments.resourceSlipUpload');


Route::get('/extra-lessons', [ExtraLessonsController::class, 'index'])->middleware(['auth', 'verified'])->name('extra_lessons');


Route::get('/resources', [ResourcesController::class, 'index'])->middleware(['auth', 'verified'])->name('resources');


Route::middleware(['auth', 'verified', 'admin'])->group(function () {
    Route::get('/class-controls', [ClassControlsController::class, 'index'])->name('class_controls');
    Route::post('/class-controls/video-list-update', [ClassControlsController::class, 'updateClassVideoList'])->name('class_controls.video_list_update');
    Route::post('/class-controls/addclass', [ClassControlsController::class, 'addNewClass'])->name('class_controls.add_video');
    Route::patch('/class-controls/updateclass', [ClassControlsController::class, 'updateclass'])->name('class_controls.update_class');
    Route::post('/class-controls/addnewvideo', [ClassControlsController::class, 'addNewVideo'])->name('class_controls.new_video');
    Route::post('/class-controls/addTute', [ClassControlsController::class, 'addTute'])->name('class_controls.new_tute');
    Route::delete('/class-controls/deleteTute', [ClassControlsController::class, 'deleteTute'])->name('class_controls.delete_tute');
    Route::delete('/class-controls/deleteClass', [ClassControlsController::class, 'deleteClass'])->name('class_controls.delete_class');
});

// Route::get('/payments', function () {
//     return Inertia::render('Payment');
// })->name('payments');

// have to add admin middleware to these routs
Route::get('/resource-controls', [ResourceControlsController::class, 'index'])->middleware(['auth', 'verified'])->name('resourceControls');
// Route::get('resourceCPanel/edit', function () {
//     return Inertia::render('Admin/EditResource');
// })->middleware(['auth', 'verified'])->name('resourceCPanel/edit');
Route::get('/resource-controls/edit/{resourceId}', [EditResourceController::class, 'show'])->middleware(['auth', 'verified'])->name('resourceControls.edit');
Route::patch('/resource-controls/edit/save-changes', [EditResourceController::class, 'saveResourceChanges'])->middleware(['auth', 'verified'])->name('resourceControls.saveChanges');
Route::post('/resource-controls/add-resource', [ResourceControlsController::class, 'addResource'])->middleware(['auth', 'verified'])->name('resourceControls.addResource');
Route::delete('/resource-controls/delete-resource', [ResourceControlsController::class, 'deleteResource'])->middleware(['auth', 'verified'])->name('resourceControls.deleteResource');
Route::post('/resource-controls/resource/add-video', [EditResourceController::class, 'addVideo'])->middleware(['auth', 'verified'])->name('resourceControls.addVideo');
Route::patch('/resource-controls/edit/save-video-changes', [EditResourceController::class, 'updateResourceVideoList'])->middleware(['auth', 'verified'])->name('resourceControls.updateVideoChanges');

// Student control page
// Route::get('/studentCPanel', function () {
//     return Inertia::render('Admin/StudentControls');
// })->middleware(['auth', 'verified'])->name('studentCPanel');
Route::get('/student-controls', [StudentControlsController::class, 'index'])->middleware(['auth', 'verified'])->name('studentCPanel');

//student' classes page
Route::get('/studentsClasses', function () {
    return Inertia::render('Admin/FilterStuClass');
})->middleware(['auth', 'verified'])->name('studentsClasses');

Route::middleware(['auth', 'verified', 'admin'])->group(function () {
    Route::get('/classfees', [ClassFeeController::class, 'index'])->name('classfees');
    Route::patch('/classfees', [ClassFeeController::class, 'acceptPayment'])->name('classfees.accept');
    Route::patch('/classfees/undo-payment', [ClassFeeController::class, 'undoPayment'])->name('classfees.undo');
    Route::delete('/classfees/delete/slips', [ClassFeeController::class, 'clearSlipTable'])->name('');
    Route::delete('/classfees/delete-slip', [ClassFeeController::class, 'deleteStudentSlip'])->name('classfees.deleteSlip');
});

Route::get('/more-classes', [MoreClassesController::class, 'index'])->middleware(['auth', 'verified'])->name('classinfo');


require __DIR__ . '/auth.php';
