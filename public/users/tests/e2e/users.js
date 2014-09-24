describe('users :', function() {
    
    describe('admin', function() {
        beforeEach(function() {
            browser.get('/logout');
            browser.get('/#!/user/signin');
            var btn = element(by.css('button.btn-primary'));
            element(by.model('user.email')).sendKeys('admin@admin.com');
            element(by.model('user.password')).sendKeys('sentryadmin');
            btn.click();
        });
        it('should be logged in as admin', function() {
            expect(browser.getCurrentUrl()).toMatch(/\/#!\/$/);
            var nav = element.all(by.css('ul.navbar-left li a'));
            expect(nav.count()).toBe(2);
        });
        
        describe('admin manage listed users', function() {
            
            beforeEach(function() {
                var linkUsers = element(by.css('ul.navbar-left li:nth-child(2) a'));
                expect(browser.isElementPresent(linkUsers)).toBe(true);
                linkUsers.click();
            });
         
            it('should show users', function() {
                expect(browser.getCurrentUrl()).toMatch(/\/#!\/users/);
            });
         
            it('should show listed users', function() {
                expect(element.all(by.repeater('user in paginator.items')).count()).toEqual(2);
            });
            
            it('should manage ban', function() {
                var repeater = element(by.repeater('user in paginator.items').row(1));
                var banBtn = repeater.element(by.css('a.btn-warning:nth-child(1)'));
                expect(browser.isElementPresent(banBtn)).toBe(true);
                expect(banBtn.getText()).toEqual('Ban'); 
                banBtn.click();
                expect(banBtn.getText()).toEqual('Unban');
                banBtn.click();
                expect(banBtn.getText()).toEqual('Ban');
            });
            
            it('should manage suspend', function() {
                var repeater = element(by.repeater('user in paginator.items').row(1));
                var suspendBtn = repeater.element(by.css('a.btn-warning:nth-child(2)'));
                expect(browser.isElementPresent(suspendBtn)).toBe(true);
                expect(suspendBtn.getText()).toEqual('Suspend'); 
                suspendBtn.click();
                element(by.model('user.minutes')).sendKeys(1);
                var btn = element(by.css('button.btn-primary'));
                btn.click();
                expect(browser.getCurrentUrl()).toMatch(/\/#!\/users/);
                expect(suspendBtn.getText()).toEqual('Unsuspend'); 
                
            });
            
        });
    });
    
});
