<?php

use App\Http\Controllers\ChatController;
use App\Http\Controllers\GroupController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\UserRoleController;
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
Route::middleware(['role:admin'])->group(function () {

    Route::resource('projects', ProjectController::class)->middleware('auth');
});
Route::resource('projects.tasks', TaskController::class)->shallow();
Route::get('/projects/{project}/kanban', [ProjectController::class, 'kanban'])->name('projects.kanban');
Route::get('/tasks/{task}', [TaskController::class, 'show'])->name('tasks.show');
// Role & Permission Management
// all role/permission management routes
Route::resource('roles', RoleController::class)->middleware('role:admin');
Route::get('users/roles', [UserRoleController::class, 'index'])->name('users.roles')->middleware('role:admin');
Route::post('users/roles/{user}', [UserRoleController::class, 'update'])->name('users.roles.update')->middleware('role:admin');


require __DIR__ . '/auth.php';
