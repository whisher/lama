<?php
/* Check if a user is just logged */
Route::filter('loggedOut', function()
{
    if (Sentry::check()){
        return Response::make('Forbidden', 403);
    }
});

Route::filter('auth', function()
{
    if (!Sentry::check()){
        return Response::make('Unauthorized', 401);
    }
});

Route::filter('xhr', function()
{
    if(!Request::ajax()){
        return Response::make('Not Found', 404);
    }
});

Route::filter('xsrf', function()
{
    if((!isset($_COOKIE['XSRF-TOKEN']) && is_null(Request::header('X-XSRF-TOKEN'))) || ($_COOKIE['XSRF-TOKEN'] !== Request::header('X-XSRF-TOKEN'))){
        return Response::make('Not Found', 404);
    }
});


