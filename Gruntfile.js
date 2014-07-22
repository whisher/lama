'use strict';



var paths = {
    js: ['Gruntfile.js', 'public/**/*.js', '!public/bower_components/**'],
    html: ['public/**/views/**'],
    css: ['public/**/assets/css/*.css', '!public/bower_components/**'],
    php: ['app/**/*.php', '!vendor/**']
};

module.exports = function(grunt) {

    require('time-grunt')(grunt);

   // Project Configuration
    grunt.initConfig({
        pkg: grunt.file.readJSON('package.json'),
        assets: grunt.file.readJSON('app/config/assets.json'),
        watch: {
            css: {
                files: paths.css,
                tasks: ['csslint'],
                options: {
                    livereload: true
                }
            },
            html: {
                files: paths.html,
                options: {
                    livereload: true
                }
            },
            js: {
                files: paths.js,
                tasks: ['jshint'],
                options: {
                    livereload: true
                }
            },
            php: {
                files: paths.php,
                options: {
                    livereload: true
                }
            }
        },
        jshint: {
            all: {
                src: paths.js,
                options: {
                    jshintrc: true
                }
            }
        },
        csslint: {
            options: {
                csslintrc: '.csslintrc'
            },
            src: paths.css
        },
        php: {
            dist: {
                options: {
                    port: 8000,
                    keepalive: true,
                    open: true
                }
            }
        },
        laravel:{
           dist:{
                options: {
                    hostname: 'lama.io',
                    keepalive: true,
                    open: true
                }
            }
        },
        concurrent: {
            tasks: ['laravel', 'watch'],
            options: {
                logConcurrentOutput: true
            }
        }
    });
 grunt.loadTasks('tasks');  
    //Load NPM tasks
    require('load-grunt-tasks')(grunt);
    grunt.registerTask('default', ['jshint','concurrent']);

};
