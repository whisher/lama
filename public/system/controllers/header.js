'use strict';

angular.module('lama.system')
    .controller('HeaderController', ['$scope', '$rootScope', 'Global',
        function($scope, $rootScope, Global) {
            $scope.global = Global;
            $rootScope.$on('loggedin', function() {
                $scope.global = {
                    user:  $rootScope.global.user,
                    authenticated: $rootScope.global.user.groups.length,
                    isAdmin:  $rootScope.global.user.groups.indexOf('Admins')
                };
            });
        }
    ]);
