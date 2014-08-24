'use strict';

angular.element(document).ready(function() {
    
    //Then init the app
    angular.bootstrap(document, ['lama']);

});

angular.module('lama', ['ui.router','restangular','lama.system','lama.users'])
    .config(['$locationProvider',
        function($locationProvider) {
            $locationProvider.hashPrefix('!');
        }
    ])
    .run(['$rootScope',  'Menus',function ($rootScope, Menus) {
        // Default hard coded menu items for main menu
        var menus = [
        {
            'permission': null,
            'title': 'Home',
            'link': 'home'
        },
        {
            'permission': 'users',
            'title': 'Users',
            'link': 'user_actions.list'
        }
        ];

        $rootScope.menus = [];
            
        function queryMenu(menus) {
            Menus.query(menus).then(
                function (result) {
                    $rootScope.menus = result.data; 
                },
                function (reason) {
                    throw new Error(reason);
                }
                );
        }

        // Query server for menus and check permissions
        queryMenu(menus);
        
        $rootScope.$on('loggedin', function(event,user) {
            console.log('kkk');
            queryMenu(menus);
                
            $rootScope.global = {
                user:  user,
                authenticated: user.groups.length,
                isAdmin:  user.groups.indexOf('Admins')
            };
        });
        

    }]);
 