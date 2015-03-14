app = angular.module('student.controller',[]);
app.controller('ProfileController', ['$scope','$location','$http', function($scope,$location,$http) {
  $scope.loadProfile = function(){
    $http.post('/account/getUser',{}).success(function(data){
      if(data.status === true){
        $scope.Model = data.data;
      }
    });
  };
  $scope.init = function(){
    $scope.loadProfile();
  };
  return $scope.init();
}]);