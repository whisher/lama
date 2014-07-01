'use strict';

//Service for session status
angular.module('lama.users')
    .factory('Session', ['$http',
        function($http) {
            return{
                isSessionedIn :function() {
                    $http.get('/issessionedin');
                },
                isLoggedIn :function() {
                    $http.get('/isloggedin');
                },
                hasAccess :function(permission) {
                    $http.get('/hasaccess/'+permission);
                }
            };
        }
    ]);
