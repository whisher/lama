'use strict';

//Users service used for articles REST endpoint
angular.module('lama.users')
    .config(['RestangularProvider',function(RestangularProvider) {
        RestangularProvider.setBaseUrl('/api/v1');
    }])
    .factory('Groups', ['Restify', function(Restify) {
        function Groups() {}
        return angular.extend(Restify('groups'), new Groups());
    }]);
