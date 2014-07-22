'use strict';

angular.module('lama.users')
    .controller('SessionSigninCtrl', ['$scope', '$rootScope', '$http', '$state',
        function($scope, $rootScope, $http, $state) {
            $scope.user = {};
            $scope.error = null;
           
            $scope.save = function() {
                $http.post('/api/v1/signin', $scope.user).then(
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
            $scope.isSubmitted = false;
            $scope.save = function(){
                $scope.isSubmitted = true;
                User.post($scope.user).then(
                    function(data) {
                        if(data.success){
                            if(data.logged > 0){
                                $rootScope.global.user = data.user;
                                $rootScope.$emit('loggedin');
                                return $state.go('home');
                            }
                            return $state.go('session.register-thanks');
                        }
                        $scope.errors = data.errors;
                        $scope.isSubmitted = false;
                    }
                );
            };
            $scope.registerLoading = function() {
                return $scope.isSubmitted;
            };
        }
    ])
    .controller('SessionForgotPasswordCtrl', ['$scope', '$state', 'User',
        function($scope, $state, User) {
            $scope.user = {};
            $scope.errors = null;
            $scope.save = function(){
                User.forgot($scope.user).then(
                    function(data) {
                        if(data.success){
                            return $state.go('session.forgot-thanks');
                        }
                        $scope.errors = data.errors;
                    }
                    );
            };
        }
    ]);