'use strict';

angular.module('lama.users')
    .controller('SessionSigninController', ['$scope', '$rootScope', 'Users', '$state',
        function($scope, $rootScope, Users, $state) {
            $scope.user = {};
            $scope.errors = [];
            $scope.save = function() {
                Users.signin($scope.user).then(
                    function(data) { 
                        if(data.success){
                            $rootScope.$emit('loggedin',data.user);
                            return $state.go('home');
                        }
                        $scope.errors = data.errors;
                    }
                );
            };
        }
    ])
    .controller('SessionRegisterController', ['$rootScope', '$scope', '$state', 'Users',
        function($rootScope, $scope, $state, Users) {
            $scope.user = {};
            $scope.errors = [];
            $scope.isSubmitted = false;
            $scope.save = function(){
                $scope.isSubmitted = true;
                Users.post($scope.user).then(
                    function(data) {
                        if(data.success){
                            if(data.logged > 0){
                                $rootScope.$emit('loggedin',data.user);
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
    .controller('SessionForgotPasswordController', ['$scope', '$state', 'Users',
        function($scope, $state, Users) {
            $scope.user = {};
            $scope.errors = [];
            $scope.save = function(){
                Users.forgot($scope.user).then(
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