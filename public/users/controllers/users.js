'use strict';

angular.module('lama.users')
    .controller('UserCtrl', ['$scope', '$state', 'users', 'User','Paginator','Current',
        function($scope, $state, users, User, Paginator, Current) {
            
            $scope.hasUsers = users.length > 0;
            $scope.paginator =  Paginator(2,5,users);
            if(Current.get() > 1){
                $scope.paginator.toPageId(Current.get());
            }
            $scope.unSuspend = function(id){
                var unsuspend = User.unsuspend(id);
                unsuspend.put().then(function() {
                        Current.set($scope.paginator.getCurrentPage());
                        return $state.go('user_actions.list',{}, {reload: true});
                    },
                    function error(reason) {
                        throw new Error(reason);
                    }
                );
            };
            
            $scope.ban = function(id){
                var ban = User.ban(id);
                ban.put().then(function() {
                        Current.set($scope.paginator.getCurrentPage());
                        return $state.go('user_actions.list',{}, {reload: true});
                    },
                    function error(reason) {
                        throw new Error(reason);
                    }
                );
            };
            
            $scope.unBan = function(id){
                var unban = User.unban(id);
                unban.put().then(function() {
                        Current.set($scope.paginator.getCurrentPage());
                        return $state.go('user_actions.list',{}, {reload: true});
                    },
                    function error(reason) {
                        throw new Error(reason);
                    }
                );
            };
        }
    ])
    .controller('UserInnerCtrl', ['$scope', '$filter',
        function($scope, $filter) {
            $scope.user.created_at = $filter('tsToDate')($scope.user.created_at,'shortDate'); 
            $scope.user.showSuspend = $scope.user.active && !$scope.user.banned;
            $scope.user.showUnSuspend = !$scope.user.active && !$scope.user.banned;
        }
    ])
    .controller('UserParentActionsCtrl', ['$scope',
        function($scope) {
         //http://stackoverflow.com/a/19633860/356380
         $scope.someSelected = function (object) {
            return Object.keys(object).some(function (key) {
                    return object[key];
                });
            } 
        }
    ])
    .controller('UserCreateCtrl', ['$scope', '$state', 'groups', 'User',
        function($scope, $state, groups, User) {
            $scope.groups = groups;
            $scope.user = {};
            $scope.user.groups = {};
            $scope.errors = null;
            $scope.save = function(){
               $scope.user.groups = Object.keys($scope.user.groups);
               User.register($scope.user).then(
                    function(data) {
                        if(data.success){
                           return $state.go('user_actions.list');
                        }
                        $scope.errors = data.errors;
                        $scope.user.groups = {};
                    }
                );
            };
        }
    ])
    .controller('UserSuspendCtrl', ['$scope', '$state', 'user', 'User',
        function($scope, $state, user, User) {
            $scope.user =  {};
            var suspend = User.suspend(user.id);
            $scope.errors = null;
            $scope.save = function(){
                suspend.minutes = $scope.user.minutes;
                suspend.put().then(
                    function(data) {
                        if(data.success){
                            return $state.go('user_actions.list');
                        }
                        $scope.errors = data.errors;
                    }
                );
            };
        }
    ])
    .controller('UserEditCtrl', ['$scope', '$state', 'groups', 'user', 'User', 
        function ($scope, $state, groups, user, User) {
            $scope.groups = groups;
            $scope.user = user;
            var userHasGroup = {};
            //  trasform user.groups for checkbox
            angular.forEach($scope.user.groups, function(value, key) {
               var hasGroup = _.find($scope.groups, function(group) {
                  return group.id === value.id;
               })
               if(hasGroup){
                   userHasGroup[value.id] = true;
               }
            },userHasGroup);
            $scope.user.groups = userHasGroup;
            var edit = User.edit($scope.user.id);
            $scope.errors = null;
            $scope.save = function(){
                edit.fullname = $scope.user.fullname;
                edit.email = $scope.user.email;
                edit.username = $scope.user.username;
                //to avoid send id with false value
                angular.forEach($scope.user.groups, function(value, key) {
                    if(!value){
                        delete $scope.user.groups[key];
                    }
                });   
                edit.groups  = $scope.user.groups;
                edit.put().then(
                    function(data) {
                        if(data.success){
                            return $state.go('user_actions.list');
                        }
                        $scope.errors = data.errors;
                        $scope.user.groups = {};
                    }
                );
            };
    }])
    .controller('UserDeleteCtrl', ['$scope', '$state', 'user', function ($scope, $state, user) {
        $scope.save = function() {
            return $state.go('users_list');
        };
        $scope.destroy = function() {
            user.remove().then(
                function() {
                    return $state.go('user_actions.list');
                },
                function error(reason) {
                    throw new Error(reason);
                }
                );
        };
    }])
    .controller('UserAccountCtrl', ['$rootScope', '$scope', '$state', 'user', 'User',
        function($rootScope, $scope, $state, user, User) {
            $scope.user =  user;
            var account = User.account($scope.user.id);
            $scope.errors = null;
            $scope.save = function(){
                account.fullname = $scope.user.fullname;
                account.email = $scope.user.email;
                account.username = $scope.user.username;
                account.put().then(
                    function(data) {
                        if(data.success){
                            $rootScope.global.user.fullname = data.user.fullname;
                            return $state.go('home');
                        }
                        $scope.errors = data.errors;
                    }
                );
            };
        }
    ])
    .controller('UserPasswordCtrl', ['$rootScope', '$scope', '$state', 'user', 'User',
        function($rootScope, $scope, $state, user, User) {
            $scope.user =  {};
            var password = User.password(user.id);
            $scope.errors = null;
            $scope.save = function(){
                password.old_password = $scope.old_password;
                password.password = $scope.user.password;
                password.password_confirmation = $scope.user.password_confirmation;
                password.put().then(
                    function(data) {
                        if(data.success){
                            return $state.go('home');
                        }
                        $scope.errors = data.errors;
                    }
                );
            };
        }
    ])
    .factory('Current',
        function() {
            var current = 1;
            return{
                get :function(){
                    return current
                },
                set :function(c) {
                    current = c;
                }
            };
        }
    );