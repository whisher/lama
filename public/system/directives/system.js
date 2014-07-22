'use strict';

angular.module('lama.system')
    .directive('lmUserFeedback',function() {
            return {
                require: 'ngModel',
                restrict: 'A',
                link: function(scope, element, attrs,ctrl) {
                    var $parentDiv = element.parent();
                    var currentClass = $parentDiv.attr('class');
                    element.on('blur',function() {
                        $parentDiv.removeClass();
                        $parentDiv.addClass(currentClass);
                        if(ctrl.$valid){
                            $parentDiv.addClass('has-success');
                        }
                        else{
                            $parentDiv.addClass('has-error');
                        }
                    });
                }
            };
    })
    .directive('lmEquals', function() {
        return {
            restrict: 'A',
            require: 'ngModel',
            link: function(scope, element, attrs, ngModelCtrl) {
                function validateEqual(myValue) {
                    var valid = (myValue === scope.$eval(attrs.lmEquals));
                    ngModelCtrl.$setValidity('lmequals', valid);
                    return valid ? myValue : undefined;
                }
                ngModelCtrl.$parsers.push(validateEqual);
                ngModelCtrl.$formatters.push(validateEqual);
                scope.$watch(attrs.validateEquals, function() {
                    ngModelCtrl.$setViewValue(ngModelCtrl.$viewValue);
                });
            }
        };
    })
    .directive('lmLoader', function($parse){
        var tpl = '<div id="loading"><i class="fa fa-spinner fa-spin fa-4x"></i></div>';
        return {
            restrict: 'A',
            scope : {
                condition: '&'
            },
            link: function(scope, element) {
                element.css('position','relative');
                scope.$watch('condition()', function(){
                    var isSubmitted = scope.condition();
                    if(isSubmitted){
                       element.append(tpl); 
                    }
                    else{
                        $('#loading').remove();
                    }
                    
                }); 
            }
        };
        
    });