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
    Route::post('signin', array('as' => 'session.store', 'uses' => 'App\Controllers\SessionController@store'))->before('issessionedin');
    Route::get('issessionedin', array('before' => 'issessionedin', function(){}));
    Route::get('isloggedin', array('before' => 'isloggedin', function(){}));
    Route::get('hasaccess/{permission}', array('before' => 'hasAccessSession', function(){}));
    /* FIX base and edit */
    /* User */
    Route::post('user', array('as' => 'base.user.register', 'uses' => 'App\Controllers\UserController@register'))->before('issessionedin');
    Route::post('user/create', array('as' => 'base.user.create', 'uses' => 'App\Controllers\UserController@create'))->before('hasAccess:users');
    Route::post('user/forgot', array('as' => 'base.user.forgot', 'uses' => 'App\Controllers\UserController@forgot'));
    Route::get('user', array('as' => 'base.user.index', 'uses' => 'App\Controllers\UserController@index'))->before('hasAccess:users');
    Route::get('user/{id}', array('as' => 'base.user.show', 'uses' => 'App\Controllers\UserController@show'))->where('id', '[0-9]+')->before('hasAccessAndIsOwner:users.show');
    Route::put('user/{id}', array('as' => 'base.user.edit', 'uses' => 'App\Controllers\UserController@edit'))->where('id', '[0-9]+')->before('hasAccess:users');
    Route::put('user/{id}/account', array('as' => 'base.user.account', 'uses' => 'App\Controllers\UserController@account'))->where('id', '[0-9]+')->before('hasAccessAndIsOwner:users.account');
    Route::put('user/{id}/password', array('as' => 'base.user.password', 'uses' => 'App\Controllers\UserController@password'))->where('id', '[0-9]+')->before('hasAccessAndIsOwner:users.password');
    Route::put('user/{id}/edit', array('as' => 'base.user.edit', 'uses' => 'App\Controllers\UserController@edit'))->where('id', '[0-9]+')->before('hasAccess:users');
    Route::put('user/{id}/suspend', array('as' => 'base.user.suspend', 'uses' => 'App\Controllers\UserController@suspend'))->where('id', '[0-9]+')->before('hasAccess:users');
    Route::put('user/{id}/unsuspend', array('as' => 'base.user.unsuspend', 'uses' => 'App\Controllers\UserController@unsuspend'))->where('id', '[0-9]+')->before('hasAccess:users');
    Route::put('user/{id}/ban', array('as' => 'base.user.ban', 'uses' => 'App\Controllers\UserController@ban'))->where('id', '[0-9]+')->before('hasAccess:users');
    Route::delete('user/{id}', array('as' => 'base.user.destroy', 'uses' => 'App\Controllers\UserController@destroy'))->where('id', '[0-9]+')->before('hasAccess:users');
 
    /* group */
    Route::get('group', array('as' => 'base.group.index', 'uses' => 'App\Controllers\GroupController@index'));
    
    /* menu */
    Route::get('user/menus', array('as' => 'base.menu', 'uses' => 'App\Controllers\MenuController@index'));
    
 });

Route::get('user/{id}/activate/{code}', array('as' => 'base.user.activate', 'uses' => 'App\Controllers\UserController@activate'))->where('id', '[0-9]+');
Route::get('user/{id}/reset/{code}', array('as' => 'base.user.reset', 'uses' => 'App\Controllers\UserController@reset'))->where('id', '[0-9]+');

Route::get('user/newpassword', array('as' => 'base.user.newpassword', function()
{
	return View::make('users.newpassword');
}));



/* Session */
Route::get('logout', array('as' => 'session.destroy', 'uses' => 'App\Controllers\SessionController@destroy'));








