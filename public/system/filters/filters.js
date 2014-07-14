'use strict';

//Global service for global variables
angular.module('lama.system').filter('tsToDate', function($filter) {
        return function(input,format) {
            return $filter('date')(Date.parse(input.split(' ').shift()),format);
        };
    });