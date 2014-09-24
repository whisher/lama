// Karma configuration
// Generated on Wed Aug 13 2014 21:55:53 GMT+0200 (CEST)

module.exports = function(config) {
    var _ = require('lodash'),
        basePath = '.',
        assets = require(basePath + '/app/config/assets.json');
    var vendor =  _.flatten(_.values(assets.vendor.js));
    var scripts =  _.flatten(_.values(assets.scripts.js));
    // take a look at http://stackoverflow.com/a/25412250/356380
    var init = scripts.shift();
    var spec = [
        'public/bower_components/angular-mocks/angular-mocks.js',
        'state.mock.js',
        'public/system/tests/unit/**/*.js',
        'public/users/tests/unit/**/*.js'
    ];
    var files = vendor.concat(scripts,spec);
      
    config.set({

        // base path, that will be used to resolve files and exclude
        basePath: basePath,

        // frameworks to use
        frameworks: ['jasmine'],

        // list of files / patterns to load in the browser
        files: files,

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
