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
Route::delete('/delete_user','app\Http\Controllers\AdminController@deleteUser');
Route::post('/admin_login','app\Http\Controllers\AdminController@adminLogin');
Route::post('/create_role','app\Http\Controllers\AdminController@addRole');
Route::put('/update_role', 'app\Http\Controllers\AdminController@updateRole');
Route::delete('/delete_role','app\Http\Controllers\AdminController@deleteRole');
Route::get('/get_roles', 'app\Http\Controllers\AdminController@getRole');
Route::post('/assign_roles','app\Http\Controllers\AdminController@assignRoles');
Route::get('/search_project', 'app\Http\Controllers\AdminController@searchProject');
Route::get('/get/user/byid', 'app\Http\Controllers\AdminController@getUserById');
//inventory_data
Route::post('/create-inventorydata','app\Http\Controllers\AdminController@addInventoryData');
Route::get('/inventory_data','app\Http\Controllers\AdminController@inventoryData');
Route::delete('/delete/inventory_data','app\Http\Controllers\AdminController@deleteInventoryData');
Route::get('/inventory_data/{id}','app\Http\Controllers\AdminController@inventoryData');
Route::put('/update/inventory_data','app\Http\Controllers\AdminController@updateInventoryData');
Route::get('/search_users', 'app\Http\Controllers\AdminController@searchUser');
Route::get('/search_inventory', 'app\Http\Controllers\AdminController@searchInventory');
Route::get('/inventory_data/project/{id}', 'app\Http\Controllers\AdminController@getInventoryById');
Route::get('/paginate/inventory_data/project/{id}', 'app\Http\Controllers\AdminController@getPaginateInventoryById');
Route::get('/approved/inventory_data/project/{id}', 'app\Http\Controllers\AdminController@getApprovedInventoryData');
Route::get('/paginate/approved/inventory_data/project/{id}', 'app\Http\Controllers\AdminController@getPaginateApprovedInventoryData');
Route::get('/with_purchase/inventory_data/project/{id}', 'app\Http\Controllers\AdminController@getWithPurchaseInventoryData');
Route::get('/paginate/with_purchase/inventory_data/project/{id}', 'app\Http\Controllers\AdminController@getPaginateWithPurchaseInventoryData');
Route::get('/store_kepper/two/inventory_data/project/{id}', 'app\Http\Controllers\AdminController@getStoreKeeper2InventoryData');
Route::get('/paginate/store_kepper/two/inventory_data/project/{id}', 'app\Http\Controllers\AdminController@getPaginateStoreKeeper2InventoryData');
Route::get('/project/{id}', 'app\Http\Controllers\AdminController@getProjectById');
//Notification
Route::post('/create-notification','app\Http\Controllers\AdminController@createNotification');
Route::get('/notification', 'app\Http\Controllers\AdminController@getNotification');
Route::get('/notification/data/{id}', 'app\Http\Controllers\AdminController@getNotificationData');
Route::put('/update/notification/{id}', 'app\Http\Controllers\AdminController@seenNotification');
Route::get('/project/notification/pend','app\Http\Controllers\AdminController@getNotifPending');
Route::get('/project/notification/pending/{id}','app\Http\Controllers\AdminController@getNotifByIdPending');
Route::get('/notification/role/pend/{id}','app\Http\Controllers\AdminController@getNotificationByRole');
Route::put('/update/project/notification/pend/{id}', 'app\Http\Controllers\AdminController@setSeenNotifPendById');
Route::put('/update/role/notification/pend', 'app\Http\Controllers\AdminController@setSeenRoleNotifPendById');
Route::get('/role/notification/data/{id}', 'app\Http\Controllers\AdminController@getRoleNotificationData');
});
// Route::get('/projects', function () {
//     $nn = Notification::get();
//     broadcast(new ItemAdded($nn));
//     return view('welcome');
// });
Route::get('/slug','app\Http\Controllers\AdminController@slug');
Route::get('/logout','app\Http\Controllers\AdminController@logout');
Route::get('/','app\Http\Controllers\AdminController@index');
Route::any('{slug}','app\Http\Controllers\AdminController@index')->where('slug', "([A-z\d/]+)?");
Route::get('/{route?}', 'RouteController@show')->where('route', '([0-9]+(\/){0,1})*');
Route::get('/{catchall?}', 'app\Http\Controllers\AdminController@index')->where('catchall', '^(?!api).*$')->name('administration');
