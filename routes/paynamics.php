<?php

// Transaction QUERY
Route::post('/paynamics-query', 'PaynamicsController@query_payment_processing_check')->name('paynamics.query_check');
Route::get('/paynamics/query-check/response/{id}', 'PaynamicsController@query_view')->name('paynamics.query_view');
