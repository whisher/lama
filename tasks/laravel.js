/*
 * grunt-laravel
 * https://github.com/whisher/grunt-laravel
 *
 * A simple fork of grunt-php to serve laravel by php artisan serve command
 * 
 * Copyright (c) 2014 Fabio Bedini aka whisher
 * Licensed under the MIT license.
 */

'use strict';
var spawn = require('child_process').spawn,
    http = require('http'),
    opn = require('opn'),
    binVersionCheck = require('bin-version-check');

module.exports = function (grunt) {
    
    var checkServerTries = 0;

    function checkServer(hostname, port, cb) {
        setTimeout(function () {
            http.request({
                method: 'HEAD',
                hostname: hostname,
                port: port
            }, function (res) {
                if ([200, 404, 301].indexOf(res.statusCode) !== -1) {
                    return cb();
                }

                checkServer(hostname, port, cb);
            }).on('error', function (err) {
                // back off after 1s
                if (++checkServerTries > 20) {
                    return cb();
                }

                checkServer(hostname, port, cb);
            }).end();
        }, 50);
    }

    grunt.registerMultiTask('laravel', 'Serving Laravel', function () {
        var cb = this.async();
        var options = this.options({
            port: 8000,
            hostname: '127.0.0.1',
            base: '.',
            keepalive: true,
            open: true,
            bin: 'php'
        });
        var host = options.hostname + ':' + options.port;
        var args = ['artisan', 'serve'];

        if (options.router) {
            args.push(options.router);
        }

        binVersionCheck(options.bin, '>=5.4', function (err) {
            if (err) {
                grunt.warn(err);
                return cb();
            }

            var cp = spawn(options.bin, args, {
                cwd: options.base,
                stdio: 'inherit'
            });

            // quit PHP when grunt is done
            process.on('exit', function () {
                cp.kill();
            });

            // check when the server is ready. tried doing it by listening
            // to the child process `data` event, but it's not triggered...
            checkServer(options.hostname, options.port, function () {
                if (!options.keepalive) {
                    cb();
                }

                if (options.open) {
                    opn('http://' + host);
                }
            });
        });
    });
};
