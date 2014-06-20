<?php
Blade::setContentTags('<%', '%>'); 		// for variables and all things Blade
Blade::setEscapedContentTags('<%%', '%%>'); // for escaped data

/* Index */
Route::get('/', array('as' => 'home', 'uses' => 'App\Controllers\HomeController@index'))->before('token');
/* User register */
Route::post('user', array('as' => 'base.user.store', 'uses' => 'App\Controllers\UserController@store'))->before('loggedIn|xsrf');  

/*
Route::group(array('before' => 'loggedIn'), function()
{
    Route::get('signin', array('as' => 'session.create', 'uses' => 'App\Controllers\Base\SessionController@create'));  
});
Route::group(array('before' => 'csrf'), function()
{
    Route::post('signin', array('as' => 'session.store',  'uses' => 'App\Controllers\Base\SessionController@store'));  
});
Route::group(array('before' => 'auth'), function()
{
    Route::get('logout', array('as' => 'session.destroy', 'uses' => 'App\Controllers\Base\SessionController@destroy'));
});



Route::group(array('before' => 'inGroup:Admins'), function()
{
    Route::get('user/register', array('as' => 'base.user.create', 'uses' => 'App\Controllers\Base\UserController@create'));  
    Route::post('user', array('as' => 'base.user.store', 'uses' => 'App\Controllers\Base\UserController@store'));  
    Route::get('user', array('as' => 'base.user.index', 'uses' => 'App\Controllers\Base\UserController@index'));
    Route::get('user/{id}', array('as' => 'base.user.show', 'uses' => 'App\Controllers\Base\UserController@show'))->where('id', '[0-9]+');
    Route::put('user/{id}', array('as' => 'base.user.edit', 'uses' => 'App\Controllers\Base\UserController@edit'))->where('id', '[0-9]+');
    Route::delete('user/{id}', array('as' => 'base.user.destroy', 'uses' => 'App\Controllers\Base\UserController@destroy'))->where('id', '[0-9]+');
    
});
*/
