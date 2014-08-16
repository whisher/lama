'use strict';
describe('homepage', function() {
    beforeEach(function() {
        browser.get('http://127.0.0.1:9000/');
    });

    it('should find title element', function() {
        browser.get('app/index.html');
        browser.debugger();
        element(by.binding('user.name'));
    });
    
});
