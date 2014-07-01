'use strict';

//Setting up route
angular.module('lama.users')
    .config(['$stateProvider',function($stateProvider) {
       
        // states for users
        $stateProvider
        .state('users', {
            abstract: true,
            templateUrl: 'users/views/users.html',
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
                    return User.get($stateParams.id);
                }
            },
            controller:'UserAccountCtrl'
        })
        .state('users.password', {
            url: '/user/password/:id',
            templateUrl: 'users/views/password.html',
            resolve: {
                user: function(User, $stateParams){
                    return User.get($stateParams.id);
                }
            },
            controller:'UserPasswordCtrl'
        })
        .state('users_list', {
            url: '/users',
            templateUrl: 'users/views/index.html',
            resolve: {
                hasaccess: function(Session){
                    return Session.hasAccess('users');
                }, 
                users: function(User){
                   return User.getList();
                }
            },
            controller:'UserCtrl'
        })
        .state('user_edit', {
            url: '/users',
            templateUrl: 'users/views/index.html',
            resolve: {
                hasaccess: function(Session){
                    return Session.hasAccess('users');
                }, 
                users: function(User){
                    return User.getList();
                }
            },
            controller:'UserCtrl'
        })
        .state('user_delete', {
            url: '/user/:id/delete',
            templateUrl: 'users/views/delete.html',
            resolve: {
                hasaccess: function(Session){
                    return Session.hasAccess('users');
                }, 
                users: function(User){
                    return User.getList();
                }
            },
            controller:'UserCtrl'
        });
            
    }]);
