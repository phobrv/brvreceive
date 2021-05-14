<?php

Route::middleware(['web', 'auth', 'auth:sanctum', 'lang', 'verified'])->namespace('Phobrv\BrvReceive\Controllers')->group(function () {
	Route::middleware(['can:receive_manage'])->prefix('admin')->group(function () {
		Route::resource('receive', 'ReceiveDataController');
		Route::post('/receive/setDefaultSelect', 'ReceiveDataController@setDefaultSelect')->name('receive.setDefaultSelect');
		Route::get('/receive/updateStatus/{id}/{status}', 'ReceiveDataController@updateStatus')->name('receive.updateStatus');
	});
	Route::middleware(['can:order_manage'])->prefix('admin')->group(function () {
		Route::resource('manage-order', 'OrderController');
		Route::post('/manage-order/setDefaultSelect', 'OrderController@setDefaultSelect')->name('order.setDefaultSelect');
	});
});
