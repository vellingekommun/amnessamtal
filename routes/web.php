<?php

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

Auth::routes();

Route::get('/', ['as' => 'index', 'uses' => 'IndexController@index']);
Route::post('/create', ['as' => 'create', 'uses' => 'IndexController@create']);
Route::get('/verify', ['as' => 'verify', 'uses' => 'IndexController@getVerify']);
Route::post('/verify', ['as' => 'post.verify', 'uses' => 'IndexController@postVerify']);

Route::group(['prefix' => 'book'], function () {
    Route::get('/', ['as' => 'book', 'uses' => 'BookController@index']);
    Route::post('/save', ['as' => 'book.save', 'uses' => 'BookController@save']);
    Route::get('/confirmation', ['as' => 'book.confirmation', 'uses' => 'BookController@confirmation']);
});

Route::get('/edit/{token}', ['as' => 'edit', 'uses' => 'BookController@edit']);
Route::get('/view/{token}', ['as' => 'view', 'uses' => 'BookController@view']);
Route::get('/delete/{id}/{token}', ['as' => 'delete', 'uses' => 'BookController@delete']);
Route::post('/delete/save/{id}/{token}', ['as' => 'confirm.delete', 'uses' => 'BookController@confirmDelete']);

Route::group(['prefix' => 'admin', 'middleware' => 'auth'], function () {
    
    
    Route::resource('users', 'Admin\UserController')->except(['show']);

    Route::get('/', ['as' => 'events.index', 'uses' => 'Admin\EventController@index']);
    Route::group(['prefix' => 'events'], function () {
        Route::post('/store', ['as' => 'events.store', 'uses' => 'Admin\EventController@store']);
        Route::get('/create', ['as' => 'events.create', 'uses' => 'Admin\EventController@create']);
        Route::get('/{event}/edit', ['as' => 'events.edit', 'uses' => 'Admin\EventController@edit']);
        Route::get('/{event}/close', ['as' => 'events.close', 'uses' => 'Admin\EventController@close']);
        Route::get('/{event}/import', ['as' => 'events.import', 'uses' => 'Admin\ImportController@index']);
        Route::post('/{event}/import', ['as' => 'events.import.store', 'uses' => 'Admin\ImportController@store']);
        Route::get('/{event}/export', ['as' => 'events.export', 'uses' => 'Admin\ExportController@slots']);
        Route::delete('/{event}', ['as' => 'events.destroy', 'uses' => 'Admin\EventController@destroy']);
        Route::put('/{event}', ['as' => 'events.update', 'uses' => 'Admin\EventController@update']);
        Route::get('/{event}', ['as' => 'events.show', 'uses' => 'Admin\EventController@show']);

        Route::post('/{event}/email/teachers', ['as' => 'admin.notification.event.teachers', 'uses' => 'Admin\NotificationController@sendNotificationAboutEventToTeachers']);
        Route::post('/{event}/email/visitors', ['as' => 'admin.notification.event.visitors','uses' => 'Admin\NotificationController@sendNotificationAboutEventToVisitors']);
        Route::post('/{event}/text/visitors', ['as' => 'admin.notification.text_message.event.teachers', 'uses' => 'Admin\NotificationController@sendTextMessageAboutEventToVisitors']);
    });

    Route::group(['prefix' => 'slot'], function () {
        Route::post('/', ['as' => 'admin.slot.store', 'uses' => 'Admin\SlotController@store']);
        Route::post('/delete', ['as' => 'admin.slot.delete', 'uses' => 'Admin\SlotController@delete']);
        Route::post('/block', ['as' => 'admin.slot.block', 'uses' => 'Admin\SlotController@block']);
        Route::get('/{slot}', ['as' => 'admin.slot.create', 'uses' => 'Admin\SlotController@create']);
    });

});

Route::group(['prefix' => 'api'], function () {
    Route::group(['prefix' => 'slot'], function () {
        Route::post('/reserve', ['as' => 'reserve', 'uses' => 'Api\SlotController@reserve']);
        Route::post('/release', ['as' => 'release', 'uses' => 'Api\SlotController@release']);
    });
});

