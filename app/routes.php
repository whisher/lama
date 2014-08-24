<?php
/* There is no need to change 
 * the delimeters from {{}} to <%%>
 * just to separate the realms of laravel from that of angular
 */
 
Blade::setContentTags('<%', '%>');          // for variables and all things Blade
Blade::setEscapedContentTags('<%%', '%%>'); // for escaped data

/* Index */
Route::get('/', array('as' => 'home', 'uses' => 'App\Controllers\HomeController@index'));


Route::group(array('prefix' => 'api/v1', 'before' => 'xhr|xsrf'), function() {
    
    /* Session */
    Route::post('signin', array('as' => 'sessions.store', 'uses' => 'App\Controllers\SessionsController@store'))->before('issessionedin');
    Route::get('issessionedin', array('before' => 'issessionedin', function(){}));
    Route::get('isloggedin', array('before' => 'isloggedin', function(){}));
    Route::get('hasaccess/{permission}', array('before' => 'hasAccessSession', function(){}));
    /* FIX base and edit */
    /* User */
    Route::post('users', array('as' => 'users.register', 'uses' => 'App\Controllers\UsersController@register'))->before('issessionedin');
    Route::post('users/create', array('as' => 'users.create', 'uses' => 'App\Controllers\UsersController@create'))->before('hasAccess:users');
    Route::post('users/forgot', array('as' => 'users.forgot', 'uses' => 'App\Controllers\UsersController@forgot'));
    Route::get('users', array('as' => 'users.index', 'uses' => 'App\Controllers\UsersController@index'))->before('hasAccess:users');
    Route::get('users/{id}', array('as' => 'users.show', 'uses' => 'App\Controllers\UsersController@show'))->where('id', '[0-9]+')->before('hasAccessAndIsOwner:users.show');
    Route::put('users/{id}', array('as' => 'users.edit', 'uses' => 'App\Controllers\UsersController@edit'))->where('id', '[0-9]+')->before('hasAccess:users');
    Route::put('users/{id}/account', array('as' => 'users.account', 'uses' => 'App\Controllers\UsersController@account'))->where('id', '[0-9]+')->before('hasAccessAndIsOwner:users.account');
    Route::put('users/{id}/password', array('as' => 'users.password', 'uses' => 'App\Controllers\UsersController@password'))->where('id', '[0-9]+')->before('hasAccessAndIsOwner:users.password');
    Route::put('users/{id}/edit', array('as' => 'users.edit', 'uses' => 'App\Controllers\UsersController@edit'))->where('id', '[0-9]+')->before('hasAccess:users');
    Route::put('users/{id}/suspend', array('as' => 'users.suspend', 'uses' => 'App\Controllers\UsersController@suspend'))->where('id', '[0-9]+')->before('hasAccess:users');
    Route::put('users/{id}/unsuspend', array('as' => 'users.unsuspend', 'uses' => 'App\Controllers\UsersController@unsuspend'))->where('id', '[0-9]+')->before('hasAccess:users');
    Route::put('users/{id}/ban', array('as' => 'users.ban', 'uses' => 'App\Controllers\UsersController@ban'))->where('id', '[0-9]+')->before('hasAccess:users');
    Route::delete('users/{id}', array('as' => 'users.destroy', 'uses' => 'App\Controllers\UsersController@destroy'))->where('id', '[0-9]+')->before('hasAccess:users');
 
    /* group */
    Route::get('groups', array('as' => 'groups.index', 'uses' => 'App\Controllers\GroupsController@index'));
    
    /* menu */
    Route::get('users/menus', array('as' => 'menus', 'uses' => 'App\Controllers\MenusController@index'));
    
 });

Route::get('users/{id}/activate/{code}', array('as' => 'users.activate', 'uses' => 'App\Controllers\UsersController@activate'))->where('id', '[0-9]+');
Route::get('users/{id}/reset/{code}', array('as' => 'users.reset', 'uses' => 'App\Controllers\UsersController@reset'))->where('id', '[0-9]+');

Route::get('users/newpassword', array('as' => 'users.newpassword', function()
{
	return View::make('users.newpassword');
}));



/* Session */
Route::get('logout', array('as' => 'sessions.destroy', 'uses' => 'App\Controllers\SessionsController@destroy'));








