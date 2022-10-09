<?php

use App\Http\Controllers\ContactController;
use App\Http\Controllers\ContactGroupController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return Inertia::render('Welcome', [

    ]);
})->name('welcome');

Auth::routes([
    'verify' => true,
]);

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/home', [HomeController::class, 'index'])->name('home');

    Route::resource('users', UserController::class)->parameters([
        'users' => 'userUuid',
    ])->only('edit', 'update');

    Route::resource('contactGroups', ContactGroupController::class)->parameters([
        'contactGroups' => 'contactGroupUuid',
    ]);

    Route::get('/contactGroups/{contactGroupUuid}/delete', [ContactGroupController::class, 'delete'])->name('contactGroups.delete');

    Route::resource('contactGroups.contacts', ContactController::class)->parameters([
        'contactGroups' => 'contactGroupUuid',
        'contacts' => 'contactUuid',
    ]);

    Route::get('/contactGroups/{contactGroupUuid}/contacts/{contactUuid}/delete', [ContactController::class, 'delete'])->name('contactGroups.contacts.delete');

    Route::resource('contactGroups.messages', MessageController::class)->parameters([
        'contactGroups' => 'contactGroupUuid',
        'messages' => 'messageUuid',
    ]);
});
