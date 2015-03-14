app = angular.module('role.controller',[]);
app.controller('RoleController', ['$scope','$location','$http', function($scope,$location,$http) {
  $scope.CurrentPage = 1;
  $scope.ListRole = [];
  $scope.Count = 0;
  $scope.ClassId = null;
  $scope.SubjectId = null;
  $scope.TeacherId = null;
  $scope.ListClass = [];
  $scope.ListSubject = [];
  $scope.ListTeacher = [];
  $scope.getListRole = function(page){
    $http.post('/admin/getListRole',{page:page}).success(function(data){
      $scope.ListRole = data.data;
      $scope.Count = data.count;
      $scope.Pages = data.pages;
      $scope.PageSize = data.pageSize;
      $scope.CurrentPage = page;
      if($scope.ListRole.length === 0 && $scope.CurrentPage>1){
        $scope.CurrentPage --;
        $scope.getListRole($scope.CurrentPage);
      }
    });
  };
  $scope.getAllList = function(){
    $http.post('/admin/getAllListTeacherSubjectClass',{}).success(function(data){
      $scope.ListClass = data.class;
      $scope.ListSubject = data.subject;
      $scope.ListTeacher = data.teacher;
      $scope.ClassId = $scope.ListClass[0].id;
      $scope.SubjectId = $scope.ListSubject[0].id;
      $scope.TeacherId = $scope.ListTeacher[0].id;
    });
  };
  $scope.addNewRole = function(){
    $http.post('/admin/addNewRole',{teacherid:$scope.TeacherId,subjectid:$scope.SubjectId,classid:$scope.ClassId}).success(function(data){
      if(data.status === true){
        toastr.success("Add role sucessful");
        $scope.getListRole($scope.CurrentPage);
      }else{
        toastr.error("Cannot add role");
      }
    });
  };
  $scope.deleteRole = function(id){
    $http.post('/admin/deleteRole',{id:id}).success(function(data){
      if(data.status === true){
        toastr.success("Delete role sucessful");
        $scope.getListRole($scope.CurrentPage);
      }
      else{
        toastr.error("Cannot delete role");
      }
    });
  };
  $scope.init = function(){
    $scope.getAllList();
    $scope.getListRole($scope.CurrentPage);
  };
  return $scope.init();
}]);
