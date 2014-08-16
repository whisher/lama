'use strict';

(function() {
    describe('LAMA sessions module', function() {
        describe('SessionSigninController', function() {
            beforeEach(function() {
                this.addMatchers({
                    toEqualData: function(expected) {
                        return angular.equals(this.actual, expected);
                    }
                });
            });

            beforeEach(function() {
                module('lama');
                module('stateMock');
            });
            

            var SessionSigninController,
            $scope,
            $rootScope,
            $httpBackend,
            $location,
            $state;

            beforeEach(inject(function($controller, _$rootScope_, _$location_, _$state_ , _$httpBackend_) {

                $scope = _$rootScope_.$new();
                $rootScope = _$rootScope_;

                SessionSigninController = $controller('SessionSigninController', {
                    $scope: $scope,
                    $rootScope: _$rootScope_
                });

                $httpBackend = _$httpBackend_;
 
                $location = _$location_;
                
                $state = _$state_;
                
            }));

            afterEach(function() {
                $httpBackend.verifyNoOutstandingExpectation();
                $httpBackend.verifyNoOutstandingRequest();
            });

            it('should register with correct data', function() {
                $state.expectTransitionTo('home');
                spyOn($rootScope, '$emit');
                
                $httpBackend.when('POST', '/api/v1/signin').respond(200,{
                    "success":1,
                    "user":{
                        "id":1,
                        "email":"lama@test.test",
                        "fullname":"Lama user",
                        "username":"lamauser",
                        "groups":["Users"]
                        }
                    });
            
                $scope.save();
                $httpBackend.flush();
                expect($rootScope.global.user.id).toBe(1);
                expect($scope.errors.length).toBe(0);
                expect($rootScope.$emit).toHaveBeenCalledWith('loggedin');
                expect($location.url()).toBe('');
            });

        });
  
        describe('RegisterController', function() {
            beforeEach(function() {
                this.addMatchers({
                    toEqualData: function(expected) {
                        return angular.equals(this.actual, expected);
                    }
                });
            });

            beforeEach(function() {
                module('lama');
                module('stateMock');
            });
            

            var RegisterController,
            $scope,
            $rootScope,
            $httpBackend,
            $location,
            $state;

            beforeEach(inject(function($controller, _$rootScope_, _$location_, _$state_ , _$httpBackend_) {

                $scope = _$rootScope_.$new();
                $rootScope = _$rootScope_;

                RegisterController = $controller('SessionRegisterController', {
                    $scope: $scope,
                    $rootScope: _$rootScope_
                });

                $httpBackend = _$httpBackend_;
 
                $location = _$location_;
                
                $state = _$state_;
                
            }));

            afterEach(function() {
             $httpBackend.verifyNoOutstandingExpectation();
                $httpBackend.verifyNoOutstandingRequest();
            });

            it('should register and logged with correct data', function() {
                $state.expectTransitionTo('home');
                spyOn($rootScope, '$emit');
                $httpBackend.when('POST', '/api/v1/user').respond(200,{
                    "success":1,
                    "user":{
                        "id":1,
                        "email":"lama@test.test",
                        "fullname":"Lama user",
                        "username":"lamauser",
                        "groups":["Users"]
                    },
                    "logged":1
                });
            
                $scope.save();
                $httpBackend.flush();
                expect($rootScope.global.user.id).toBe(1);
                expect($scope.errors.length).toBe(0);
                expect($rootScope.$emit).toHaveBeenCalledWith('loggedin');
                expect($location.url()).toBe('');
            });
        });
    });
}());
