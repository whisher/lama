'use strict';

angular.element(document).ready(function() {
    
    //Then init the app
    angular.bootstrap(document, ['lama']);

});

angular.module('lama', ['ui.router','restangular','lama.system','lama.users']);
