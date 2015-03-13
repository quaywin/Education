app = angular.module('subject.controller',[]);
app.controller('SubjectController', ['$scope','$location','$http', function($scope,$location,$http) {
  $scope.CurrentPage = 1;
  $scope.ListSubject = [];
  $scope.Count = 0;
  $scope.SubjectName = null;
  $scope.SubjectCode = null;
  $scope.getListSubject = function(page){
    $http.post('/admin/getListSubject',{page:page}).success(function(data){
      $scope.ListSubject = data.data;
      $scope.Count = data.count;
      $scope.Pages = data.pages;
      $scope.PageSize = data.pageSize;
      $scope.CurrentPage = page;
      if($scope.ListSubject.length === 0 && $scope.CurrentPage>1){
        $scope.CurrentPage --;
        $scope.getListSubject($scope.CurrentPage);
      }
    });
  };
  $scope.addNewSubject = function(){
    $http.post('/admin/addNewSubject',{name:$scope.SubjectName,code:$scope.SubjectCode}).success(function(data){
      if(data.status === true){
        $scope.SubjectName = null;
        $scope.SubjectCode = null;
        $scope.getListSubject($scope.CurrentPage);
      }
    });
  };
  $scope.deleteSubject = function(id){
    $http.post('/admin/deleteSubject',{id:id}).success(function(data){
      if(data.status === true){
        $scope.getListSubject($scope.CurrentPage);
      }
    });
  };
  $scope.init = function(){
    $scope.getListSubject($scope.CurrentPage);
  };
  return $scope.init();
}]);
