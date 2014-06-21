<?php
/* There is no need to change 
 * the delimeters from {{}} to <%%>
 * just to separate realm from Laravel to
 * angularjs 
 */
Blade::setContentTags('<%', '%>');          // for variables and all things Blade
Blade::setEscapedContentTags('<%%', '%%>'); // for escaped data

/* Index */
Route::get('/', array('as' => 'home', 'uses' => 'App\Controllers\HomeController@index'))->before('token');
/* User */
Route::post('user', array('as' => 'base.user.store', 'uses' => 'App\Controllers\UserController@store'))->before('loggedIn|xhr|xsrf'); 
/* Auth */
Route::get('logout', array('as' => 'session.destroy', 'uses' => 'App\Controllers\SessionController@destroy'));
Route::get('/loggedout', array('before' => 'loggedOut', function(){}));

