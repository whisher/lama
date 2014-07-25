'use strict';



var paths = {
    js: ['Gruntfile.js', 'tasks/laravel.js', 'public/**/*.js', '!public/build/**', '!public/bower_components/**'],
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
        clean: ['public/build'],
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
        laravel:{
           dist:{}
        },
        concurrent: {
            tasks: ['laravel', 'watch'],
            options: {
                logConcurrentOutput: true
            }
        },
        concat:{
            productionCssVendor:{
                files: '<%= assets.vendor.css %>',
                nonull: true
            },
            productionJsVendor:{
                files: '<%= assets.vendor.js %>',
                nonull: true
            }
        },
        cssmin: {
            productionScripts: {
                files: '<%= assets.scripts.css %>'
            }
        },
        uglify: {
            options: {
                mangle: false
            },
            productionScripts: {
                files: '<%= assets.scripts.js %>'
            }
        }
    });
    
    grunt.loadTasks('tasks');  
    require('load-grunt-tasks')(grunt);
    
    grunt.registerTask('default', ['jshint','concurrent']);
    grunt.registerTask('prod', ['clean', 'concat', 'cssmin','uglify']);
 
};
