'use strict';

angular.module('lama.users')
    .directive('userManagerStatus',function(User) {
            return {
                restrict: 'A',
                scope:{
                    userData: '='
                },
                controller:function($scope){
                    $scope.ban = function(id){
                        var ban = User.ban(id);
                        return ban.put();
                    };

                    $scope.unBan = function(id){
                        var unban = User.unban(id);
                        return unban.put();
                    };
                },
                link: function(scope, element) {
                    var status = scope.userData.status;
                    if(status==='Banned'){
                       element.text('Un-ban');
                    }
                    else{
                        element.text('Ban');
                    }
                    element.on('click',function(e){
                        e.stopPropagation();
                        if(status==='Banned'){
                            scope.unBan(scope.userData.id)
                                .then(function(data) {
                                    $('#user-status-'+scope.userData.id).text('Active');
                                    scope.userData.status = 'Active';
                                    element.text('Ban');
                                },
                                function error(reason) {
                                    throw new Error(reason);
                                }
                            );
                        } 
                        else{
                            scope.ban(scope.userData.id)
                                .then(function(data) {
                                    $('#user-status-'+scope.userData.id).text('Banned');
                                    scope.userData.status = 'Banned';
                                    element.text('Un-ban');
                                },
                                function error(reason) {
                                    throw new Error(reason);
                                }
                            );
                        }
                    });
                }
            };
    });