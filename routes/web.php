<?php

use App\Http\Controllers\ChatController;
use App\Http\Controllers\GroupController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProjectController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware(['auth'])->group(function () {
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::post('/profile/update', [ProfileController::class, 'update'])->name('profile.update');
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});

Route::middleware('auth')->group(function () {
    Route::get('/chat', [ChatController::class, 'index'])->name('chat.index');
    Route::get('/chat/{userId}', [ChatController::class, 'chatWith'])->name('chat.with');
    Route::post('/chat/{userId}', [ChatController::class, 'sendMessage'])->name('chat.send');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/groups', [GroupController::class, 'index'])->name('group.index');
    Route::get('/groups/create', [GroupController::class, 'create'])->name('group.create');
    Route::post('/groups', [GroupController::class, 'store'])->name('group.store');
    Route::get('/groups/{id}', [GroupController::class, 'chat'])->name('group.chat');
    Route::post('/groups/{id}/send', [GroupController::class, 'sendMessage'])->name('group.send');
});

Route::resource('projects', ProjectController::class)->middleware('auth');


require __DIR__ . '/auth.php';
