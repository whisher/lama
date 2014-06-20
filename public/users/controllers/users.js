'use strict';

angular.module('lama.users')
    .controller('UserRegisterCtrl', ['$rootScope', '$scope', '$state', 'User',
        function($rootScope, $scope, $state, User) {console.log(document.cookie);
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