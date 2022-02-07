<?php

/*
|--------------------------------------------------------------------------
| Employee Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::group(['prefix' => 'employee', 'middleware' => ['auth', 'verified', 'user', 'employee']], function () {
    Route::get('my-resellers', 'EmployeeController@my_resellers')->name('employee.my_resellers');
    Route::get('my-resellers/show/{reseller_id}', 'EmployeeController@my_reseller_show')->name('employee.my_reseller_show');

    Route::get('my-earnings', 'EmployeeController@my_earnings')->name('employee.my_earnings');
    Route::get('my-earnings/reseller', 'EmployeeController@my_earnings_reseller')->name('employee.my_earnings_reseller');

    Route::get('my-earnings/customer/purchase_history/{id}/show', 'EmployeeController@my_earnings_cutomer_order_show')->name('employee.my_earnings_customer.order_show');
    Route::get('my-earnings/reseller/purchase_history/{id}/show', 'EmployeeController@my_earnings_reseller_order_show')->name('employee.my_earnings_reseller.order_show');

    Route::get('my-customer-orders', 'EmployeeController@my_customer_orders')->name('employee.my_customer_orders');
    Route::get('my-customer-orders/returns', 'EmployeeController@my_customer_orders_returns')->name('employee.my_customer_orders_returns');
    Route::get('my-customers', 'EmployeeController@my_customers')->name('employee.my_customers');
    Route::get('my-customers/show/{id}', 'EmployeeController@my_customer_show')->name('employee.my_customer.show');
});
