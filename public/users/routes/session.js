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
                controller:'SessionSigninCtrl'
             })
            .state('session.register', {
                url: '/user/register',
                templateUrl: 'users/views/register.html',
                controller:'SessionRegisterCtrl'
            })
            .state('session.password', {
                url: '/user/forgot-password',
                templateUrl: 'users/views/forgot-password.html',
                controller:'SessionForgotPasswordCtrl'
            })
            .state('session.register-thanks', {
                url: '/user/register-thanks',
                templateUrl: 'users/views/register-thanks.html'
            })
            .state('session.forgot-thanks', {
                url: '/user/forgot-thanks',
                templateUrl: 'users/views/forgot-thanks.html'
            });
        }
    ]);
