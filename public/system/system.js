'use strict';

angular.module('lamb.system', []).config(['$stateProvider', '$urlRouterProvider',
        function($stateProvider, $urlRouterProvider) {
            // For unmatched routes:
            $urlRouterProvider.otherwise('/home');

            // states for my app
            $stateProvider              
                .state('home', {
                    url: '/ppppp',
                    templateUrl: 'public/system/views/index.html'
                })
          console.log('fffffffffffffff');      
        }
    ])
    .config(['$locationProvider',
        function($locationProvider) {
            $locationProvider.hashPrefix('!');
        }
    ]);;