'use strict';

//Setting up route
angular.module('lama.users')
    .config(['$stateProvider',function($stateProvider) {
       
        // states for users
        $stateProvider
        .state('users', {
            abstract: true,
            templateUrl: 'users/views/index.html',
            resolve: {
                issessionedin: function(Session){
                    return Session.isLoggedIn();
                } 
            }
        })
        .state('users.account', {
            url: '/user/account/:id',
            templateUrl: 'users/views/account.html',
            resolve: {
                user: function(User, $stateParams){
                    return User.one($stateParams.id);
                }
            },
            controller:'UserAccountCtrl'
        })
            
    }]);
