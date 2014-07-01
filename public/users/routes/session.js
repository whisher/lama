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
                templateUrl: 'users/views/form.html',
                controller:'SessionRegisterCtrl'
            });
        }
    ]);
