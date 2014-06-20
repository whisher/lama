<?php

/*
|--------------------------------------------------------------------------
| Application & Route Filters
|--------------------------------------------------------------------------
|
| Below you will find the "before" and "after" events for the application
| which may be used to do any work before or after a request into your
| application. Here you may also register your custom route filters.
|
*/

App::before(function($request)
{
	//
});


App::after(function($request, $response)
{
	//
});

/*
|--------------------------------------------------------------------------
| Authentication Filters
|--------------------------------------------------------------------------
|
| The following filters are used to verify that the user of the current
| session is logged into this application. The "basic" filter easily
| integrates HTTP Basic authentication for quick, simple checking.
|
*/

Route::filter('auth', function()
{
	if (!Sentry::check()){
            return Redirect::route('session.create');
        }
    
});

Route::filter('loggedIn', function()
{
	if (Sentry::check()){
            // or exit ?
            throw new RuntimeException();
        }
});


Route::filter('xsrf', function()
{
    if((!isset($_COOKIE['XSRF-TOKEN']) && is_null(Request::header('X-XSRF-TOKEN'))) || ($_COOKIE['XSRF-TOKEN'] !== Request::header('X-XSRF-TOKEN'))){
        exit;
    }
});
/*
|--------------------------------------------------------------------------
| CSRF Protection Filter
|--------------------------------------------------------------------------
|
| The CSRF filter is responsible for protecting your application against
| cross-site request forgery attacks. If this special token in a user
| session does not match the one given in this request, we'll bail.
|
*/
/*
Route::filter('csrf', function()
{
	if (Session::token() !== Input::get('_token',''))
	{
		throw new Illuminate\Session\TokenMismatchException;
	}
});

Route::filter('inGroup', function($route, $request, $value)
{
	//dd($route, $request, $value);
});
 * */
 

