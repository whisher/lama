'use strict';

angular.module('lama.system', ['ui.router','restangular'])
   .config(['$httpProvider', function($httpProvider) {
        // Crossdomain requests not allowed if you want do cors request see filter.php 
        $httpProvider.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
    }])
    .run(['$rootScope', '$state', '$log', 'Global',function ($rootScope, $state, $log, Global) {
        $rootScope.$state = $state;
        $rootScope.$log = $log;
        $rootScope.global = Global;
    }]);
   