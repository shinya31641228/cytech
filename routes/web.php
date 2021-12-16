<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductsController;

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

// Route::get('/', function () {
//     return view('welcome');
// });

Auth::routes();

//商品一覧画面を表示
Route::get('/', [HomeController::class, 'showHome'])->name('home');
//商品登録画面を表示
Route::get('/product/create', [ProductsController::class, 'showCreate'])->name('create');
//商品登録する
Route::post('/product/store', [ProductsController::class, 'exeStore'])->name('store');
//商品詳細表示する
Route::get('/product/detail/{id}', [ProductsController::class, 'showDetail'])->name('detail');
//商品編集画面を表示する
Route::get('/product/edit/{id}', [ProductsController::class, 'showEdit'])->name('edit');
//商品編集する
Route::post('/product/update', [ProductsController::class, 'exeUpdate'])->name('update');
//商品を削除する
Route::post('/product/delete/{id}', [ProductsController::class, 'delete'])->name('delete');
//検索ボタンを押すとのSearchメソッドを実行する
Route::get('/product/search', [ProductsController::class,'searchList'])->name('search');
