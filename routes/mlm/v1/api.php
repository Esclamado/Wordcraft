<?php


// Auth
Route::post('/login', 'Auth\ApiAuthController@login');

Route::group(['middleware' => 'auth:api'], function () {
  Route::get('/retrieve-reseller-info', 'MLM\v1\ApiController@retrieve_reseller');
  Route::get('/retrieve-reseller-verification', 'MLM\v1\ApiController@retrieve_reseller_verification');
  Route::get('/retrieve-reseller-transactions', 'MLM\v1\ApiController@retrieve_reseller_transactions');
  Route::get('/retrieve-reseller-transaction', 'MLM\v1\ApiController@retrieve_reseller_transaction');
});

Route::post('/trigger/webhook/new-user', 'MLM\v1\TestWebhookController@test_new_user');
Route::post('/trigger/webhook/new-order', 'MLM\v1\TestWebhookController@test_new_order');
Route::post('/trigger/webhook/new-wallet-update', 'MLM\v1\TestWebhookController@test_new_wallet_update');
