'use strict';

describe('LAMA Unit Test: lama module', function () {
    
    describe('HeaderController', function () {
        
        beforeEach(function() {
            module('lama');
        });
        
        var menus = [
        {
            'permission': null,
            'title': 'Home',
            'link': 'home'
        }];
    
        beforeEach(module(function($provide) {
              $provide.decorator('Menus', function($delegate, $q) {
                  // overwrite the query method
                  $delegate.query = function() {
                      return $q.when(menus);
                  };    
                  return $delegate; 
              });
        }));
        
        var $rootScope, 
            Menus;
            
        beforeEach(inject(function(_$rootScope_, _Menus_) {
             $rootScope = _$rootScope_;
             Menus = _Menus_;
        }));
        
        it('should expose some menu scope', function() {
            Menus.query();
            expect($rootScope.menus).toBeDefined();
            expect($rootScope.menus.length).toEqual(0);
        });
        
    });
        
});
