'use strict';

angular.module('lama.users')
    .controller('UserCtrl', ['$scope',
        function($scope) {
           
        }
    ])
    .controller('UserAccountCtrl', ['$rootScope', '$scope', '$state', 'user', 'User',
        function($rootScope, $scope, $state, user, User) {
            $scope.user =  user;
            var account = User.account($scope.user.id);
            $scope.errors = null;
            $scope.save = function(){
                account.fullname = $scope.user.fullname;
                account.email = $scope.user.email;
                account.username = $scope.user.username;
                account.put().then(
                    function(data) {
                        if(data.success){
                            $rootScope.global.user.fullname = data.user.fullname;
                            return $state.go('home');
                        }
                        $scope.errors = data.errors;
                    }
                );
            };
        }
    ])
    .controller('UserPasswordCtrl', ['$rootScope', '$scope', '$state', 'user', 'User',
        function($rootScope, $scope, $state, user, User) {
            $scope.user =  {};
            var password = User.password(user.id);
            $scope.errors = null;
            $scope.save = function(){
                password.old_password = $scope.old_password;
                password.password = $scope.user.password;
                password.password_confirmation = $scope.user.password_confirmation;
                password.put().then(
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
    