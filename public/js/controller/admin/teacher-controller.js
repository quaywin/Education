app = angular.module('teacher.controller',[]);
app.controller('TeacherController', ['$scope','$location','$http', function($scope,$location,$http) {
  $scope.CurrentPage = 1;
  $scope.ListTeacher = [];
  $scope.Count = 0;
  $scope.TeacherName = null;
  $scope.getListTeacher = function(page){
    $http.post('/admin/getListTeacher',{page:page}).success(function(data){
      $scope.ListTeacher = data.data;
      $scope.Count = data.count;
      $scope.Pages = data.pages;
      $scope.PageSize = data.pageSize;
      $scope.CurrentPage = page;
      if($scope.ListTeacher.length === 0 && $scope.CurrentPage>1){
        $scope.CurrentPage --;
        $scope.getListTeacher($scope.CurrentPage);
      }
    });
  };
  $scope.addNewTeacher = function(){
    $http.post('/admin/addNewTeacher',{name:$scope.TeacherName}).success(function(data){
      if(data.status === true){
        toastr.success("Add Teacher sucessful");
        $scope.TeacherName = null;
        $scope.getListTeacher($scope.CurrentPage);
      }else{
        toastr.error("Cannot add teacher");
      }
    });
  };
  $scope.deleteTeacher = function(id){
    $http.post('/admin/deleteTeacher',{id:id}).success(function(data){
      if(data.status === true){
        toastr.success("Delete teacher sucessful");
        $scope.getListTeacher($scope.CurrentPage);
      }else{
        toastr.error("Cannot delete teacher");
      }
    });
  };
  $scope.init = function(){
    $scope.getListTeacher($scope.CurrentPage);
  };
  return $scope.init();
}]);
