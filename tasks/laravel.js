/*
 * grunt-laravel
 * https://github.com/whisher/grunt-laravel
 *
 * Copyright (c) 2014 Fabio Bedini aka whisher
 * Licensed under the MIT license.
 */

'use strict';
var http = require('http');
var open = require('opn');  
module.exports = function(grunt) {
    var checkServerTries = 0;

    function checkServer(hostname, cb) {
       setTimeout(function () {
            http.request({
                method: 'HEAD',
                hostname: hostname
            }, function (res) {
                if ([200, 404, 301].indexOf(res.statusCode) !== -1) {
                    return cb();
                }

                checkServer(hostname, cb);
            }).on('error', function (err) {
                // back off after 1s
                if (++checkServerTries > 20) {
                    return cb();
                }

                checkServer(hostname, cb);
            }).end();
        }, 50);
    }
    grunt.registerMultiTask('laravel', 'A simple wrapper of artisan cmd', function() {
        
       var options = this.options({
            hostname: '127.0.0.1',
	    keepalive: false,
            open: false
			
        });
        
        var cb = this.async();
        
        checkServer(options.hostname, function () {
            if (!options.keepalive) {
                cb();
            }
            if (options.open) {
                open('http://' + options.hostname);
            }
        });
        
    });

};
