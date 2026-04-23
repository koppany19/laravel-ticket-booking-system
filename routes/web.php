<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ScanController;
use App\Http\Controllers\SeatController;
use App\Http\Controllers\TicketController;
use Illuminate\Support\Facades\Route;


Route::get('/', [EventController::class, 'index'])->name('home');

Route::get('/events/{event}', [EventController::class, 'show'])->name('events.show');


Route::get('/events/{event}/tickets', [TicketController::class, 'create'])->middleware('auth')->name('buy-tickets');
Route::post('/events/{event}/tickets', [TicketController::class, 'store'])->middleware('auth')->name('buy-tickets.store');
Route::get('/my-tickets', [TicketController::class, 'myTickets'])->middleware('auth')->name('my-tickets');


Route::get('/admin', [AdminController::class, 'index'])->middleware(['auth', 'admin'])->name('dashboard');
Route::get('/admin/create', [AdminController::class, 'create'])->middleware(['auth', 'admin'])->name('events.create');
Route::get('/admin/events/{event}', [AdminController::class, 'show'])->middleware(['auth', 'admin'])->name('events.show');
Route::get('/admin/events/{event}/edit', [AdminController::class, 'edit'])->middleware(['auth', 'admin'])->name('events.edit');

Route::post('/admin/event', [AdminController::class, 'store'])->middleware(['auth', 'admin'])->name('events.store');
Route::put('/admin/events/{event}', [AdminController::class, 'update'])->middleware(['auth', 'admin'])->name('events.update');
Route::delete('/admin/events/{event}', [AdminController::class, 'destroy'])->middleware(['auth', 'admin'])->name('events.destroy');


Route::get('admin/seats', [SeatController::class, 'index'])->middleware(['auth', 'admin'])->name('seat.index');
Route::post('admin/seats', [SeatController::class, 'store'])->middleware(['auth', 'admin'])->name('seat.store');
Route::get('admin/seats/{seat}', [SeatController::class, 'show'])->middleware(['auth', 'admin'])->name('seat.show');
Route::get('admin/seats/{seat}/edit', [SeatController::class, 'edit'])->middleware(['auth', 'admin'])->name('seat.edit');
Route::put('admin/seats/{seat}', [SeatController::class, 'update'])->middleware(['auth', 'admin'])->name('seat.update');
Route::delete('admin/seats/{seat}', [SeatController::class, 'destroy'])->middleware(['auth', 'admin'])->name('seat.destroy');

Route::get('/admin/scanner', [ScanController::class, 'index'])->middleware(['auth', 'admin'])->name('scanner');
Route::post('/admin/scanner', [ScanController::class, 'scan'])->middleware(['auth', 'admin'])->name('admin.scan');





Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboar');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
