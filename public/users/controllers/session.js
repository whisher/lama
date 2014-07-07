'use strict';

angular.module('lama.users')
    .controller('SessionSigninCtrl', ['$scope', '$rootScope', '$http', '$state',
        function($scope, $rootScope, $http, $state) {
            $scope.user = {};
            $scope.error = null;
           
            $scope.save = function() {
                $http.post('/signin', $scope.user).then(
                    function(response) {
                        var data = response.data;
                        if(data.success){
                           $rootScope.global.user = data.user;
                           $rootScope.$emit('loggedin');
                           return $state.go('home');
                        }
                        $scope.errors = data.errors;
                    }
                );
            };
        }
    ])
    .controller('SessionRegisterCtrl', ['$rootScope', '$scope', '$state', 'User',
        function($rootScope, $scope, $state, User) {
            $scope.user = {};
            $scope.errors = null;
            $scope.save = function(){
                User.post($scope.user).then(
                    function(data) {
                        if(data.success){
                           $rootScope.global.user = data.user;
                           $rootScope.$emit('loggedin');
                           return $state.go('home');
                        }
                        $scope.errors = data.errors;
                    }
                );
            };
        }
    ]);