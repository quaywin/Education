app = angular.module('score.controller',[]);
app.controller('ScoreController', ['$scope','$location','$http', function($scope,$location,$http) {
  $scope.CurrentPage = 1;
  $scope.ListStudent = [];
  $scope.Count = 0;
  $scope.ClassId = null;
  $scope.SubjectId = null;
  $scope.ListClass = [];
  $scope.ListSubject = [];
  $scope.loadListStudent = function(page){
    $http.post('/admin/getListStudentByRole',{page:page,subjectid:$scope.SubjectId,classid:$scope.ClassId}).success(function(data){
      $scope.ListStudent = data.data;
      $scope.Count = data.count;
      $scope.Pages = data.pages;
      $scope.PageSize = data.pageSize;
      $scope.CurrentPage = page;
      if($scope.ListStudent.length === 0 && $scope.CurrentPage>1){
        $scope.CurrentPage --;
        $scope.loadListStudent($scope.CurrentPage);
      }
    });
  };
  $scope.getListClass = function(){
    $http.post('/admin/getAllListClass',{}).success(function(data){
      $scope.ListClass = data;
      $scope.ClassId = $scope.ListClass[0].id;
      $scope.getListSubject($scope.ClassId);
    });
  };
  $scope.getListSubject = function(classid){
    $http.post('/admin/getAllListSubjectByClass',{classid:classid}).success(function(data){
      $scope.ListSubject = data;
      $scope.SubjectId = $scope.ListSubject[0].id;
    });
  };
  $scope.updateScore = function(item){
    $http.post('/admin/updateScore',{item:item}).success(function(data){
      if(data.status === true){
        toastr.success('Update score successful');
      }else{
        toastr.success('Cannot update score');
      }
    });
  };
  $scope.init = function(){
    $scope.getListClass();
  };
  return $scope.init();
}]);
