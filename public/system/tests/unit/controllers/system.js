'use strict';
describe('LAMA Unit Test: system module', function () {
    
    describe('SystemController', function () {
        
        beforeEach(function() {
            module('lama.system');
        });

        var SystemController,
        $rootScope,
        $scope;

        beforeEach(inject(function ($controller, _$rootScope_) {
            $rootScope = _$rootScope_;
            $scope = _$rootScope_.$new();
            SystemController = $controller('SystemController', {
                $scope: $scope
            });
               
        }));

        it('should expose some global scope', function() {
            expect($rootScope.global).toBeTruthy();
        });
        
    });
        
});

