<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\AdminBorrowController;


Route::get('/', function(){
     return view('auth/login');
    });
Route::post('/searchm',[BookController::class,'searchm'])->name('searchm');
Route::get('/welcome',[BookController::class,'index'])->name('welcome');
Route::get('/detail/{id}',[BookController::class,'detail']);


Route::get('/book', [AdminController::class,'index'])->name('book')->middleware('is_admin');
Route::post('/insert',[AdminController::class,'insert'])->middleware('is_admin');
Route::get('/create',[AdminController::class,'create'])->middleware('is_admin');
Route::get('/delete',[AdminController::class,'delete'])->name('deletebook');
Route::put('/update/{id}',[AdminController::class,'update'])->name('update');
Route::get('/change/{id}',[AdminController::class,'change'])->name('change');
Route::get('/edit/{id}',[AdminController::class,'edit'])->name('edit');
Route::post('/search',[AdminController::class,'search'])->name('search');
Route::get('/borrow/{id}', [AdminController::class, 'borrow'])->name('borrow');
Route::post('/borrow', [AdminController::class, 'storeBorrow'])->name('storeBorrow');
Route::get('/pending', [AdminController::class, 'pending'])->name('pending')->middleware('is_admin');
Route::post('/borrow/{id}/approve', [AdminController::class, 'approve'])->name('approve');
Route::post('/borrow/{id}/reject', [AdminController::class, 'reject'])->name('reject');
Route::get('/history', [AdminController::class, 'history'])->name('history');
Route::post('/return-book/{id}', [AdminController::class, 'returnBook'])->name('returnBook');
Route::get('/return', [AdminController::class, 'return'])->name('return')->middleware('is_admin');
Route::post('/approve-return/{id}', [AdminController::class, 'approveReturn'])->name('approveReturn');




Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
// Route::get('admin/home', [HomeController::class, 'adminHome'])->name('admin.home')->middleware('is_admin');


