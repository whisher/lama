'use strict';

//Setting up route
angular.module('lama.users')
    .config(['$stateProvider',function($stateProvider) {
        // states for session
        $stateProvider
            .state('session', {
                abstract: true,
                templateUrl: 'users/views/session.html',
                resolve: {
                    issessionedin: function(Session){
                        return Session.isSessionedIn();
                    } 
                }
            })
            .state('session.signin', {
                url: '/user/signin',
                templateUrl: 'users/views/signin.html',
                controller:'SessionSigninController'
             })
            .state('session.register', {
                url: '/user/register',
                templateUrl: 'users/views/register.html',
                controller:'SessionRegisterController'
            })
            .state('session.password', {
                url: '/user/forgot-password',
                templateUrl: 'users/views/forgot-password.html',
                controller:'SessionForgotPasswordController'
            })
            .state('session.register-thanks', {
                url: '/user/register-thanks',
                templateUrl: 'users/views/register-thanks.html'
            })
            .state('session.forgot-thanks', {
                url: '/user/forgot-thanks',
                templateUrl: 'users/views/forgot-thanks.html'
            })
            .state('session.reset-thanks', {
                url: '/user/reset-thanks',
                templateUrl: 'users/views/reset-thanks.html'
            });
        }
    ]);
