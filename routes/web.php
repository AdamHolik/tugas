<?php

use App\Http\Controllers\BlogController;
use App\Http\Controllers\Backend\BlogController as BackendBlogController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\Backend\SliderController;
use App\Http\Controllers\Backend\ServiceController;
use Faker\Guesser\Name;
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

Route::get('/',[HomeController::class,'index'])->name('home');

Route::get('/blog',[BlogController::class,'index'])->name('blog');
Route::get('/blog/detail',
[BlogController::class,'detail'])
->name('blog_detail');


// backend
Route::get('/login',[LoginController::class,'index'])->name('login');
Route::post('/aksi_login',[LoginController::class,'aksi_login'])->name('aksi_login');

// Route::middleware(['AuthWeb'])->group(function () {
Route::get('backend/blog',[BackendBlogController::class,'index'])->name('backend.blog');
Route::get('backend/blog/tambah',[BackendBlogController::class,'tambah'])->name('backend.blog.tambah');
Route::get('backend/blog/edit/{id}',[BackendBlogController::class,'edit'])->name('backend.blog.edit');
Route::post('backend/blog/aksi_edit/{id}',[BackendBlogController::class,'aksi_edit'])->name('backend.blog.aksi_edit');
Route::post('backend/blog/aksi_tambah',[BackendBlogController::class,'aksi_tambah'])->name('backend.blog.aksi_tambah');
Route::post('backend/blog/aksi_hapus/{id}',[BackendBlogController::class,'aksi_hapus'])->name('backend.blog.aksi_hapus');
Route::get('backend/slider',[SliderController::class,'index'])->name('backend.slider');
Route::get('backend/service',[ServiceController::class,'index'])->name('backend.service');
// });