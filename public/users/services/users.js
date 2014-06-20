'use strict';

//Articles service used for articles REST endpoint
angular.module('lama.users')
    .config(['RestangularProvider',function(RestangularProvider) {
        RestangularProvider.setBaseUrl('/');
        RestangularProvider.setRequestInterceptor(function(elem, operation, what) {
            if (operation === 'put') {
                elem._id = undefined;
                return elem;
            }
            return elem;
        }); 
    }])
    .factory('User', ['Restify', function(Restify) {
        function User() {}
        return angular.extend(Restify('user'), new User());
    }]);
