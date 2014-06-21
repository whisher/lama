'use strict';

//Setting up route
angular.module('lama.users')
    .config(['$stateProvider',function($stateProvider) {
        //  Check if the user is just logged
        var checkLoggedOut = function($http) {
            return $http.get('/loggedout');
        };
        //  Check if the user is logged
        var checkLoggedIn = function($http) {
            return $http.get('/loggedin');
        };
        
        // states for my app
        $stateProvider
            .state('auth', {
                abstract: true,
                templateUrl: 'users/views/auth.html',
                resolve: {
                    loggedout: checkLoggedOut
                }
            })
            .state('auth.signin', {
                url: '/user/signin',
                templateUrl: 'users/views/signin.html',
                controller:'UserSigninCtrl'
             })
            .state('auth.register', {
                url: '/user/register',
                templateUrl: 'users/views/register.html',
                controller:'UserRegisterCtrl'
            })
            .state('user', {
                abstract: true,
                templateUrl: 'users/views/index.html',
                resolve: {
                    loggedin: checkLoggedIn
                }
            })
            .state('user_register', {
                url: '/user/register',
                templateUrl: 'users/views/register.html',
                resolve: {
                    loggedin: checkLoggedOut
                },
                controller:'UserRegisterCtrl'
            });
    }
    ]);
