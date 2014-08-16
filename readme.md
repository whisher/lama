# LAMA Stack
LAMA is a boilerplate that provides a nice starting point for Laravel/Sentry and AngularJS based applications.

## Credits
* [L4withSentry](https://github.com/rydurham/L4withSentry)
* [MEAN fullstack javascript framework](http://mean.io)

## Features
* Handy assetsmanager don't need to add your assets (css,js) in the main template  
  and in the grunt/gulp file
* JSON Vulnerability Protection
* Cross Site Request Forgery (XSRF) Protection

## Tools Prerequisites
* Composer - Dependency Manager for PHP, installing [Composer](https://getcomposer.org/)
* Node.js platform, installing [Node.js](http://www.nodejs.org/download/)
* Grunt - The JavaScript Task Runner, installing [Grunt](http://gruntjs.com/)
* Bower - Web package manager, installing [Bower](http://bower.io/)

## Quick Install
    git clone https://github.com/whisher/lama.git
    cd lama
    php composer.phar install
    chmod -R 0777 app/storage
    configuring your database app/config/database.php
    php artisan migrate --package=cartalyst/sentry
    php artisan migrate
    php artisan db:seed
    php artisan key:generate
    bower install
    npm install

## Quick Install testing
    set the project url in tests app/tests/acceptance.suite.yml
    provide your database test credentials in codeception.yml
    php artisan migrate --package=cartalyst/sentry --env="testing"
    php artisan migrate --seed --env="testing"

## TODO
   bug reset password too much info
   rename User