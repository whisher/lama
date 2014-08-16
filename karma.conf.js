// Karma configuration
// Generated on Wed Aug 13 2014 21:55:53 GMT+0200 (CEST)

module.exports = function(config) {
  config.set({

    // base path, that will be used to resolve files and exclude
    basePath: '',
    

    // frameworks to use
    frameworks: ['jasmine'],


    // list of files / patterns to load in the browser
    files: [
        'public/bower_components/lodash/dist/lodash.min.js',
        'public/bower_components/jquery/dist/jquery.min.js',
        'public/bower_components/bootstrap/dist/js/bootstrap.min.js',
        'public/bower_components/angular/angular.min.js',
        'public/bower_components/angular-ui-router/release/angular-ui-router.min.js',
        'public/bower_components/restangular/dist/restangular.min.js',
        'public/bower_components/angular-mocks/angular-mocks.js',
        'public/init.js',
        'public/system/system.js',
        'public/system/controllers/*.js',
        'public/system/directives/*.js',
        'public/system/filters/*.js',
        'public/system/routes/*.js',
        'public/system/services/*.js',
        'public/users/users.js',
        'public/users/controllers/*.js',
        'public/users/directives/*.js',
        'public/users/routes/*.js',
        'public/users/services/*.js',
        'ui-router-mock.js',
        'public/system/tests/unit/**/*.js',
        'public/users/tests/unit/**/*.js'
    ],


    // list of files to exclude
    exclude: [],


    // test results reporter to use
    // possible values: 'dots', 'progress', 'junit', 'growl', 'coverage'
    reporters: ['progress'],


    // web server port
    port: 9876,


    // enable / disable colors in the output (reporters and logs)
    colors: true,


    // level of logging
    // possible values: config.LOG_DISABLE || config.LOG_ERROR || config.LOG_WARN || config.LOG_INFO || config.LOG_DEBUG
    logLevel: config.LOG_INFO,


    // enable / disable watching file and executing tests whenever any file changes
    autoWatch: true,


    // Start these browsers, currently available:
    // - Chrome
    // - ChromeCanary
    // - Firefox
    // - Opera
    // - Safari (only Mac)
    // - PhantomJS
    // - IE (only Windows)
    browsers: ['PhantomJS'],


    // If browser does not capture in given timeout [ms], kill it
    captureTimeout: 60000,


    // Continuous Integration mode
    // if true, it capture browsers, run tests and exit
    singleRun: true
  });
};
