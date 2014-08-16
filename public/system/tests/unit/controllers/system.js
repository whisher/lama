'use strict';

(function() {
    describe('Unit test: system module', function () {
        describe('SystemController', function () {

            // load the controller's module
            beforeEach(function() {
                module('lama');
                module('stateMock');
            });

            var SystemController,
            $rootScope,
            $scope;
            window.user = {};
            // Initialize the controller and a mock scope
            beforeEach(inject(function ($controller, _$rootScope_) {
                $rootScope = _$rootScope_;
                $scope = _$rootScope_.$new();
                SystemController = $controller('SystemController', {
                    $scope: $scope
                });
            }));

            it('should attach a list of awesomeThings to the scope', function () {
                expect($scope.test.length).toBe(0);
            });

            it('should expose some global scope', function() {
                expect($rootScope.global).toBeTruthy();
            });
        });
        describe('HeaderController', function () {

            // load the controller's module
            beforeEach(function() {
                module('lama');
                module('stateMock');
            });

            var HeaderController,
            $rootScope,
            $scope,
            $httpBackend,
            $location,
            $state;
            // Initialize the controller and a mock scope
            beforeEach(inject(function ($controller,_$rootScope_, _$state_,_$httpBackend_) {
                $httpBackend = _$httpBackend_;
                
 
                $rootScope = _$rootScope_;
                $scope = _$rootScope_.$new();
                HeaderController = $controller('HeaderController', {
                    $scope: $scope
                });
                
                $state = _$state_;
                
            }));
afterEach(function() {
             // $httpBackend.verifyNoOutstandingExpectation();
              // $httpBackend.verifyNoOutstandingRequest();
            });
            it('should attach a menu to the scope', function () {
                //$state.expectTransitionTo('home');
               // $httpBackend.when('GET', '/api/v1/user/menus').respond([{permission: null, title: 'Home', link:'home'}]);
                //$httpBackend.flush();
                //console.log($scope.menus);
               // expect($scope.menus.length).toBe(1);
            });

           
        });
    });
}());