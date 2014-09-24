// An example configuration file.
exports.config = {
    // Do not start a Selenium Standalone sever - only run this using chrome.
    chromeOnly: true,
    chromeDriver: './node_modules/protractor/selenium/chromedriver',
    // seleniumAddress: 'http://0.0.0.0:4444/wd/hub',
    // Capabilities to be passed to the webdriver instance.
    capabilities: {
        'browserName': 'chrome'
    },

   baseUrl: 'http://localhost:8000',
   
   allScriptsTimeout: 30000,
   
    // Spec patterns are relative to the current working directly when
    // protractor is called.
    specs: [
    '/home/whisher/public_html/lama/public/system/tests/e2e/*.js',
    '/home/whisher/public_html/lama/public/users/tests/e2e/*.js'],

    // Options to be passed to Jasmine-node.
    jasmineNodeOpts: {
        showColors: true,
        defaultTimeoutInterval: 30000
    }
};
