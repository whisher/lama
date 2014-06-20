'use strict';

//Setting up route
angular.module('lama.system')
    .config(['$stateProvider', '$urlRouterProvider',
        function($stateProvider, $urlRouterProvider) {
            $urlRouterProvider.otherwise('/');
            $stateProvider              
            .state('home', {
                url: '/',
                templateUrl: 'system/views/home.html'
            })
        }
    ])
    .config(['$locationProvider',
        function($locationProvider) {
            $locationProvider.hashPrefix('!');
        }
    ]);
