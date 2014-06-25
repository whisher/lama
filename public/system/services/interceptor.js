'use strict';

angular.module('lama.system')
    .factory('httpInterceptor', ['$q','$location',function ($q,$location) {
        return {
            'response': function(response) {
                if (response.status === 401) {
                    $location.url('/user/signin');
                    return $q.reject(response);
                }
                if (response.status === 403) {
                    $location.url('/');
                    return $q.reject(response);
                }
                return response || $q.when(response);
            },
            'responseError': function(rejection) {
                if (rejection.status === 401) {
                    $location.url('/user/signin');
                    return $q.reject(rejection);
                }
                if (rejection.status === 403) {
                    $location.url('/');
                    return $q.reject(rejection);
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