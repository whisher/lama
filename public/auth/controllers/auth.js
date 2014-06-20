'use strict';

angular.module('lama.auth')
    .controller('AuthSigninCtrl', ['$scope', '$rootScope', '$http', '$location',
        function($scope, $rootScope, $http, $location) {
            // This object will be filled by the form
            $scope.user = {};
            $scope.error = '';
            // Register the login() function
            $scope.login = function() {
                $http.post('/signin', $scope.user)
                .success(function(response) {
                    $rootScope.user = response.user;
                    $rootScope.$emit('loggedin');
                    $location.url('/');
                })
                .error(function() {
                    $scope.error = 'Authentication failed.';
                });
            };
        }
    ]);