'use strict';

angular.module('lama.users')
    .controller('SessionSigninCtrl', ['$scope', '$rootScope', '$http', '$state','Session',
        function($scope, $rootScope, $http, $state,Session) {
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
    .controller('SessionRegisterCtrl', ['$rootScope', '$scope', '$state',/*'$timeout',*/ 'Session', 'User',
        function($rootScope, $scope, $state,Session, User) {
            $scope.user = {};
            $scope.errors = null;
            $scope.save = function(){
                User.store($scope.user).then(
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