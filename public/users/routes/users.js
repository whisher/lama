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
                issessionedin: function(Sessions){
                    return Sessions.isLoggedIn();
                } 
            }
        })
        .state('users.account', {
            url: '/user/account/:id',
            templateUrl: 'users/views/account.html',
            resolve: {
                user: function(Users, $stateParams){
                    return Users.get($stateParams.id);
                }
            },
            controller:'UserAccountController'
        })
        .state('users.password', {
            url: '/user/password/:id',
            templateUrl: 'users/views/password.html',
            resolve: {
                user: function(Users, $stateParams){
                    return Users.get($stateParams.id);
                }
            },
            controller:'UserPasswordController'
        })
        .state('user_actions', {
            abstract: true,
            templateUrl: 'users/views/actions.html',
            resolve: {
                hasaccess: function(Sessions){
                    return Sessions.hasAccess('users');
                } 
            },
            controller:'UserParentActionsController'
        })
        .state('user_actions.create', {
            url: '/user/create',
            templateUrl: 'users/views/create.html',
            resolve: {
                groups: function(Groups){
                   return Groups.getList();
                }
            },
            controller:'UserCreateController'
        })
        .state('user_actions.list', {
            url: '/users',
            templateUrl: 'users/views/index.html',
            resolve: {
                users: function(Users){
                   return Users.getList();
                }
            },
            controller:'UserController'
        })
        .state('user_actions.suspend', {
            url: '/user/:id/suspend/page/:page',
            templateUrl: 'users/views/suspend.html',
            resolve: {
                user: function(Users,$stateParams){
                    return Users.get($stateParams.id);
                }
            },
            controller:'UserSuspendController'
        })
        .state('user_actions.edit', {
            url: '/user/:id/edit',
            templateUrl: 'users/views/edit.html',
            resolve: {
                groups: function(Groups){
                   return Groups.getList();
                },
                user: function(Users,$stateParams){
                    return Users.get($stateParams.id);
                }
            },
            controller:'UserEditController'
        })
        .state('user_actions.delete', {
            url: '/user/:id/delete',
            templateUrl: 'users/views/delete.html',
            resolve: {
                user: function(Users,$stateParams){
                    return Users.get($stateParams.id);
                }
            },
            controller:'UserDeleteController'
        });
            
    }]);
