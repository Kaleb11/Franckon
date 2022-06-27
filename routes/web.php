<?php

use App\Events\ItemAdded;
use App\Models\Notification;
use App\Http\Middleware\AdminCheck;
use Illuminate\Support\Facades\Auth;
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

Route::group([
    'middleware' => [AdminCheck::class],
    'prefix' => 'app'
], function () {
Auth::routes();
Route::post('/create_category','app\Http\Controllers\AdminController@addCategory');
Route::get('/get_category', 'app\Http\Controllers\AdminController@getCategory');
Route::delete('/delete_category','app\Http\Controllers\AdminController@deleteCategory');
Route::post('/upload','app\Http\Controllers\AdminController@upload');
Route::post('/upload/user/photo','app\Http\Controllers\AdminController@upload');
Route::post('/delete_image','app\http\Controllers\AdminController@deleteImage');
Route::put('/update_category', 'app\Http\Controllers\AdminController@updateCategory');
Route::post('/create_user','app\Http\Controllers\AdminController@createUser');
Route::get('/get_users', 'app\Http\Controllers\AdminController@getUsers');
Route::post('/upload/project/image','app\Http\Controllers\AdminController@upload');
Route::post('/upload/reset/photo','app\Http\Controllers\AdminController@upload');
Route::put('/update_user', 'app\Http\Controllers\AdminController@updateUser');
Route::delete('/delete_user','App\Http\Controllers\AdminController@deleteUser');
Route::post('/admin_login','App\Http\Controllers\AdminController@adminLogin');
Route::post('/create_role','App\Http\Controllers\AdminController@addRole');
Route::put('/update_role', 'App\Http\Controllers\AdminController@updateRole');
Route::delete('/delete_role','App\Http\Controllers\AdminController@deleteRole');
Route::get('/get_roles', 'App\Http\Controllers\AdminController@getRole');
Route::post('/assign_roles','App\Http\Controllers\AdminController@assignRoles');
Route::get('/search_project', 'App\Http\Controllers\AdminController@searchProject');
Route::get('/get/user/byid', 'App\Http\Controllers\AdminController@getUserById');
//inventory_data
Route::post('/create-inventorydata','App\Http\Controllers\AdminController@addInventoryData');
Route::get('/inventory_data','App\Http\Controllers\AdminController@inventoryData');
Route::delete('/delete/inventory_data','App\Http\Controllers\AdminController@deleteInventoryData');
Route::get('/inventory_data/{id}','App\Http\Controllers\AdminController@inventoryData');
Route::put('/update/inventory_data','App\Http\Controllers\AdminController@updateInventoryData');
Route::get('/search_users', 'App\Http\Controllers\AdminController@searchUser');
Route::get('/search_inventory', 'App\Http\Controllers\AdminController@searchInventory');
Route::get('/inventory_data/project/{id}', 'App\Http\Controllers\AdminController@getInventoryById');
Route::get('/paginate/inventory_data/project/{id}', 'App\Http\Controllers\AdminController@getPaginateInventoryById');
Route::get('/approved/inventory_data/project/{id}', 'App\Http\Controllers\AdminController@getApprovedInventoryData');
Route::get('/paginate/approved/inventory_data/project/{id}', 'App\Http\Controllers\AdminController@getPaginateApprovedInventoryData');
Route::get('/with_purchase/inventory_data/project/{id}', 'App\Http\Controllers\AdminController@getWithPurchaseInventoryData');
Route::get('/paginate/with_purchase/inventory_data/project/{id}', 'App\Http\Controllers\AdminController@getPaginateWithPurchaseInventoryData');
Route::get('/store_kepper/two/inventory_data/project/{id}', 'App\Http\Controllers\AdminController@getStoreKeeper2InventoryData');
Route::get('/paginate/store_kepper/two/inventory_data/project/{id}', 'App\Http\Controllers\AdminController@getPaginateStoreKeeper2InventoryData');
Route::get('/project/{id}', 'App\Http\Controllers\AdminController@getProjectById');
//Notification
Route::post('/create-notification','App\Http\Controllers\AdminController@createNotification');
Route::get('/notification', 'App\Http\Controllers\AdminController@getNotification');
Route::get('/notification/data/{id}', 'App\Http\Controllers\AdminController@getNotificationData');
Route::put('/update/notification/{id}', 'App\Http\Controllers\AdminController@seenNotification');
Route::get('/project/notification/pend','App\Http\Controllers\AdminController@getNotifPending');
Route::get('/project/notification/pending/{id}','App\Http\Controllers\AdminController@getNotifByIdPending');
Route::get('/notification/role/pend/{id}','App\Http\Controllers\AdminController@getNotificationByRole');
Route::put('/update/project/notification/pend/{id}', 'App\Http\Controllers\AdminController@setSeenNotifPendById');
Route::put('/update/role/notification/pend', 'App\Http\Controllers\AdminController@setSeenRoleNotifPendById');
Route::get('/role/notification/data/{id}', 'App\Http\Controllers\AdminController@getRoleNotificationData');
});
// Route::get('/projects', function () {
//     $nn = Notification::get();
//     broadcast(new ItemAdded($nn));
//     return view('welcome');
// });
Route::get('/slug','App\Http\Controllers\AdminController@slug');
Route::get('/logout','App\Http\Controllers\AdminController@logout');
Route::get('/','App\Http\Controllers\AdminController@index');
Route::any('{slug}','App\Http\Controllers\AdminController@index')->where('slug', "([A-z\d/]+)?");
Route::get('/{route?}', 'RouteController@show')->where('route', '([0-9]+(\/){0,1})*');
Route::get('/{catchall?}', 'App\Http\Controllers\AdminController@index')->where('catchall', '^(?!api).*$')->name('administration');
