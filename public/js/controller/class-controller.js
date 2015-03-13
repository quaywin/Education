app = angular.module('classes.controller',[]);
app.controller('ClassController', ['$scope','$location', function($scope,$location) {
  $scope.CurrentPage = 1;
  $scope.ListClass = [];
  $scope.Count = 0;
  $scope.ClassName = null;
  $scope.getListClass = function(page){
    $http.post('/admin/getListClass',{page:page}).success(function(data){
      $scope.ListClass = data.data;
      $scope.Count = data.count;
      $scope.Pages = data.pages;
      $scope.PageSize = data.pageSize;
      $scope.CurrentPage = page;
    });
  };
  $scope.addNewCLass = function(){
    $http.post('/admin/addNewCLass',{page:$scope.ClassName}).success(function(data){
      if(data === true){
        $scope.ClassName = null;
        $scope.getListClass($scope.CurrentPage);
      }
    });
  };
  $scope.init = function(){
    $scope.getListClass($scope.CurrentPage);
  };
  return $scope.init();
}]);
