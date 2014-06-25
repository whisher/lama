'use strict';

//Articles service used for articles REST endpoint
angular.module('lama.users')
    .config(['RestangularProvider',function(RestangularProvider) {
        RestangularProvider.setBaseUrl('/');
    }])
    .factory('User', ['Restify', function(Restify) {
        function User() {}
        return angular.extend(Restify('user'), new User());
    }]);
