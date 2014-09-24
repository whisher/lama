describe('homepage', function() {
    beforeEach(function() {
        browser.get('/');
    });
    it('should load home', function() {
       var jumbotron = element.all(by.css('.jumbotron h1'));
       expect(jumbotron.count()).toBe(1);
    });
    it('should load the menu', function() {
       var nav = element.all(by.css('ul.navbar-left li a'));
       expect(nav.count()).toBe(1);
    });
});