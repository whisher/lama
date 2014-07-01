<?php
/* There is no need to change 
 * the delimeters from {{}} to <%%>
 * just to separate the realms of laravel from that of angular
 */
 
Blade::setContentTags('<%', '%>');          // for variables and all things Blade
Blade::setEscapedContentTags('<%%', '%%>'); // for escaped data

/* Index */
Route::get('/', array('as' => 'home', 'uses' => 'App\Controllers\HomeController@index'))->before('token');

/* User */
Route::post('user', array('as' => 'base.user.store', 'uses' => 'App\Controllers\UserController@store'))->before('issessionedin|xhr|xsrf'); 
Route::get('user', array('as' => 'base.user.index', 'uses' => 'App\Controllers\UserController@index'))->before('hasAccess:users');
Route::get('user/{id}', array('as' => 'base.user.show', 'uses' => 'App\Controllers\UserController@show'))->where('id', '[0-9]+')->before('hasAccessAndIsOwner:users.show');
Route::put('user/{id}', array('as' => 'base.user.update', 'uses' => 'App\Controllers\UserController@update'))->where('id', '[0-9]+')->before('xhr|xsrf|hasAccess:users');
Route::put('user/{id}/account', array('as' => 'base.user.account', 'uses' => 'App\Controllers\UserController@account'))->where('id', '[0-9]+')->before('xhr|xsrf|hasAccessAndIsOwner:users.account');
Route::put('user/{id}/password', array('as' => 'base.user.password', 'uses' => 'App\Controllers\UserController@password'))->where('id', '[0-9]+')->before('xhr|xsrf|hasAccessAndIsOwner:users.password');
Route::delete('user/{id}', array('as' => 'base.user.destroy', 'uses' => 'App\Controllers\UserController@destroy'))->where('id', '[0-9]+')->before('hasAccess:users');

/* Session */
Route::get('logout', array('as' => 'session.destroy', 'uses' => 'App\Controllers\SessionController@destroy'));
Route::post('signin', array('as' => 'session.store', 'uses' => 'App\Controllers\SessionController@store'));
Route::get('issessionedin', array('before' => 'issessionedin', function(){}));
Route::get('isloggedin', array('before' => 'isloggedin', function(){}));
Route::get('hasaccess/{permission}', array('before' => 'hasAccessSession', function(){}));


