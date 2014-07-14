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
            this.register = function(data){
                return this.all('user/create').post(data);
            };
            this.forgot = function(data){
                return this.all('user/forgot').post(data);
            };
            this.edit = function(id){
                return this.one(id).one('edit');
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
        return angular.extend(Restify('user'), new User());
    }])
   .factory('Group', ['Restify', function(Restify) {
        function Group() {}
        return angular.extend(Restify('group'), new Group());
    }]);
