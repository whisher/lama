'use strict';

//Setting up route
angular.module('lama.auth')
    .config(['$stateProvider',function($stateProvider) {
        //  Check if the user is not connetected
        var checkLoggedOut = function($http) {
            //return $http.get('/loggedout');
            return true;
        };

        // states for my app
        $stateProvider
            .state('auth', {
                url: '/signin',
                templateUrl: 'auth/views/signin.html',
                controller:'AuthSigninCtrl',
                resolve: {
                    loggedin: checkLoggedOut
                }
            });
            
    }
    ]);
