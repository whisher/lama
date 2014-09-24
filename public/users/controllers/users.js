'use strict';

angular.module('lama.users')
    .controller('UserController', ['$scope', '$state', 'users', 'Users', 'Paginator', 'PAGINATOR', 'CurrentPageMemory',
        function($scope, $state, users, Users, Paginator, PAGINATOR, CurrentPageMemory) {
            
            $scope.hasUsers = users.length > 0;
            $scope.paginator =  Paginator(PAGINATOR.size, PAGINATOR.range, users);
            if(CurrentPageMemory.get() > 1){
                $scope.paginator.toPageId(CurrentPageMemory.get());
            }
            $scope.unSuspend = function(id){
                var unsuspend = Users.unsuspend(id);
                unsuspend.put().then(function() {
                        CurrentPageMemory.set($scope.paginator.getCurrentPage());
                        return $state.go('user_actions.list',{}, {reload: true});
                    },
                    function error(reason) {
                        throw new Error(reason);
                    }
                );
            };
           
            $scope.search = function (row) { 
                return !!((row.email.indexOf($scope.query || '') !== -1 || row.fullname.indexOf($scope.query || '') !== -1));
            };
         }
    ])
    .controller('UserInnerController', ['$scope', '$filter',
        function($scope, $filter) {
            $scope.user.created_at = $filter('tsToDate')($scope.user.created_at,'shortDate'); 
            $scope.user.showSuspend = $scope.user.active && !$scope.user.banned;
            $scope.user.showUnSuspend = !$scope.user.active && !$scope.user.banned;
        }
    ])
    .controller('UserParentActionsController', ['$scope',
        function($scope) {
         //http://stackoverflow.com/a/19633860/356380
         $scope.someSelected = function (object) {
            return Object.keys(object).some(function (key) {
                    return object[key];
                });
            }; 
        }
    ])
    .controller('UserCreateController', ['$scope', '$state', 'groups', 'Users',
        function($scope, $state, groups, Users) {
            $scope.groups = groups;
            $scope.user = {};
            $scope.user.groups = {};
            $scope.errors = null;
            $scope.save = function(){
               $scope.user.groups = Object.keys($scope.user.groups);
               Users.create($scope.user).then(
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
    .controller('UserSuspendController', ['$scope', '$state', 'user', 'Users', 'CurrentPageMemory',
        function($scope, $state, user, Users, CurrentPageMemory) {
            $scope.user =  {};
            var suspend = Users.suspend(user.id);
            $scope.errors = null;
            $scope.save = function(){
                suspend.minutes = $scope.user.minutes;
                suspend.put().then(
                    function(data) {
                        if(data.success){
                            CurrentPageMemory.set($state.params.page);
                            return $state.go('user_actions.list');
                        }
                        $scope.errors = data.errors;
                    }
                );
            };
        }
    ])
    .controller('UserEditController', ['$scope', '$state', 'groups', 'user', 'Users', 
        function ($scope, $state, groups, user, Users) {
            $scope.groups = groups;
            var original = user;
            $scope.user = Users.copy(original);
            var userHasGroup = {};
            //  trasform user.groups for checkbox
            angular.forEach($scope.user.groups, function(value, key) {
               var hasGroup = _.find($scope.groups, function(group) {
                  return group.id === value.id;
               });
               if(hasGroup){
                   userHasGroup[value.id] = true;
               }
            },userHasGroup);
            $scope.user.groups = userHasGroup;
            $scope.errors = null;
            $scope.save = function(){
               //to avoid send id with false value
                angular.forEach($scope.user.groups, function(value, key) {
                    if(!value){
                        delete $scope.user.groups[key];
                    }
                });   
                
                $scope.user.put().then(
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
    .controller('UserDeleteController', ['$scope', '$state', 'user', function ($scope, $state, user) {
        $scope.save = function() {
            return $state.go('user_actions.list');
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
    .controller('UserAccountController', ['$rootScope', '$scope', '$state', 'user', 'Users',
        function($rootScope, $scope, $state, user, Users) {
            $scope.user =  user;
            var account = Users.account($scope.user.id);
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
    .controller('UserPasswordController', ['$rootScope', '$scope', '$state', 'user', 'Users',
        function($rootScope, $scope, $state, user, Users) {
            $scope.user =  {};
            var password = Users.password(user.id);
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
    .factory('CurrentPageMemory',
        function() {
            var current = 1;
            return{
                get :function(){
                    return current;
                },
                set :function(num) {
                    current = num;
                }
            };
        }
    );