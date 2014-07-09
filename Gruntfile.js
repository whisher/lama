'use strict';

var paths = {
    js: ['Gruntfile.js', 'public/**/*.js', '!public/bower_components/**'],
    html: ['public/**/views/**'],
    css: ['public/**/css/*.css', '!public/bower_components/**']
};

module.exports = function(grunt) {
    
    require('time-grunt')(grunt);
    
   // Project Configuration
    grunt.initConfig({
        pkg: grunt.file.readJSON('package.json'),
        watch: {
            options: {
                livereload: true
            },
            page: {
                files: ['*.php', '*.html','*.js','*.css'],
                tasks: ['php']
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
        php: {
            dist: {
                options: {
                    port: 5000,
                    keepalive: true,
                    open: true
                }
            }
        }
    });

    //Load NPM tasks
    require('load-grunt-tasks')(grunt);
    grunt.registerTask('default', ['jshint']);
    
};
