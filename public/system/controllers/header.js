'use strict';

angular.module('lama.system')
    .controller('HeaderController', ['$scope', '$rootScope', 'Menus',
        function($scope, $rootScope, Menus) { 
            // Default hard coded menu items for main menu
            var menus = [
            {
                'permission': null,
                'title': 'Home',
                'link': 'home'
            },
            {
                'permission': 'users',
                'title': 'User',
                'link': 'user_actions.list'
            }
            ];

            $scope.menus = [];
            
            function queryMenu(menus) {
                Menus.query(menus).then(
                    function (result) {
                        $scope.menus = result.data; 
                    },
                    function (reason) {
                        throw new Error(reason);
                    }
                    );
            }

            // Query server for menus and check permissions
            queryMenu(menus);
        
            $rootScope.$on('loggedin', function() {
                
                queryMenu(menus);
                
                $scope.global = {
                    user:  $rootScope.global.user,
                    authenticated: $rootScope.global.user.groups.length,
                    isAdmin:  $rootScope.global.user.groups.indexOf('Admins')
                };
            });
        }
    ]);
