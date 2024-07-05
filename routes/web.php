<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\BookController;

Route::get('/', function(){
     return view('auth/login');
    });
Route::get('/searchm',[BookController::class,'searchm'])->name('searchm');
Route::get('/welcome',[BookController::class,'index'])->name('welcome');
Route::get('/detail/{id}',[BookController::class,'detail']);


Route::get('/book', [AdminController::class,'index'])->name('book')->middleware('is_admin');
Route::post('/insert',[AdminController::class,'insert']);
Route::get('/create',[AdminController::class,'create']);
Route::get('/delete/{id}',[AdminController::class,'delete'])->name('delete');
Route::put('/update/{id}',[AdminController::class,'update'])->name('update');
Route::get('/change/{id}',[AdminController::class,'change'])->name('change');
Route::get('/edit/{id}',[AdminController::class,'edit'])->name('edit');
Route::get('/search',[AdminController::class,'search'])->name('search');
Route::get('/borrow',[AdminController::class,'borrow'])->name('borrow');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
// Route::get('admin/home', [HomeController::class, 'adminHome'])->name('admin.home')->middleware('is_admin');
