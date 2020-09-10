<?php

/*
|--------------------------------------------------------------------------
| Web Dashboard Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web admin routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" & "auth" middleware group. Now create something great!
|
*/

Route::get('/', 'DashboardController@index')->name('index');

Route::resource('categories', 'CategoriesController');
Route::get('products/autocomplete', 'ProductsController@autocomplete');
Route::get('products/bulk_upload', 'ProductsController@bulk_upload')->name('products.bulk_upload');
Route::post('products/bulk', 'ProductsController@bulk')->name('products.bulk');
Route::resource('products', 'ProductsController');
Route::post('product_image/{id}/delete', 'ProductsController@deleteImage')->name('products.delete_image');
Route::put('orders/{id}/boy', 'OrdersController@setDeliveryBoy')->name('orders.update_boy');
Route::resource('orders', 'OrdersController');
Route::resource('news_items', 'NewsItemsController');
Route::resource('settings', 'SettingsController');
Route::resource('push_messages', 'PushMessagesController');
Route::resource('delivery_areas', 'DeliveryAreasController');
Route::resource('promo_codes', 'PromoCodesController');
Route::resource('tax_groups', 'TaxGroupsController');
Route::resource('cities', 'CitiesController');
Route::resource('restaurants', 'RestaurantsController');
Route::resource('customers', 'CustomersController');
Route::resource('ordered_products', 'OrderedProductsController');
Route::resource('order_statuses', 'OrderStatusesController');
Route::resource('users', 'UsersController');
Route::resource('delivery_boys', 'DeliveryBoysController');
