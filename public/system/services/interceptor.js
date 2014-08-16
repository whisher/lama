'use strict';

angular.module('lama.system')
    .factory('httpInterceptor', ['$q', '$location',function ($q, $location) {
        var canceller = $q.defer();
        return {
            'request': function(config) {
                // promise that should abort the request when resolved.
                config.timeout = canceller.promise;
                return config;
            },
            'response': function(response) {
                return response;
            },
            'responseError': function(rejection) {
                if (rejection.status === 401) {
                    canceller.resolve('Unauthorized'); 
                    $location.url('/user/signin');
                }
                if (rejection.status === 403) {
                    canceller.resolve('Forbidden');  
                    $location.url('/');
                }
                return $q.reject(rejection);
            }

        };
    }
    ])
    //Http Intercpetor to check auth failures for xhr requests
   .config(['$httpProvider',function($httpProvider) {
        $httpProvider.interceptors.push('httpInterceptor');
    }]);