'use strict';

//Articles service used for articles REST endpoint
angular.module('lama.users')
    .config(['RestangularProvider',function(RestangularProvider) {
        RestangularProvider.setBaseUrl('/');
    }])
    .factory('User', ['Restify', function(Restify) {
        function User() {
            this.account = function(id){
                return this.one(id).one('account');
            };
            this.password = function(id){
                return this.one(id).one('password');
            };
        }
        return angular.extend(Restify('user'), new User());
    }]);
