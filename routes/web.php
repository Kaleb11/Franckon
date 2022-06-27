<?php

use App\Events\ItemAdded;
use App\Models\Notification;
use App\Http\Middleware\AdminCheck;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\admincontroller;
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

Route::group([
    'middleware' => [AdminCheck::class],
    'prefix' => 'app'
], function () {
Auth::routes();

});
// Route::get('/projects', function () {
//     $nn = Notification::get();
//     broadcast(new ItemAdded($nn));
//     return view('welcome');
// });
Route::get('/slug',[admincontroller::class, 'slug']);
Route::get('/logout',[admincontroller::class, 'logout']);
Route::get('/',[admincontroller::class, 'index']);
Route::any('{slug}',[admincontroller::class, 'index'])->where('slug', "([A-z\d/]+)?");
Route::get('/{route?}', 'RouteController@show')->where('route', '([0-9]+(\/){0,1})*');
Route::get('/{catchall?}', [admincontroller::class, 'index'])->where('catchall', '^(?!api).*$')->name('administration');
