'use strict';
beforeEach(function() {
                module('lama');
                module('lama.system');
                module('stateMock');
            });
var $httpBackend,$state;
beforeEach(inject(function( _$httpBackend_, _$state_) {
    $httpBackend = _$httpBackend_;
    $httpBackend.when('GET', '/api/v1/user/menus',[]).respond(200,{});
    $httpBackend.flush();
    $state = _$state_;
    $state.expectTransitionTo('home');
}));
afterEach(function() {
    $httpBackend.verifyNoOutstandingExpectation();
    $httpBackend.verifyNoOutstandingRequest();
});
/*(function() {*/
    describe('Unit test: system module', function () {
        describe('SystemController', function () {

            // load the controller's module
           beforeEach(function() {
                module('lama');
                module('stateMock');
            });

            var SystemController,
            $rootScope,
            $scope,
            $httpBackend,
            $state;

            
            // Initialize the controller and a mock scope
            beforeEach(inject(function ($controller, _$rootScope_, _$httpBackend_,_$state_) {
                $rootScope = _$rootScope_;
                $scope = _$rootScope_.$new();
                $httpBackend = _$httpBackend_;
                SystemController = $controller('SystemController', {
                    $scope: $scope
                });
                $state = _$state_;
            }));

            it('should attach a list of awesomeThings to the scope', function () {
               // $state.expectTransitionTo('home');
                expect($scope.test.length).toBe(0);
            });

            it('should expose some global scope', function() {
                expect($rootScope.global).toBeTruthy();
            });
        });
        
    });
/*}());*/