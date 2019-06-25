<?php

Auth::routes();

Route::get('/', 'HomeController@index')->name('home');


//magazine
Route::resource('/magazine', 'MagazineController');
Route::get('/magazine/download/{id}', 'MagazineController@downloadAllContribution');

//contribution
Route::resource('/contribution', 'ContributionController');
Route::post('/update_published_status', 'ContributionController@updatePublishedStatus');
Route::post('/contribution/{id}/comment', 'ContributionController@comment');

//notification
Route::get('/notification/{id}', 'NotificationController@clear');
Route::get('/message', 'NotificationController@index');
Route::post('/message', 'NotificationController@sendMessage');
Route::get('/message/seen/{id}', 'NotificationController@seenMessage');

//report
Route::get('/report/statistics',  'ContributionController@showStatisticsReport');
Route::get('/report/exception',  'ContributionController@showExceptionReport');






