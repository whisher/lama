<!DOCTYPE html>
<html xmlns:ng="http://angularjs.org" id="ng-app" lang="<% Config::get('app.locale'); %>">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="LAMB is a boilerplate that provides a nice starting point for Laravel and AngularJS based applications">
        <meta name="author" content="whisher">
        <link rel="shortcut icon" href="<% asset('favicon.ico');  %>">
        <title><% Config::get('config.name'); %></title>
        <link type="text/css" rel="stylesheet" href="<% asset('system/lib/bootstrap/dist/css/bootstrap.min.css');  %>">
        <link type="text/css" rel="stylesheet" href="<% asset('system/assets/css/main.css'); %>">
        <!-- HTML5 shim for IE8 support of HTML5 elements -->
        <!--[if lt IE 9]>
          <script src="<% asset('system/lib/html5shiv/dist/html5shiv.min.js');  %>"></script>
        <![endif]-->
    </head>
    <body>
        <div class="navbar navbar-default" role="navigation" data-ng-include="'<% asset('system/views/header.html'); %>'"></div>
        <div class="container content" role="content">
            @yield('content')
        </div>
        <div class="footer" role="footer">
            <div class="container">
                <p><% Config::get('config.name'); %> - &#169; 2014 All Rights Reserved</p>
            </div>
        </div>
        <script src="<% asset('system/lib/lodash/dist/lodash.min.js');  %>"></script>
        <script src="<% asset('system/lib/jquery/dist/jquery.min.js');  %>"></script>
        <script src="<% asset('system/lib/bootstrap/dist/js/bootstrap.min.js'); %>"></script>
        <script src="<% asset('system/lib/angular/angular.min.js'); %>"></script>
        <script src="<% asset('system/lib/angular-ui-router/release/angular-ui-router.min.js'); %>"></script>
        <script src="<% asset('system/lib/restangular/dist/restangular.min.js'); %>"></script>
        <script src="<% asset('system/lib/restangular/dist/restangular.min.js'); %>"></script>
        <script src="<% asset('init.js'); %>"></script>
        <script src="<% asset('system/system.js'); %>"></script>
        <!-- <script src="<% asset('system/routes/system.js'); %>"></script> -->
    </body>
</html>