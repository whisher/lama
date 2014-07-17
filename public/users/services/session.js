'use strict';

//Service for session status
angular.module('lama.users')
    .factory('Session', ['$http',
        function($http) {
            return{
                isSessionedIn :function() {
                    $http.get('/api/v1/issessionedin');
                },
                isLoggedIn :function() {
                    $http.get('/api/v1/isloggedin');
                },
                hasAccess :function(permission) {
                    $http.get('/api/v1/hasaccess/'+permission);
                }
            };
        }
    ]);
