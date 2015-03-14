app = angular.module('student.controller',[]);
app.controller('StudentController', ['$scope','$location','$http', function($scope,$location,$http) {
  $scope.CurrentPage = 1;
  $scope.ListStudent = [];
  $scope.ListClass = [];
  $scope.ListGender = [];
  $scope.Count = 0;
  $scope.FirstName = null;
  $scope.LastName = null;
  $scope.Username = null;
  $scope.Gender = null;
  $scope.ClassId = null;
  $scope.StudentCode = null;
  $scope.Address = null;
  $scope.getListStudent = function(page){
    $http.post('/admin/getListStudent',{page:page}).success(function(data){
      $scope.ListStudent = data.data;
      $scope.Count = data.count;
      $scope.Pages = data.pages;
      $scope.PageSize = data.pageSize;
      $scope.CurrentPage = page;
      if($scope.ListStudent.length === 0 && $scope.CurrentPage>1){
        $scope.CurrentPage --;
        $scope.getListStudent($scope.CurrentPage);
      }
    });
  };
  $scope.getAllList = function(){
    $http.post('/admin/getAllListClass',{}).success(function(data){
      $scope.ListClass = data;
      $scope.ClassId = $scope.ListClass[0].id;
    });
    $http.post('/admin/getListGender',{}).success(function(data){
      $scope.ListGender = data;
      $scope.Gender = $scope.ListGender[0].id;
    });
  };
  $scope.addNewStudent = function(){
    $http.post('/admin/addNewStudent',{firstname:$scope.FirstName,lastname:$scope.LastName,
      username:$scope.Username,gender:$scope.Gender,classid:$scope.ClassId,studentcode:$scope.StudentCode,
      address:$scope.Address}).success(function(data){
      if(data.status === true){
        toastr.success("Add student sucessful");
        $scope.FirstName = null;
        $scope.LastName = null;
        $scope.Username = null;
        $scope.StudentCode = null;
        $scope.Address = null;
        $scope.getListStudent($scope.CurrentPage);
      }else{
        toastr.error("Cannot add student");
      }
    });
  };
  $scope.deleteStudent = function(id){
    $http.post('/admin/deleteStudent',{id:id}).success(function(data){
      if(data.status === true){
        toastr.success("Delete student sucessful");
        $scope.getListStudent($scope.CurrentPage);
      }else{
        toastr.error("Cannot delete student");
      }
    });
  };
  $scope.init = function(){
    $scope.getAllList();
    $scope.getListStudent($scope.CurrentPage);
  };
  return $scope.init();
}]);
