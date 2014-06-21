'use strict';

angular.module('lama.users')
    .controller('UserSigninCtrl', ['$scope', '$rootScope', '$http', '$location',
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
    ])
    .controller('UserRegisterCtrl', ['$rootScope', '$scope', '$state', 'User',
        function($rootScope, $scope, $state, User) {
            $scope.user = {};
            $scope.errors = null;
            $scope.save = function(){
                User.store($scope.user).then(
                    function(data) {
                        if(data.success){
                            return $state.go('home');
                        }
                        $scope.errors = data.errors;
                    }
                );
            };
        }
    ]);