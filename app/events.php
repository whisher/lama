<?php

// User Login event
Event::listen('session.login', function($data)
{ 
    Session::put('user', $data);
});

// User logout event
Event::listen('session.logout', function()
{
    Session::flush();
});

// User register event
Event::listen('user.register', function($data)
{
    Session::put('user', $data);
});



Event::subscribe('Users\Mailer\UserMailer');
