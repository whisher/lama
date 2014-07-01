<?php

/* Check if a user is just logged */
Route::filter('issessionedin', function()
{
    if (Sentry::check()){
        return Response::make('Forbidden', 403);
    }
});

/* Check if a user is logged */
Route::filter('isloggedin', function()
{
    if (!Sentry::check()){
        return Response::make('Unauthorized', 401);
    }
});

/* Check if a user is the same of the current id */
Route::filter('hasAccessAndIsOwner', function($route, $request, $value)
{
    $check = Sentry::check();
    if (!$check){
        return Response::make('Unauthorized', 401);
    }
    if($check){
        $user = Sentry::getUser();
        if (!$user->hasAccess($value)) {
            return Response::make('Unauthorized', 401); 
        }
        $id = $route->getParameter('id');
        if($id !== $user->id){
           return Response::make('Unauthorized', 401); 
        }
    }
});

/* Check if a user has access */
Route::filter('hasAccess', function($route, $request, $permission)
{
    $check = Sentry::check();
    if (!$check){
        return Response::make('Unauthorized', 401);
    }
    if($check){
        $user = Sentry::getUser();
        if (!$user->hasAccess($permission)) {
            return Response::make('Unauthorized', 403); 
        }
    }
});

/* Check if a user session has access */
Route::filter('hasAccessSession', function($route)
{
    $check = Sentry::check();
    if (!$check){
        return Response::make('Unauthorized', 401);
    }
    if($check){
        $user = Sentry::getUser();
        $permission = $route->getParameter('permission');
        if (!$user->hasAccess($permission)) {
            return Response::make('Unauthorized', 403); 
        }
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


