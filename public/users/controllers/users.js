'use strict';

angular.module('lama.users')
    .controller('UserCtrl', ['$scope',
        function($scope) {
           
        }
    ])
    .controller('UserAccountCtrl', ['$rootScope', '$scope', '$state', 'user',
        function($rootScope, $scope, $state, user) {
            $scope.user = user;
            $scope.errors = null;
            $scope.save = function(){
                $scope.user.put().then(
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