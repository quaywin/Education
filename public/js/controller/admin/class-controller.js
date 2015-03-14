app = angular.module('classes.controller',[]);
app.controller('ClassController', ['$scope','$location','$http', function($scope,$location,$http) {
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
      if($scope.ListClass.length === 0 && $scope.CurrentPage>1){
        $scope.CurrentPage --;
        $scope.getListClass($scope.CurrentPage);
      }
    });
  };
  $scope.addNewCLass = function(){
    $http.post('/admin/addNewClass',{name:$scope.ClassName}).success(function(data){
      if(data.status === true){
        toastr.success("Add class sucessful");
        $scope.ClassName = null;
        $scope.getListClass($scope.CurrentPage);
      }else{
        toastr.error("Cannot add class");
      }
    });
  };
  $scope.deleteClass = function(id){
    $http.post('/admin/deleteClass',{id:id}).success(function(data){
      if(data.status === true){
        toastr.success("Delete class sucessful");
        $scope.getListClass($scope.CurrentPage);
      }else{
        toastr.error("Cannot delete class");
      }
    });
  };
  $scope.init = function(){
    $scope.getListClass($scope.CurrentPage);
  };
  return $scope.init();
}]);
