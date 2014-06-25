<?php

// User Login event
Event::listen('session.login', function($user)
{
    Session::put('user', $user);
});

// User logout event
Event::listen('session.logout', function()
{
    Session::flush();
});

// User register event
Event::listen('user.register', function($user)
{
    Session::put('user', $user);
});

