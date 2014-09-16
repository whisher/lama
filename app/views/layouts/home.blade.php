<!DOCTYPE html>
<html xmlns:ng="http://angularjs.org" id="ng-app" lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="title" content="lama">
        <meta name="description" content="LAMA is a boilerplate that provides a nice starting point for Laravel and AngularJS based applications">
        <meta name="author" content="whisher">
        <meta name="keywords" content="">
        <meta name="description" content="">
        <link rel="shortcut icon" href="<% asset('favicon.ico');  %>">
        <title>Lama</title>
        <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css" rel="stylesheet">
        @if (isset($assets))
            @foreach ($assets['vendor']['css'] as $file)
                <link type="text/css" rel="stylesheet" href="<% asset($file);  %>">
            @endforeach
            @foreach ($assets['scripts']['css'] as $file)
                <link type="text/css" rel="stylesheet" href="<% asset($file);  %>">
            @endforeach
        @endif
        <!-- HTML5 shim for IE8 support of HTML5 elements -->
        <!--[if lt IE 9]>
          <script src="<% asset('bower_components/html5shiv/dist/html5shiv.min.js');  %>"></script>
        <![endif]-->
    </head>
    <body>
        <div class="navbar navbar-default" role="navigation" data-ng-include="'<% asset('system/views/header.html'); %>'"></div>
        <div class="container" role="content">
            @yield('content')
        </div>
        <div class="footer" role="footer">
            <div class="container">
                <p>Lama - &#169; 2014 All Rights Reserved</p>
            </div>
        </div>
        @if (isset($assets))
            @foreach ($assets['vendor']['js'] as $file)
                <script src="<% asset($file);  %>"></script>
            @endforeach
            @foreach ($assets['scripts']['js'] as $file)
                <script src="<% asset($file);  %>"></script>
            @endforeach
        @endif
        @if(Config::get('lama.isdev'))
            <script src="//localhost:35729/livereload.js"></script>
        @endif
    </body>
</html>