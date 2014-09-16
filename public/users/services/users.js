'use strict';

//Users service used for articles REST endpoint
angular.module('lama.users')
    .config(['RestangularProvider',function(RestangularProvider) {
        RestangularProvider.setBaseUrl('/api/v1');
    }])
    .factory('Users', ['Restify', function(Restify) {
        function Users() {
            this.account = function(id){
                return this.one(id).one('account');
            };
            this.password = function(id){
                return this.one(id).one('password');
            };
            this.create = function(data){
                return this.all('users/create').post(data);
            };
            this.forgot = function(data){
                return this.all('users/forgot').post(data);
            };
            this.suspend = function(id){
                return this.one(id).one('suspend');
            };
            this.unsuspend = function(id){
                return this.one(id).one('unsuspend');
            };
            this.ban = function(id){
                return this.one(id).one('ban');
            };
            this.unban = function(id){
                return this.one(id).one('unban');
            };
            
        }
        return angular.extend(Restify('users'), new Users());
    }]);
