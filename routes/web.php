<?php

use Illuminate\Support\Facades\Route;
use App\Product;
use App\Stock;
use App\Price;
use App\Order;
use App\OrderDetail;
use App\Seller;
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
Route::get('houses', function () {
    return view('welcome');
});
Route::get('demo', function () {
    return view('demo');
});
Route::get('/', 'HomeController@index')->name('codbars');

Route::get('logs', [\Rap2hpoutre\LaravelLogViewer\LogViewerController::class, 'index']);

Auth::routes();

Route::post('codbars_save', ['as' => 'products.codbars_save', 'uses' => 'HomeController@codbars_save']);