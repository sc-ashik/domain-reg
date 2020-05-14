<?php

use Illuminate\Support\Facades\Route;

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

// Auth::routes(['register' => false]);
Auth::routes();

Route::get('/', 'HomeController@index')->name('home');
Route::get('/table1', 'HomeController@table1');
Route::get('/table2', 'HomeController@table2');
Route::resources([
    'task' => 'TaskController'
]);

Route::post('resello', function () {
    return '{"success":true}';
});