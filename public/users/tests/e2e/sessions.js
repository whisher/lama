describe('users :', function() {
    
    describe('register', function() {
        beforeEach(function() {
            browser.get('/#!/user/register');
        });
        it('btn should be disabled', function() {
            var btn = element(by.css('button.btn-primary'));
            expect(browser.isElementPresent(btn)).toBe(true);
            expect(btn.isEnabled()).toBe(false);
        });
        it('should be registered and logged in', function() {
            var random = ~~(Math.random() * 1000);
            var btn = element(by.css('button.btn-primary'));
            element(by.model('user.fullname')).sendKeys('test user');
            element(by.model('user.email')).sendKeys('test'+random+'@test.io');
            element(by.model('user.username')).sendKeys('testuser'+random);
            element(by.model('user.password')).sendKeys('testsecret');
            element(by.model('user.password_confirmation')).sendKeys('testsecret');
            expect(browser.isElementPresent(btn)).toBe(true);
            expect(btn.isEnabled()).toBe(true);
            btn.click();
            expect(browser.getCurrentUrl()).toMatch(/\/#!\/$/);
            var userMenu = element.all(by.css('ul.dropdown-menu li'));
            expect(userMenu.count()).toBe(3);
         });
    });
    
    describe('logout', function() {
        beforeEach(function() {
            browser.get('/logout');
        });
        it('should be home page', function() {
            expect(browser.getCurrentUrl()).toMatch(/\/#!\/$/);
        });
    });
    
    describe('signin', function() {
        beforeEach(function() {
            browser.get('/#!/user/signin');
        });
        it('btn should be disabled', function() {
            var btn = element(by.css('button.btn-primary'));
            expect(browser.isElementPresent(btn)).toBe(true);
            expect(btn.isEnabled()).toBe(false);
        });
        it('should be logged in', function() {
            var btn = element(by.css('button.btn-primary'));
            element(by.model('user.email')).sendKeys('user@user.com');
            element(by.model('user.password')).sendKeys('sentryuser');
            expect(browser.isElementPresent(btn)).toBe(true);
            expect(btn.isEnabled()).toBe(true);
            btn.click();
            expect(browser.getCurrentUrl()).toMatch(/\/#!\/$/);
            var userMenu = element.all(by.css('ul.dropdown-menu li'));
            expect(userMenu.count()).toBe(3);
         });
    });
});
