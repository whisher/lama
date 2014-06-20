'use strict';

//Setting up route
angular.module('lama.users')
    .config(['$stateProvider',function($stateProvider) {
        //  Check if the user is not connetected
        var checkLoggedIn = function($http) {
            //return $http.get('/loggedout');
            return true;
        };

        // states for my app
        $stateProvider
            .state('user', {
                abstract: true,
                templateUrl: 'users/views/index.html',
                resolve: {
                    loggedin: checkLoggedIn
                }
            })
            .state('user.register', {
                url: '/user/register',
                templateUrl: 'users/views/register.html',
                controller:'UserRegisterCtrl'
            });
    }
    ]);
