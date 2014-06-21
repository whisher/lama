'use strict';

//Global service for global variables
angular.module('lama.system').factory('Global', [

    function() {
        var data =  {
            user: window.user,
            authenticated: false,
            isAdmin: false
        };
        if (data.user && data.user.groups) {
           data.authenticated = data.user.groups.length;
           data.isAdmin = ~data.user.groups.indexOf('Admins');
        }
        return data;
    }
]);
