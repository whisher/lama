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
        .state('user_actions', {
            abstract: true,
            templateUrl: 'users/views/actions.html',
            resolve: {
                hasaccess: function(Session){
                    return Session.hasAccess('users');
                } 
            },
            controller:'UserParentActionsCtrl'
        })
        .state('user_actions.create', {
            url: '/user/create',
            templateUrl: 'users/views/create.html',
            resolve: {
                groups: function(Group){
                   return Group.getList();
                }
            },
            controller:'UserCreateCtrl'
        })
        .state('user_actions.list', {
            url: '/users',
            templateUrl: 'users/views/index.html',
            resolve: {
                users: function(User){
                   return User.getList();
                }
            },
            controller:'UserCtrl'
        })
        .state('user_actions.suspend', {
            url: '/user/:id/suspend/page/:page',
            templateUrl: 'users/views/suspend.html',
            resolve: {
                user: function(User,$stateParams){
                    return User.get($stateParams.id);
                }
            },
            controller:'UserSuspendCtrl'
        })
        .state('user_actions.edit', {
            url: '/user/:id/edit',
            templateUrl: 'users/views/edit.html',
            resolve: {
                groups: function(Group){
                   return Group.getList();
                },
                user: function(User,$stateParams){
                    return User.get($stateParams.id);
                }
            },
            controller:'UserEditCtrl'
        })
        .state('user_actions.delete', {
            url: '/user/:id/delete',
            templateUrl: 'users/views/delete.html',
            resolve: {
                user: function(User,$stateParams){
                    return User.get($stateParams.id);
                }
            },
            controller:'UserDeleteCtrl'
        });
            
    }]);
