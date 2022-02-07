<?php

/*
|--------------------------------------------------------------------------
| Reseller Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::group(['prefix' => 'reseller', 'middleware' => ['auth', 'verified', 'user', 'reseller']], function () {
    Route::get('earnings', 'ResellerController@earnings')->name('reseller.earnings');
    Route::get('earnings/purchase-history/{id}/show', 'ResellerController@show_purchase_history')->name('reseller.show_purchase_history');

    Route::get('my-customers', 'ResellerController@my_customers')->name('reseller.my_customers');
    Route::get('my-customers/show/{id}', 'ResellerController@my_customer_show')->name('reseller.my_customer.show');
    Route::get('my-customer-orders', 'ResellerController@customer_orders')->name('reseller.customer_orders');
    Route::get('my-customer-orders/returns', 'ResellerController@customer_orders_returns')->name('reseller.customer_orders_returns');

    Route::post('reseller-perks-viewed', 'ResellerController@reseller_viewed')->name('reseller.perks_viewed');
});

Route::post('convert-earnings', 'ResellerController@convert_earnings')->name('reseller.convert_earnings');
