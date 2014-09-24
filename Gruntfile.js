'use strict';



var paths = {
    js: ['Gruntfile.js', 'tasks/laravel.js', 'public/**/*.js','!public/**/tests/**', '!public/build/**', '!public/bower_components/**'],
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
            dist:{},
            e2e: {
                options: {
                    open: false
                }
            }
        },
        concurrent: {
            all:{
                tasks: ['laravel:dist', 'watch'],
                options: {
                    logConcurrentOutput: true
                }
            },
            e2e:{
                tasks: ['laravel:e2e', 'protractor:all'],
                options: {
                    logConcurrentOutput: true
                }
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
        },
        karma: {
            all: {
                configFile: 'karma.conf.js'
            }
        },
        protractor: {
            options: {
                configFile: 'protractor.conf.js',
                keepAlive: true
            },
            all: {}
        }
    });
    
    grunt.loadTasks('tasks');  
    require('load-grunt-tasks')(grunt);
    
    grunt.registerTask('default', ['jshint','concurrent:all']);
    grunt.registerTask('prod', ['clean', 'concat', 'cssmin','uglify']);
    grunt.registerTask('unit', ['karma:all']);
    grunt.registerTask('e2e', ['concurrent:e2e']);

};
