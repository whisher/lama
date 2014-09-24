'use strict';

angular.module('lama.users')
    .directive('lamaUserBanner',function(Users) {
        return {
            restrict: 'A',
            scope:{
                currentUser: '='
            },
            controller:function($scope){
                $scope.ban = function(id){
                    var ban = Users.ban(id);
                    return ban.put();
                };
            },
            link: function(scope, element) {
                var status = scope.currentUser.status;
                if(status==='Banned'){
                    element.text('Unban');
                }
                else{
                    element.text('Ban');
                }
                element.on('click',function(e){
                    e.stopPropagation();
                    scope.ban(scope.currentUser.id)
                    .then(function(data) {
                        var status =  data.ban > 0 ? 'Banned' : 'Active';
                        var action =  data.ban > 0 ? 'Unban' : 'Ban';
                        $('#user-status-'+scope.currentUser.id).text(status);
                        scope.currentUser.status = status;
                        element.text(action);
                    },
                    function error(reason) {
                        throw new Error(reason);
                    }
                    );
                        
                });
            }
        };
    });