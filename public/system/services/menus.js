'use strict';

angular.module('lama.system')
    .factory('Menus', ['$http', function($http) {
        return {
            query : function(menus){
                return $http.get('/api/v1/users/menus', {
                    params: {
                        'menus[]': menus
                    }
                });
            }
        }; 
    }]);