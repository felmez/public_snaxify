<?php

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

//Route::middleware('auth:api')->get('/user', function (Request $request) {
//    return $request->user();
//});

Route::group(['namespace' => 'Api\V1', 'middleware' => ['cors'], 'prefix' => 'v1'], function () {
    Route::get('/categories', 'CategoriesController@index')->name('categories.index');
    Route::get('/restaurants', 'RestaurantsController@index')->name('restaurants.index');
    Route::get('/delivery_areas', 'DeliveryAreasController@index')->name('delivery_areas.index');
    Route::get('/products', 'ProductsController@index')->name('products.index');
    Route::get('/news', 'NewsItemsController@index')->name('news.index');
    Route::post('/order', 'OrdersController@create')->name('orders.create');
    Route::post('/promo_codes/validate', 'PromoCodesController@validate_code')->name('promo_codes.validate');
    Route::get('/settings', 'SettingsController@index')->name('settings.index');
    Route::post('/customers', 'CustomersController@create')->name('customers.create');
    Route::post('/login', 'CustomersController@login')->name('customers.login');
    Route::group(['middleware' => ['app_user_auth']], function () {
    Route::put('/customers/1', 'CustomersController@update')->name('customers.update');
    Route::get('/orders', 'OrdersController@index')->name('orders.index');
    });
});