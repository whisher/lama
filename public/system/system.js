'use strict';

angular.module('lama.system', [])
    .run(['$state','$rootScope','$log',function ($state,$rootScope,$log) {
        $rootScope.$state = $state;
        $rootScope.$log = $log;
    }]);