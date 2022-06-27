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
Route::post('/create_category','AdminController@addCategory');
Route::get('/get_category', 'AdminController@getCategory');
Route::delete('/delete_category','AdminController@deleteCategory');
Route::post('/upload','AdminController@upload');
Route::post('/upload/user/photo','AdminController@upload');
Route::post('/delete_image','AdminController@deleteImage');
Route::put('/update_category', 'AdminController@updateCategory');
Route::post('/create_user','AdminController@createUser');
Route::get('/get_users', 'AdminController@getUsers');
Route::post('/upload/project/image','AdminController@upload');
Route::post('/upload/reset/photo','AdminController@upload');
Route::put('/update_user', 'AdminController@updateUser');
Route::delete('/delete_user','AdminController@deleteUser');
Route::post('/admin_login','AdminController@adminLogin');
Route::post('/create_role','AdminController@addRole');
Route::put('/update_role', 'AdminController@updateRole');
Route::delete('/delete_role','AdminController@deleteRole');
Route::get('/get_roles', 'AdminController@getRole');
Route::post('/assign_roles','AdminController@assignRoles');
Route::get('/search_project', 'AdminController@searchProject');
Route::get('/get/user/byid', 'AdminController@getUserById');
//inventory_data
Route::post('/create-inventorydata','AdminController@addInventoryData');
Route::get('/inventory_data','AdminController@inventoryData');
Route::delete('/delete/inventory_data','AdminController@deleteInventoryData');
Route::get('/inventory_data/{id}','AdminController@inventoryData');
Route::put('/update/inventory_data','AdminController@updateInventoryData');
Route::get('/search_users', 'AdminController@searchUser');
Route::get('/search_inventory', 'AdminController@searchInventory');
Route::get('/inventory_data/project/{id}', 'AdminController@getInventoryById');
Route::get('/paginate/inventory_data/project/{id}', 'AdminController@getPaginateInventoryById');
Route::get('/approved/inventory_data/project/{id}', 'AdminController@getApprovedInventoryData');
Route::get('/paginate/approved/inventory_data/project/{id}', 'AdminController@getPaginateApprovedInventoryData');
Route::get('/with_purchase/inventory_data/project/{id}', 'AdminController@getWithPurchaseInventoryData');
Route::get('/paginate/with_purchase/inventory_data/project/{id}', 'AdminController@getPaginateWithPurchaseInventoryData');
Route::get('/store_kepper/two/inventory_data/project/{id}', 'AdminController@getStoreKeeper2InventoryData');
Route::get('/paginate/store_kepper/two/inventory_data/project/{id}', 'AdminController@getPaginateStoreKeeper2InventoryData');
Route::get('/project/{id}', 'AdminController@getProjectById');
//Notification
Route::post('/create-notification','AdminController@createNotification');
Route::get('/notification', 'AdminController@getNotification');
Route::get('/notification/data/{id}', 'AdminController@getNotificationData');
Route::put('/update/notification/{id}', 'AdminController@seenNotification');
Route::get('/project/notification/pend','AdminController@getNotifPending');
Route::get('/project/notification/pending/{id}','AdminController@getNotifByIdPending');
Route::get('/notification/role/pend/{id}','AdminController@getNotificationByRole');
Route::put('/update/project/notification/pend/{id}', 'AdminController@setSeenNotifPendById');
Route::put('/update/role/notification/pend', 'AdminController@setSeenRoleNotifPendById');
Route::get('/role/notification/data/{id}', 'AdminController@getRoleNotificationData');
});
// Route::get('/projects', function () {
//     $nn = Notification::get();
//     broadcast(new ItemAdded($nn));
//     return view('welcome');
// });
Route::get('/slug','AdminController@slug');
Route::get('/logout','AdminController@logout');
Route::get('/','AdminController@index');
Route::any('{slug}','AdminController@index')->where('slug', "([A-z\d/]+)?");
Route::get('/{route?}', 'RouteController@show')->where('route', '([0-9]+(\/){0,1})*');
Route::get('/{catchall?}', 'AdminController@index')->where('catchall', '^(?!api).*$')->name('administration');
