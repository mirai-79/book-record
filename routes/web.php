<?php

use App\Http\Controllers\CreateRecordController;
use App\Http\Controllers\DeleteRecordController;
use App\Http\Controllers\EditRecordController;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\ListController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SearchBookController;
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

Route::get('/', [ListController::class, 'index'])->name('index');
Route::get('/user/{user_id}', [ListController::class, 'showMyRecord'])->name('my.record');

Route::get('/search', [SearchBookController::class, 'show'])->name('search');
Route::get('/search/book', [CreateRecordController::class, 'searchBook'])->name('book.search');

Route::get('/search/{id}', [CreateRecordController::class, 'create'])->name('book.create');
Route::post('/search/{id}', [CreateRecordController::class, 'create'])->name('book.create');
Route::post('/create/{id}', [CreateRecordController::class, 'addRecord'])->name('book.record');

Route::get('/create/other/{id}', [CreateRecordController::class, 'otherCreate'])->name('other.book.record');

Route::get('/edit/{record_id}', [EditRecordController::class, 'edit'])->name('record.edit');
Route::get('/user/{user_id}/edit/{record_id}', [EditRecordController::class, 'edit'])->name('user.record.edit');
Route::put('/edit/{record_id}', [EditRecordController::class, 'update'])->name('record.update');
Route::put('/user/{user_id}/edit/{record_id}', [EditRecordController::class, 'update'])->name('user.record.update');

Route::delete('/delete/{record_id}', [DeleteRecordController::class, 'delete'])->name('record.delete');

Route::post('/index/{record_id}', [FavoriteController::class, 'saveFavorite'])->name('favorite.save');
Route::delete('/index/{record_id}', [FavoriteController::class, 'destroyFavorite'])->name('favorite.destroy');

// Route::get('test', [TestController::class, 'testFunction']);

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
